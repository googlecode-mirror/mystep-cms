<?php
require("inc.php");

$tpl_info['idx'] = "index";
$tpl = $mystep->getInstance("MyTpl", $tpl_info);

includeCache("website");
$tpl->Set_Variable("username", $_SESSION['username']);
$tpl->Set_Variable("usergroup", $group['group_name']);
$tpl->Set_Variable("admin_cat", json_encode(chg_charset($admin_cat, $setting['gen']['charset'], "utf-8")));
$tpl->Set_Variable("website", json_encode(chg_charset($website, $setting['gen']['charset'], "utf-8")));

$mystep->show($tpl);
$mystep->pageEnd(false);
?>