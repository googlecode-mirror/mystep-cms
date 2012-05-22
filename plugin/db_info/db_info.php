<?php
require("../inc.php");

$db_name = $req->getGet("db");
if(empty($db_name)) $db_name = $setting['db']['name'];
$tbl = $req->getGet("tbl");
$tpl_info = array(
	"idx" => (empty($tbl)?"db":"tbl"),
	"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
	"path" => ROOT_PATH."/".$setting['path']['template'],
);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);
if(empty($tbl)){
	$title = $setting['language']['plugin_db_info_db'] . " - " . $db_name;
	$str_sql = "select table_name as Name, Engine, table_rows as Rows, (data_length+index_length) as Data_length, Create_time, table_collation as Collation, table_comment as Comment from information_schema.tables where table_schema='".$db_name."';";
	$db->Query($str_sql);
	$root_mode = true;
	if($db->CheckError()) {
		$db->free();
		$db->clearError();
		$str_sql = "SHOW TABLE STATUS FROM ".$db_name;
		$db->Query($str_sql);
		$root_mode = false;
	}
	$n = 1;
	while($record = $db->GetRS()) {
		HtmlTrans(&$record);
		$record['no'] = $n++;
		$record['Data_length'] = $root_mode ? GetFileSize($record['Data_length']) : "--";
		$tpl->Set_Loop('record', $record);
	}
	$db_list = $db->GetDBs();
	$max_count = count($db_list);
	for($i=0; $i<$max_count; $i++) {
		$tpl->Set_Loop("db", array("name"=>$db_list[$i], "selected"=>($db_list[$i]==$db_name?"selected":"")));
	}
} else {
	$title = $setting['language']['plugin_db_info_tbl'] . " - " . $db_name . " - " . $tbl;
	$tbl_info = $db->GetTabSetting($tbl, $db_name);
	$str_sql = "describe ".$db_name.".".$tbl;
	$db->Query($str_sql);
	$n = 1;
	while($record = $db->GetRS()) {
		HtmlTrans(&$record);
		$record['no'] = $n++;
		$record['comment'] = "";
		if(preg_match("/`".$record['Field']."`.+COMMENT '(.+)'/", $tbl_info, $matches)) {
			$record['comment'] = $matches[1];
		}
		$tpl->Set_Loop('record', $record);
	}
	$tpl->Set_Variable('tbl', $tbl);
}

$db->Free();
$tpl->Set_Variables($record);
$tpl->Set_Variable('db', $db_name);
$tpl->Set_Variable('title', $title);
$tpl->Set_Variable('path_admin', $setting['path']['admin']);
$mystep->show($tpl);
$mystep->pageEnd(false);
?>