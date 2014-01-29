<?php
$ms_sign = 1;
$etag_expires = 604800;
define('ROOT_PATH', str_replace("\\", "/", realpath(dirname(__file__)."/../")));
require(ROOT_PATH."/include/config.php");
require(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/etag.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/function/web.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/mystep.class.php");

$mystep = new MyStep();
$mystep->pageStart(true);
header('Content-Type: application/x-javascript');
$cache_file = ROOT_PATH."/".$setting['path']['cache']."script/".$setting['info']['web']['idx']."_setting.js";

if(file_exists($cache_file) && (filemtime($cache_file)+$etag_expires)>($setting['info']['time_start']/1000)) {
	$result = GetFile($cache_file);
} else {
	$result = "";
	$result .= "var ms_setting = ".toJson($setting['js'], $setting['gen']['charset']).";\n";
	$result .= "ms_setting.lang = \"".$setting['gen']['language']."\";";
	WriteFile($cache_file, $result, "wb");
}
header("Accept-Ranges: bytes");
header("Accept-Length: ".strlen($result));
echo $result;
$mystep->pageEnd(false);
?>D:/Website/mystep/aa.txtD:/Website/mystep/aa.txt