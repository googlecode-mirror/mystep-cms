<?php
require("inc.php");

$tpl_info['idx'] = "user_online";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

$order = $req->getGet("order");
$order_type = $req->getGet("order_type");
if(empty($order_type)) $order_type = "desc";
$keyword = $req->getGet("keyword");
$tpl_tmp->Set_Variable('keyword', $keyword);

$condition = array();
if(!empty($keyword)) $condition[] = array("username","like",$keyword);
$counter = $db->result($setting['db']['pre']."user_online","count(*)",$condition);

$page = $req->getGet("page");
list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
$tpl_tmp->Set_Variables($page_arr);

if(empty($order)) $order="reflash";
$db->select($setting['db']['pre']."user_online", "*", $condition, array("order"=>"$order $order_type","limit"=>"$page_start, $page_size"));

$tpl_tmp->Set_Variable('order_type_org', $order_type);
if($order_type=="desc") {
	$order_type = "asc";
} else {
	$order_type = "desc";
}
$tpl_tmp->Set_Variable('order', $order);
$tpl_tmp->Set_Variable('order_type', $order_type);
while($record = $db->GetRS()) {
	$record['userinfo'] = unserialize($record['userinfo']);
	HtmlTrans(&$record);
	$record['reflash'] = date("Y-m-d H:i:s", $record['reflash']);
	$type_info = getParaInfo("user_type", "type_id", $record['usertype']);
	$record['usertype'] = $type_info['type_name'];
	if($group_info = getParaInfo("user_group", "group_id", $record['usergroup'])) {
		$record['usertype'] .= " ги".$group_info['group_name']."гй"; 
	}
	if(isset($record['userinfo']['name']))  $record['username'] = $record['userinfo']['name'];
	$tpl_tmp->Set_Loop('record', $record);
}
$tpl_tmp->Set_Variable('title', $setting['language']['admin_user_online_title']);
$db->Free();

$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);

$mystep->show($tpl);
$mystep->pageEnd(false);
?>