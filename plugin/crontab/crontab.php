<?php
require("../inc.php");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$id = $req->getReq("id");
$log_info = "";
switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['plugin_crontab_delete'];
		$db->Query("delete from ".$setting['db']['pre']."crontab where id = '{$id}'");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			$_POST['next_date'] = date("Y-m-d H:i:s");
			$_POST['schedule'] = implode(",", $_POST['schedule']);
			if($method=="add_ok") {
				$log_info = $setting['language']['plugin_crontab_add'];
				$str_sql = $db->buildSQL($setting['db']['pre']."crontab", $_POST, "insert", "a");
			} else {
				if(empty($_POST['expire'])) unset($_POST['expire']);
				$log_info = $setting['language']['plugin_crontab_edit'];
				$str_sql = $db->buildSQL($setting['db']['pre']."crontab", $_POST, "update", "id={$id}");
			}
			$db->Query($str_sql);
		}
		break;
	case "start":
		file_put_contents("status.txt", "run");
		if($fp = @fopen("http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["SCRIPT_NAME"])."/run.php", "r")) {
			fclose($fp);
		}
		$goto_url = $setting['info']['self'];
		break;
	case "stop":
		file_put_contents("status.txt", "");
		$goto_url = $setting['info']['self'];
		break;
	default:
		$goto_url = $setting['info']['self'];
}

if(!empty($log_info)) {
	write_log($log_info, "id=".$id);
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $id;

	$tpl_info = array(
		"idx" => ($method=="list"?"list":"input"),
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$status = file_get_contents("status.txt");
		if($status=="run") {
			$tpl->Set_Variable('status_info', $setting['language']['plugin_crontab_status_run']);
			$tpl->Set_Variable('status_link', "?method=stop");
			$tpl->Set_Variable('status_txt', $setting['language']['plugin_crontab_status_stop']);
		} else {
			$tpl->Set_Variable('status_info', $setting['language']['plugin_crontab_status_stop']);
			//$tpl->Set_Variable('status_link', "?method=start");
			$tpl->Set_Variable('status_link', 'javascript:crontab_start()');
			$tpl->Set_Variable('status_txt', $setting['language']['plugin_crontab_status_run']);
		}
		$str_sql = "select * from ".$setting['db']['pre']."crontab order by id desc";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$tpl->Set_Loop('record', $record);
		}
		$db->Free();
		$tpl->Set_Variable('title', $setting['language']['plugin_crontab_title']);
	} else {
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."crontab where id='{$id}'");
			$record  = $db->GetRS();
			$db->Free();
			if(!$record) {
				$tpl->Set_Variable('main', showInfo($setting['language']['plugin_crontab_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			HtmlTrans(&$record);
		} else {
			$record = array();
			$record['id'] = 0;
			$record['name'] = "";
			$record['mode'] = 1;
			$record['expire'] = "";
			$record['schedule'] = "0,0,0,10,0";
			$record['url'] = "";
			$record['code'] = "";
		}
		$record['send_date'] = date("Y-m-d H:i:s");
		$tpl->Set_Variables($record);
		$tpl->Set_Variable('title', ($method=='add'?$setting['language']['plugin_crontab_add']:$setting['language']['plugin_crontab_edit']));
		$tpl->Set_Variable('method', $method);
		$tpl->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$db->Free();
	$mystep->show($tpl);
	return;
}
?>