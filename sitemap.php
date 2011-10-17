<?php
require("inc.php");
$tpl_info['idx'] = "sitemap";
if($setting['gen']['cache']) {
	$cache_info = array(
		'idx' => "sitemap_".$setting['info']['web']['web_id'],
		'path' => $cache_path."/sitemap/",
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
$charset_tag = '<?xml version="1.0" encoding="'.$setting['gen']['charset'].'"?>'."\n";

$tpl->Set_Variable('charset_tag', $charset_tag);
$tpl->Set_Variable('now', date("r"));
$from = array("&", "'", '"', ">", "<");
$to = array("&amp;", "&apos;", "&quot;", "&gt;", "&lt;");
$news_all = getData("select count(*) from ".$setting['db']['pre']."news_show", "result", 86400);
for($i=0, $m=count($news_cat); $i<$m; $i++) {
	$record = array();
	$record['url'] = getFileURL(0, $news_cat[$i]['cat_idx'], $setting['info']['web']['web_id']);
	$record['url'] = str_replace($from, $to, $record['url']);
	$record['date'] = substr(getData("select max(add_date) from ".$setting['db']['pre']."news_show where cat_id=".$news_cat[$i]['cat_id'], "result", 86400), 0, 10);
	if(empty($record['date'])) $record['date'] = date("Y-m-d");
	$news_current = getData("select count(*) from ".$setting['db']['pre']."news_show where cat_id=".$news_cat[$i]['cat_id'], "result", 86400);
	$record['priority'] = round($news_current/$news_all, 2);
	$tpl->Set_Loop("record", $record);
}

header('Content-Type: application/xml; charset='.$setting['gen']['charset']);
$mystep->show($tpl);
$mystep->pageEnd(false);
?>