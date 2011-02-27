<?php
require("inc.php");

$tpl_info['idx'] = "info_count";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

$order = $req->getGet("order");
$tpl_tmp->Set_Variable('order', $order);
$order_type = $req->getGet("order_type");
if(empty($order_type)) $order_type = "desc";

//navigation
$str_sql = "select count(*) as counter from ".$setting['db']['pre']."counter";
$counter = $db->GetSingleResult($str_sql);
$tpl_tmp->Set_If('empty', ($counter==0));
$page = $req->getGet("page");
list($page_arr, $page_start, $page_size) = GetPageList($counter, "?order={$order}&order_type={$order_type}", $page);
$tpl_tmp->Set_Variables($page_arr);

//main list
$str_sql = "select * from ".$setting['db']['pre']."counter";
$str_sql.= " order by".(empty($order)?" ":" {$order} {$order_type}, ")."date {$order_type}";
$str_sql.= " limit {$page_start}, {$page_size}";
$db->Query($str_sql);
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

$tpl_tmp->Set_Variable('title', $language['admin_info_count_title']);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
$db->Free();
$mystep->show($tpl);
$mystep->pageEnd(false);
?>