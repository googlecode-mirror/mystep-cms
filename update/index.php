<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/global.php");
require("version.php");

$v = $_GET['v'];
if($v!="") {
	$cache_file = ROOT_PATH."/".$setting['path']['cache']."/update/".md5($v.$ms_version['ver']);
	if(file_exists($cache_file)) {
		$update = GetFile($cache_file);
	} else {
		$sql_list = array();
		$file_list = array();
		$setting_list = array();
		$flag = false;
		foreach($version as $key => $value) {
			if($flag) {
				$sql_list = array_merge($sql_list, $value['sql']);
				$file_list = array_merge($file_list, $value['file']);
				$setting_list = arrayMerge($setting_list, $value['setting']);
			} else {
				$flag = ($key==$v || $key>$v);
			}
		}
		$file_list = array_unique($file_list);
		$update_info = array('sql'=>$sql_list, 'file'=>$file_list, 'content'=>array(), 'setting'=>$setting_list);
		for($i=0,$m=count($update_info['file']); $i<$m; $i++) {
			if(file_exists(ROOT_PATH."/".$update_info['file'][$i]) && !is_dir(ROOT_PATH."/".$update_info['file'][$i])) {
				$update_info['content'][$i] = GetFile(ROOT_PATH."/".$update_info['file'][$i]);
			} else {
				$update_info['content'][$i] = "";
			}
		}
		$update = base64_encode(serialize($update_info));
		WriteFile($cache_file, $update, "wb");
	}
	echo $update;
} else {
	if(isset($_GET['all'])) {
		array_shift($version);
		echo toJson($version, $setting['gen']['charset']);
	} else {
		$last_update = array_pop($version);
		$ms_version['update'] = preg_replace("/[\r\n]+\s+/", "\n", $last_update['info']);
		echo toJson($ms_version, $setting['gen']['charset']);
	}
}
?>