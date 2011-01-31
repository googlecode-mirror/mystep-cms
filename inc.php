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
$mystep->pageStart();
$mystep->setPlugin();
$cache_path = ROOT_PATH."/".$setting['path']['cache']."/html/".$web_info['idx']."/";

?>