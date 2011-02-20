<?php
define(ROOT_PATH, str_replace("\\", "/", dirname(__file__)));
include(ROOT_PATH."/include/config.php");
if($setting['web']['close'] && !isset($_COOKIE['force'])) {
	header("location: ".$setting['web']['url'].$setting['web']['close_page']);
	exit();
}
include(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/global.php");
include(ROOT_PATH."/source/function/web.php");
include(ROOT_PATH."/source/class/mysql.class.php");

$mystep = new MyStep();
$mystep->setPlugin();
$mystep->pageStart();
$cache_path = ROOT_PATH."/".$setting['path']['cache']."/html/".$web_info['idx']."/";
$tpl_info = array(
		"idx" => "main",
		"style" => $setting['gen']['template'],
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
includeCache("news_cat");
?>