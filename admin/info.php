<?php
require("inc.php");
$tpl_info = array(
		"idx" => "main",
		"style" => "admin",
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);
$pass	= "<font color=green><b>��</b></font>";
$error = "<font color=red><b>��</b></font>";
switch($req->getServer("QUERY_STRING")) {
	case "server":
	case "mysql":
	case "php":
	case "phpinfo":
		$tpl_info['idx'] = "info_".$req->getServer("QUERY_STRING");
		break;
	default:
		$tpl_info['idx'] = "info_main";
		break;
}
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $req, $setting, $pass, $error'));
$mystep->show($tpl);
$mystep->pageEnd(false);
?>