<?php
require("inc.php");
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
		set_time_limit(0);
		$result = array();
		$header = array();
		$header['Referer'] = "http://".$req->GetServer("HTTP_HOST")."/update/";
		$update_info = GetRemoteContent($setting['gen']['update']."?v=".$ms_version['ver'], $header);
		$update_info = base64_decode($update_info);
		$update_info = unserialize($update_info);
		
		if(count($update_info['setting'])>0) {
			$setting_org = $setting;
			require(ROOT_PATH."/include/config.php");
			$update_info['setting'] = arrayMerge($setting, $update_info['setting']);
			$expire_list = var_export($expire_list, true);
			$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$expire_list = {$expire_list};
?>
mystep;
			$content = str_replace("/*--settings--*/", makeVarsCode($update_info['setting'], '$setting'), $content);
			WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
			$setting = $setting_org;
		}
	
		$strFind = array("{db_name}", "{pre}", "{charset}");
		$strReplace = array($setting['db']['name'], $setting['db']['pre'], $setting['db']['charset'], $req->getServer("HTTP_HOST"), $charset_collate["Default collation"]);
		for($i=0,$m=count($update_info['sql']); $i<$m; $i++) {
			$db->Query(str_replace($strFind, $strReplace, $update_info['sql'][$i]));
		}
		if($m>0) {
			$result['info'] = sprintf($setting['language']['admin_update_sql'], $m);
		} else {
			$result['info'] = "";
		}
		
		$list = array();
		for($i=0,$m=count($update_info['file']); $i<$m; $i++) {
			if($update_info['file'][$i]=="include/config.php") continue;
			if(isWriteable(ROOT_PATH."/".$update_info['file'][$i])) {
				if(empty($update_info['content'][$i])) {
					@unlink(ROOT_PATH."/".$update_info['file'][$i]);
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
		write_log($setting['language']['admin_update_done']);
		echo toJson($result, $setting['db']['charset']);
		break;
	default:
		$check_info = GetRemoteContent($setting['gen']['update']);
		$check_info = chg_charset($check_info, "utf-8", $setting['gen']['charset']);
		echo $check_info;
		break;
}

$mystep->pageEnd(false);
?>