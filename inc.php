<?php
if(count(debug_backtrace())<1) {
	header("HTTP/1.0 404 Not Found");
	exit();
} elseif(!is_file("include/install.lock")) {
	header("location: install/");
	exit();
}
define('ROOT_PATH', str_replace("\\", "/", dirname(__file__)));
require(ROOT_PATH."/include/config.php");
if($setting['web']['close'] && !isset($_COOKIE['force'])) {
	header("location: ".$setting['web']['close_page']);
	exit();
}
require(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/function/web.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/mystep.class.php");

$mystep = new MyStep();
$mystep->pageStart(true);
$cache_path = ROOT_PATH."/".$setting['path']['cache']."/html/".$setting['info']['web']['idx']."/";
$tpl_info = array(
		"idx" => "main",
		"style" => $setting['gen']['template'],
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
includeCache("news_cat");

$keyword = $req->getReq("k");
if(empty($keyword)) $keyword = $setting['language']['plug_search_default'];
?>