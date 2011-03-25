<?php
require("inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$id = $req->getReq("id");
$web_id = $req->getReq("web_id");
$log_info = "";

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_art_info_delete'];
		$db->Query("delete from ".$setting['db']['pre']."info_show where id = '{$id}'");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			if($method=="add_ok") {
				$log_info = $setting['language']['admin_art_info_add'];
				$str_sql = $db->buildSQL($setting['db']['pre']."info_show", $_POST, "insert", "a");
			} else {
				$log_info = $setting['language']['admin_art_info_edit'];
				$str_sql = $db->buildSQL($setting['db']['pre']."info_show", $_POST, "update", "id={$id}");
			}
			$db->Query($str_sql);
		}
		break;
	default:
		break;
}

if(!empty($log_info)) {
	write_log($log_info, "id={$id}");
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $tpl, $tpl_info, $setting, $id, $web_id;

	$tpl_info['idx'] = "art_info_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$db->Query("select * from ".$setting['db']['pre']."info_show order by id asc");
		$n = 0;
		while($record = $db->GetRS()) {
			$n++;
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_If('empty', ($n==0));
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_art_info_title']);
	} else {
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."info_show where id='{$id}'");
			$record  = $db->GetRS();
			$db->Free();
			if(!$record) {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_art_info_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			$web_id = $record['web_id'];
			HtmlTrans(&$record);
		} else {
			$record = array();
			$record['id'] = 0;
			$record['web_id'] = 0;
			$record['subject'] = "";
			$record['content'] = "";
		}
		$tpl_tmp->Set_Variables($record);
		
		$tpl_tmp->Set_Variable('title', ($method=='add'?$setting['language']['admin_art_info_add']:$setting['language']['admin_art_info_edit']));
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	
	$max_count = count($GLOBALS['website']);
	for($i=0; $i<$max_count; $i++) {
		$GLOBALS['website'][$i]['selected'] = $GLOBALS['website'][$i]['web_id']==$web_id?"selected":"";
		$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
	}
	$db->Free();

	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>