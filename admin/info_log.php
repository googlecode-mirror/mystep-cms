<?php
require("inc.php");

$keyword = $req->getGet("keyword");
$method = $req->getGet("method");
$log_info = "";

if($method=="clean") {
	$log_info = $setting['language']['admin_info_log_clean'];
	$db->delete($setting['db']['pre']."modify_log");
	$goto_url = $setting['info']['self'];
} elseif($method=="download") {
	$log_info = $setting['language']['admin_info_log_download'];
	$db->select($setting['db']['pre']."modify_log", "*", array(), array("order"=>"id desc"));
	$content = "";
	while($record = $db->GetRS()) {
		$content .= join(",", $record)."\n";
	}
	if(!empty($content)) {
		if(ob_get_length()) ob_end_clean();
		$content = preg_replace("/\n+/", "\n", $content);
		$content = str_replace("\n", "\r\n", $content);
		header("Content-type: text/plain");
		header("Accept-Ranges: bytes");
		header("Accept-Length: ".strlen($content));
		header("Content-Disposition: attachment; filename=".date("Ymd")."_log.txt");
		echo $content;
	}
}

if(!empty($log_info)) {
	write_log($log_info);
	$mystep->pageEnd(false);
}

$tpl_info['idx'] = "info_log";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

$order = $req->getGet("order");
$tpl_tmp->Set_Variable('order', $order);
$order_type = $req->getGet("order_type");
if(empty($order_type)) $order_type = "desc";

//navigation
$condition = array();
if(!empty($keyword)) $condition[] = array("user","like",$keyword);
$counter = $db->result($setting['db']['pre']."modify_log","count(*)",$condition);
$tpl_tmp->Set_If('empty', ($counter==0));
$page = $req->getGet("page");
list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
$tpl_tmp->Set_Variables($page_arr);

//main list
if(empty($order)) $order="id";
$the_order = array();
$the_order[] = "$order $order_type";
if($order!="id") $the_order[] = "id desc";
$db->select($setting['db']['pre']."modify_log", "*", $condition, array("order"=>$the_order,"limit"=>"$page_start, $page_size"));

$tpl_tmp->Set_Variable('order_type_org', $order_type);
if($order_type=="asc") {
	$order_type = "desc";
} else {
	$order_type = "asc";
}
$tpl_tmp->Set_Variable('order_type', $order_type);
while($record = $db->GetRS()) {
	HtmlTrans(&$record);
	$record['time'] = date("Y-m-d H:i:s", $record['time']);
	$tpl_tmp->Set_Loop('record', $record);
}

$tpl_tmp->Set_Variable('keyword', $keyword);
$tpl_tmp->Set_Variable('title', $setting['language']['admin_info_log_title']);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
$db->Free();
$mystep->show($tpl);
$mystep->pageEnd(false);
?>