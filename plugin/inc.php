<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/global.php");
include(ROOT_PATH."/source/function/web.php");
include(ROOT_PATH."/source/function/admin.php");
include(ROOT_PATH."/source/class/mysql.class.php");

$mystep = new MyStep();
$mystep->pageStart(false);
$db->Reconnect(true, $setting['db']['name']);

$usertype = $req->getSession("usertype");
$group = getParaInfo("user_group", "group_id", $usertype);
if(empty($group['power_func']) ) {
	$goto_url = $setting_type['path']['admin']."/login.php";
	$mystep->pageEnd(false);
}

includeCache("admin_cat");
if($group['power_func']!="all" && $cat_info = getParaInfo("admin_cat_plat", "file", $self)) {
	if(strpos(",".$group['power_func'].",", ",".$cat_info['id'].",")===false) {
		echo '<div style="text-align:center; font-size:36px; color:#f00; margin-top:100px;">您无权进行该操作！</div>';
		$mystep->pageEnd(false);
	}
}
?>