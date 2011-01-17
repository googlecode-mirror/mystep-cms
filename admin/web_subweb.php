<?php
require("inc.php");

includeCache("website");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$web_id = $req->getGet("web_id");
$log_info = "";

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = "É¾³ıÍøÕ¾";
		$web_id = $req->getGet("web_id");
		$web_info = getParaInfo("website", "web_id", $web_id);
		if($web_id>1) {
			$cfg_file = ROOT_PATH."/include/config_".$web_info['idx'].".php";
			$main_setting = $setting;
			include($cfg_file);
			if($main_setting['db']['name']!=$setting['db']['name']) {
				$db->Query("drop database ".$main_setting['db']['name']);
			} elseif($main_setting['db']['pre']!=$setting['db']['pre']) {
				$db->Query("drop table ".$setting['db']['pre']."news_show");
				$db->Query("drop table ".$setting['db']['pre']."news_detail");
				$db->Query("drop table ".$setting['db']['pre']."info_show");
				$db->Query("drop table ".$setting['db']['pre']."news_tag");
				$db->Query("drop table ".$setting['db']['pre']."attachment");
				$db->Query("drop table ".$setting['db']['pre']."links");
				$db->Query("drop table ".$setting['db']['pre']."counter");
			} else {
				$db->Query("update news_cat set web_id=1 where web_id='{$web_id}'");
				$db->Query("update news_show set web_id=1 where web_id='{$web_id}'");
			}
			@unlink($cfg_file);
			$db->Query("delete from ".$setting['db']['pre']."website where web_id='{$web_id}'");
			deleteCache("website");
			$setting = $main_setting;
		}
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $self;
		} else {
			$log_info = ($method=="add_ok"?"Ìí¼ÓÍøÕ¾":"±à¼­ÍøÕ¾");
			$new_setting = $_POST['setting'];
			unset($_POST['setting']);
			$result = <<<mystep
<?php
\$setting = array();

/*--settings--*/
?>
mystep;
			$result = str_replace("/*--settings--*/", makeVarsCode($new_setting, '$setting'), $result);
			if($method=="add_ok" && ($setting['db']['name']!=$new_setting['db']['name'] || $setting['db']['pre']!=$new_setting['db']['pre'])) {
				$strFind = array("{db_name}", "{pre}", "{charset}", "{host}");
				$strReplace = array($new_setting['db']['name'], $new_setting['db']['pre'], $setting['db']['charset'], $_POST['host']);
				$info = $db->ExeSqlFile("subweb.sql", $strFind, $strReplace);
			}
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
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"]."&web_id={$web_id}", $log_info);
	$goto_url = $self;
}
$mystep->pageEnd(false);


function build_page($method) {
	global $mystep, $req, $db, $tpl, $web_id, $tpl_info, $website, $setting;

	$tpl_info['idx'] = "web_subweb_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

	if($method == "list") {
		$str_sql = "select * from ".$setting['db']['pre']."website order by web_id";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', 'ÍøÕ¾ÁĞ±í');
	} else {
		$tpl_tmp->Set_Variable('title', ($method == "add"?'ÍøÕ¾Ìí¼Ó':'ÍøÕ¾±à¼­'));
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."website where web_id='{$web_id}'");
			if($record = $db->GetRS()) {
				//nothing
			} else {
				$tpl->Set_Variable('main', showInfo("Ö¸¶¨ ID µÄÍøÕ¾²»´æÔÚ£¡", 0));
				$mystep->pageEnd(false);
			}
		} else {
			$record['web_id'] = 0;
			$record['name'] = "";
			$record['idx'] = "";
			$record['host'] = "";
		}
		$tpl_tmp->Set_Variables($record);
		$setting['watermark']['mode'] = array($setting['watermark']['mode']&1==1, $setting['watermark']['mode']&2==2);
		
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_temp);
	$mystep->show($tpl);
	return;
}
?>