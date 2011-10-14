<?php
require("inc.php");

$tpl_info['idx'] = "index";
$tpl = $mystep->getInstance("MyTpl", $tpl_info);

includeCache("website");
includeCache("news_cat", false);
$tpl->Set_Variable("username", $_SESSION['username']);
$tpl->Set_Variable("usergroup", $group['group_name']);
$tpl->Set_Variable("web_id", $setting['info']['web']['web_id']);
$tpl->Set_Variable("group", toJson($group, $setting['gen']['charset']));
if($op_mode) {
	$tpl->Set_Variable("admin_cat", toJson($admin_cat, $setting['gen']['charset']));
} else {
	$tpl->Set_Variable("admin_cat", toJson($admin_cat_plat, $setting['gen']['charset']));
}
$tpl->Set_Variable("website", toJson($website, $setting['gen']['charset']));
$tpl->Set_Variable("news_cat", toJson($news_cat, $setting['gen']['charset']));

$tpl->Set_Variable("year", date('Y'));
$tpl->Set_Variables($ms_version, "ms_version");

$mystep->show($tpl);
$mystep->pageEnd(false);
?>