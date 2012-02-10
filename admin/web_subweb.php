<?php
require("inc.php");

includeCache("website");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$web_id = $req->getGet("web_id");
if(!$op_mode) {
	$web_id = $setting['info']['web']['web_id'];
	if($method!="edit_ok") $method = "edit";
}
$log_info = "";

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_web_subweb_delete'];
		$web_id = $req->getGet("web_id");
		$web_info = getParaInfo("website", "web_id", $web_id);
		if($web_id>1) {
			$cfg_file = ROOT_PATH."/include/config_".$web_info['idx'].".php";
			include($cfg_file);
			if($setting['db']['name']!=$setting_sub['db']['name']) {
				$db->Query("drop database ".$setting_sub['db']['name']);
			} elseif($setting['db']['pre']!=$setting_sub['db']['pre']) {
				$db->Query("drop table ".$setting_sub['db']['pre']."news_show");
				$db->Query("drop table ".$setting_sub['db']['pre']."news_detail");
				$db->Query("drop table ".$setting_sub['db']['pre']."news_tag");
			} else {
				$db->Query("update ".$setting['db']['pre']."news_cat set web_id=1 where web_id='{$web_id}'");
				$db->Query("update ".$setting['db']['pre']."news_show set web_id=1 where web_id='{$web_id}'");
			}
			unlink($cfg_file);
			$db->Query("delete from ".$setting['db']['pre']."website where web_id='{$web_id}'");
			deleteCache("website");
		}
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			$log_info = ($method=="add_ok"?$setting['language']['admin_web_subweb_add']:$setting['language']['admin_web_subweb_edit']);
			$new_setting = $_POST['setting'];
			$new_setting['web']['url'] = "http://".$_POST['host'];
			$new_setting['web']['title'] = $_POST['name'];
			$new_setting['watermark']['mode'] = array_sum($new_setting['watermark']['mode']);
			unset($_POST['setting']);
			$result = <<<mystep
<?php
\$setting_sub = array();

/*--settings--*/
?>
mystep;
			$result = str_replace("/*--settings--*/", makeVarsCode($new_setting, '$setting_sub'), $result);
			if($method=="add_ok" && ($setting['db']['name']!=$new_setting['db']['name'] || $setting['db']['pre']!=$new_setting['db']['pre'])) {
				$strFind = array("{db_name}", "{pre}", "{charset}", "{host}", "{idx}");
				$strReplace = array($new_setting['db']['name'], $new_setting['db']['pre'], $setting['db']['charset'], $_POST['host'], $_POST['idx']);
				$info = $db->ExeSqlFile("subweb.sql", $strFind, $strReplace);
			}
			$db->Query("use ".$setting['db']['name']);
			WriteFile(ROOT_PATH."/include/config_".$_POST['idx'].".php", $result, "w");
			$qry_str = $db->buildSQL($setting['db']['pre']."website", $_POST);
			$db->Query($qry_str);
			deleteCache("website");
		}
		break;
	default:
		build_page("list");
}

if(!empty($log_info)) {
	write_log($log_info, "web_id={$web_id}");
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);


function build_page($method) {
	global $mystep, $req, $db, $tpl, $web_id, $tpl_info, $website, $setting;

	$tpl_info['idx'] = "web_subweb_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	$tpl_tmp->allow_script = true;

	if($method == "list") {
		$str_sql = "select * from ".$setting['db']['pre']."website order by web_id";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_subweb_title']);
		global $admin_cat;
		$tpl_tmp->Set_Variable("admin_cat", toJson($admin_cat, $setting['gen']['charset']));
		$tpl_tmp->Set_Variable("website", toJson($website, $setting['gen']['charset']));
	} else {
		$tpl_tmp->Set_Variable('title', ($method == "add"?$setting['language']['admin_web_subweb_add']:$setting['language']['admin_web_subweb_edit']));
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."website where web_id='{$web_id}'");
			if($record = $db->GetRS()) {
				//nothing
			} else {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_web_subweb_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
		} else {
			$record['web_id'] = 0;
			$record['name'] = "";
			$record['idx'] = "";
			$record['host'] = "";
		}
		$GLOBALS['subweb_idx'] = $record['idx'];
		
		$tpl_tmp->Set_Variables($record);
		$setting['watermark']['mode'] = array($setting['watermark']['mode']&1==1, $setting['watermark']['mode']&2==2);
		
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	$db->Free();
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>