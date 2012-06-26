<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/mydb.class.php");
require("version.php");
date_default_timezone_set($setting['gen']['timezone']);
$v = $_GET['v'];
$cs = $_GET['cs'];
if($cs==$setting['gen']['charset']) $cs = "";
if($v=="check") {
	$the_file = ROOT_PATH."/cache/checkfile.php";
	if(file_exists($the_file)) {
		include($the_file);
		$check_info['file_list'] = $file_list;
		$check_info['file_list_md5'] = $file_list_md5;
		unset($file_list, $file_list_md5);
		echo toJson($check_info, $setting['gen']['charset']);
	} else {
		echo "";
	}
} elseif($v!="" && !empty($_SERVER["HTTP_REFERER"])) {
	$cache_file = ROOT_PATH."/".$setting['path']['cache']."/update/".md5($v.$ms_version['ver'].$cs);
	if(file_exists($cache_file)) {
		$update = GetFile($cache_file);
	} else {
		$sql_list = array();
		$file_list = array();
		$setting_list = array();
		$code_list = array();
		foreach($version as $key => $value) {
			if($key>$v) {
				$file_list = array_merge($file_list, $value['file']);
				if(isset($value['setting'])) $setting_list = arrayMerge($setting_list, $value['setting']);
				if(isset($value['sql'])) $sql_list = array_merge($sql_list, $value['sql']);
				if(isset($value['code'])) $code_list[] = $value['code'];
			}
		}
		if(!empty($cs)) {
			$sql_list = chg_charset($sql_list, $setting['gen']['charset'], $cs);
			$setting_list = chg_charset($setting_list, $setting['gen']['charset'], $cs);
		}
		
		$file_list = array_values(array_unique($file_list));
		$update_info = array('sql'=>$sql_list, 'file'=>$file_list, 'content'=>array(), 'setting'=>$setting_list, 'code'=>$code_list);
		for($i=0,$m=count($update_info['file']); $i<$m; $i++) {
			if(file_exists(ROOT_PATH."/".$update_info['file'][$i])) {
				if(is_dir(ROOT_PATH."/".$update_info['file'][$i])) {
					$update_info['content'][$i] = ".";
				} else {
					$update_info['content'][$i] = GetFile(ROOT_PATH."/".$update_info['file'][$i]);
					$path_parts = pathinfo($update_info['file'][$i]);
					if(!empty($cs) && strpos(".php,.tpl,.html,.htm,.sql", $path_parts["extension"])!==false) {
						$update_info['content'][$i] = str_ireplace(strtolower($setting['gen']['charset']), strtolower($cs), $update_info['content'][$i]);
						$update_info['content'][$i] = str_ireplace(strtoupper($setting['gen']['charset']), strtoupper($cs), $update_info['content'][$i]);
						$update_info['content'][$i] = chg_charset($update_info['content'][$i], $setting['gen']['charset'], $cs);
					}
				}
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
			array("referer",200),
			array("charset",20)
		);
		$mydb->createTBL($db_setting);
	}
	$data = array (
		date("Y-m-d H:i:s"),
		md5($v.$ms_version['ver']),
		$v,
		$ms_version['ver'],
		GetIp(),
		$_SERVER["HTTP_REFERER"],
		$cs
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