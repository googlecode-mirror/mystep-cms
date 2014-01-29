<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "referer";

if($method=="del_keyword") {
	$db->delete($setting['db']['pre']."visit_keyword", array("id","n=",$req->getGet("id")));
	$goto_url = $req->getServer("HTTP_REFERER");
	$mystep->pageEnd(false);
}

$tpl_info = array(
		"idx" => "main",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);
$tpl_info['idx'] = $method;
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$order = $req->getGet("order");
$order_type = $req->getGet("order_type");
if(empty($order_type)) $order_type = "desc";
if($method == "referer") {
	$counter = $db->result($setting['db']['pre']."visit_analysis","count(*)");
	$page = $req->getGet("page");
	list($page_arr, $page_start, $page_size) = GetPageList($counter, "?method=referer&order={$order}&order_type={$order_type}", $page);
	$tpl_tmp->Set_Variables($page_arr);
	if(empty($order)) $order = "id";
	$db->select($setting['db']['pre']."visit_analysis","*","",array("order"=>"{$order} {$order_type}","limit"=>"{$page_start}, {$page_size}"));
	while($record = $db->GetRS()) {
		$record['add_date'] = date("Y-m-d H:i:s", $record['add_date']);
		$record['chg_date'] = date("Y-m-d H:i:s", $record['chg_date']);
		$tpl_tmp->Set_Loop('record', $record);
	}
	$db->Free();
} elseif($method == "keyword") {
	$counter = $db->result($setting['db']['pre']."visit_keyword","count(*)");
	$page = $req->getGet("page");
	list($page_arr, $page_start, $page_size) = GetPageList($counter, "?method=keyword&order={$order}&order_type={$order_type}", $page);
	$tpl_tmp->Set_Variables($page_arr);
	if(empty($order)) $order = "id";
	$db->select($setting['db']['pre']."visit_keyword","*","",array("order"=>"{$order} {$order_type}","limit"=>"{$page_start}, {$page_size}"));
	while($record = $db->GetRS()) {
		$record['keyword'] = stripcslashes($record['keyword']);
		$record['add_date'] = date("Y-m-d H:i:s", $record['add_date']);
		$record['chg_date'] = date("Y-m-d H:i:s", $record['chg_date']);
		$tpl_tmp->Set_Loop('record', $record);
	}
	$db->Free();
}

$tpl_tmp->Set_Variable('order_type_org', $order_type);
if($order_type=="desc") {
	$order_type = "asc";
} else {
	$order_type = "desc";
}
$tpl_tmp->Set_Variable('order', $order);
$tpl_tmp->Set_Variable('order_type', $order_type);

$tpl_tmp->Set_Variable('title', $setting['language']['plugin_visit_analysis_title_'.$method]);
$tpl->Set_Variable('path_admin', $setting['path']['admin']);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting'));
unset($tpl_tmp);
$mystep->show($tpl);

$mystep->pageEnd(false);
?>