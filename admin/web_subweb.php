<?php
require("inc.php");

includeCache("website");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
if(!$op_mode) {
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
		if(!$op_mode) {
				$goto_url = $setting['info']['self'];
			} else {
				$log_info = $setting['language']['admin_web_subweb_delete'];
				$web_id = $req->getGet("web_id");
				if($web_info = getParaInfo("website", "web_id", $web_id)) {
					$cfg_file = ROOT_PATH."/include/config_".$web_info['idx'].".php";
					include($cfg_file);
					if($setting['db']['name']!=$setting_sub['db']['name']) {
						$db->exec("drop","database",$setting_sub['db']['name']);
					} elseif($setting['db']['pre']!=$setting_sub['db']['pre']) {
						$db->exec("drop","table",$setting_sub['db']['pre']."news_show");
						$db->exec("drop","table",$setting_sub['db']['pre']."news_detail");
						$db->exec("drop","table",$setting_sub['db']['pre']."news_tag");
					} else {
						$db->update($setting['db']['pre']."news_cat", array("web_id"=>1), array("web_id","n=",$web_id));
						$db->update($setting['db']['pre']."news_show", array("web_id"=>1), array("web_id","n=",$web_id));
					}
					unlink($cfg_file);
					$db->delete($setting['db']['pre']."website", array("web_id","n=",$web_id));
					deleteCache("website");
				} else {
					$goto_url = $setting['info']['self'];
				}
			}
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0 || (!$op_mode && $method=="add_ok")) {
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
			$db->SelectDB($setting['db']['name']);
			WriteFile(ROOT_PATH."/include/config_".$_POST['idx'].".php", $result, "w");
			$db->replace($setting['db']['pre']."website", $_POST);
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
		$db->select($setting['db']['pre']."website", "*", "", array("order"=>"web_id"));
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
			$record = $db->record($setting['db']['pre']."website","*",array("web_id","n=",$web_id));
			if($record === false) {
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