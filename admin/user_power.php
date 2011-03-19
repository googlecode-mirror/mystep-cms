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
		$db->Query("delete from ".$setting['db']['pre']."user_power where power_id = '{$power_id}'");
		$powerInfo = getParaInfo("user_power", "power_id", $power_id);
		$db->Query("alter table ".$setting['db']['pre']."user_type drop ".$powerInfo['idx']);
		deleteCache("user_type");
		deleteCache("user_power");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			
			$formatList = array(
				'digital' => " INT NOT NULL DEFAULT 0",
				'date' => " Date NOT NULL DEFAULT '0000-00-00'",
				'time' => " Time NOT NULL DEFAULT '00:00:00'",
			);
			$theFormat = ($_POST['format']==""?" Char(100) NOT NULL DEFAULT ''":$formatList[$_POST['format']]);
			
			$idx_org = $_POST['idx_org'];
			$format_org = $_POST['format_org'];
			unset($_POST['idx_org'], $_POST['format_org']);
			$log_info = ($method=="add_ok"?$setting['language']['admin_user_power_add']:$setting['language']['admin_user_power_edit']);
			$qry_str = $db->buildSQL($setting['db']['pre']."user_power", $_POST);
			$db->Query($qry_str);
			if($method=="add_ok") {
				$db->Query("alter table `".$setting['db']['pre']."user_type` add `".$_POST['idx']."` ".$theFormat);
				$db->Query("update `".$setting['db']['pre']."user_type` set `".$_POST['idx']."`='".$_POST['value']."'");
			} else {
				if($idx_org!=$_POST['idx']) {
					$db->Query("alter table `".$setting['db']['pre']."user_type` change `".$_POST['idx']."` ".$theFormat);
				} elseif($format_org!=$_POST['format']) {
					$db->Query("alter table `".$setting['db']['pre']."user_type` modify `".$_POST['idx']."` ".$theFormat);
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
		$str_sql = "select * from ".$setting['db']['pre']."user_power order by power_id";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$record['format'] = $formatList[$record['format']];
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_user_power_title']);
	} else {
		$tpl_tmp->Set_Variable('title', ($method == "add"?$setting['language']['admin_user_power_add']:$setting['language']['admin_user_power_edit']));
		
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."user_power where power_id='{$power_id}'");
			if($record = $db->GetRS()) {
				$record['idx_org'] = $record['idx'];
			} else {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_user_power_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
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