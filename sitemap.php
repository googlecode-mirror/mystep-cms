<?php
$ms_sign = 1;
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

$sql = $db->buildSel($setting['db']['pre_sub']."news_show", "count(*) as news_count", array("web_id", "n=", $setting['info']['web']['web_id']), array("group"=>"cat_id", "order"=>"news_count desc", "limit"=>"1"));
$news_count_max = getData($sql, "result", 86400);
for($i=0, $m=count($news_cat); $i<$m; $i++) {
	if($news_cat[$i]['web_id']!=$setting['info']['web']['web_id']) continue;
	$record = array();
	$record['url'] = getUrl("list", $news_cat[$i]['cat_idx'], 1, $setting['info']['web']['web_id']);
	$record['url'] = str_replace($from, $to, $record['url']);
	$sql = $db->buildSel($setting['db']['pre_sub']."news_show", "max(add_date)", array("cat_id", "n=", $news_cat[$i]['cat_id']));
	$record['date'] = substr(getData($sql, "result", 86400), 0, 10);
	if(empty($record['date'])) $record['date'] = date("Y-m-d");
	$sql = $db->buildSel($setting['db']['pre_sub']."news_show", "count(*)", array("cat_id", "n=", $news_cat[$i]['cat_id']));
	$news_count_current = getData($sql, "result", 86400);
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