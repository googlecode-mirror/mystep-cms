<?php
require("inc.php");
set_time_limit(300);
$tpl_info['idx'] = "sitemap";
if($setting['gen']['cache']) {
	$cache_info = array(
		'idx' => "sitemap",
		'path' => $cache_path."/",
		'expire' => getCacheExpire(),
	);
} else {
	$cache_info = false;
}
$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
if($tpl->Is_Cached()) {
	header('Content-Type: application/xml; charset='.$setting['gen']['charset']);
	echo $tpl->Get_Content();
	$mystep->pageEnd(false);
}
$charset_tag = '<?xml version="1.0" encoding="'.$setting['gen']['charset'].'"?>'."\n";
$tpl->Set_Variable('charset_tag', $charset_tag);
$tpl->Set_Variable('now', date("r"));
$from = array("&", "'", '"', ">", "<");
$to = array("&amp;", "&apos;", "&quot;", "&gt;", "&lt;");

$record = array();
$record['url'] = $setting['web']['url'];
$record['date'] = date("Y-m-d");
$record['priority'] = "1";
$tpl->Set_Loop("record", $record);

$news_count_max = getData("select max(news_count) from (select count(*) as news_count from ".$setting['db']['pre_sub']."news_show where web_id=".$setting['info']['web']['web_id']." group by cat_id) as news_count", "result", 86400);
for($i=0, $m=count($news_cat); $i<$m; $i++) {
	if($news_cat[$i]['web_id']!=$setting['info']['web']['web_id']) continue;
	$record = array();
	$record['url'] = getFileURL(0, $news_cat[$i]['cat_idx'], $setting['info']['web']['web_id']);
	$record['url'] = str_replace($from, $to, $record['url']);
	$record['date'] = substr(getData("select max(add_date) from ".$setting['db']['pre_sub']."news_show where cat_id=".$news_cat[$i]['cat_id'], "result", 86400), 0, 10);
	if(empty($record['date'])) $record['date'] = date("Y-m-d");
	$news_count_current = getData("select count(*) from ".$setting['db']['pre_sub']."news_show where cat_id=".$news_cat[$i]['cat_id'], "result", 86400);
	$record['priority'] = $news_count_current/$news_count_max;
	if($news_count_current>0) $record['priority'] += 0.1;
	$record['priority'] = round(ceil($record['priority']*10)/10, 1);
	if($record['priority']>1) $record['priority'] = 1;
	$tpl->Set_Loop("record", $record);
}
header('Content-Type: application/xml; charset='.$setting['gen']['charset']);
$mystep->show($tpl);
$mystep->pageEnd(false);
?>