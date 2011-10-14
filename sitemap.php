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

$db->Query("select cat_idx from ".$setting['db']['pre']."news_cat where web_id=".$setting['info']['web']['web_id']);
while($record = $db->GetRS()) {
	$record['url'] = getFileURL(0, $record['cat_idx'], $setting['info']['web']['web_id']);
	$record['url'] = str_replace($from, $to, $record['url']);
	$record['date'] = date("Y-m-d");
	$tpl->Set_Loop("record", $record);
}
$db->Free();

header('Content-Type: application/xml; charset='.$setting['gen']['charset']);
$mystep->show($tpl);
$mystep->pageEnd(false);
?>