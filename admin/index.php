<?php
require("inc.php");

$tpl_info['idx'] = "index";
$tpl = $mystep->getInstance("MyTpl", $tpl_info);

includeCache("website");
includeCache("news_cat");
$tpl->Set_Variable("username", $_SESSION['username']);
$tpl->Set_Variable("usergroup", $group['group_name']);
$tpl->Set_Variable("web_id", $setting['info']['web']['web_id']);
$tpl->Set_Variable("group", json_encode(chg_charset($group, $setting['gen']['charset'], "utf-8")));
if($op_mode) {
	$tpl->Set_Variable("admin_cat", json_encode(chg_charset($admin_cat, $setting['gen']['charset'], "utf-8")));
} else {
	$tpl->Set_Variable("admin_cat", json_encode(chg_charset($admin_cat_plat, $setting['gen']['charset'], "utf-8")));
}
$tpl->Set_Variable("website", json_encode(chg_charset($website, $setting['gen']['charset'], "utf-8")));
$tpl->Set_Variable("news_cat", json_encode(chg_charset($news_cat, $setting['gen']['charset'], "utf-8")));

$mystep->show($tpl);
$mystep->pageEnd(false);
?>