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
	case "login":
		$user_name = $req->getPost("user_name");
		$user_psw =$req->getPost("user_psw");
		$check_code = $req->getPost("check_code");
		$ms_info = "";
		if(strtolower($check_code) == strtolower($req->getCookie("vcode"))) {
			$ms_info = $mystep->login($user_name, $user_psw);
		} else {
			$ms_info = $setting['language']['login_error_vcode'];
		}
		$req->setCookie("ms_info");
		$req->setCookie("vcode");
		if(empty($ms_info)) {
			$goto_url = $req->getServer("HTTP_REFERER");
		} else {
			$req->setCookie("ms_info", $ms_info, 60*10);
			$goto_url = "module.php?m=offical&f=login_show";
		}
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
	$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
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