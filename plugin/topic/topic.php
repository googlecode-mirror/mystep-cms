<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$topic_id = $req->getReq("topic_id");
$log_info = "";

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['plugin_topic_delete'];
		$db->Query("delete from ".$setting['db']['pre']."topic where topic_id='{$topic_id}'");
		$db->Query("delete from ".$setting['db']['pre']."topic_link where topic_id='{$topic_id}'");
		unlink(dirname(__FILE__)."/topic/".$topic_id.".tpl");
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "add_ok":
	case "edit_ok":
		$_POST['topic_cat'] = str_replace("£¬", ",", $_POST['topic_cat']);
		$tpl_content = $_POST['topic_tpl'];
		unset($_POST['topic_tpl']);
		if($method=="add_ok") {
			$log_info = $setting['language']['plugin_topic_add'];
			$_POST['add_date'] = "now()";
			$db->Query($db->buildSQL($setting['db']['pre']."topic", $_POST, "insert", "a"));
			$top_id = $db->GetInsertId();
		} else {
			$log_info = $setting['language']['plugin_topic_edit'];
			$top_id = $_POST['topic_id'];
			unset($_POST['topic_id']);
			$db->Query($db->buildSQL($setting['db']['pre']."topic", $_POST, "update", "topic_id={$topic_id}"));
		}
		WriteFile("topic/".$top_id.".tpl", $tpl_content, "wb");
		break;
	default:
		break;
}

if(!empty($log_info)) {
	write_log($log_info, "topic_id=".$topic_id);
	if(empty($goto_url)) $goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $mydb, $setting, $topic_id;
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
	
	if($method == "list") {
		$order = $req->getGet("order");
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$keyword = $req->getGet("keyword");
		$page = $req->getGet("page");
		
		$condition = "1=1";
		$condition .= empty($keyword) ? "" : " and topic_name like '%{$keyword}%'";
		$str_sql = "select count(*) as counter from ".$setting['db']['pre']."topic where {$condition}";
		$counter = $db->GetSingleResult($str_sql);
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);

		$str_sql = "select * from ".$setting['db']['pre']."topic where {$condition}";
		if(empty($order)) $order="topic_id";
		$str_sql.= " order by $order {$order_type}".(($order=="topic_id")?"":", topic_id desc");
		$str_sql.= " limit $page_start, $page_size";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			//HtmlTrans(&$record);
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('order_type_org', $order_type);
		if($order_type=="desc") {
			$order_type = "asc";
		} else {
			$order_type = "desc";
		}
		$tpl_tmp->Set_Variable('keyword', $keyword);
		$tpl_tmp->Set_Variable('order', $order);
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_topic_title']);
	} else {
		$record = array();
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."topic where topic_id='{$topic_id}'");
			$record = $db->GetRS();
			$db->Free();
			if(!$record) {
				$tpl->Set_Variable('main', showInfo($setting['language']['plugin_topic_error'], 0));
				$mystep->show($tpl);
				return;
			}
			$record['topic_tpl'] = GetFile("topic/".$topic_id.".tpl");
			HtmlTrans(&$record);
			$style_list = explode(",", $record['topic_cat']);
			$max_count = count($style_list);
			for($i=0; $i<$max_count; $i++) {
				$tpl_tmp->Set_Loop('style_list', array("index"=>$i, "style"=>$style_list[$i]));
			}
			
			$str_sql = "select * from ".$setting['db']['pre']."topic_link where topic_id='{$topic_id}' order by id desc";
			$db->Query($str_sql);
			$n = 1;
			while($links = $db->GetRS()) {
				HtmlTrans(&$links);
				$links['idx'] = $n++;
				$links['link_cat'] = $style_list[$links['link_cat']];
				if(empty($links['link_url'])) $links['link_url'] = "/read.php?id=".$links['news_id'];
				$tpl_tmp->Set_Loop('link_list', $links);
			}
		} else {
			$record = array();
			$record['topic_id'] = 0;
		}
		
		$tpl_tmp->Set_Variables($record);
		$tpl_tmp->Set_Variable('show_link', ($method=="edit"?"":"none"));
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_topic_'.$method]);
		$tpl_tmp->Set_Variable('method', $method);
	}
	$tpl_tmp->Set_Variable('max_size', ini_get('upload_max_filesize'));
	$tpl_tmp->Set_Variable('path_admin', $setting['path']['admin']);
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting'));
	$db->Free();
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>