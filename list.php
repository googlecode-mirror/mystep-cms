<?php
require("inc.php");
$page = $req->getGet("page");
if(!is_numeric($page) || $page < 1) $page = 1;
$cat_idx = strtolower($req->getGet("cat"));
if($setting['gen']['cache']) {
	$cache_info = array(
			'idx' => ($page==1?"index":"index_{$page}"),
			'path' => $cache_path."/".(empty($cat_idx)?"all":$cat_idx)."/",
			'expire' => getCacheExpire(),
			);
} else {
	$cache_info = false;
}
$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
if($tpl->Is_Cached()) {
	echo $tpl->Get_Content();
	$mystep->pageEnd();
}
$cat_id = 0;
$list_limit = array_values($setting['list']);
if($cat_info = getParaInfo("news_cat", "cat_idx", $cat_idx)) {
	$cat_id = $cat_info['cat_id'];
	$cat_name = $cat_info['cat_name'];
	$cat_comment = $cat_info['cat_comment'];
	$page_size = $list_limit[$cat_info['cat_type']];
} else {
	$cat_name = $setting['language']['page_update'];
	$cat_idx = "";
	$page_size = $list_limit[0];
}

if(isset($cat_info['cat_type'])) {
	$tpl_info['idx'] = "list_".$cat_info['cat_type'];
} else {
	$tpl_info['idx'] = "list";
}
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$news_count = getData("select count(*) from ".$setting['db']['pre']."news_show where 1=1".($cat_id==0?"":" and cat_id='{$cat_id}'"), "result");
if(!empty($cat_name)) $tpl_tmp->Set_Variable('catalog_txt', ' - <a href="'.getFileURL(0, $cat_idx).'">'.$cat_name.'</a>');
$tpl_tmp->Set_Variable('title', $setting['web']['title']);
$tpl_tmp->Set_Variable('web_url', $setting['web']['url']);
$tpl_tmp->Set_Variable('page_list', PageList($page, ceil($news_count/$page_size)));

$paras = array(
	'cat_id' => $cat_id,
	'limit' => (($page-1)*$page_size).", ".$page_size,
);

$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting, $paras'));
unset($tpl_temp);
if(!empty($cat_idx)) {
	$setting['web']['title'] = $cat_comment."_".$setting['web']['title'];
	$setting['web']['keyword'] = $cat_name.",".$cat_comment;
}
$mystep->show($tpl);
$mystep->pageEnd();
?>