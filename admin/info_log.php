<?php
require("inc.php");

$keyword = $req->getGet("keyword");
$method = $req->getGet("method");
$log_info = "";

if($method=="clear") {
	$log_info = "清空日志";
	$db->Query("truncate table ".$setting['db']['pre']."modify_log");
	$goto_url = $self;
} elseif($method=="download") {
	$log_info = "导入日志";
	$db->Query("select * from ".$setting['db']['pre']."modify_log order by id desc");
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
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"], $log_info);
	$mystep->pageEnd(false);
}

$tpl_info['idx'] = "info_log";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

$order = $req->getGet("order");
$tpl_tmp->Set_Variable('order', $order);
$order_type = $req->getGet("order_type");
if(empty($order_type)) $order_type = "desc";

//navigation
$str_sql = "select count(*) as counter from ".$setting['db']['pre']."modify_log".(empty($keyword)?"":" where user like '%$keyword%'");
$counter = $db->GetSingleResult($str_sql);
$tpl_tmp->judge_list['empty'] = ($counter==0);
$page = $req->getGet("page");
list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
$tpl_tmp->Set_Variables($page_arr);

//main list
$str_sql = "select * from ".$setting['db']['pre']."modify_log".(empty($keyword)?"":" where user like '%$keyword%'");
$str_sql.= " order by".(empty($order)?" ":" {$order} {$order_type}, ")."id {$order_type}";
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
	$record['time'] = date("Y-m-d H:i:s", $record['time']);
	$tpl_tmp->Set_Loop('record', $record);
}

$tpl_tmp->Set_Variable('keyword', $keyword);
$tpl_tmp->Set_Variable('title', '网站维护日志');
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
$db->Free();
$mystep->show($tpl);
$mystep->pageEnd(false);
?>