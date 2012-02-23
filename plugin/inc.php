<?php
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
	$mystep->pageEnd(false);
}
$group = getParaInfo("user_group", "group_id", $usergroup);
if(empty($group['power_func']) ) {
	$goto_url = "/".$setting['path']['admin']."login.php";
	$mystep->pageEnd(false);
}

includeCache("admin_cat");
if($group['power_func']!="all" && $cat_info = getParaInfo("admin_cat_plat", "file", $setting['info']['self'])) {
	if(strpos(",".$group['power_func'].",", ",".$cat_info['id'].",")===false) {
		echo '<div style="text-align:center; font-size:36px; color:#f00; margin-top:100px;">'.$setting['language']['admin_nopower'].'</div>';
		$mystep->pageEnd(false);
	}
}
?>