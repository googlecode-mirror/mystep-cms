<?php
define(ROOT_PATH, str_replace("\\", "/", dirname(__file__)));
require_once(ROOT_PATH."/include/config.php");
if($setting['web']['close'] && !isset($_COOKIE['force'])) {
	header("location: ".$setting['web']['url'].$setting['web']['close_page']);
	exit();
}
require_once(ROOT_PATH."/include/parameter.php");
require_once(ROOT_PATH."/source/function/global.php");
require_once(ROOT_PATH."/source/function/web.php");

$mystep = new MyStep();
$req = $mystep->getInstance("MyReq", $setting['cookie'], $setting['session']);
$db = $mystep->getInstance("MySQL", $setting['db']['host'], $setting['db']['user'], $setting['db']['pass'], $setting['db']['charset']);
$mystep->setPlugin();
$mystep->pageStart();
?>