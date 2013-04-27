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
require(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/function/web.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/mystep.class.php");

$mystep = new MyStep();
$mystep->pageStart(true);
if($setting['web']['close'] && $req->getCookie("force")=="" && $setting['info']['self']!="vcode.php") {
	$goto_url = $setting['web']['close_page'];
	$mystep->pageEnd(false);
}
$cache_path = ROOT_PATH."/".$setting['path']['cache']."/html/".$setting['info']['web']['idx']."/";
if($req->getCookie("template", false)!="") $setting['gen']['template'] = $req->getCookie("template", false);
$tpl_info = array(
		"idx" => "main",
		"style" => $setting['gen']['template'],
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
includeCache("news_cat");
includeCache("link");

$keyword = $req->getReq("k");
if(empty($keyword)) $keyword = $setting['language']['plug_search_default'];
?>