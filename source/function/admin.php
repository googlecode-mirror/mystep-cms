<?php
/********************************************
*                                           *
* Name    : Functions 4 PHP                 *
* Author  : Windy2000                       *
* Time    : 2003-05-03                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*--------------------------------Website Functions Start-----------------------------------------*/
function write_log($comment="", $q_str_addon="") {
	global $db, $setting, $req;
	$link = "http://".$req->getServer("SERVER_NAME").$req->getServer("SCRIPT_NAME");
	$q_str = $req->getServer("QUERY_STRING");
	if(!empty($q_str)) $link .= "?".$q_str;
	if(!empty($q_str_addon)) $link .= (empty($q_str)?"?":"&").$q_str_addon;
	$str_sql = "
		insert into ".$setting['db']['pre']."modify_log (`id`,	`user`,			`group`,		`time`,		`link`, `comment`)
				values (0,	'".$req->getSession('username')."',	'".$req->getSession('usertype')."',	".$req->getServer('REQUEST_TIME').",	'{$link}', '{$comment}');
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
	global $db, $setting, $pic_list;
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
		preg_match_all("/<img.+?src=(.?)(http.+?)\\1.*?>/is", $tmp[$n], $arr);
		$attach_list .= localPicture($arr[2], $tmp[$n], $zoom);
		$attach_list .= "0";
		$db->Query("update ".$setting['db']['pre_sub']."news_detail set content='".mysql_real_escape_string($tmp[$n])."' where news_id={$news_id} and page=".($n+1));
		$db->Query("update ".$setting['db']['pre']."attachment set news_id={$news_id}, web_id={$web_id} where id in ({$attach_list})");
	}
	return;
}

function GetPictures(&$content, $db=null, $zoom = 700) {
	if(is_null($db)) global $db;
	if(is_array($content)) {
		$tmp = $content;
	} else {
		$tmp = array();
		$tmp[] = $content;
	}
	global $pic_list;
	$pic_list = array();
	$id_list = array();
	$max_count = count($tmp);
	$attach_list = "";
	for($n=0; $n<$max_count; $n++) {
		preg_match_all("/<img.+?src=(.?)(http.+?)\\1.*?>/is", $tmp[$n], $arr);
		$attach_list .= localPicture($arr[2], $tmp[$n], $zoom);
	}
	$attach_list .= "0";
	if(count($tmp)==1) {
		$content = $tmp[0];
	} else {
		$content = $tmp;
	}
	return $attach_list;
}

function localPicture($img_list, &$content, $zoom=700) {
	global $db, $setting, $req, $pic_list;
	for($i=0, $m=count($img_list); $i<$m; $i++) {
		if(array_search($img_list[$i], $pic_list)===false) {
			array_push($pic_list, $img_list[$i]);
		} else {
			continue;
		}
		if(strpos($img_list[$i], $setting['web']['url'])!==false) continue;
		if(strpos($img_list[$i], getSetting('web', 'url'))!==false) continue;
		$the_time = GetMicrotime();
		$old_name = strtolower(basename($img_list[$i]));
		$ext = ".".GetFileExt($img_list[$i]);
		$ext = preg_replace("/\?.*$/", "", $ext);
		$old_name = preg_replace("/\?.*$/", "", $old_name);
		$old_name = preg_replace("/[;,&\=]/", "", $old_name);
		//if(strpos("*.jpg.bmp.gif.png",$ext)===false) continue;
		if($ext==".") {
			$ext = ".jpg";
			$old_name .= $ext;
		}
		if(strlen($old_name)>120) $old_name = substr($old_name, -120);
		$new_name = $the_time.$ext;
		$the_path = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d/");
		MakeDir($the_path);
		if(GetRemoteFile($img_list[$i], $the_path.$new_name)) {
			$img_info = GetImageSize($the_path.$new_name);
			$the_width = $img_info[0];
			$the_height = $img_info[1];
			if(!is_numeric($zoom)) $zoom = 700;
			if($the_width > $zoom) {
				$the_height *= $zoom/$the_width;
				$the_width = $zoom;
			}
			$qrl_str = "insert into ".$setting['db']['pre']."attachment values(0, 0, 0, '".$old_name."', 'image".str_replace(".","/",$ext)."', '".filesize($the_path.$new_name)."', '', '".$the_time."', 0, '', '".$req->getSession('username')."', ".(($setting['watermark']['mode'] & 2) ? 1 : 0).")";
			$db->Query($qrl_str);
			$new_id = $db->GetInsertId();
			if($new_id != 0) {
				$attach_list .= $new_id.",";
				$content = str_replace($img_list[$i], $setting['web']['url']."/files?".$new_id, $content);
				array_push($id_list, $new_id);
			}
			$name_new = $the_time.substr(md5(filesize($the_path.$new_name)),0,5).$ext;
			rename($the_path.$new_name, $the_path.$name_new);
			MakeDir("{$the_path}/preview/");
			img_thumb($the_path.$name_new, $the_width, $the_height, $the_path."/preview/".$name_new);
		}
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

function checkFile($dir="", $layer=0, $check="") {
	global $file_list, $file_list_md5;
	if($layer==0) {
		$file_list = array();
		$file_list_md5 = array();
	}
	$the_file = ROOT_PATH."/cache/checkfile.php";
	if(empty($dir)) $dir = ROOT_PATH;
	if(($handle = opendir($dir))===false) return false;
	$ignore = array();
	if(is_file($dir."/ignore")) {
		$ignore = file_get_contents($dir."/ignore");
		if(strlen($ignore)==0) return;
		$ignore = str_replace("\r", "", $ignore);
		$ignore = explode("\n", $ignore);
	}
	if($check!="") {
		if(file_exists(ROOT_PATH."/update/")) {
			$cs_list = array("GBK","UTF-8","BIG5");
			$charset = $GLOBALS['setting']['gen']['charset'];
			global $file_list_md5_ext;
			if($layer==0) {
				$file_list_md5_ext = array();
				foreach ($cs_list as $item) {
					$item = strtoupper($item);
					$file_list_md5_ext[$item] = array();
				}
			}
		}
		while (false !== ($file = readdir($handle))) {
			if(trim($file, ".") == "" || $file == "ignore" || array_search($file, $ignore)!==false) continue;
			$the_name = $dir."/".$file;
			if($the_name==$the_file) continue;
			if(is_dir($the_name)) {
				checkFile($the_name, $layer+1, "y");
			} else {
				$file_list[] = str_replace(ROOT_PATH, "", $the_name);
				$file_list_md5[] = md5_file($the_name);
				if(isset($cs_list, $file_list_md5_ext)) {
					foreach ($cs_list as $item) {
						$item = strtoupper($item);
						$file_list_md5_ext[$item][] = md5_file_cs($the_name, $item, $charset);
					}
				}
			}
		}
		if($layer==0) {
			$content = '<?php
$file_list = '.var_export($file_list, true).';
$file_list_md5 = '.var_export($file_list_md5, true).';
'.(isset($file_list_md5_ext)?('$file_list_md5_ext = '.var_export($file_list_md5_ext, true)):'').'
?>';
			WriteFile($the_file, $content, "wb");
		}
		$result = true;
	} else {
		if($layer==0) {
			if(!is_file($the_file)) return false;
			include($the_file);
		}
		$result = array(
			"new" => array(),
			"mod" => array(),
			"miss" => array()
		);
		while (false !== ($file = readdir($handle))) {
			if(trim($file, ".") == "" || $file == "ignore" || array_search($file, $ignore)!==false) continue;
			$the_name = $dir."/".$file;
			if($the_name==$the_file || $the_name==$the_file.".bak") continue;
			if(is_dir($the_name)) {
				$result_new = checkFile($the_name, $layer+1);
				if($result_new==null) continue;
				$result['new'] = array_merge($result['new'], $result_new['new']);
				$result['mod'] = array_merge($result['mod'], $result_new['mod']);
				$result['miss'] = array_merge($result['miss'], $result_new['miss']);
			} else {
				$the_name = str_replace(ROOT_PATH, "", $the_name);
				if(strpos($the_name, "/config.php")!==false) continue;
				if(strpos($the_name, "/template")===0 && stripos($the_name, ".php")===false) continue;
				if(strpos($the_name, "/images")===0 && stripos($the_name, ".php")===false) continue;
				if(strpos($the_name, "/plugin/")===0) {
					if(strpos(str_replace("/plugin/", "", $the_name), "/")!==false && strpos($the_name, "/plugin/offical/")!==0) continue;
				}
				if(false !== ($key = array_search($the_name, $file_list))) {
					if(md5_file(ROOT_PATH.$the_name)!=$file_list_md5[$key]) {
						$result['mod'][] = $the_name;
					}
					unset($file_list[$key]);
				} else {
					$result['new'][] = $the_name;
				}
			}
		}
		if($layer==0) {
			foreach($file_list as $the_name) {
				if(strpos($the_name, "/config.php")!==false) continue;
				if(strpos($the_name, "/template")===0 && stripos($the_name, ".php")===false) continue;
				if(strpos($the_name, "/images")===0 && stripos($the_name, ".php")===false) continue;
				if(strpos($the_name, "/plugin/")===0) {
					if(strpos(str_replace("/plugin/", "", $the_name), "/")!==false && strpos($the_name, "/plugin/offical/")!==0) continue;
				}
				$result['miss'][] = $the_name;
			}
		}
	}
	closedir($handle);
	return $result;
}
/*--------------------------------Website Functions End-----------------------------------------*/
?>