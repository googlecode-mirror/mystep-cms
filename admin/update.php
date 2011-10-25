<?php
require("inc.php");
if(isset($_GET['update'])) {
	$result = array();
	$update_info = GetRemoteContent($setting['gen']['update']."?v=".$ms_version['ver']);
	$update_info = base64_decode($update_info);
	$update_info = unserialize($update_info);

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
	echo toJson($result, $setting['db']['charset']);
} else {
	$check_info = GetRemoteContent($setting['gen']['update']);
	$check_info = chg_charset($check_info, "utf-8", $setting['gen']['charset']);
	echo $check_info;
}
$mystep->pageEnd(false);
?>