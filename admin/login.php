<?php
require("inc.php");
$ms_info = "";
$goto_url = "";
switch($method) {
	case "login":
		$req->getPost();
		if(isset($user_name, $user_psw, $check_code)) {
			if(strtolower($check_code) == strtolower($req->getCookie("vcode"))) {
				$req->setCookie("ms_info");
				$req->setCookie("vcode");
				$user_info = $db->record($setting['db']['pre']."users","user_id, group_id, type_id",array(array("username","=",$username),array("password","=",md5($user_psw),"and")));
				if($user_info)  list($uid, $groupid) = array_values($user_info);
				if($user_name==$setting['web']['s_user'] && md5($user_psw)==$setting['web']['s_pass']) {
					$uid=0;
					$groupid=1;
				}
				if(isset($uid)) {
					$req->setCookie("ms_user", $uid."\t".md5($user_psw), 60*60*24*(float)$keep);
					if($groupid===0) {
						$goto_url = "../";
					} else {
						if(empty($referer)) $referer = "index.php";
						$goto_url = $referer;
					}
				} else {
					$ms_info = $setting['language']['login_error_psw'];
				}
			} else {
				$ms_info = $setting['language']['login_error_vcode'];
			}
		}
		break;
	case "logout":
		$ms_info = $setting['language']['login_logout'];
		$req->setCookie("ms_user");
		$req->destroySession();
		break;
}

if(empty($goto_url)) build_page();
$mystep->pageEnd(false);

function build_page() {
	global $mystep, $req, $tpl, $tpl_info, $setting, $ms_info;
	$tpl_info['idx'] = "login";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if(empty($ms_info)) $ms_info = $setting['language']['login_login'];
	$tpl->Set_Variable('title', $setting['web']['title']);
	$tpl_tmp->Set_Variable('err_msg', $ms_info);
	$req->setCookie("ms_info");
	$tpl_tmp->Set_Variable('referer', $req->getCookie("referer"));
	$req->setCookie("referer");
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>