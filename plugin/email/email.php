<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";

$id = $req->getReq("id");
$log_info = "";
switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['plugin_email_delete'];
		$attachment = $db->result($setting['db']['pre']."email","attachment",array("id","n=",$id));
		preg_match_all("/(^|\n)(\d+)\|/", $attachment, $matches);
		for($i=0,$m=count($matches[2]); $i<$m; $i++) {
			@unlink(dirname(__FILE__)."/attachment/".$matches[2][$i]);
		}
		$db->delete($setting['db']['pre']."email",array("id","n=",$id));
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			$log_info = $setting['language']['plugin_email_send'];
			if(!isset($_POST['notification'])) $_POST['notification'] = "";
			if($method=="add_ok") {
				$log_info = $setting['language']['plugin_email_add'];
				$db->insert($setting['db']['pre']."email", $_POST, true);
			} else {
				$log_info = $setting['language']['plugin_email_edit'];
				$db->update($setting['db']['pre']."email", $_POST, array("id","n=",$id));
			}
			if($method=="add_ok") {
				$id = $db->GetInsertId();
			}
			send_mail($id);
		}
		break;
	case "send":
		$log_info = $setting['language']['plugin_email_send'];
		send_mail($id);
		break;
	default:
		$goto_url = $setting['info']['self'];
}

if(!empty($log_info)) {
	write_log($log_info, "id=".$id);
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $id;

	$tpl_info = array(
		"idx" => ($method=="list"?"list":"input"),
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$db->select($setting['db']['pre']."email","*","",array("order"=>"id desc"));
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$tpl->Set_Loop('record', $record);
		}
		$db->Free();
		$tpl->Set_Variable('title', $setting['language']['plugin_email_title']);
	} else {
		if($method == "edit") {
			$record = $db->record($setting['db']['pre']."email","*",array("id","n=",$id));
			if($record===false) {
				$tpl->Set_Variable('main', showInfo($setting['language']['plugin_email_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			HtmlTrans(&$record);
		} else {
			$record = array();
			$record['id'] = 0;
			$record['subject'] = "";
			$record['from'] = "";
			$record['reply'] = "";
			$record['notification'] = "";
			$record['priority'] = 3;
			$record['to'] = "";
			$record['cc'] = "";
			$record['bcc'] = "";
			$record['header'] = "";
			$record['content'] = "";
			$record['attachment'] = "";
		}
		$record['send_date'] = date("Y-m-d H:i:s");
		$tpl->Set_Variables($record);
		$tpl->Set_Variable('title', ($method=='add'?$setting['language']['plugin_email_add']:$setting['language']['plugin_email_edit']));
		$tpl->Set_Variable('method', $method);
		$tpl->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$db->Free();
	$mystep->show($tpl);
	return;
}

function send_mail($id) {
	global $mystep, $req, $db, $setting, $id;
	ignore_user_abort("on");
	set_time_limit(0);
	$record = $db->record($setting['db']['pre']."email","*",array("id","n=",$id));
	if($record===false) return false;
	$mail = $mystep->getInstance("MyEmail", "", $setting['gen']['charset'], "send.log");
	list($from, $name) = parse_mail($record['from']);
	$mail->setFrom($from, $name, false);
	$mail->setSubject($record['subject']);
	$mail->setContent($record['content'], true);
	
	$n = 0;
	$record['reply'] = str_replace("\r", "", $record['reply']);
	$reply = explode("\n", $record['reply']);
	for($i=0,$m=count($reply);$i<$m;$i++) {
		list($from, $name) = parse_mail($reply[$i]);
		$mail->addEmail($from, $name, "reply");
		$n++;
	}
	
	$record['to'] = str_replace("\r", "", $record['to']);
	$to = explode("\n", $record['to']);
	for($i=0,$m=count($to);$i<$m;$i++) {
		list($from, $name) = parse_mail($to[$i]);
		$mail->addEmail($from, $name, "to");
		$n++;
	}
	
	$record['cc'] = str_replace("\r", "", $record['cc']);
	$cc = explode("\n", $record['cc']);
	for($i=0,$m=count($cc);$i<$m;$i++) {
		list($from, $name) = parse_mail($cc[$i]);
		$mail->addEmail($from, $name, "cc");
		$n++;
	}
	
	$record['bcc'] = str_replace("\r", "", $record['bcc']);
	$bcc = explode("\n", $record['bcc']);
	for($i=0,$m=count($bcc);$i<$m;$i++) {
		list($from, $name) = parse_mail($bcc[$i]);
		$mail->addEmail($from, $name, "bcc");
		$n++;
	}
	
	if($n>100) $record['single']=1;
	
	if(!empty($record['notification'])) 	$mail->addHeader("Disposition-Notification-To", $record['from']);
	
	$record['attachment'] = str_replace("\r", "", $record['attachment']);
	$attachment = explode("\n", $record['attachment']);
	for($i=0,$m=count($attachment);$i<$m;$i++) {
		if(empty($attachment[$i])) continue;
		$current = explode("|", $attachment[$i]);
		$mail->addFile(dirname(__FILE__)."/attachment/".$current[0], $current[1], $current[2], ($current[3]==1));
	}
	
	$plugin_setting['email'] = null;
	if(is_file(dirname(__FILE__)."/config.php")) include(dirname(__FILE__)."/config.php");
	$flag = $mail->send($plugin_setting['email'], ($record['single']==1), $record['priority'], $record['header']);
	unset($mail);
	return $flag;
}

function parse_mail($str) {
	$result = array();
	if(preg_match("/^[\w\-\.]+@([\w\-]+\.)+[a-z]{2,4}$/", $str)) {
		$result = array($str, "");
	} elseif(preg_match("/^(.+?)\s*<([\w\-\.]+@([\w\-]+\.)+[a-z]{2,4})>$/i", $str, $match)) {
		$result = array($match[2], $match[1]);
	}
	return $result;
}
?>