<?php
$mid = $req->getReq("mid");

if(count($_POST)>0 && isset($_COOKIE['reg_time'])) {
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
	$mystep->pageEnd(false);
}

$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	
$tpl_info['idx'] = $mid."_regist_".($setting['gen']['language']=="en"?"en":"cn");
$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$tpl_tmp->allow_script = true;
$tpl_tmp->Set_Variable('mid', $mid);
$tpl_tmp->Set_Variable('meeting_name', $db->GetSingleResult("select name".($setting['gen']['language']=="en"?"_en":"")." from ".$setting['db']['pre']."meeting where mid=".$mid));
global $para;
include("setting/{$mid}.php");
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting,$para'));
unset($tpl_tmp);

$mystep->show($tpl);
$mystep->pageEnd();
?>