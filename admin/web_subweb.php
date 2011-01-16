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
		$log_info = "删除网站";
		$web_id = $req->getGet("web_id");
		if($web_id>1) {
			$db->Query("delete from ".$setting['db']['pre']."website where web_id='{$web_id}'");
			deleteCache("website");
		}
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $self;
		} else {
			$log_info = ($method=="add_ok"?"添加网站":"编辑网站");
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
		$tpl_tmp->Set_Variable('title', '网站列表');
	} else {
		$tpl_tmp->Set_Variable('title', ($method == "add"?'网站添加':'网站编辑'));
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."website where web_id='{$web_id}'");
			if($record = $db->GetRS()) {
				//nothing
			} else {
				$tpl->Set_Variable('main', showInfo("指定 ID 的网站不存在！", 0));
				$mystep->pageEnd(false);
			}
		} else {
			$record['web_id'] = 0;
			$record['name'] = "";
			$record['idx'] = "";
			$record['host'] = "";
		}
		$tpl_tmp->Set_Variables($record);
		
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_temp);
	$mystep->show($tpl);
	return;
}
?>