<?php
$method = $req->getGet("f");
switch($method) {
	case "login":
		extract($_POST, EXTR_SKIP);
		if(isset($user_name, $user_psw, $check_code)) {
			if(strtolower($check_code) == strtolower($req->getCookie("vcode"))) {
				$msg = $mystep->login($user_name, $user_psw);
			} else {
				$msg = $setting['language']['login_error_vcode'];
			}
		} else {
			$msg = $setting['language']['login_error'];
		}
		$req->setCookie("ms_info", $msg, 60*10);
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "logout":
		$mystep->logout();
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	default:
		$goto_url = "/";
}
$mystep->pageEnd();
?>