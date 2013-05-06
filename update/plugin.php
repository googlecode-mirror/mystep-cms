<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/myfso.class.php");
date_default_timezone_set($setting['gen']['timezone']);
$plugin_path = ROOT_PATH."/plugin/";
$p = $_GET['p'];
$l = $_GET['l'];
$cs = $_GET['cs'];
if($cs==$setting['gen']['charset']) $cs = "";
if(!empty($l)) $setting['gen']['language'] = $l;
if(!empty($p)) {
	$the_file = $plugin_path.$p."/update.php";
	if(!file_exists($the_file)) {
		$file_list = getFileList($plugin_path.$p, "update.php,config.php,cache");
		$content = '<?php
include("info.php");
$sql_list = array();
$file_list = '.var_export($file_list, true).';
?>';
		WriteFile($the_file, $content, "wb");
	}
	include($the_file);
}
if(!empty($_SERVER["HTTP_REFERER"]) && isset($file_list)) {
	$cache_file = ROOT_PATH."/".$setting['path']['cache']."/update/".md5($p.$cs.$info['ver']);
	if(file_exists($cache_file)) {
		$update = GetFile($cache_file);
	} else {
		if(!empty($cs)) {
			$sql_list = chg_charset($sql_list, $setting['gen']['charset'], $cs);
		}
		$update_info = array('sql'=>$sql_list, 'file'=>$file_list, 'content'=>array());
		for($i=0,$m=count($update_info['file']); $i<$m; $i++) {
			$the_file = $plugin_path."/".$p."/".$update_info['file'][$i];
			if(file_exists($the_file)) {
				if(is_dir($the_file)) {
					$update_info['content'][$i] = ".";
				} else {
					$update_info['content'][$i] = GetFile($the_file);
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
	echo $update;
} else {
	$fso = new MyFSO;
	$dir_list = $fso->Get_List($plugin_path);
	$plugin_list = array();
	for($i=0,$m=count($dir_list['dir']); $i<$m; $i++) {
		if(file_exists($dir_list['dir'][$i]."/lock")) continue;
		if(is_file($dir_list['dir'][$i]."/info.php")) {
			include($dir_list['dir'][$i]."/info.php");
			$plugin_list[$info['idx']] = array(
				'name' => $info['name'],
				'ver' => $info['ver'],
				'intro' => $info['intro'],
			);
		}
	}
	echo toJson($plugin_list, $setting['gen']['charset']);
}
?>