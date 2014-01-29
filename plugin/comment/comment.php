<?php
require("../inc.php");
include("info.php");

$method = $req->getGet("method");
$web_id = $req->getGet("web_id");
if(empty($web_id) || !is_numeric($web_id)) $web_id = 1;
if($method=="delete") {
	$log_info = $setting['language']['plugin_comment_delete'];
	$id = $req->getGet("id");
	list($news_id, $web_id) = array_values($db->record($setting['db']['pre']."comment","news_id, web_id",array("id","n=",$id)));
	$n = 1;
	$db->select($setting['db']['pre']."comment","id, quote",array("news_id","n=",$news_id),array("order"=>"id asc"));
	while($record = $db->GetRS()) {
		if($record['id']==$id) break;
		$n++;
	}
	$db->Free();
	$db->update($setting['db']['pre']."comment", array("quote"=>0),array("quote","n=",$n));
	$db->update($setting['db']['pre']."comment", array("quote"=>"-1"),array("quote","n>",$n));
	$db->delete($setting['db']['pre']."comment", array("id","n=",$id));
	plugin_comment::build_list($news_id, $web_id);
	$goto_url = $req->getServer("HTTP_REFERER");
	write_log($log_info, "id=".$id);
	$mystep->pageEnd(false);
}

$tpl_info = array(
		"idx" => "list",
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
if(!empty($keyword)) $condition[] = array("comment","like",$keyword);
$counter = $db->result($setting['db']['pre']."comment","count(*)",array("web_id","n=",$web_id));
list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
$tpl->Set_Variables($page_arr);

$webInfo = getSubSetting($web_id);
$pre_sub = $webInfo['db']['name'].".".$webInfo['db']['pre'];
$condition[] = array("web_id","n=",$web_id,"and");
$the_order = array();
if(empty($order)) $order = "id";
$the_order[] = "{$order} {$order_type}";	
$db->select(
	array(
		array(
			"name" => $setting['db']['pre']."comment",
			"idx" => "a",
			"col" => "*",
			"condition" => $condition,
			"order" => $the_order
		),
		array(
			"name" => $pre_sub."news_show",
			"idx" => "b",
			"col" => "subject, cat_id",
			"join" => "news_id",
		)
	), 
	"", 
	array("limit"=>"{$page_start}, {$page_size}")
);
while($record = $db->GetRS()) {
	HtmlTrans(&$record);
	$record['link'] = getUrl("read", array($record['news_id'], $record['cat_id']), 1, $record['web_id']);
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
$tpl->Set_Variable('title', $setting['language']['plugin_comment_title']);

$max_count = count($GLOBALS['website']);
for($i=0; $i<$max_count; $i++) {
	$GLOBALS['website'][$i]['selected'] = $GLOBALS['website'][$i]['web_id']==$web_id?"selected":"";
	$tpl->Set_Loop("website", $GLOBALS['website'][$i]);
}

$mystep->show($tpl);
unset($tpl);
$mystep->pageEnd(false);
?>