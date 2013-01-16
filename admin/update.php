<?php
require("inc.php");
ignore_user_abort("on");
set_time_limit(0);
$method = $req->GetServer("QUERY_STRING");
switch($method) {
	case "empty":
		$cache_path = ROOT_PATH."/".$setting['path']['cache']."/update/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
		break;
	case "export":
		$mydb = $mystep->getInstance("MyDB", "update", ROOT_PATH."/".$setting['path']['cache']."/update/");
		if($mydb->checkTBL()) {
			$xls = $mystep->getInstance("MyXls", "update_info", "update");
			$record = $mydb->queryAll();
			$xls->addRow();
			$xls->addCells(array("date","idx","ver_remote","ver_local","remote_ip","referer"));
			$max_count = count($record);
			for($i=0; $i<$max_count; $i++) {
				$xls->addRow();
				$xls->addCells($record[$i]);
			}
			$xls->makeFile();
		} else {
			echo "<script>window.close();</script>";
		}
		$mydb->closeTBL();
		break;
	case "update":
	case "download":
		$result = array();
		$header = array();
		$header['Referer'] = "http://".$req->GetServer("HTTP_HOST")."/update/";
		$update_info = GetRemoteContent($setting['gen']['update']."?v=".$ms_version['ver']."&cs=".$setting['gen']['charset'], $header);
		$update_info = preg_replace("/(^|[\r\n]+)([\w]{0,6})[\r\n]+/", "", $update_info);
		$update_info = base64_decode($update_info);
		$update_info = unserialize($update_info);
		if(count($update_info['setting'])>0) {
			$setting_org = $setting;
			require(ROOT_PATH."/include/config.php");
			$update_info['setting'] = arrayMerge($setting, $update_info['setting']);
			$rewrite_list_str = var_export($rewrite_list, true);
			$expire_list_str = var_export($expire_list, true);
			$ignore_list_str = var_export($ignore_list, true);
			$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$rewrite_list = {$rewrite_list_str};
\$expire_list = {$expire_list_str};
\$ignore_list = {$ignore_list_str};
\$authority = "{$authority}";
?>
mystep;
			$update_info['setting']['gen']['etag'] = date("Ymd");
			$content = str_replace("/*--settings--*/", makeVarsCode($update_info['setting'], '$setting'), $content);
			if($method=="update") WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
			$setting = $setting_org;
		}
		$pre_list = array();
		foreach($website as $cur_web) {
			$cur_setting = getSubSetting($cur_web['web_id']);
			$pre_list[] = $cur_setting['db']['name']."`.`".$cur_setting['db']['pre'];
		}
		$strFind = array("{db_name}", "{pre}", "{charset}");
		$strReplace = array($setting['db']['name'], $setting['db']['pre'], $setting['db']['charset']);
		$sql_list = array();
		for($i=0,$m=count($update_info['sql']); $i<$m; $i++) {
			if(count($pre_list)>1 && (strpos($update_info['sql'][$i], "{pre}news_show") || strpos($update_info['sql'][$i], "{pre}news_detail") || strpos($update_info['sql'][$i], "{pre}news_tag"))) {
				foreach($pre_list as $cur_pre) {
					$cur_sql = str_replace("{pre}", $cur_pre, $update_info['sql'][$i]);
					$cur_sql = str_replace($strFind, $strReplace, $cur_sql);
					if($method=="update") {
						$db->Query($cur_sql);
					} else {
						$sql_list[] = $cur_sql;
					}
				}
			} else {
				if($method=="update") {
					$db->Query(str_replace($strFind, $strReplace, $update_info['sql'][$i]));
				} else {
					$sql_list[] = str_replace($strFind, $strReplace, $update_info['sql'][$i]);
				}
			}
		}
		if($method=="update" && $m>0) {
			$result['info'] = sprintf($setting['language']['admin_update_sql'], $m);
		} else {
			$result['info'] = "";
		}
		
		if($method=="update") {
			for($i=0,$m=count($update_info['code']); $i<$m; $i++) {
				@eval($update_info['code'][$i]);
			}
		}
		
		$check_file_list = checkFile();
		if($check_file_list==false) $check_file_list = array();
		$check_file_list= $check_file_list['mod'];
		$list = array();
		for($i=0,$m=count($update_info['file']); $i<$m; $i++) {
			if(strpos(strtolower($update_info['file'][$i]), "config.php")!==false) continue;
			if($method=="update" && isWriteable(ROOT_PATH."/".$update_info['file'][$i]) && array_search("/".$update_info['file'][$i], $check_file_list)===false) {
				if(empty($update_info['content'][$i])) {
					@unlink(ROOT_PATH."/".$update_info['file'][$i]);
				} elseif($update_info['content'][$i]==".") {
					MakeDir(ROOT_PATH."/".$update_info['file'][$i]);
				} else {
					WriteFile(ROOT_PATH."/".$update_info['file'][$i], $update_info['content'][$i], "wb");
				}
			} else {
				$list[] = $i;
			}
		}
		$result['link'] = "";
		$m = count($list);
		if($m>0) {
			require(ROOT_PATH."/source/class/myzip.class.php");
			$dir = ROOT_PATH."/".$setting['path']['upload']."/tmp/";
			$zipfile = $dir."update_".date("Ymd").".zip";
			@unlink($zipfile);
			$dir = $dir."update/".date("Ymd/");
			$files = array();
			for($i=0; $i<$m; $i++) {
				if($update_info['content'][$list[$i]]==".") continue;
				$files[$i] = $dir.$update_info['file'][$list[$i]];
				WriteFile($files[$i], $update_info['content'][$list[$i]], "wb");
			}
			if(isset($content)) {
				$files[] = $dir."include/config.php";
				WriteFile($dir."include/config.php", $content, "wb");
			}
			$script_update = <<<mystep
<?php
define('ROOT_PATH', str_replace("\\\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/global.php");
include(ROOT_PATH."/source/function/web.php");
include(ROOT_PATH."/source/class/abstract.class.php");
include(ROOT_PATH."/source/class/mystep.class.php");
\$mystep = new MyStep();
\$mystep->pageStart();

mystep;
			if(count($sql_list)>0) {
				$files[] = $dir."_update/run.sql";
				WriteFile($dir."_update/run.sql", join(";\n", $sql_list).";", "wb");
				$script_update .= <<<mystep
\$db->ExeSqlFile("run.sql");

//------------------------------
mystep;
			}
			if(count($update_info['code'])>0) {
				$script_update .= "\n\n".join("\n//------------------------------\n", $update_info['code'])."\n\n";
			}
			$script_update .= <<<mystep
//------------------------------

MultiDel(ROOT_PATH."/_update");
\$goto_url = "{$setting['web']['url']}/{$setting['path']['admin']}";
\$mystep->pageEnd(false);
?>
mystep;
			if(count($sql_list)>0 || count($update_info['code'])>0) {
				$files[] = $dir."_update/index.php";
				WriteFile($dir."_update/index.php", $script_update, "wb");
			}
			
			if(zip($files, $zipfile, $dir)) {
				$result['link'] = $setting['web']['url']."/".$setting['path']['upload']."/tmp/".basename($zipfile);
			}
			MultiDel($dir);
			$result['info'] .= "\n". $setting['language']['admin_update_error'];
		} else {
			$result['info'] .= "\n". sprintf($setting['language']['admin_update_file'], count($update_info['file']));
		}
		
		$cache_path = ROOT_PATH."/".$setting['path']['template']."/cache/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
		$cache_path = ROOT_PATH."/".$setting['path']['cache']."/para/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
		$cache_path = ROOT_PATH."/".$setting['path']['cache']."/script/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}
		if($method=="update") checkFile(ROOT_PATH, 0, "y");
		
		write_log($setting['language']['admin_update_done']);
		echo toJson($result, $setting['db']['charset']);
		break;
	case "build":
		if(!checkFile(ROOT_PATH, 0, "y")) {
			echo "error";
		}
		break;
	case "check":
		$result = checkFile();
		echo toJson($result, $setting['gen']['charset']);
		break;
	case "check_server":
		$check_info = GetRemoteContent($setting['gen']['update']."?v=check");
		if(!empty($check_info)) {
			$check_info = json_decode($check_info);
			$the_file = ROOT_PATH."/cache/checkfile.php";
			if(file_exists($the_file)) rename($the_file, $the_file.".bak");
			$file_list = $check_info->file_list;
			$file_list_md5 = $check_info->file_list_md5;
			unset($check_info);
			$content = "<?php\n";
			$content .= '$file_list = '.var_export($file_list, true).";\n";
			$content .= '$file_list_md5 = '.var_export($file_list_md5, true).";\n";
			$content .= "?>";
			WriteFile($the_file, $content, "wb");
			$result = checkFile();
			echo toJson($result, $setting['gen']['charset']);
			@unlink($the_file);
			if(file_exists($the_file.".bak")) rename($the_file.".bak", $the_file);
		} else {
			echo "error";
		}
		break;
	default:
		$check_info = GetRemoteContent($setting['gen']['update']."?v=".$ms_version['ver']."&cs=".$setting['gen']['charset']."&check=yes");
		$check_info = chg_charset($check_info, "utf-8", $setting['gen']['charset']);
		echo $check_info;
		break;
}

$mystep->pageEnd(false);
?>