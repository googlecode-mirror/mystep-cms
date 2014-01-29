<?php
require("inc.php");

$tag = $req->getGet("tag");
if($tag=="index") $tag = "";
$tag = getString($tag);
$tag = mysql_real_escape_string($tag);
if(get_magic_quotes_gpc()) $tag = addslashes($tag);
$page = $req->getGet("page");
if(!is_numeric($page) || $page < 1) $page = 1;
$page_size = $setting['list']['txt'];

if($setting['gen']['cache']) {
	$cache_info = array(
			'idx' => "tag_".($page==1?$tag:"{$tag}_{$page}"),
			'path' => $cache_path."/tag/",
			'expire' => getCacheExpire(),
			);
} else {
	$cache_info = false;
}
$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
if($tpl->Is_Cached()) {
	echo $tpl->Get_Content();
	$mystep->pageEnd($setting['gen']['show_info']);
}
$tpl_info['idx'] = "tag";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

$db->Query("update ".$setting['db']['pre_sub']."news_tag set click=click+1 where tag = '{$tag}'");
$cur_tag = "";
if(!empty($tag)) $cur_tag = " - ".$tag;

$sql = $db->buildSel($setting['db']['pre_sub']."news_show", "count(*)", array("tag", "like", $tag));
$news_count = getData($sql, "result");
$tpl_tmp->Set_Variable('title', $setting['web']['title']);
$tpl_tmp->Set_Variable('tag', $tag);
$tpl_tmp->Set_Variable('cur_tag', $cur_tag);
$tpl_tmp->Set_Variable('web_url', $setting['web']['url']);
$tpl_tmp->Set_Variable('cat_main_link', $cat_main_link);
$tpl_tmp->Set_Variable('page_list', PageList($page, ceil($news_count/$page_size)));
$limit = (($page-1)*$page_size).", ".$page_size;

$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
if(!empty($tag)) {
	$setting['web']['title'] = $tag."_".$setting['web']['title'];
	$setting['web']['keyword'] = $tag.",".$setting['web']['keyword'];
	$setting['web']['description'] = $tag.",".$setting['web']['description'];
}
$mystep->show($tpl);
$mystep->pageEnd($setting['gen']['show_info']);
?>