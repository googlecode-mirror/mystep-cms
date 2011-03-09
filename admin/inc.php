<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/global.php");
include(ROOT_PATH."/source/function/web.php");
include(ROOT_PATH."/source/function/admin.php");

header("Expires: -1");
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

$mystep = new MyStep();
$mystep->getLanguage(dirname(__FILE__)."/language/");
$mystep->pageStart(false);
$db->Reconnect(true, $setting['db']['name']);

$usertype = $req->getSession("usertype");
$group = getParaInfo("user_group", "group_id", $usertype);
if($self=="login.php") {
	$method = $req->getServer("QUERY_STRING");
	if(!empty($group['power_func']) && $method!="logout") {
		$goto_url = "./index.php";
		$mystep->pageEnd(false);
	}
} else {
	if(empty($group['power_func']) ) {
		$goto_url = "./login.php";
		$mystep->pageEnd(false);
	}
}

includeCache("admin_cat");
if($group['power_func']!="all" && $cat_info = getParaInfo("admin_cat_plat", "file", $self)) {
	if(strpos(",".$group['power_func'].",", ",".$cat_info['id'].",")===false) {
		echo '<div style="text-align:center; font-size:36px; color:#f00; margin-top:100px;">'.$language['admin_nopower'].'</div>';
		$mystep->pageEnd(false);
	}
}

$tpl_info = array(
		"idx" => "main",
		"style" => "admin",
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);
?>