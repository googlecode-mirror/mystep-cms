<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/global.php");
require("version.php");

$v = $_GET['v'];
if($v!="") {
	$sql_list = array();
	$file_list = array();
	$flag = false;
	foreach($version as $key => $value) {
		if($flag) {
			$sql_list = array_merge($sql_list, $value['sql']);
			$file_list = array_merge($file_list, $value['file']);
		} else {
			$flag = ($key==$v || $key>$v);
		}
	}
	$file_list = array_unique($file_list);
	$update_info = array('sql'=>$sql_list, 'file'=>$file_list, 'content'=>array());
	for($i=0,$m=count($update_info['file']); $i<$m; $i++) {
		if(file_exists(ROOT_PATH."/".$update_info['file'][$i])) {
			$update_info['content'][$i] = GetFile(ROOT_PATH."/".$update_info['file'][$i]);
		} else {
			$update_info['content'][$i] = "";
		}
	}
	echo base64_encode(serialize($update_info));
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