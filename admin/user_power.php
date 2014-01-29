<?php
require("inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$power_id = $req->getReq("power_id");
$log_info = "";
includeCache("user_power");

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_user_power_delete'];
		$db->delete($setting['db']['pre']."user_power", array("power_id","n=",$power_id));
		$powerInfo = getParaInfo("user_power", "power_id", $power_id);
		$db->delete($setting['db']['pre']."user_power", array("power_id","n=",$power_id));
		$db->exec("alter","table",$setting['db']['pre']."user_type","drop",$powerInfo['idx']);
		deleteCache("user_type");
		deleteCache("user_power");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			
			$formatList = array(
				'string' => " Char(100) NOT NULL DEFAULT ''",
				'digital' => " INT NOT NULL DEFAULT 0",
				'date' => " Date NOT NULL DEFAULT '0000-00-00'",
				'time' => " Time NOT NULL DEFAULT '00:00:00'",
			);
			if(empty($_POST['format']) || !isset($formatList[$_POST['format']])) $_POST['format'] = "string";
			$theFormat = $formatList[$_POST['format']];
			
			$idx_org = $_POST['idx_org'];
			$format_org = $_POST['format_org'];
			unset($_POST['idx_org'], $_POST['format_org']);
			$log_info = ($method=="add_ok"?$setting['language']['admin_user_power_add']:$setting['language']['admin_user_power_edit']);
			$db->replace($setting['db']['pre']."user_power", $_POST);
			if($method=="add_ok") {
				$db->exec("alter","table",$setting['db']['pre']."user_type","add","`".$_POST['idx']."` ".$theFormat);
				$db->update($setting['db']['pre']."user_type", array($_POST['idx']=>$_POST['value']));
			} else {
				if($idx_org!=$_POST['idx']) {
					$db->Query("alter","table",$setting['db']['pre']."user_type","change","`".$idx_org."` `".$_POST['idx']."` ".$theFormat);
				} elseif($format_org!=$_POST['format']) {
					$db->Query("alter","table",$setting['db']['pre']."user_type","modify","`".$_POST['idx']."` ".$theFormat);
				}
			}
			deleteCache("user_type");
			deleteCache("user_power");
		}
		break;
	default:
		build_page("list");
}

if(!empty($log_info)) {
	write_log($log_info, "power_id=".$power_id);
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);


function build_page($method) {
	global $mystep, $req, $db, $tpl, $power_id, $tpl_info, $setting;

	$tpl_info['idx'] = "user_power_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

	$formatList = array(
		'digital' => $setting['language']['checkform_item_digital'],
		'date' => $setting['language']['checkform_item_date'],
		'time' => $setting['language']['checkform_item_time'],
	);

	if($method == "list") {
		$db->select($setting['db']['pre']."user_power","*","",array("order"=>"power_id"));
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$record['format'] = $formatList[$record['format']];
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_user_power_title']);
	} else {
		$tpl_tmp->Set_Variable('title', ($method == "add"?$setting['language']['admin_user_power_add']:$setting['language']['admin_user_power_edit']));
		
		if($method == "edit") {
			$record = $db->record($setting['db']['pre']."user_power","*",array("power_id", "n=", $power_id));
			if($record === false) {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_user_power_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			$record['idx_org'] = $record['idx'];
		} else {
			$record['power_id'] = 0;
			$record['idx'] = "";
			$record['idx_org'] = "";
			$record['name'] = "";
			$record['value'] = "";
			$record['format'] = "";
			$record['format_org'] = "";
			$record['comment'] = "";
		}
		$tpl_tmp->Set_Variables($record);
		
		foreach($formatList as $key => $value) {
			$tpl_tmp->Set_Loop('format', array("key"=>$key, "value"=>$value, "select"=>($record['format']==$key?"selected":"")));
		}
		
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$db->Free();
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>