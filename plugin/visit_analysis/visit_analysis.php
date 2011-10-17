<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "referer";

$tpl_info = array(
		"idx" => "main",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);
$tpl_info['idx'] = $method;
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
if($method == "referer") {
	$db->Query("select * from ".$setting['db']['pre']."visit_analysis order by chg_date");
	while($record = $db->GetRS()) {
		$record['add_date'] = date("Y-m-d H:i:s", $record['add_date']);
		$record['chg_date'] = date("Y-m-d H:i:s", $record['chg_date']);
		$tpl_tmp->Set_Loop('record', $record);
	}
	$db->Free();
} elseif($method == "keyword") {
	$counter = $db->GetSingleResult("select count(*) as counter from ".$setting['db']['pre']."visit_keyword");
	$page = $req->getGet("page");
	list($page_arr, $page_start, $page_size) = GetPageList($counter, "?method=keyword", $page);
	$tpl_tmp->Set_Variables($page_arr);
	
	$db->Query("select * from ".$setting['db']['pre']."visit_keyword order by chg_date desc limit {$page_start}, {$page_size}");
	while($record = $db->GetRS()) {
		$record['add_date'] = date("Y-m-d H:i:s", $record['add_date']);
		$record['chg_date'] = date("Y-m-d H:i:s", $record['chg_date']);
		$tpl_tmp->Set_Loop('record', $record);
	}
	$db->Free();
}

$tpl_tmp->Set_Variable('title', $setting['language']['plug_visit_analysis_title_'.$method]);
$tpl->Set_Variable('path_admin', $setting['path']['admin']);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting'));
unset($tpl_tmp);
$mystep->show($tpl);

$mystep->pageEnd(false);
?>