<?php
require("../inc.php");
include("info.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$idx = $req->getReq("idx");
$log_info = "";

$mydb = $mystep->getInstance("MyDB", "code", dirname(__FILE__));
if(!$mydb->checkTBL()) {
	$db_setting = array(
		array("idx",10),
		array("page",30),
		array("description",200)
	);
	$mydb->createTBL($db_setting);
}

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['plugin_front_code_delete'];
		$record = $mydb->queryDate("idx=".$idx, true, &$fp_pos, &$row_pos);
		$mydb->deleteDate($row_pos);
		unlink(dirname(__FILE__)."/code/".$idx.".php");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			$content = $_POST['content'];
			if(get_magic_quotes_gpc()) $content = stripslashes($content);
			if(!preg_match("/^<\?php(.+)\?>$/i", $content)) $content = "<?php\n".$content."\n?>";
			unset($_POST['content']);
			if($method=="add_ok") {
				$_POST['idx'] = $_SERVER['REQUEST_TIME'];
				$log_info = $setting['language']['plugin_front_code_add'];
				$mydb->insertDate($_POST, 1);
			} else {
				$log_info = $setting['language']['plugin_front_code_edit'];
				$record = $mydb->queryDate("idx=".$idx, true, &$fp_pos, &$row_pos);
				$mydb->updateDate($_POST, $row_pos, 1);
			}
			WriteFile(dirname(__FILE__)."/code/".$_POST['idx'].".php", $content, "wb");
		}
		break;
	default:
		break;
}

if(!empty($log_info)) {
	write_log($log_info, "idx={$idx}");
	$goto_url = $setting['info']['self'];
}
$mydb->closeTBL();
unset($mydb);
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $idx, $mydb;
	$tpl_info = array(
			"idx" => "main",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
			);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);

	$tpl_info['idx'] = ($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if($method == "list") {
		$record = $mydb->queryAll();
		if(!$record) $record = array();
		$tpl_tmp->Set_Loop('record', $record, true);
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_front_code_title']);
	} else {
		if($method == "edit") {
			$record = $mydb->queryDate("idx=".$idx, true, &$fp_pos, &$row_pos);
			if(!$record) {
				$tpl->Set_Variable('main', showInfo($setting['language']['plugin_front_code_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			$record['content'] = GetFile(dirname(__FILE__)."/code/".$idx.".php");
			$record['content'] = preg_replace("/^<\?php(.+)\?>$/is", "\\1", $record['content']);
			HtmlTrans(&$record);
		} else {
			$record = array();
			$record['idx'] = $_SERVER['REQUEST_TIME'];
			$record['page'] = "";
			$record['description'] = "";
			$record['content'] = "";
		}
		$tpl_tmp->Set_Variables($record);
		
		$tpl_tmp->Set_Variable('title', ($method=='add'?$setting['language']['plugin_front_code_add']:$setting['language']['plugin_front_code_edit']));
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}

	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>