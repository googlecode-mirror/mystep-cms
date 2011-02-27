<?php
require("inc.php");

$tpl_info['idx'] = "user_online";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

$order = $req->getGet("order");
$order_type = $req->getGet("order_type");
if(empty($order_type)) $order_type = "desc";
$keyword = $req->getGet("keyword");
$tpl_tmp->Set_Variable('keyword', $keyword);

$str_sql = "select count(*) as counter from ".$setting['db']['pre']."user_online where 1=1";
if(!empty($keyword)) $str_sql.= " and username like '%{$keyword}%'";
$str_sql .= " order by reflash desc";
$counter = $db->GetSingleResult($str_sql);
$page = $req->getGet("page");
list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
$tpl_tmp->Set_Variables($page_arr);

$str_sql = "select * from ".$setting['db']['pre']."user_online where 1=1";
if(!empty($keyword)) $str_sql.= " and username like '%{$keyword}%'";
$str_sql.= " order by ".(empty($order)?"reflash":"$order")." {$order_type}";
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
	$record['reflash'] = date("Y-m-d H:i:s", $record['reflash']);
	$group_info = getParaInfo("user_group", "group_id", $record['usertype']);
	$record['usertype'] = $group_info['group_name'];
	$tpl_tmp->Set_Loop('record', $record);
}
$tpl_tmp->Set_Variable('title', $language['admin_user_online_title']);
$db->Free();

$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);

$mystep->show($tpl);
$mystep->pageEnd(false);
?>