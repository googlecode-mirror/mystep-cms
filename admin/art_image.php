<?php
require("inc.php");

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
		$log_info = $setting['language']['admin_art_image_delete'];
		$db->Query("delete from ".$setting['db']['pre']."news_image where id = '{$id}'");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			$_POST['image'] = str_replace("//", "/", $_POST['image']);
			if($method=="add_ok") {
				$log_info = $setting['language']['admin_art_image_add'];
				$str_sql = $db->buildSQL($setting['db']['pre']."news_image", $_POST, "insert", "a");
			} else {
				$log_info = $setting['language']['admin_art_image_edit'];
				$str_sql = $db->buildSQL($setting['db']['pre']."news_image", $_POST, "update", "id={$id}");
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
	global $mystep, $req, $db, $tpl, $tpl_info, $setting, $id;

	$tpl_info['idx'] = "art_image_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$db->Query("select * from ".$setting['db']['pre']."news_image order by id asc");
		while($record = $db->GetRS()) {
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_art_image_title']);
	} else {
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."news_image where id='{$id}'");
			$record  = $db->GetRS();
			$db->Free();
			if(!$record) {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_art_image_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			$web_id = $record['web_id'];
			HtmlTrans(&$record);
		} else {
			$record = array();
			$record['id'] = 0;
			$record['name'] = "";
			$record['keyword'] = "";
			$record['image'] = "";
		}
		$tpl_tmp->Set_Variables($record);
		
		$tpl_tmp->Set_Variable('title', ($method=='add'?$setting['language']['admin_art_image_add']:$setting['language']['admin_art_image_edit']));
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>