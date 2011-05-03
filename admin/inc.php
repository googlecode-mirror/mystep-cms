<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/global.php");
include(ROOT_PATH."/source/function/web.php");
include(ROOT_PATH."/source/function/admin.php");
include(ROOT_PATH."/source/class/abstract.class.php");
include(ROOT_PATH."/source/class/mystep.class.php");

header("Expires: -1");
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0", false);
header("Pragma: no-cache");

$mystep = new MyStep();
$mystep->getLanguage(dirname(__FILE__)."/language/");
$mystep->pageStart();
$db->Reconnect(true, $setting['db']['name']);

$usergroup = $req->getSession("usergroup");
if($usergroup===0) {
	$goto_url = "../";
	$mystep->pageEnd(false);
}
$group = getParaInfo("user_group", "group_id", $usergroup);
if($setting['info']['self']=="login.php") {
	$method = $req->getServer("QUERY_STRING");
	if(!empty($group['power_func']) && $method!="logout") {
		$goto_url = "./index.php";
		$mystep->pageEnd(false);
	}
} else {
	if(empty($group['power_func']) ) {
		$goto_url = "./login.php";
		$mystep->pageEnd(false);
	}
	
	if($group['power_web']!="all" && strpos(",".$group['power_web'].",", ",".$setting['info']['web']['web_id'].",")===false) {
		echo showInfo($setting['language']['admin_nopower']);
		$mystep->pageEnd(false);
	}
	
	includeCache("admin_cat");
	if($group['power_func']!="all" && $cat_info = getParaInfo("admin_cat_plat", "file", $setting['info']['self'])) {
		if(strpos(",".$group['power_func'].",", ",".$cat_info['id'].",")===false) {
			echo showInfo($setting['language']['admin_nopower']);
			$mystep->pageEnd(false);
		}
	}
}

$op_mode = ($setting['info']['web']['web_id']==1 && ($group['power_func']=="all" || strpos(",".$group['power_func'].",", ",1,")!==false));

$tpl_info = array(
		"idx" => "main",
		"style" => ($op_mode?"admin":"admin_simple"),
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);
?>