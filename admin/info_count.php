<?php
require("inc.php");

$tpl_info['idx'] = "info_count";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

$order = $req->getGet("order");
$tpl_tmp->Set_Variable('order', $order);
$order_type = $req->getGet("order_type");
if(empty($order_type)) $order_type = "desc";

//navigation
$counter = $db->result($setting['db']['pre']."counter", "count(*)");
$tpl_tmp->Set_If('empty', ($counter==0));
$page = $req->getGet("page");
list($page_arr, $page_start, $page_size) = GetPageList($counter, "?order={$order}&order_type={$order_type}", $page);
$tpl_tmp->Set_Variables($page_arr);

//main list
$the_order = array();
if(!empty($order)) $the_order[] = "$order $order_type";
$the_order[] = "date {$order_type}";
$db->select($setting['db']['pre']."counter", "*", array(), array("order"=>$the_order,"limit"=>"$page_start, $page_size"));


$tpl_tmp->Set_Variable('order_type_org', $order_type);
if($order_type=="asc") {
	$order_type = "desc";
} else {
	$order_type = "asc";
}
$tpl_tmp->Set_Variable('order_type', $order_type);
while($record = $db->GetRS()) {
	HtmlTrans(&$record);
	$tpl_tmp->Set_Loop('record', $record);
}

$tpl_tmp->Set_Variable('title', $setting['language']['admin_info_count_title']);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
$db->Free();
$mystep->show($tpl);
$mystep->pageEnd(false);
?>