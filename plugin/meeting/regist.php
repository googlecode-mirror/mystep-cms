<?php
$mid = $req->getReq("mid");

if(count($_POST)>0) {
	if(isset($_COOKIE['reg_time'])) {
		if($req->getCookie("reg_done")>time()) {
			if($setting['gen']['language']=="en") {
				echo '
				<script>
					alert("You can only make a registration for one time in 5 minutes.");
					history.go(-1);
				</script>
				';
			} else {
				echo '
				<script>
					alert("禁止在短时间内连续注册，请稍后再试！");
					history.go(-1);
				</script>
				';
			}
		} else {
			unset($_POST['mid']);
			$_POST['add_date'] = date("Y-m-d H:i:s");
			$str_sql = $db->buildSQL($setting['db']['pre']."meeting_".$mid, $_POST, "insert", "a");
			$db->Query($str_sql);
			if($setting['gen']['language']=="en") {
				echo '
				<script>
					alert("Congratulations! Your online registration succeeded. We will reply to you within 3 working days. Please note our feedback and remit indicated registration fee.");
					location.href="./";
				</script>
				';
			} else {
				echo '
				<script>
					alert("恭喜您网上注册成功，我们将尽快回复您确认邮件，请注意查收并按要求汇款。");
					location.href="./";
				</script>
				';
			}
			unset($_COOKIE['reg_time']);
			$req->setCookie("reg_done", time()+300, time()+300);
			$mystep->pageEnd(false);
		}
	} else {
		if($setting['gen']['language']=="en") {
			echo '
			<script>
				alert("Registration time expired, try again.");
				history.go(-1);
			</script>
			';
		} else {
			echo '
			<script>
				alert("注册表填写时间过长，请再次提交！");
				history.go(-1);
			</script>
			';
		}
	}
}

$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
	
$tpl_info['idx'] = $mid."_".$module."_".($setting['gen']['language']=="en"?"en":"cn");
$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/setting/";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

if($module=="regist") {
	$tpl_tmp->allow_script = true;
	global $para;
	include("setting/{$mid}.php");
} elseif($module=="reglist") {
	global $limit;
	$page = $req->getGet("page");
	if(!is_numeric($page) || $page < 1) $page = 1;
	$page_size = $setting['list']['txt'];
	$count = $db->getSingleResult("select count(*) from ".$setting['db']['pre']."meeting_".$mid);
	$tpl_tmp->Set_Variable('page_list', PageList($page, ceil($count/$page_size)));
	$tpl_tmp->Set_Variable('title', $setting['web']['title']);
	$limit = (($page-1)*$page_size).", ".$page_size;
	$GLOBALS['mid'] = $mid;
}

$tpl_tmp->Set_Variable('mid', $mid);
$tpl_tmp->Set_Variable('meeting_name', $db->GetSingleResult("select name".($setting['gen']['language']=="en"?"_en":"")." from ".$setting['db']['pre']."meeting where mid=".$mid));
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting,$db,$para'));
unset($tpl_tmp);

$mystep->show($tpl);
$mystep->pageEnd();
?>