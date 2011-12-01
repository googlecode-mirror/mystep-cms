<?php
require("inc.php");
$page = $req->getGet("page");
$prefix = $req->getGet("pre");
if(!is_numeric($page) || $page < 1) $page = 1;
$cat_idx = $req->getGet("cat");

if(is_numeric($cat_idx)) {
	if($cat_info = getParaInfo("news_cat_sub", "cat_id", $cat_idx)) {
		$cat_idx = $cat_info['cat_idx'];
	} else {
		$cat_idx = "";
	}
}
$cat_info = getParaInfo("news_cat_sub", "cat_idx", $cat_idx);
if($cat_info===false && !empty($cat_idx)) {
	unset($_SERVER['QUERY_STRING']);
	$prefix = "";
	$cat_idx = "";
}

if($setting['gen']['cache']) {
	$cache_info = array(
			'idx' => "index",
			'path' => $cache_path."/".(empty($cat_idx)?"all":$cat_idx)."/",
			'expire' => getCacheExpire(),
			);
	if(!empty($prefix)) $cache_info['idx'] .= "_".$prefix;
	if($page>1) $cache_info['idx'] .= "_".$page;
} else {
	$cache_info = false;
}
$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
if($tpl->Is_Cached()) {
	echo $tpl->Get_Content();
	$mystep->pageEnd();
}
$cat_id = 0;
$web_id = $setting['info']['web']['web_id'];
$list_limit = array_values($setting['list']);
if($cat_info === false) {
	$cat_name = $setting['language']['page_update'];
	$page_size = $list_limit[0];
	$cat_main = 0;
	$sub_list = "";
} else {
	$cat_id = $cat_info['cat_id'];
	$cat_name = $cat_info['cat_name'];
	$cat_keyword = $cat_info['cat_keyword'];
	$cat_comment = $cat_info['cat_comment'];
	$page_size = $list_limit[$cat_info['cat_type']];
	$cat_main = $cat_info['cat_main'];
	$sub_list = $cat_info['cat_sub'];
}
$menu_cat_id = $cat_id;

if(isset($cat_info['cat_type'])) {
	$tpl_info['idx'] = "list_".$cat_info['cat_type'];
} else {
	$tpl_info['idx'] = "list";
}

$cat_main_link = "";
if($cat_main > 0) {
	$menu_cat_id = $cat_main;
	if($cat_info = getParaInfo("news_cat_sub", "cat_id", $cat_main)) {
		$cat_main_link = '<a href="'.getFileURL(0, $cat_info['cat_idx'], $cat_info['web_id']).'">'.$cat_info['cat_name'].'</a>';
	}
}

$condition = "1=1";
if(!empty($prefix)) {
	$condition = "subject like '[".$prefix."]%'";
}

$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$news_count = getData("select count(*) from ".$setting['db']['pre_sub']."news_show a left join ".$setting['db']['pre']."news_cat b on a.cat_id=b.cat_id where 1=1".($cat_id==0?"":" and (a.cat_id ='{$cat_id}' || b.cat_main='{$cat_id}')").(empty($condition)?"":" and {$condition}"), "result");
if(!empty($cat_name)) $tpl_tmp->Set_Variable('catalog_txt', (empty($cat_main_link)?"":" - {$cat_main_link}").' - <a href="'.getFileURL(0, $cat_idx, $web_id).'">'.$cat_name.'</a>');
$tpl_tmp->Set_Variable('title', $setting['web']['title']);
$tpl_tmp->Set_Variable('web_url', $setting['web']['url']);
$tpl_tmp->Set_Variable('cat_main_link', $cat_main_link);
$tpl_tmp->Set_Variable('page_list', PageList($page, ceil($news_count/$page_size)));

$prefix_list = "";
if(strlen($sub_list)>0) {
	$sub_list = explode(",", $sub_list);
	for($i=0,$m=count($sub_list);$i<$m;$i++) {
		$prefix_list .= '<a href="?cat='.$cat_idx.'&pre='.$sub_list[$i].'">'.$sub_list[$i].'</a> &nbsp; &nbsp;';
	}
}
$tpl_tmp->Set_Variable('prefix_list', $prefix_list);

$limit = (($page-1)*$page_size).", ".$page_size;
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
if(!empty($cat_idx)) {
	$setting['web']['title'] = $cat_name."_".$setting['web']['title'];
	$setting['web']['keyword'] = $cat_name.",".$cat_keyword;
	$setting['web']['description'] = $cat_comment;
}
$mystep->show($tpl);
$mystep->pageEnd();
?>