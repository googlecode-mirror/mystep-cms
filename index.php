<?php
require("inc.php");
$tpl_info = array(
		"idx" => "main",
		"style" => $setting['gen']['template'],
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
if($setting['gen']['cache']) {
	$cache_info = array(
			'idx' => 'index',
			'path' => ROOT_PATH."/".$setting['path']['cache']."/",
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

includeCache("catalog");
$max_count = count($news_cat);
for($i=0; $i<$max_count; $i++) {
	if($news_cat[$i]['cat_layer']==1) {
		if(empty($news_cat[$i]['cat_link'])) $news_cat[$i]['cat_link'] = getFileURL(0, $news_cat[$i]['cat_idx']);
		$tpl->Set_Loop('news_cat', $news_cat[$i]);
	}
}
includeCache("link");
$tpl_info['idx'] = "index";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_temp);

$mystep->show($tpl);
$mystep->pageEnd();
?>