<?php
if(!isset($ms_sign)) $ms_sign = 0;
$ms_sign += 128;
define('ROOT_PATH', str_replace("\\", "/", realpath(dirname(__file__)."/../")));
require(ROOT_PATH."/include/config.php");
require(ROOT_PATH."/include/parameter.php");
require(ROOT_PATH."/source/function/global.php");
require(ROOT_PATH."/source/function/web.php");
require(ROOT_PATH."/source/function/admin.php");
require(ROOT_PATH."/source/class/abstract.class.php");
require(ROOT_PATH."/source/class/mystep.class.php");

header("Expires: -1");
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

$mystep = new MyStep();
$mystep->getLanguage(dirname(ROOT_PATH.$_SERVER['PHP_SELF'])."/language/");
$mystep->pageStart(true);
$db->Reconnect(true, $setting['db']['name']);

$setting['gen']['minify'] = false;
$usergroup = $req->getSession("usergroup");
if($usergroup===0) {
	$goto_url = $setting['web']['url'];
	//debug("usergroup",$goto_url);
	$mystep->pageEnd(false);
}
$group = getParaInfo("user_group", "group_id", $usergroup);
if(empty($group['power_func'])) {
	$goto_url = "/".$setting['path']['admin']."login.php";
	//debug("power_func",$goto_url);
	$req->setCookie("referer", $req->getServer("REQUEST_URI"), 1000);
	$mystep->pageEnd(false);
}
$op_mode = ($setting['info']['web']['web_id']==1 && ($group['power_func']=="all" || strpos(",".$group['power_func'].",", ",1,")!==false));
includeCache("admin_cat");
$cat_info = getParaInfo("admin_cat_plat", "file", $setting['info']['self'], true);
$plugin_info = getParaInfo("plugin", "idx", basename($cat_info["path"]));
if($plugin_info['active']==0) $cat_info=false;
if(!$op_mode) $admin_cat = $admin_cat_plat;
if(($cat_info===false && !checkSign(8)) || ($group['power_func']!="all" && strpos(",".$group['power_func'].",", ",".$cat_info['id'].",")===false)) {
	echo showInfo($setting['language']['login_nopower'],false);
	$mystep->pageEnd(false);
}
if(!$op_mode) $web_id = $setting['info']['web']['web_id'];
?>