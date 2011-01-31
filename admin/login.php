<?php
require("inc.php");
$err_msg = "";
$goto_url = "";
switch($method) {
	case "login":
		$req->getPost();
		if(isset($user_name, $user_psw, $check_code)) {
			if(strtolower($check_code) == strtolower($req->getCookie("vcode"))) {
				$req->setCookie("err_msg");
				$req->setCookie("vcode");
				$user_info = $db->GetSingleRecord("select user_id, group_id from ".$setting['db']['pre']."users where username='{$user_name}' and password='".md5($user_psw)."'");
				if($user_info)  list($uid, $groupid) = array_values($user_info);
				if($user_name==$setting['web']['s_user'] && md5($user_psw)==$setting['web']['s_pass']) $uid = 0;
				if(isset($uid)) {
					$req->setCookie("ms_user", $uid."\t".md5($user_psw), 60*60*24*(float)$keep);
					$goto_url = "index.php";
				} else {
					$err_msg = "登录错误，错误的用户名或密码！";
				}
			} else {
				$err_msg = "校验码不正确，请重新输入！";
			}
		}
		break;
	case "logout":
		$err_msg = "您已经成功退出管理系统!";
		$req->setCookie("ms_user");
		$req->destroySession();
		break;
}

if(empty($goto_url)) build_page();
$mystep->pageEnd(false);

function build_page() {
	global $mystep, $req, $tpl, $tpl_info, $setting, $err_msg;
	$tpl_info['idx'] = "login";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if(empty($err_msg)) $err_msg = "请您登录";
	$tpl->Set_Variable('title', $setting['web']['title']);
	$tpl_tmp->Set_Variable('err_msg', $err_msg);
	$req->setCookie("err_msg");
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>