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
		$db->delete($setting['db']['pre']."topic",array("topic_id","n=",$topic_id));
		$db->delete($setting['db']['pre']."topic_link",array("topic_id","n=",$topic_id));
		unlink(dirname(__FILE__)."/topic/".$topic_id.".tpl");
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "add_ok":
	case "edit_ok":
		$_POST['topic_cat'] = str_replace("£¬", ",", $_POST['topic_cat']);
		$tpl_content = $_POST['topic_tpl'];
		unset($_POST['topic_tpl']);
		$tpl_content = str_replace("&#160;"," ",$tpl_content);
		if($method=="add_ok") {
			$log_info = $setting['language']['plugin_topic_add'];
			$_POST['add_date'] = "now()";
			$db->insert($setting['db']['pre']."topic", $_POST, true);
			$top_id = $db->GetInsertId();
		} else {
			$log_info = $setting['language']['plugin_topic_edit'];
			$top_id = $_POST['topic_id'];
			unset($_POST['topic_id']);
			$db->update($setting['db']['pre']."topic", $_POST, array("topic_id","n=",$topic_id));
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
		
		$condition = array();
		if(!empty($keyword)) $condition[] = array("topic_name","like",$keyword);
		$counter = $db->result($setting['db']['pre']."topic", "count(*)",$condition);
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);

		$the_order = array();
		if(empty($order)) $order="topic_id";
		$the_order[] = "{$order} {$order_type}";
		if($order!="topic_id") $the_order[] = "topic_id {$order_type}";
		$db->select($setting['db']['pre']."topic","*",$condition,array("order"=>$the_order,"limit"=>"$page_start, $page_size"));
		while($record = $db->GetRS()) {
			if(empty($record['topic_link'])) $record['topic_link'] = getUrl("topic", $record['topic_idx']);
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
			$record = $db->record($setting['db']['pre']."topic","*",array("topic_id","n=",$topic_id));
			if($record===false) {
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
			
			$n = 1;
			$db->select($setting['db']['pre']."topic_link","*",array("topic_id","n=",$topic_id),array("order"=>"link_order desc,id desc"));
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