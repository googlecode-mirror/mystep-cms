<?php
require("inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$id = $req->getReq("id");
$log_info = "";

if(!empty($id)) {
	$cur_web_id = $db->result($setting['db']['pre']."info_show", "web_id", array("id","n=",$id));
	if(!$op_mode && $web_id!=$cur_web_id) {
		echo showInfo($setting['language']['admin_art_image_error']);
		$mystep->pageEnd(false);
	}
}

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_art_info_delete'];
		$db->delete($setting['db']['pre']."info_show", array("id","n=",$id));
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			if($method=="add_ok") {
				$log_info = $setting['language']['admin_art_info_add'];
				$db->insert($setting['db']['pre']."info_show", $_POST, true);
			} else {
				$log_info = $setting['language']['admin_art_info_edit'];
				$db->update($setting['db']['pre']."info_show", $_POST, array("id","n=",$id));
			}
		}
		break;
	default:
		break;
}

if(!empty($log_info)) {
	write_log($log_info, "id={$id}");
	$goto_url = ($method=="delete") ? $req->getServer("HTTP_REFERER") : $setting['info']['self'];
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $tpl, $tpl_info, $setting, $id, $web_id;

	$tpl_info['idx'] = "art_info_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$condition = array();
		if(!empty($web_id)) $condition = array("web_id","n=",$web_id);
		$db->select($setting['db']['pre']."info_show", "*", $condition, array("order"=>"id asc"));
		$n = 0;
		while($record = $db->GetRS()) {
			$n++;
			if($webInfo = getParaInfo("website", "web_id", $record['web_id'])) {
				$record['web_id'] = $webInfo['name'];
			} else {
				$record['web_id'] = "ALL";
			}
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_If('empty', ($n==0));
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_art_info_title']);
		$tpl_tmp->Set_Variable('web_id', $web_id);
	} else {
		if($method == "edit") {
			$record = $db->record($setting['db']['pre']."info_show", "*", array("id","n=",$id));
			if($record===false) {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_art_info_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			$web_id = $record['web_id'];
			HtmlTrans(&$record);
		} else {
			$record = array();
			$record['id'] = 0;
			$record['web_id'] = $web_id;
			$record['subject'] = "";
			$record['content'] = "";
			$record['attach_list'] = "|";
		}
		$tpl_tmp->Set_Variables($record);
		$Max_size = round(GetFileSize(ini_get('upload_max_filesize'))/1024/1024,2);
		
		$tpl_tmp->Set_Variable('title', ($method=='add'?$setting['language']['admin_art_info_add']:$setting['language']['admin_art_info_edit']));
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('MaxSize', $Max_size);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	
	$max_count = count($GLOBALS['website']);
	for($i=0; $i<$max_count; $i++) {
		$GLOBALS['website'][$i]['selected'] = $GLOBALS['website'][$i]['web_id']==$web_id?"selected":"";
		$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
	}
	$db->Free();

	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>