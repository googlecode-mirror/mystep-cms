<?php
require("inc.php");

$tpl_info = array(
		"idx" => "index",
		"style" => "admin",
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);

$tpl = $mystep->getInstance("MyTpl", $tpl_info);

includeCache("admin_cat");

$tpl->Set_Variable("username", $_SESSION['username']);
$tpl->Set_Variable("usergroup", $usergroup);
$tpl->Set_Variable("admin_cat", json_encode(chg_charset($admin_cat, $setting['gen']['charset'], "utf-8")));

$mystep->show($tpl);
$mystep->pageEnd(false);
?>