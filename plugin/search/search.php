<?php
require("../inc.php");
include("se.php");

$method = $req->getGet("method");
if(empty($method)) $method = "engine";

$idx = $req->getReq("idx");
$log_info = "";
switch($method) {
	case "engine":
	case "keyword":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['plugin_search_delete'];
		$db->delete($setting['db']['pre']."search_keyword",array("keyword","=",$req->getGet('k')));
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "update":
		if(count($_POST) != 0) {
			$log_info = $setting['language']['plugin_search_update'];
			$se = array();
			for($i=0, $m=count($_POST['key']);$i<$m;$i++) {
				if(empty($_POST['key'][$i]) || empty($_POST['value'][$i])) continue;
				$se[$_POST['key'][$i]] = $_POST['value'][$i];	
			}
			$content = "<?PHP
\$se = ".var_export($se, true).";			
?>";
			WriteFile("se.php", $content, "wb");
		}
		$goto_url = $setting['info']['self']."?method=engine";
		break;
	default:
		$goto_url = $setting['info']['self'];
}

if(!empty($log_info)) {
	write_log($log_info);
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $idx, $se;
	$tpl_info = array(
			"idx" => "main",
			"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
			"path" => ROOT_PATH."/".$setting['path']['template'],
			);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	$tpl_info['idx'] = $method;
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if($method=="engine") {
		$n = 1;
		foreach($se as $key => $value) {
			$record = array();
			$record['idx'] = $n++;
			$record['key'] = $key;
			$record['value'] = $value;
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_search_title']);	
	} elseif($method=="keyword") {
		$order = $req->getGet("order");
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$counter = $db->result($setting['db']['pre']."search_keyword", "count(*)");
		$page = $req->getGet("page");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?method=keyword&order=".$order."&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);
		if(empty($order)) $order = "chg_date";
		$db->select($setting['db']['pre']."search_keyword", "*", "", array("order"=>"{$order} {$order}","limit"=>"{$page_start}, {$page_size}"));
		while($record = $db->GetRS()) {
			$record['add_date'] = date("Y-m-d H:i:s", $record['add_date']);
			$record['chg_date'] = date("Y-m-d H:i:s", $record['chg_date']);
			$record['encode'] = urlencode($record['keyword']);
			$tpl_tmp->Set_Loop('record', $record);
		}
		$db->Free();
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_search_title_kw']);
		$tpl_tmp->Set_Variable('order_type_org', $order_type);
		if($order_type=="desc") {
			$order_type = "asc";
		} else {
			$order_type = "desc";
		}
		$tpl_tmp->Set_Variable('order', $order);
		$tpl_tmp->Set_Variable('order_type', $order_type);
	}
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>