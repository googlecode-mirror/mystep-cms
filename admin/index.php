<?php
require("inc.php");

$tpl_info['idx'] = "index";
$tpl = $mystep->getInstance("MyTpl", $tpl_info);

includeCache("website");
includeCache("news_cat", false);
$tpl->Set_Variable("username", $req->getSession('username'));
$tpl->Set_Variable("usergroup", $group['group_name']);
$tpl->Set_Variable("web_id", $web_id);
$tpl->Set_Variable("group", toJson($group, $setting['gen']['charset']));
if($op_mode) {
	$tpl->Set_Variable("admin_cat", toJson($admin_cat, $setting['gen']['charset']));
} else {
	$tpl->Set_Variable("admin_cat", toJson($admin_cat_plat, $setting['gen']['charset']));
	if($group['power_func']=="all") {
		$first_page = "art_content.php";
	} else {
		$power_list = explode(",", $group['power_func']);
		for($i=0, $m=count($power_list);$i<$m;$i++) {
			$first_page = getParaInfo("admin_cat_plat", "id", array_shift($power_list));
			if($first_page!==false && strpos($first_page['file'], "#")===false) break;
		}
		if($first_page==false) {
			$goto_url = "/";
			$mystep->pageEnd(false);
		}
		$first_page = $first_page['url'];
	}
	$tpl->Set_Variable("first_page", $first_page);
}
$tpl->Set_Variable("website", toJson($website, $setting['gen']['charset']));
$tpl->Set_Variable("news_cat", toJson($news_cat, $setting['gen']['charset']));

$tpl->Set_Variable("year", date('Y'));
$tpl->Set_Variables($ms_version, "ms_version");

$mystep->show($tpl);
$mystep->pageEnd(false);
?>