<?php
require("../inc.php");
include("info.php");
$web_id = $req->getGet("web_id");
if(empty($web_id)) $web_id = 1;
$tpl_info = array(
		"idx" => "news_mark",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);

$order = $req->getGet("order");
$order_type = $req->getGet("order_type");
if(empty($order_type)) $order_type = "desc";
$keyword = $req->getGet("keyword");
$tpl->Set_Variable('keyword', $keyword);

$page = $req->getGet("page");
$condition = array();
$condition[] = array("web_id","n=",$web_id);
if(!empty($keyword)) $condition[] = array("subject","like",$keyword,"and");
$counter = $db->result($setting['db']['pre']."news_mark", "count(*)", $condition);
list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
$tpl->Set_Variables($page_arr);

includeCache("news_cat");
if(empty($order)) $order="news_id";
$db->select($setting['db']['pre']."news_mark","*",$condition, array("order"=>"$order $order_type","limit"=>"$page_start, $page_size"));
while($record = $db->GetRS()) {
	HtmlTrans(&$record);
	$record['jump_time'] = date("Y-m-d", $record['jump_time']);
	$record['rank_time'] = date("Y-m-d", $record['rank_time']);
	$record['link'] = getUrl("list", $record['news_id'], 1, $web_id);
	$catInfo = getParaInfo("news_cat", "cat_id", $record['cat_id']);
	$record['cat_id'] = $catInfo['cat_name'];
	$tpl->Set_Loop('record', $record);
}
$db->Free();
$tpl->Set_Variable('order_type_org', $order_type);
if($order_type=="desc") {
	$order_type = "asc";
} else {
	$order_type = "desc";
}
$tpl->Set_Variable('order', $order);
$tpl->Set_Variable('order_type', $order_type);
$tpl->Set_Variable('path_admin', $setting['path']['admin']);
$tpl->Set_Variable('title', $info['name']);

$max_count = count($GLOBALS['website']);
for($i=0; $i<$max_count; $i++) {
	$GLOBALS['website'][$i]['selected'] = $GLOBALS['website'][$i]['web_id']==$web_id?"selected":"";
	$tpl->Set_Loop("website", $GLOBALS['website'][$i]);
}

$mystep->show($tpl);
unset($tpl);
$mystep->pageEnd(false);
?>