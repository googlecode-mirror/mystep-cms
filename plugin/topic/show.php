<?php
$id = $req->getGet("id");
if(!is_numeric($id)) {
	$idx = $id;
	$id = "";
}
$idx = $req->getGet("idx");

$topic = false;
if(!empty($id)) {
	$topic = getData("select * from ".$setting['db']['pre']."topic where topic_id='{$id}'", "record", 86400);
} elseif(!empty($idx)) {
	$topic = getData("select * from ".$setting['db']['pre']."topic where topic_idx='".mysql_real_escape_string($idx)."'", "record", 86400);
	$id = $topic['topic_id'];
}

if($topic === false) {
	$goto_url = "./";
} else {
	$tpl_info['idx'] = $id;
	$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/topic/";
	$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
	$tpl->Set_Variables($topic);
	$setting['web']['title'] = $topic['topic_name']."_".$setting['web']['title'];
	$setting['web']['keyword'] = $topic['topic_keyword'];
	$setting['web']['description'] = addslashes(strip_tags($topic['topic_intro']));
	$mystep->show($tpl);
}

if(!empty($goto_url)) $setting['gen']['show_info'] = false;
?>