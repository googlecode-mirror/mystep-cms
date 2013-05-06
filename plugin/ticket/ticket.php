<?php
require("../inc.php");
include("list.php");

$method = $req->getGet("method");
if(empty($method)) $method = "topic";
$id = $req->getReq('id');
$idx = $req->getReq('idx');
$log_info = "";
switch($method) {
	case "add":
	case "edit":
	case "topic":
	case "list":
	case "check":
		build_page($method);
		break;
	case "add_ok":
	case "edit_ok":
		$_POST['type'] = str_replace("\r", "", $_POST['type']);
		$_POST['type'] = explode("\n", $_POST['type']);
		if($method=="add_ok") {
			$log_info = $setting['language']['plugin_ticket_add'];
			for($i=0,$m=count($ticket_list);$i<$m;$i++) {
				if($ticket_list[$i]['idx'] == $idx) {
					showInfo($setting['language']['plugin_ticket_duplicate']);
				}
			}
			$_POST['lastpost'] = 0;
			$_POST['total'] = 0;
			$_POST['untreated'] = 0;
			$_POST['processing'] = 0;
			$_POST['done'] = 0;
			$ticket_list[] = 	$_POST;
		} else {
			$log_info = $setting['language']['plugin_ticket_edit'];
			for($i=0,$m=count($ticket_list);$i<$m;$i++) {
				if($ticket_list[$i]['idx'] == $idx) {
					$ticket_list[$i]['topic'] = $_POST['topic'];
					$ticket_list[$i]['email'] = $_POST['email'];
					$ticket_list[$i]['type'] = $_POST['type'];
					break;
				}
			}
		}
		$content = "<?PHP
\$ticket_list = ".var_export($ticket_list, true).";			
?>";
		WriteFile("list.php", $content, "wb");
		$goto_url = $setting['info']['self'];
		break;
	case "delete_topic":
		$log_info = $setting['language']['plugin_ticket_delete_topic'];
		$db->Query("delete from ".$setting['db']['pre']."ticket where idx = '".$idx."'");
		$new_ticket_list = array();
		for($i=0,$m=count($ticket_list);$i<$m;$i++) {
			if($ticket_list[$i]['idx'] == $idx) continue;
			$new_ticket_list[] = $ticket_list[$i];
		}
		$content = "<?PHP
\$ticket_list = ".var_export($new_ticket_list, true).";			
?>";
		WriteFile("list.php", $content, "wb");
		$goto_url = $setting['info']['self'];
		break;
	case "delete":
		$log_info = $setting['language']['plugin_ticket_delete'];
		$db->Query("delete from ".$setting['db']['pre']."ticket where id = '{$id}'");
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "reply":
		$log_info = $setting['language']['plugin_ticket_reply'];
		unset($_POST['id']);
		if(!empty($_POST['reply'])) {
			if($_POST['status']==0) $_POST['status'] = 1;
			if(isset($_POST['sendmail'])) {
				$topic_info = array();
				for($i=0,$m=count($ticket_list);$i<$m;$i++) {
					if($ticket_list[$i]['idx'] == $idx) {
						$topic_info = $ticket_list[$i];
						break;
					}
				}
				if(!empty($topic_info)) {
					$mail = $mystep->getInstance("MyEmail", $topic_info['email'], $setting['gen']['charset']);
					$mail->addEmail($topic_info['email'], $setting['web']['title'], "reply");
					$mail->setSubject("RE: ".$_POST['subject']);
					$mail->setContent($_POST['reply'], false);
					$mail->addEmail($_POST['email']);
					$flag = $mail->send($setting['email']);
					unset($mail);
					unset($_POST['sendmail']);
				}
			}
		}
		$db->Query($db->buildSQL($setting['db']['pre']."ticket", $_POST, "update", "id={$id}"));
		updateInfo($idx);
		$goto_url = $setting['info']['self']."?method=list&idx=".$idx;
		break;
	default:
		$goto_url = $setting['info']['self'];
}

function updateInfo($idx) {
	global $ticket_list, $db, $setting;
	for($i=0,$m=count($ticket_list);$i<$m;$i++) {
		if($ticket_list[$i]['idx'] == $idx) {
			$ticket_list[$i]['lastpost'] = $db->getSingleResult("select max(add_date) from ".$setting['db']['pre']."ticket where idx = '{$idx}'");
			$ticket_list[$i]['total'] = $db->getSingleResult("select count(*) from ".$setting['db']['pre']."ticket where idx = '{$idx}'");
			$ticket_list[$i]['untreated'] = $db->getSingleResult("select count(*) from ".$setting['db']['pre']."ticket where idx = '{$idx}' and `status`=0");
			$ticket_list[$i]['processing'] = $db->getSingleResult("select count(*) from ".$setting['db']['pre']."ticket where idx = '{$idx}' and `status`=1");
			$ticket_list[$i]['done'] = $db->getSingleResult("select count(*) from ".$setting['db']['pre']."ticket where idx = '{$idx}' and `status`=2");
			break;
		}
	}
	$content = "<?PHP
\$ticket_list = ".var_export($ticket_list, true).";			
?>";
	WriteFile("list.php", $content, "wb");
	return;
}

if(!empty($log_info)) {
	write_log($log_info, (isset($id)?"id={$id}":""));
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $id, $idx, $ticket_list;
	$tpl_info = array(
			"idx" => "main",
			"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
			"path" => ROOT_PATH."/".$setting['path']['template'],
			);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	if($method=="add" || $method=="edit") {
		$tpl_info['idx'] = "input";
	} else {
		$tpl_info['idx'] = $method;
	}
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if($method=="list") {
		$order = $req->getGet("order");
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$condition = "";
		if(!empty($idx)) $condition = "where idx='".$idx."'";
		$counter = $db->GetSingleResult("select count(*) as counter from ".$setting['db']['pre']."ticket ".$condition);
		$page = $req->getGet("page");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?method=list&order=".$order."&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);
		$str_sql = "select * from ".$setting['db']['pre']."ticket ".$condition." order by ".(empty($order)?"id":"{$order}")." {$order_type} limit {$page_start}, {$page_size}";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			$record['add_date'] = date("Y-m-d H:i:s", $record['add_date']);
			$tpl_tmp->Set_Loop('record', $record);
		}
		$db->Free();
		$tpl_tmp->Set_Variable('order_type_org', $order_type);
		if($order_type=="desc") {
			$order_type = "asc";
		} else {
			$order_type = "desc";
		}
		for($i=0,$m=count($ticket_list);$i<$m;$i++) {
			if($idx == $ticket_list[$i]['idx']) $ticket_list[$i]['selected']="selected";
			$tpl_tmp->Set_Loop('topic', $ticket_list[$i]);
		}
		$tpl_tmp->Set_Variable('order', $order);
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_ticket_title']);	
	} elseif($method=="topic") {
		for($i=0,$m=count($ticket_list);$i<$m;$i++) {
			if($ticket_list[$i]['lastpost']==0) {
				$ticket_list[$i]['lastpost'] = "";
			} else {
				$ticket_list[$i]['lastpost'] = date("Y-m-d", $ticket_list[$i]['lastpost']);
			}
			$tpl_tmp->Set_Loop('record', $ticket_list[$i]);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_ticket_title']);	
	} elseif($method=="check") {
		$record = $db->GetSingleRecord("select * from ".$setting['db']['pre']."ticket where id='{$id}'");
		if(!$record) {
			$tpl->Set_Variable('main', showInfo($setting['language']['admin_art_content_error'], 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		HtmlTrans(&$record);
		for($i=0,$m=count($ticket_list);$i<$m;$i++) {
			if($ticket_list[$i]['idx'] == $record['idx']) {
				$record['topic'] = $ticket_list[$i]['topic'];
				break;
			}
		}	
		$tpl_tmp->Set_Variables($record);
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_ticket_title']);	
	} else {
		$record = array();
		if($method=="edit") {
			for($i=0,$m=count($ticket_list);$i<$m;$i++) {
				if($ticket_list[$i]['idx'] == $idx) {
					$record = $ticket_list[$i];
					$record['type'] = implode("\n", $record['type']);
					$record['disabled'] = "readonly";
					break;
				}
			}
		}
		$tpl_tmp->Set_Variables($record);
		$tpl_tmp->Set_Variable('method', $method);	
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_ticket_title']);	
	}
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>