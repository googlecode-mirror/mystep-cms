<?php
$method = $req->getGet("f");
switch($method) {
	case "login_show":
		if(is_null($setting['info']['user']['name']) || $setting['info']['user']['type']['type_id']==1) {
			build_page($method);
		} else {
			$goto_url = "./";
		}
		break;
	case "password":
		build_page($method);
		break;
	case "logout":
		$mystep->logout();
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	default:
		$goto_url = "/";
}
$mystep->pageEnd();

function build_page($method) {
	global $setting, $mystep, $req, $db, $tpl_info;
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	if($method=="login_show") {
		$tpl_info['idx'] = "login";
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
		$ms_info = $req->getCookie("ms_info");
		if(empty($ms_info)) $ms_info = $setting['language']['login_login'];
		$tpl_tmp->Set_Variable('info', $ms_info);
	} elseif($method=="password") {
		$tpl_info['idx'] = "password";
		$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/";
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	}
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content());
	unset($tpl_temp);
	$mystep->show($tpl);
	return;
}
?>