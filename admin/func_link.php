<?php
require("inc.php");

includeCache("link");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$id = $req->getReq("id");
$idx = $req->getReq("idx");
$log_info = "";

if(!empty($id)) {
	$cur_link = getParaInfo("link_txt", "id", $id);
	if($cur_link==false) $cur_link = getParaInfo("link_img", "id", $id);
	if($cur_link==false || (!$op_mode && $web_id!=$cur_link['web_id'])) {
		echo showInfo($setting['language']['admin_func_link_error']);
		$mystep->pageEnd(false);
	}
}

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_func_link_delete'];
		$db->delete($setting['db']['pre']."links", array("id","n=",$id));
		deleteCache("link");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			if($method=="add_ok") {
				$log_info = $setting['language']['admin_func_link_add'];
				$db->insert($setting['db']['pre']."links", $_POST, true);
			} else {
				$log_info = $setting['language']['admin_func_link_edit'];
				$db->update($setting['db']['pre']."links", $_POST, array("id","n=",$id));
			}
			deleteCache("link");
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
	global $mystep, $req, $db, $tpl, $tpl_info, $setting, $id, $idx, $web_id;
	
	$tpl_info['idx'] = "func_link_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$condition = array();
		if(!empty($idx)) $condition[] = array("idx","=",$idx);
		if(!empty($web_id)) $condition[] = array("web_id","n=",$web_id);
		
		$counter = $db->result($setting['db']['pre']."links", "count(*)", $condition);
		$page = $req->getGet("page");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);

		$order = $req->getGet("order");
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		if(empty($order)) $order="id";
		$the_order = array();
		$the_order[] = "$order $order_type";
		if($order!="id") $the_order[] = "id desc";
		$db->select($setting['db']['pre']."links", "*", $condition, array("order"=>$the_order,"limit"=>"$page_start, $page_size"));
		
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
		$db->Free();
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_func_link_title']);
		$tpl_tmp->Set_Variable('idx', $idx);
		$tpl_tmp->Set_Variable('web_id', $web_id);
	} else {
		if($method == "edit") {
			$record = $db->record($setting['db']['pre']."links", "*", array("id","n=",$id));
			if($record===false) {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_func_link_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			$web_id = $record['web_id'];
			$idx = $record['idx'];
			HtmlTrans(&$record);
		} else {
			$record['id'] = "0";
			$record['web_id'] = $web_id;
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
	
	for($i=0,$m=count($GLOBALS['website']); $i<$m; $i++) {
		$GLOBALS['website'][$i]['selected'] = $GLOBALS['website'][$i]['web_id']==$web_id?"selected":"";
		$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
	}
	
	$db->select($setting['db']['pre']."links", "distinct idx");
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