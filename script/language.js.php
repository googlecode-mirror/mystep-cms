<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
$etag_expires = 86400;
require(ROOT_PATH."/include/config.php");
require(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/etag.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/function/web.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/mystep.class.php");

function gbk2utf8($data){
	if(is_array($data)){
		return array_map('gbk2utf8', $data);
	}
	return iconv('gbk', 'utf-8',$data);
}

$mystep = new MyStep();
$mystep->pageStart(true);
$result = "";
header('Content-Type: application/x-javascript');
$cache_file = ROOT_PATH."/".$setting['path']['cache']."script/".$setting['info']['web']['idx']."_language.js";
if(file_exists($cache_file) && (filemtime($cache_file)+$etag_expires)<($setting['info']['time_start']/1000)) {
	$result = GetFile($cache_file);
} else {
	$result = "var language = ".json_encode(array_map("gbk2utf8", $setting['language'])).";";
	WriteFile($cache_file, $result, "wb");
}
header("Accept-Ranges: bytes");
header("Accept-Length: ".strlen($result));
echo $result;
$mystep->pageEnd(false);
?>