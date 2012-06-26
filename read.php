<?php
require("inc.php");

$news_id = intval($req->getGet("id"));
if(!is_numeric($news_id)) {
	$goto_url = "/";
	$mystep->pageEnd();
}
list($cat_id, $add_date, $page_count, $subject, $view_lvl, $link)=array_values(getData("select cat_id, add_date, pages, subject, view_lvl, link from ".$setting['db']['pre_sub']."news_show where news_id='{$news_id}'", "record", 1200));
if(is_null($cat_id) || is_null($add_date)) {
	$goto_url = "/";
	$mystep->pageEnd();
}
if(!empty($link)) {
	$goto_url = $link;
	$mystep->pageEnd();
}

$add_date = strtotime($add_date);
if($cat_info = getParaInfo("news_cat", "cat_id", $cat_id)) {
	$cat_idx = $cat_info['cat_idx'];
	$cat_name = $cat_info['cat_name'];
	$menu_cat_id = $cat_info['cat_main'];
	if($menu_cat_id==0) $menu_cat_id = $cat_info['cat_id'];
} else {
	$goto_url = "/";
	$mystep->pageEnd();
}
$db->Query("update ".$setting['db']['pre_sub']."news_show set views = views + 1 where news_id=".$news_id);
$page = $req->getGet("page");
if(!is_numeric($page)) $page = 1;
if($page < 1) $page = 1;
if($page > $page_count) $page = $page_count;

if($setting['gen']['cache']) {
	$cache_info = array(
			'idx' => ($page==1?$news_id:"{$news_id}_{$page}"),
			'path' => $cache_path."/".date("Y/md/",$add_date),
			'expire' => getCacheExpire(),
			);
} else {
	$cache_info = false;
}
if($view_lvl>$setting['info']['user']['type']['view_lvl']) {
	$tpl = $mystep->getInstance("MyTpl", $tpl_info, false);
	$tpl_info['idx'] = "login";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	$ms_info = $req->getCookie("ms_info");
	if(empty($ms_info)) $ms_info = ($req->getSession("usertype")==1)?$setting['language']['login_login']:$setting['language']['login_nopower'];
	$tpl_tmp->Set_Variable('info', $ms_info);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content());
	unset($tpl_tmp);
	$mystep->show($tpl);
	$mystep->pageEnd($setting['gen']['show_info']);
}

$tpl = $mystep->getInstance("MyTpl", $tpl_info, $cache_info);
if($tpl->Is_Cached()) {
	echo $tpl->Get_Content();
	$mystep->pageEnd($setting['gen']['show_info']);
}

$detail = getData("select a.*, b.sub_title, b.content from ".$setting['db']['pre_sub']."news_show a left join ".$setting['db']['pre_sub']."news_detail b on a.news_id=b.news_id where a.news_id='{$news_id}' and b.page='{$page}'", "record", 1200);
if($detail===false) {
	$goto_url = "/";
	$mystep->pageEnd();
}

$web_id = $setting['info']['web']['web_id'];
$tpl_info['idx'] = "read";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

if(!empty($cat_name)) $tpl_tmp->Set_Variable('catalog_txt', ' - <a href="'.getUrl("list", $cat_idx, 1, $setting['info']['web']['web_id']).'">'.$cat_name.'</a>');
$tpl_tmp->Set_Variable('web_url', $setting['web']['url']);
$tpl_tmp->Set_Variable('page_list', PageList($page, $page_count));
$tpl_tmp->Set_Variable('title', $setting['web']['title']);
$tpl_tmp->Set_Variable('web_title', $setting['web']['title']);
$tpl_tmp->Set_Variable('web_url', $setting['web']['url']);

//if($setting['watermark']['mode'] & 1) $detail['content'] = txt_watermark($detail['content'], true, $setting['watermark']['credit'], $setting['web']['url']);
if($setting['watermark']['mode'] & 1) {
	$script = <<<mystep
<script language="JavaScript">
watermark(\$id('content'), 5, "{$setting['watermark']['credit']}", "{$setting['watermark']['txt']}");
</script>
mystep;
	$mystep->setAddedContent("end", $script);
}
if(empty($detail['original'])) $detail['original'] = $setting['language']['original'];
if(empty($detail['image'])) $detail['image'] = "images/dummy.png";
$tpl_tmp->Set_Variables($detail, "record");

//News Page
if($page_count==1) {
	$tpl_tmp->Set_Variable('sub_page', 'new Array()');
} else {
	$result = getData("select sub_title, page from ".$setting['db']['pre_sub']."news_detail where news_id='{$news_id}' order by page", "all", 1200);
	$max_count = count($result);
	for($i=0; $i<$max_count; $i++) {
		$result[$i]['url'] = getUrl("read", array($news_id, $cat_idx), $result[$i]['page'], $setting['info']['web']['web_id']);
		if($result[$i]['page']==$page) $result[$i]['selected'] = "selected";
		$result[$i]['txt'] = sprintf($setting['language']['page_no'], $result[$i]['page']);
		if(!empty($result[$i]['sub_title'])) $result[$i]['txt'] .= " - ".$result[$i]['sub_title'];
	}
	$tpl_tmp->Set_Variable('sub_page', toJson($result, $setting['gen']['charset']));
	unset($result);
}

//Prev. Article
if($article = getData("select news_id, cat_id, subject, add_date from ".$setting['db']['pre_sub']."news_show where news_id<'{$news_id}' order by news_id desc limit 1", "record")) {
	if($cat_info = getParaInfo("news_cat", "cat_id", $article['cat_id'])) {
		$cat_idx = $cat_info['cat_idx'];
	} else {
		$cat_idx = "";
	}
	$tpl_tmp->Set_Variable('article_prev_link', getUrl("read", array($article['news_id'], $cat_idx), 1, $setting['info']['web']['web_id']));
	$tpl_tmp->Set_Variable('article_prev_text', $article['subject']);
} else {
	$tpl_tmp->Set_Variable('article_prev_link', "###");
	$tpl_tmp->Set_Variable('article_prev_text', "");
}

//Next Article
if($article = getData("select news_id, cat_id, subject, add_date from ".$setting['db']['pre_sub']."news_show where news_id>'{$news_id}' order by news_id asc limit 1", "record")) {
	if($cat_info = getParaInfo("news_cat", "cat_id", $article['cat_id'])) {
		$cat_idx = $cat_info['cat_idx'];
	} else {
		$cat_idx = "";
	}
	$tpl_tmp->Set_Variable('article_next_link', getUrl("read", array($article['news_id'], $cat_idx), 1, $setting['info']['web']['web_id']));
	$tpl_tmp->Set_Variable('article_next_text', $article['subject']);
} else {
	$tpl_tmp->Set_Variable('article_next_link', "###");
	$tpl_tmp->Set_Variable('article_next_text', "");
}

//News Tag
$tag = explode(",", $detail['tag']);
$max_count = count($tag);
for($i=0; $i<$max_count; $i++) {
	if($setting['rewrite']['enable']) {
		$tpl_tmp->Set_Loop('tag_list', array("link"=>$setting['web']['url']."/tag/".urlencode($tag[$i]).$setting['gen']['cache_ext'], "tag"=>$tag[$i]));
	} else {
		$tpl_tmp->Set_Loop('tag_list', array("link"=>"tag.php?tag=".urlencode($tag[$i]), "tag"=>$tag[$i]));
	}
}
unset($tag);
$tag = $detail['tag'];

$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);

if(!empty($cat_idx)) $setting['web']['title'] = $cat_name."_".$setting['web']['title'];
$setting['web']['title'] = $detail['subject']."_".$setting['web']['title'];
$setting['web']['keyword'] = $detail['subject'].",".$cat_name;
$setting['web']['description'] = $detail['describe'];
$mystep->show($tpl);
$mystep->pageEnd($setting['gen']['show_info']);
?>