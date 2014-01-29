<?php
global $keyword, $condition, $limit, $web_id;
$mode = $req->getGet("mode");
$keyword = $req->getGet("k");

if(strlen($keyword)>=4) {
	$keyword = safeEncoding($keyword, $setting['gen']['charset']);
	$keyword = substrPro($keyword, 0, 200);
	$keyword = htmlspecialchars($keyword);
	if($record = $db->record($setting['db']['pre']."search_keyword", "*", array("keyword", "=", $keyword))) {
		$record['chg_date'] = time();
		$record['count'] += 1;
	} else {
		$record['keyword'] = $keyword;
		$record['count'] = 1;
		$record['add_date'] = time();
		$record['chg_date'] = time();
	}
	$db->replace($setting['db']['pre']."search_keyword", $record);

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
		$condition = array();
		if(!empty($keyword)) {
			$condition[] = array("subject","like",$keyword);
		}
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
		$sql = $db->buildSel(
			array(
				array(
					"name" => $setting['db']['pre_sub']."news_show",
					"idx" => "a",
					"col" => "count(*)",
					"condition" => $condition
				),
				array(
					"name" => $setting['db']['pre_sub']."news_cat",
					"idx" => "b",
					"join" => "cat_id"
				),
			)
		);
		$news_count = getData($sql, "result");
		if($news_count>0) $db->update($setting['db']['pre']."search_keyword", array("amount"=>$news_count), array("keyword","=",$keyword));
		$tpl_tmp->Set_Variable('title', $setting['web']['title']);
		$tpl_tmp->Set_Variable('web_url', $setting['web']['url']);
		$tpl_tmp->Set_Variable('keyword', $keyword);
		$tpl_tmp->Set_Variable('page_list', PageList($page, ceil($news_count/$page_size)));
		$limit = (($page-1)*$page_size).", ".$page_size;
		$condition = $db->buildCondition($condition);
		$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
		unset($tpl_tmp);
		if(!empty($keyword)) {
			$setting['web']['title'] = $keyword."_".$setting['web']['title'];
			$setting['web']['keyword'] = $keyword;
		}
		$mystep->show($tpl);
	}
} else {
	$goto_url = "/";
}
if(!empty($goto_url)) $setting['gen']['show_info'] = false;
?>