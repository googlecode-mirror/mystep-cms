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

/*--------------------------------Website Functions Start-----------------------------------------*/
function write_log($comment="", $q_str="") {
	global $db, $setting;
	$link = "http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"]."&".$q_str;
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
	$page_arr['page_total'] = $counter;
	$page_arr['page_cur'] = $page;
	$page_arr['page_count'] = $page_count;
	$page_arr['page_first'] = ($page<=1 ? "###" : $qry_str."&page=1");
	$page_arr['page_prev'] = ($page<=1 ? "###" : $qry_str."&page=".($page-1));
	$page_arr['page_next'] = ($page==$page_count ? "###" : $qry_str."&page=".($page+1));
	$page_arr['page_last'] = ($page==$page_count ? "###" : $qry_str."&page=".$page_count);
	return array($page_arr, $page_start, $page_size);
}

function GetPictures_news($news_id, $web_id, $content, $zoom = 700) {
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
		preg_match_all("/\<img.+src\=\"(.+?)\"[^>]+?>/i", $tmp[$n], $arr);
		$img_list = $arr[1];
		$max_count2 = count($img_list);
		for($i=0; $i<$max_count2; $i++) {
			if(array_search($img_list[$i], $pic_list)===false) {
				array_push($pic_list, $img_list[$i]);
			} else {
				continue;
			}
			if(strpos($img_list[$i], $setting['web']['url'])!==false) continue;
			$the_time = GetMicrotime();
			$old_name = strtolower(basename($img_list[$i]));
			$ext = ".".GetFileExt($img_list[$i]);
			$ext = preg_replace("/\?.*$/", "", $ext);
			$old_name = preg_replace("/\?.*$/", "", $old_name);
			//if(strpos("*.jpg.bmp.gif.png",$ext)===false) continue;
			if(empty($ext)) {
				$ext = ".jpg";
				$old_name .= $ext;
			}
			$new_name = $the_time.$ext;
			$the_path = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d/");
			MakeDir($the_path);
			if(GetRemoteFile($img_list[$i], $the_path.$new_name)) {
				$img_info = GetImageSize($the_path.$new_name);
				$the_width = $img_info[0];
				$the_height = $img_info[1];
				if(!is_numeric($zoom)) $zoom = 600;
				if($the_width > $zoom) {
					$the_height *= $zoom/$the_width;
					$the_width = $zoom;
				}
				MakeDir("{$the_path}/preview/");
				img_thumb($the_path.$new_name, $the_width, $the_height, $the_path."/preview/".$new_name);
				$qrl_str = "insert into ".$setting['db']['pre']."attachment values(0, 0, 0, '".$old_name."', 'image".str_replace(".","/",$ext)."', '".filesize($the_path.$new_name)."', '', '".$the_time."', 0, '', '".$_SESSION['username']."', ".(($setting['watermark']['mode'] & 2) ? 1 : 0).")";
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
		$db->Query("update ".$setting['db']['pre_sub']."news_detail set content='".mysql_real_escape_string($tmp[$n])."' where news_id={$news_id} and page=".($n+1));
		$db->Query("update ".$setting['db']['pre']."attachment set news_id={$news_id}, web_id={$web_id} where id in ({$attach_list})");
	}
	return;
}

function GetPictures(&$content, $db=null, $zoom = 700) {
	global $setting;
	if(is_null($db)) global $db;
	if(is_array($content)) {
		$tmp = $content;
	} else {
		$tmp = array();
		$tmp[] = $content;
	}
	$pic_list = array();
	$id_list = array();
	$max_count = count($tmp);
	$attach_list = "";
	for($n=0; $n<$max_count; $n++) {
		preg_match_all("/\<img.+src\=\"(.+?)\"[^>]+?>/i", $tmp[$n], $arr);
		$img_list = $arr[1];
		$max_count2 = count($img_list);
		for($i=0; $i<$max_count2; $i++) {
			if(array_search($img_list[$i], $pic_list)===false) {
				array_push($pic_list, $img_list[$i]);
			} else {
				continue;
			}
			if(strpos($img_list[$i], $setting['web']['url'])!==false) continue;
			$the_time = GetMicrotime();
			$old_name = strtolower(basename($img_list[$i]));
			$ext = ".".GetFileExt($img_list[$i]);
			if(empty($ext)) {
				$ext = ".jpg";
				$old_name .= $ext;
			}
			$new_name = $the_time.$ext;
			$the_path = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d/");
			MakeDir($the_path);
			if(GetRemoteFile($img_list[$i], $the_path.$new_name)) {
				$img_info = GetImageSize($the_path.$new_name);
				$the_width = $img_info[0];
				$the_height = $img_info[1];
				if(!is_numeric($zoom)) $zoom = 600;
				if($the_width > $zoom) {
					$the_height *= $zoom/$the_width;
					$the_width = $zoom;
				}
				MakeDir("{$the_path}/preview/");
				img_thumb($the_path.$new_name, $the_width, $the_height, $the_path."/preview/".$new_name);
				$qrl_str = "insert into ".$setting['db']['pre']."attachment values(0, 0, 0, '".$old_name."', 'image".str_replace(".","/",$ext)."', '".filesize($the_path.$new_name)."', '', '".$the_time."', 0, '', '".$_SESSION['username']."', ".(($setting['watermark']['mode'] & 2) ? 1 : 0).")";
				$db->Query($qrl_str);
				$new_id = $db->GetInsertId();
				if($new_id != 0) {
					$attach_list .= $new_id.",";
					$tmp[$n] = str_replace($img_list[$i], $setting['web']['url']."/files?".$new_id, $tmp[$n]);
					array_push($id_list, $new_id);
				}
			}
		}
	}
	$attach_list .= "0";
	if(count($tmp)==1) {
		$content = $tmp[0];
	} else {
		$content = $tmp;
	}
	return $attach_list;
}

function delTplCache($tpl="", $file="") {
	global $setting;
	$cache_pathe = ROOT_PATH."/".$setting['path']['template']."/cache/";
	if(empty($tpl)) {
		MultiDel($cache_pathe);
	} elseif(empty($file)) {
		MultiDel($cache_pathe.$tpl);
	} else {
		MultiDel($cache_pathe.$tpl."/".$file.".php");
	}
}
/*--------------------------------Website Functions End-----------------------------------------*/
?>