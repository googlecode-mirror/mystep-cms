<?php
require("../inc.php");
include("info.php");
$web_id = $req->getGet("web_id");
if(empty($web_id)) $web_id = 1;
$tpl_info = array(
		"idx" => "news_visit",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);

includeCache("news_cat");
$order = $req->getGet("order");
$order_type = $req->getGet("order_type");
if(empty($order_type)) $order_type = "desc";
$keyword = $req->getGet("keyword");
$tpl->Set_Variable('keyword', $keyword);

$page = $req->getGet("page");
$str_sql = "select count(*) as counter from ".$setting['db']['pre']."news_visit where web_id=".$web_id;
if(!empty($keyword)) $str_sql.= " and subject like '%{$keyword}%'";
$counter = $db->GetSingleResult($str_sql);
list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
$tpl->Set_Variables($page_arr);
	
$str_sql = "select * from ".$setting['db']['pre']."news_visit where web_id=".$web_id;
if(!empty($keyword)) $str_sql.= " and subject like '%{$keyword}%'";
$str_sql.= " order by ".(empty($order)?"news_id":"{$order}")." {$order_type}";
$str_sql.= " limit $page_start, $page_size";
$db->Query($str_sql);
while($record = $db->GetRS()) {
	HtmlTrans(&$record);
	$record['day_start'] = date("Y-m-d", $record['day_start']);
	$webInfo = getParaInfo("website", "web_id", $record['web_id']);
	$record['link'] = "http://".$webInfo['host']."/read.php?id=".$record['news_id'];
	$record['web_id'] = $webInfo['name'];
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
$tpl->Set_Variable('web_id', $web_id);

$max_count = count($GLOBALS['website']);
for($i=0; $i<$max_count; $i++) {
	$GLOBALS['website'][$i]['selected'] = $GLOBALS['website'][$i]['web_id']==$web_id?"selected":"";
	$tpl->Set_Loop("website", $GLOBALS['website'][$i]);
}

$mystep->show($tpl);
unset($tpl);
$mystep->pageEnd(false);
?>