<?php
$version_u = "1.0.8";
error_reporting(E_ALL ^ E_NOTICE);
$code = $_SERVER["HTTP_MS_SIGN"];
$code = preg_replace("/\W/", "", $code);
if(strlen($code)!=32 && false) {
	header("HTTP/1.0 404 Not Found");
	exit;
}

define('ROOT_PATH', str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/mysql.class.php");
require(ROOT_PATH."/source/class/mydb.class.php");
require("version.php");

$db = new MySQL($setting['db']['host'], $setting['db']['user'], $setting['db']['pass'], $setting['db']['charset']);
$db->Connect($setting['db']['pconnect'], $setting['db']['name']);

function client_info($mode="") {
	global $db, $setting, $code;
	if(empty($code)) $code = $_SERVER["HTTP_MS_SIGN"];
	$code = preg_replace("/\W/", "", $code);
	if(strlen($code)!=32) return;
	if($db->getRecord("show tables like 'ms_client_info'")==false) {
		$sql = "
			CREATE TABLE `{pre}client_info` (
				`idx` Char(40) NOT NULL UNIQUE,
				`title` Char(60) Default '' NOT NULL,
				`domain` Char(50) Default '' NOT NULL,
				`ip` Char(20) Default '' NOT NULL,
				`email` Char(40) Default '' NOT NULL,
				`date_install` datetime NULL,
				`date_check` datetime NULL,
				`date_update` datetime NULL,
				`version` Char(20) Default '' NOT NULL,
				`info` Char(255) Default '',
				PRIMARY KEY (`idx`)
			) ENGINE=MyISAM DEFAULT CHARSET={charset};
		";
		$sql = str_replace("{pre}", $setting['db']['pre'], $sql);
		$sql = str_replace("{charset}", $setting['db']['charset'], $sql);
		$db->Query($sql);
	}
	if($record = $db->getSingleRecord("select * from ".$setting['db']['pre']."client_info where idx='$code'")) {
		$record['title'] = $_GET['title'];
		$record['domain'] = $_GET['domain'];
		$record['ip'] = $_GET['ip'];
		$record['email'] = $_GET['email'];
		$record['version'] = $_GET['v'].' ('.$_GET['cs'].')';
		switch($mode) {
			case "install":
				$record['date_install'] = date("Y-m-d H:i:s");
				break;
			case "update":
				$record['date_update'] = date("Y-m-d H:i:s");
				break;
			default:
				$record['date_check'] = date("Y-m-d H:i:s");
				break;
		}
		foreach($record as $key => $value) {
			if(empty($value)) unset($record[$key]);
		}
		$sql = $db->buildSQL($setting['db']['pre']."client_info", $record, "update", "idx='{$code}'");
	} else {
		$record = array(
			'idx' => $code,
			'title' => $_GET['title'],
			'domain' => $_GET['domain'],
			'date_install' => date("Y-m-d H:i:s"),
			'date_update' => date("Y-m-d H:i:s"),
			'date_check' => date("Y-m-d H:i:s"),
			'ip' => $_GET['ip'],
			'email' => $_GET['email'],
			'version' => $_GET['v'].' ('.$_GET['cs'].')'
		);
		$sql = $db->buildSQL($setting['db']['pre']."client_info", $record, "insert");
	}
	$db->query($sql);
	return;
}

date_default_timezone_set($setting['gen']['timezone']);
$m = $_GET['m'];
$v = $_GET['v'];
$cs = $_GET['cs'];
if($cs==$setting['gen']['charset']) $cs = "";
if(isset($_GET['check'])) $m = "check";
if(empty($v)) $v = $ms_version['ver'];

switch($m) {
	case "install":
		client_info("install");
		break;
	case "vertify":
		$the_file = ROOT_PATH."/cache/checkfile.php";
		if(file_exists($the_file)) {
			include($the_file);
			$check_info['file_list'] = $file_list;
			if(empty($cs)) {
				$check_info['file_list_md5'] = $file_list_md5;
				echo toJson($check_info, $setting['gen']['charset']);
			} else {
				$cs = strtoupper($cs);
				if(isset($file_list_md5_ext[$cs])) {
					$check_info['file_list_md5'] = $file_list_md5_ext[$cs];
					echo toJson($check_info, $setting['gen']['charset']);
				} else {
					echo "";
				}
			}
			unset($file_list, $file_list_md5);
		} else {
			echo "";
		}
		client_info("check");
		break;
	case "check":
		$version_main = substr($v, 0, 1);
		if(file_exists("version_".$version_main.".php")) {
			unset($version);
			include("version_".$version_main.".php");
		}
		$version_info = $version;
		foreach($version as $key => $value) {
			if($key<=$v) {
				array_shift($version_info);
			} else {
				break;
			}
		}
		$result = array();
		if(!empty($version_info)) $result['ver'] = $version_info;
		if($info = $db->getSingleResult("select content from ".$setting['db']['pre']."info_show where subject='push' limit 1")) {
			$result['info'] = $info;
		}
		echo toJson($result, $setting['gen']['charset']);
		client_info("check");
		break;
	case "all":
		array_shift($version);
		echo toJson($version, $setting['gen']['charset']);
		break;
	case "update":
		$version_main = substr($v, 0, 1);
		$path_ver = "/";
		if(file_exists("version_".$version_main.".php")) {
			unset($version);
			include("version_".$version_main.".php");
			$path_ver = "/update/".$version_main."/";
			if(!is_dir(ROOT_PATH.$path_ver)) $path_ver = "/";
		}
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
						$update_info['content'][$i] = GetFile(ROOT_PATH.$path_ver.$update_info['file'][$i]);
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
		if(empty($cs)) $cs = $setting['gen']['charset'];
		client_info("update");
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
			md5($v.$ms_version['ver'].$cs),
			$v,
			$ms_version['ver'],
			GetIp(),
			$_SERVER["HTTP_REFERER"],
			$cs
		);
		$mydb->insertDate($data);
		$mydb->closeTBL();
		echo $update;
		break;
	case "u_update":
		if($version_u > $v) {
			$u_info = array_shift($version);
			$u_info['content'] = array();
			for($i=0,$m=count($u_info['file']); $i<$m; $i++) {
				if(file_exists(ROOT_PATH."/".$u_info['file'][$i])) {
					if(is_dir(ROOT_PATH."/".$u_info['file'][$i])) {
						$u_info['content'][$i] = ".";
					} else {
						$u_info['content'][$i] = GetFile(ROOT_PATH."/".$u_info['file'][$i]);
						$path_parts = pathinfo($u_info['file'][$i]);
						if(!empty($cs) && strpos(".php,.tpl,.html,.htm,.sql", $path_parts["extension"])!==false) {
							$u_info['content'][$i] = str_ireplace(strtolower($setting['gen']['charset']), strtolower($cs), $u_info['content'][$i]);
							$u_info['content'][$i] = str_ireplace(strtoupper($setting['gen']['charset']), strtoupper($cs), $u_info['content'][$i]);
							$u_info['content'][$i] = chg_charset($u_info['content'][$i], $setting['gen']['charset'], $cs);
						}
					}
				} else {
					$u_info['content'][$i] = "";
				}
			}
		}
		echo base64_encode(serialize($u_info));
		break;
	default:
		$last_update = array_pop($version);
		$ms_version['update'] = preg_replace("/[\r\n]+\s+/", "\n", $last_update['info']);
		echo toJson($ms_version, $setting['gen']['charset']);
		break;
}

$db->close();
?>