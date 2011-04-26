<?php
require("inc.php");

includeCache("link");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$id = $req->getReq("id");
$idx = $req->getReq("idx");
$log_info = "";

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_func_link_delete'];
		$db->Query("delete from ".$setting['db']['pre']."links where id = '$id'");
		deleteCache("link");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) > 0) {
			if($method=="add_ok") {
				$log_info = $setting['language']['admin_func_link_add'];
				$str_sql = $db->buildSQL($setting['db']['pre']."links", $_POST, "insert", "a");
			} else {
				$log_info = $setting['language']['admin_func_link_edit'];
				$str_sql = $db->buildSQL($setting['db']['pre']."links", $_POST, "update", "id={$id}");
			}
			$db->Query($str_sql);
			deleteCache("link");
		} else {
			$goto_url = $setting['info']['self'];
		}
		break;
	default:
		break;
}

if(!empty($log_info)) {
	write_log($log_info, "id={$id}");
	$goto_url = basename($req->getServer($method=="delete"?"HTTP_REFERER":"PHP_SELF"));
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $tpl, $tpl_info, $setting, $id, $idx;
	
	$tpl_info['idx'] = "func_link_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$order = $req->getGet("order");
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		

		$str_sql = "select count(*) as counter from ".$setting['db']['pre']."links";
		if(!empty($idx)) $str_sql .= " where idx='".$idx."'";
		$counter = $db->GetSingleResult($str_sql);
		$page = $req->getGet("page");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);

		$str_sql = "select * from ".$setting['db']['pre']."links";
		if(!empty($idx)) $str_sql .= " where idx='".$idx."'";
		if(empty($order)) $order="id";
		$str_sql.= " order by $order {$order_type}".(($order=="id")?"":", id desc");
		$str_sql.= " limit $page_start, $page_size";
		$db->Query($str_sql);
		$tpl_tmp->Set_Variable('order_type_org', $order_type);
		if($order_type=="desc") {
			$order_type = "asc";
		} else {
			$order_type = "desc";
		}
		$tpl_tmp->Set_Variable('order', $order);
		$tpl_tmp->Set_Variable('order_type', $order_type);
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			if(!empty($record['image'])) {
				$record['image'] = "<img width='88' height='31' src='".$record['image']."' />";
			} else {
				$record['image'] = "&nbsp;";
			}
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_func_link_title']);
		$tpl_tmp->Set_Variable('idx', $idx);
	} else {
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."links where id='{$id}'");
			$record  = $db->GetRS();
			$db->Free();
			if(!$record) {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_func_link_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			HtmlTrans(&$record);
			$idx = $record['idx'];
		} else {
			$record['id'] = "0";
			$record['idx'] = "";
			$record['link_name'] = "";
			$record['link_url'] = "http://";
			$record['level'] = "1";
			$record['image'] = "";
		}
		$tpl_tmp->Set_Variables($record);
		$tpl_tmp->judge_list['edit'] = ($method == "edit");
		$tpl_tmp->Set_Variable('title', ($method == "add"?$setting['language']['admin_func_link_add']:$setting['language']['admin_func_link_edit']));
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$db->Free();
	
	$db->Query("select distinct idx from ".$setting['db']['pre']."links");
	while($record = $db->GetRS()) {
		$record['selected'] = $record['idx']==$idx?"selected":"";
		$tpl_tmp->Set_Loop('idx', $record);
	}
	$db->Free();
	
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>