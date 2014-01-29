<?php
$ms_sign = 1;
require("inc.php");
$cat_idx = strtolower($req->getGet("cat"));
if($cat_info = getParaInfo("news_cat", "cat_idx", $cat_idx)) {
	$web_info = getSubSetting($cat_info['web_id']);
} else {
	$cat_idx = "";
	$web_info = getSubSetting($setting['info']['web']['web_id']);
}

$tpl_info['idx'] = "rss";
if($setting['gen']['cache']) {
	$cache_info = array(
		'idx' => "rss_".$web_info["info"]["web_id"].(empty($cat_idx)?"":"_{$cat_info[cat_id]}"),
		'path' => $cache_path."/rss/",
		'expire' => getCacheExpire(),
	);
} else {
	$cache_info = false;
}
$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
if($tpl->Is_Cached()) {
	echo $tpl->Get_Content();
	$mystep->pageEnd(false);
}

if(empty($cat_idx)) {
	$cat_txt = $setting['language']['page_all_news'];
} else {
	$cat_txt = $cat_info['cat_name'];
	$setting['web']['description'] .= ", ".$cat_info['cat_comment'];
}
$cat_txt .= sprintf($setting['language']['page_update_lastest'], $setting['list']['rss']);

$charset_tag = '<?xml version="1.0" encoding="'.$setting['gen']['charset'].'"?>'."\n";

$tpl->Set_Variable('charset_tag', $charset_tag);
$tpl->Set_Variable('cat_txt', $cat_txt);
$tpl->Set_Variable('now', date("r"));

$condition = array();
if(!empty($cat_idx)) {
	$condition = array(
		array("cat_id", "n=", $cat_info['cat_id']),
		array("cat_main", "n=", $cat_info['cat_id'], "or"),
	);
}
$sql = $db->buildSel_join(array(
		array(
			"name" => $web_info['db']['name'].".".$web_info['db']['pre']."news_show",
			"idx" => "a",
			"col" => "*",
			"order" => "news_id desc"
		),
		array(
			"name" => $setting['db']['pre']."news_cat",
			"idx" => "b",
			"col" => "cat_name",
			"join" => "cat_id",
			"condition" => $condition
		)
	), $setting['list']['rss']);

$db->Query($sql);
while($record = $db->GetRS()) {
	$record['link'] = getUrl("read", array($record['news_id'], $record['cat_idx']), 1, $record['web_id']);
	$record['add_date'] = date("r", strtotime($record['add_date']));
	$tpl->Set_Loop("record", $record);
}
$db->Free();

header('Content-Type: application/rss+xml; charset='.$setting['gen']['charset']);
$mystep->show($tpl);
$mystep->pageEnd(false);
?>