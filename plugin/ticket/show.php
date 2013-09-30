<?php
$idx = $req->getReq("idx");
include(realpath(dirname(__FILE__))."/list.php");
$topic_info = array();
for($i=0,$m=count($ticket_list);$i<$m;$i++) {
	if($ticket_list[$i]['idx'] == $idx) {
		$topic_info = $ticket_list[$i];
		break;
	}
}
if(!empty($topic_info)) {
	$info = "";
	if(count($_POST)>0) {
		$_POST['add_date'] = time();
		$str_sql = $db->buildSQL($setting['db']['pre']."ticket", $_POST, "insert", "a");
		$db->Query($str_sql);
		$info = $setting['language']['plugin_ticket_post'];
		$mail = $mystep->getInstance("MyEmail", $_POST['email'], $setting['gen']['charset']);
		$mail->addEmail($_POST['email'], $_POST['name'], "reply");
		$mail->setFrom($_POST['email'], $_POST['name'], true);
		$mail->setSubject($_POST['subject']." - ".$setting['language']['plugin_ticket_notice']);
		$mail->setContent($_POST['message'], false);
		$mail->addEmail($topic_info['email']);
		$flag = $mail->send($setting['email']);
		unset($mail);
	}
	$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
	$tpl_info['idx'] = "show";
	$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	$tickets = getData("select * from ".$setting['db']['pre']."ticket where idx='".mysql_real_escape_string($idx)."' and reply!='' order by reply_date desc", "all", 86400);
	for($i=0,$m=count($tickets);$i<$m;$i++) {
		$tickets[$i]['id'] = $i+1;
		$tickets[$i]['add_date'] = date("Y-m-d H:i:s", $tickets[$i]['add_date']);
		$tickets[$i]['message'] = nl2br($tickets[$i]['message']);
		$tickets[$i]['reply'] = nl2br($tickets[$i]['reply']);
		if($tickets[$i]['status']==2) {
			$tickets[$i]['color'] = "#f6fcf3";
		} else {
			$tickets[$i]['color'] = "#fcf3fa";
		}
		$tpl_tmp->Set_Loop('record', $tickets[$i]);
	}
	for($i=0,$m=count($topic_info['type']);$i<$m;$i++) {
		$tpl_tmp->Set_Loop('type', array("name"=>$topic_info['type'][$i]));
	}
	$tpl_tmp->Set_Variables($req->getSession("userinfo"), "user");
	$tpl_tmp->Set_Variable('idx', $topic_info['idx']);
	$tpl_tmp->Set_Variable('topic', $topic_info['topic']);
	$tpl_tmp->Set_Variable('info', $info);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content());
	unset($tpl_tmp);
	$mystep->show($tpl);
} else {
	$goto_url = "/";
}
?>