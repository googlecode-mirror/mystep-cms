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
		$update_info = base64_decode($update_info);
		$update_info = unserialize($update_info);

		if(count($update_info['setting'])>0) {
			$setting_org = $setting;
			require(ROOT_PATH."/include/config.php");
			$update_info['setting'] = arrayMerge($setting, $update_info['setting']);
			$expire_list = var_export($expire_list, true);
			$ignore_list = var_export($ignore_list, true);
			$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$expire_list = {$expire_list};
\$ignore_list = {$ignore_list};
\$authority = "{$authority}";
?>
mystep;
			$content = str_replace("/*--settings--*/", makeVarsCode($update_info['setting'], '$setting'), $content);
			WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
			$setting = $setting_org;
		}
	
		$strFind = array("{db_name}", "{pre}", "{charset}");
		$strReplace = array($setting['db']['name'], $setting['db']['pre'], $setting['db']['charset']);
		for($i=0,$m=count($update_info['sql']); $i<$m; $i++) {
			$db->Query(str_replace($strFind, $strReplace, $update_info['sql'][$i]));
		}
		if($m>0) {
			$result['info'] = sprintf($setting['language']['admin_update_sql'], $m);
		} else {
			$result['info'] = "";
		}
		
		$check_file_list = checkFile();
		if($check_file_list==false) $check_file_list = array();
		$list = array();
		for($i=0,$m=count($update_info['file']); $i<$m; $i++) {
			//if($update_info['file'][$i]=="include/config.php") continue;
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
			$dir = $dir."update/".date("Ymd/");
			$files = array();
			for($i=0; $i<$m; $i++) {
				if($update_info['content'][$list[$i]]==".") continue;
				$files[$i] = $dir.$update_info['file'][$list[$i]];
				WriteFile($files[$i], $update_info['content'][$list[$i]], "wb");
			}
			if(zip($files, $zipfile, $dir)) {
				$result['link'] = $setting['web']['url']."/".$setting['path']['upload']."/tmp/".basename($zipfile);
			}
			MultiDel($dir);
			$result['info'] .= "\n". $setting['language']['admin_update_error'];
		} else {
			$result['info'] .= "\n". sprintf($setting['language']['admin_update_file'], count($update_info['file']));
		}
		
		for($i=0,$m=count($update_info['code']); $i<$m; $i++) {
			@eval($update_info['code'][$i]);
		}
		
		write_log($setting['language']['admin_update_done']);
		echo toJson($result, $setting['db']['charset']);
		
		checkFile(ROOT_PATH);
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
		break;
	case "build":
		if(!checkFile(ROOT_PATH)) {
			echo "error";
		}
		break;
	case "check":
		if(($result = checkFile())!==false) {
			echo implode("\n", $result);
		} else {
			echo "error";
		}
		break;
	default:
		$check_info = GetRemoteContent($setting['gen']['update']);
		$check_info = chg_charset($check_info, "utf-8", $setting['gen']['charset']);
		echo $check_info;
		break;
}

$mystep->pageEnd(false);
?>