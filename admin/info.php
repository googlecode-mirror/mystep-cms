<?php
require("inc.php");
$pass	= "<font color=green><b>¡Ì</b></font>";
$error = "<font color=red><b>¡Á</b></font>";
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
$tpl_tmp->allow_script = true;
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $req, $setting, $pass, $error'));
$mystep->show($tpl);
$mystep->pageEnd(false);
?>