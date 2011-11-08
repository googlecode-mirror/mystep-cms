<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/mydb.class.php");
require("version.php");

$v = $_GET['v'];
if($v!="" && !empty($_SERVER["HTTP_REFERER"])) {
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
	$mydb = new MyDB;
	$mydb->init("update", ROOT_PATH."/".$setting['path']['cache']."/update/");
	if(!$mydb->checkTBL()) {
		$db_setting = array(
			array("date",10),
			array("idx",40),
			array("ver_remote",30),
			array("ver_local",30),
			array("remote_ip",50),
			array("referer",200)
		);
		$mydb->createTBL($db_setting);
	}
	$data = array (
		date("Y-m-d H:i:s"),
		md5($v.$ms_version['ver']),
		$v,
		$ms_version['ver'],
		GetIp(),
		$_SERVER["HTTP_REFERER"]
	);
	$mydb->insertDate($data);
	$mydb->closeTBL();
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