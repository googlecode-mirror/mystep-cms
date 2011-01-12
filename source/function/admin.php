<?php
/********************************************
*                                           *
* Name    : Functions 4 PHP                 *
* Author  : Windy2000                       *
* Time    : 2003-05-03                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

// Misc varabiles
$top_mode_list = array(
		"0"	=>	"不置顶",
		"128"	=>	"文字置顶",
		"64"	=>	"幻灯图片",
		);

$top_list = array(
		"1"	=>	"首页",
		"2"	=>	"列表页",
		"4"	=>	"内容页",
		);

$power_func_list = array(
		"all"	=>	"全部权限",
		"list"	=>	"后台浏览",
		"user"	=>	"用户管理",
		"biz"	=>	"事务管理",
		"news_add"	=>	"新闻添加",
		"news_edit"	=>	"新闻修改",
		"file"	=>	"文件管理",
		);

/*--------------------------------Website Functions Start-----------------------------------------*/
function CheckPower($power) {
	//Coded By Windy2000 20040526 v1.0
	if(empty($_SESSION['username'])) return false;
	if($power=="manager" && $_SESSION['usertype']==1) return true;
	return ($_SESSION['userpower']=="all" || strpos($_SESSION['userpower'], $power)!==false);
}

function check_power($power){
	$power = strtolower($power);
	if(CheckPower($power)) return;
	global $req;
	if(empty($req)) exit();
	$err_msg = '由于您权限不足，无法察看相关内容，如果您具有高级帐户请重新登陆！';
	$req->setCookie("err_msg", $err_msg, 30);
	header("location: login.php");
	exit();
}

function write_log($link, $comment="") {
	global $db, $setting;
	$link = preg_replace("/&return_url=.+&/iU", "&", $link);
	$str_sql = "
		insert into ".$setting['db']['pre']."modify_log (`id`,	`user`,			`group`,		`time`,		`link`, `comment`)
				values (0,	'".$_SESSION['username']."',	'".$_SESSION['usertype']."',	".$_SERVER['REQUEST_TIME'].",	'{$link}', '{$comment}');
	";
	$db->Query($str_sql);
	return;
}

function GetPageList($counter, $qry_str="", $page=1, $page_size=20) {
	if(!is_numeric($page)) $page = 1;
	$page = (INT)$page;
	$page_count = ceil($counter/$page_size);
	if($page < 1) $page = 1;
	if($page > $page_count) $page = $page_count;
	if(empty($qry_str)) $qry_str = "?q=";
	$page_start = ($page-1) * $page_size;
	if($page_start < 0) $page_start = 0;
	$page_arr = array();
	$page_arr['page_cur'] = $page;
	$page_arr['page_count'] = $page_count;
	$page_arr['page_first'] = ($page<=1 ? "###" : $qry_str."&page=1");
	$page_arr['page_prev'] = ($page<=1 ? "###" : $qry_str."&page=".($page-1));
	$page_arr['page_next'] = ($page==$page_count ? "###" : $qry_str."&page=".($page+1));
	$page_arr['page_last'] = ($page==$page_count ? "###" : $qry_str."&page=".$page_count);
	return array($page_arr, $page_start, $page_size);
}

function GetPictures_news($news_id, $content, $zoom = 600) {
	global $db, $setting;
	if(is_array($content)) {
		$tmp = $content;
	} else {
		$tmp = array();
		$tmp[] = $content;
	}
	$pic_list = array();
	$id_list = array();
	$max_count = count($tmp);
	for($n=0; $n<$max_count; $n++) {
		$attach_list = "";
		preg_match_all("/\<img.+src\=\"(.+?)\"[^>]+?>/ixs", $str, $arr);
		$img_list = $arr[1];
		$max_count2 = count($img_list);
		for($i=0; $i<$max_count2; $i++) {
			$the_time = GetMicrotime();
			$old_name = strtolower(basename($img_list[$i]));
			$old_name = preg_replace("/[^\w]/", "", $old_name);
			$ext = strrchr(preg_replace("/\?.*$/", "", $old_name),".");
			//if(strpos("*.jpg.bmp.gif.png",$ext)===false) continue;
			if(empty($ext)) {
				$ext = ".jpg";
				$old_name .= $ext;
			}
			$if_exist = array_search($img_list[$i], $pic_list);
			if($if_exist===false) {
				array_push($pic_list, $img_list[$i]);
			}
			$new_name = $the_time.$ext;
			$the_path = ROOT_PATH.$setting['path']['upload'].date("Y/m/d")."/";
			Make_Dir($the_path);
			if(GetRemoteFile($img_list[$i], $the_path.$new_name)) {
				$img_info = GetImageSize($the_path.$new_name);
				$the_width = $img_info[0];
				$the_height = $img_info[1];
				if(!is_numeric($zoom)) $zoom = 600;
				if($the_width > $zoom) {
					$the_height *= $zoom/$the_width;
					$the_width = $zoom;
				}
				Make_Dir("{$the_path}/preview/");
				img_thumb($the_path.$new_name, $the_width, $the_height, $the_path."/preview/".$new_name);
				$qrl_str = "insert into ".$setting['db']['pre']."attachment values(0, 0, '".$old_name."', 'image".str_replace(".","/",$ext)."', '".filesize($the_path.$new_name)."', '', '".$the_time."', 0, '', '".$_SESSION['username']."', ".(($setting['watermark']['mode'] & 2) ? 1 : 0).")";
				$db->Query($qrl_str);
				$new_id = $db->GetInsertId();
				if($new_id != 0) {
					$attach_list .= $new_id.",";
					$tmp[$n] = str_replace($img_list[$i], $setting['web']['url']."/files?".$new_id, $tmp[$n]);
					array_push($id_list, $new_id);
				}
			}
		}
		$attach_list .= "0";
		$db->Query("update ".$setting['db']['pre']."news_detail set content='{$tmp[$n]}' where news_id={$news_id} and page=".($n+1));
		$db->Query("update ".$setting['db']['pre']."attachment set news_id={$news_id} where id in ({$attach_list})");
	}
	return;
}
/*--------------------------------Website Functions End-----------------------------------------*/
?>