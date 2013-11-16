<?php
global $keyword, $condition, $limit, $web_id;
$mode = $req->getGet("mode");
$keyword = $req->getGet("k");

if(strlen($keyword)>=4) {
	$keyword = safeEncoding($keyword, $setting['gen']['charset']);
	$keyword = mysql_real_escape_string($keyword);
	if($record = $db->getSingleRecord("select * from ".$setting['db']['pre']."search_keyword where keyword = '{$keyword}'")) {
		$record['chg_date'] = time();
		$record['count'] += 1;
	} else {
		$record['keyword'] = $keyword;
		$record['count'] = 1;
		$record['add_date'] = time();
		$record['chg_date'] = time();
	}
	$db->Query($db->buildSQL($setting['db']['pre']."search_keyword", $record, "replace"));
}
if(!empty($mode)) {
	include(dirname(__FILE__)."/se.php");
	$url = $se[$mode];
	$goto_url = $url.urlencode(chg_charset($keyword, $setting['gen']['charset'], "utf-8")." site:".$setting['info']['web']['host']);
} else {
	$page = $req->getGet("page");
	if(!is_numeric($page) || $page < 1) $page = 1;
	$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
	$tpl_info['idx'] = "search";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	$web_id = $setting['info']['web']['web_id'];
	$list_limit = array_values($setting['list']);
	$page_size = $list_limit[0];
	$condition = "1=1";
	if(!empty($keyword)) {
		$condition = "subject like '%".$keyword."%'";
	}
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	$news_count = getData("select count(*) from ".$setting['db']['pre_sub']."news_show a left join ".$setting['db']['pre']."news_cat b on a.cat_id=b.cat_id where 1=1".(empty($condition)?"":" and {$condition}"), "result");
	if($news_count>0) $db->Query("update ".$setting['db']['pre']."search_keyword set `amount`='".$news_count."' where keyword = '{$keyword}'");
	$tpl_tmp->Set_Variable('title', $setting['web']['title']);
	$tpl_tmp->Set_Variable('web_url', $setting['web']['url']);
	$tpl_tmp->Set_Variable('keyword', $keyword);
	$tpl_tmp->Set_Variable('page_list', PageList($page, ceil($news_count/$page_size)));
	$limit = (($page-1)*$page_size).", ".$page_size;
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	if(!empty($keyword)) {
		$setting['web']['title'] = $keyword."_".$setting['web']['title'];
		$setting['web']['keyword'] = $keyword;
	}
	$mystep->show($tpl);
}
if(!empty($goto_url)) $setting['gen']['show_info'] = false;
?>