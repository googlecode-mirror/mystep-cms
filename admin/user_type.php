<?php
require("inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$type_id = $req->getReq("type_id");
$log_info = "";
includeCache("user_power");

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_user_type_delete'];
		if($type_id>3) {
			$db->update($setting['db']['pre']."users", array("type_id"=>2), array("type_id","n=",$type_id));
			$db->delete($setting['db']['pre']."users", array("type_id","n=",$type_id));
			deleteCache("user_type");
		}
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			$log_info = ($method=="add_ok"?$setting['language']['admin_user_type_add']:$setting['language']['admin_user_type_edit']);
			$db->replace($setting['db']['pre']."user_type", $_POST);
			deleteCache("user_type");
		}
		break;
	default:
		build_page("list");
}

if(!empty($log_info)) {
	write_log($log_info, "type_id=".$type_id);
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);


function build_page($method) {
	global $mystep, $req, $db, $tpl, $type_id, $tpl_info, $setting, $user_power;

	$tpl_info['idx'] = "user_type_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$max_count = count($user_power);
		$db->select($setting['db']['pre']."user_type","*","",array("order"=>"type_id"));
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$record['user_power'] = "";
			for($i=0; $i<$max_count; $i++) {
				$record['user_power'] .= "<td class=\"row\">".$record[$user_power[$i]['idx']]."</td>\n";
			}
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_user_type_title']);
	} else {
		$tpl_tmp->Set_Variable('title', ($method == "add"?$setting['language']['admin_user_type_add']:$setting['language']['admin_user_type_edit']));
		
		if($method == "edit") {
			$record = $db->record($setting['db']['pre']."user_type","*", array("type_id","n=",$type_id));
			if($record === false) {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_user_type_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
		} else {
			$record['type_id'] = 0;
			$record['type_name'] = "";
		}
		$tpl_tmp->Set_Variables($record);
		
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$max_count = count($user_power);
	for($i=0; $i<$max_count; $i++) {
		if(isset($record[$user_power[$i]['idx']])) $user_power[$i]['value'] = $record[$user_power[$i]['idx']];
		$tpl_tmp->Set_Loop('user_power', $user_power[$i]);
	}
	$db->Free();
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>