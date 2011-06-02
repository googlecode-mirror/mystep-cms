<?php
define(ROOT_PATH, str_replace("\\", "/", dirname(__file__)));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/global.php");
include(ROOT_PATH."/source/function/web.php");

$req = new MyReq;
$host = $req->getServer("HTTP_HOST");
includeCache("website");
$webInfo = getParaInfo("website", "host", $host);
if($webInfo) {
	$setting_sub = getSubSetting($webInfo['web_id']);
	$setting['db_sub'] = $setting_sub['db'];
	if($setting['db']['name']==$setting_sub['db']['name']) {
		$setting['db']['pre_sub'] = $setting_sub['db']['pre'];	
	} else {
		$setting['db']['pre_sub'] = $setting_sub['db']['name'].".".$setting_sub['db']['pre'];	
	}
	unset($setting_sub['db']);
	$setting = arrayMerge($setting, $setting_sub);
	$req->init($setting['cookie'], $setting['session']);
}
$req->init($setting['cookie'], $setting['session']);
$str = RndKey(4, 3);
$req->setCookie("vcode", $str, 600);
vertify_img($str, ROOT_PATH."/images/font.ttc", 24);
?>