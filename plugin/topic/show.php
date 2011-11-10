<?php
$id = $req->getGet("id");

$tpl_info['idx'] = $id;
$tpl_info['style'] = "../plugin/".basename(realpath(dirname(__FILE__)))."/topic/";
$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);

$topic = getData("select * from ".$setting['db']['pre']."topic where topic_id='{$id}'", "record", 86400);

$tpl->Set_Variables($topic);
$setting['web']['title'] = $topic['topic_name']."_".$setting['web']['title'];
$setting['web']['keyword'] = $topic['topic_name'];
$setting['web']['description'] = addslashes(strip_tags($topic['topic_intro']));
$mystep->show($tpl);

$mystep->pageEnd(false);
?>