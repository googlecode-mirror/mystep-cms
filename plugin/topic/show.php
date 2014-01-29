<?php
$id = $req->getGet("id");
if(!is_numeric($id)) {
	$idx = $id;
	$id = "";
}
$idx = $req->getGet("idx");

$topic = false;

$condition = array();
if(!empty($id)) {
	$condition[] = array("topic_id","n=",$id);
} else {
	$condition[] = array("topic_idx","=",$idx);
}
$sql = $db->buildSel($setting['db']['pre']."topic","*",$condition);
$topic = getData($sql, "record", 86400);

if($topic === false) {
	$goto_url = "./";
} else {
	$tpl_info['idx'] = $topic['topic_id'];
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