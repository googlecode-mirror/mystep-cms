<?php
require("../inc.php");
include("info.php");

$method = $req->getGet("method");
$web_id = $req->getGet("web_id");
if(empty($web_id) || !is_numeric($web_id)) $web_id = 1;
if($method=="delete") {
	$log_info = $setting['language']['plugin_comment_delete'];
	$id = $req->getGet("id");
	list($news_id, $web_id) = array_values($db->getSingleRecord("select news_id, web_id from ".$setting['db']['pre']."comment where id = '{$id}'"));
	$n = 1;
	$db->Query("select id, quote from ".$setting['db']['pre']."comment where news_id='{$news_id}' order by id asc");
	while($record = $db->GetRS()) {
		if($record['id']==$id) break;
		$n++;
	}
	$db->Free();
	$db->Query("update ".$setting['db']['pre']."comment set quote=0 where quote={$n}");
	$db->Query("update ".$setting['db']['pre']."comment set quote=quote-1 where quote>{$n}");
	$db->Query("delete from ".$setting['db']['pre']."comment where id='{$id}'");
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
$str_sql = "select count(*) as counter from ".$setting['db']['pre']."comment where web_id=".$web_id;
if(!empty($keyword)) $str_sql.= " and `comment` like '%{$keyword}%'";
$counter = $db->GetSingleResult($str_sql);
list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
$tpl->Set_Variables($page_arr);

$str_sql = "select * from ".$setting['db']['pre']."comment where 1=1";
if(!empty($keyword)) $str_sql.= " and subject like '%{$keyword}%'";
$str_sql.= " order by ".(empty($order)?"news_id":"{$order}")." {$order_type}";
$str_sql.= " limit $page_start, $page_size";

$webInfo = getSubSetting($web_id);
$pre_sub = $webInfo['db']['name'].".".$webInfo['db']['pre'];
$str_sql = "select a.*, b.subject, b.cat_id from ".$setting['db']['pre']."comment a left join ".$pre_sub."news_show b on a.news_id=b.news_id where a.web_id=".$web_id;
if(!empty($keyword)) $str_sql.= " and a.`comment` like '%{$keyword}%'";
$str_sql.= " order by ".(empty($order)?"a.id":"a.{$order}")." {$order_type}";
$str_sql.= " limit $page_start, $page_size";
$db->Query($str_sql);
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