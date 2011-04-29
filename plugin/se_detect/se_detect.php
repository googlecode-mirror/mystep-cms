<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";

$idx = $req->getReq("idx");
$log_info = "";
switch($method) {
	case "add":
	case "edit":
	case "view":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['plug_se_detect_delete'];
		$db->Query("delete from ".$setting['db']['pre']."se_detect where idx = '{$idx}'");
		$db->Query("alter table ".$setting['db']['pre']."se_count drop `{$idx}`");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			$ip_info = array();
			$str_sql = "select ip,`count` from ".$setting['db']['pre']."se_detect";
			$db->Query($str_sql);
			while($record = $db->GetRS()) {
				$ip_info[$record['ip']] = $record['count'];
			}
			$db->Free();
			if($method=="add_ok") {
				$log_info = $setting['language']['plug_se_detect_add'];
				$db->Query("alter table ".$setting['db']['pre']."se_count add `{$idx}` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL");
			} else {
				$log_info = $setting['language']['plug_se_detect_edit'];
				if($_POST['idx_org']!=$_POST['idx']) {
					$db->Query("delete from ".$setting['db']['pre']."se_detect where idx = '".$_POST['idx_org']."'");
					$db->Query("alter table ".$setting['db']['pre']."se_count change `".$_POST['idx_org']."` `".$_POST['idx']."` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL");
				}
			}
			$_POST['ip'] = str_replace("\r", "", $_POST['ip']);
			$ip_list = explode("\n", $_POST['ip']);
			unset($_POST['ip'], $_POST['idx_org']);
			for($i=0,$m=count($ip_list);$i<$m;$i++) {
				if(strlen($ip_list[$i])<5) continue;
				$_POST['ip'] = $ip_list[$i];
				$_POST['ip'] = str_replace("\n", "", $_POST['ip']);
				$_POST['count'] = 0;
				if(isset($ip_info[$_POST['ip']])) $_POST['count'] = $ip_info[$_POST['ip']];
				$db->Query($db->buildSQL($setting['db']['pre']."se_detect", $_POST, "replace"));
			}
		}
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
	global $mystep, $req, $db, $setting, $idx;
	$tpl_info = array(
			"idx" => "main",
			"style" => "",
			"path" => "./",
			);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	$tpl_info['idx'] = (($method=="add" || $method=="edit")?"input":$method);
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if($method == "list") {
		$str_sql = "select idx, count(*) as counter from ".$setting['db']['pre']."se_detect group by idx order by idx";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			$tpl_tmp->Set_Loop('record', $record);
		}
		$db->Free();
		$tpl_tmp->Set_Variable('title', $setting['language']['plug_se_detect_title']);
	} elseif($method == "view") {
		$str_sql = "select distinct(idx) as idx from ".$setting['db']['pre']."se_detect";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			$tpl_tmp->Set_Loop('se', $record);
		}
		$db->Free();
		$str_sql = "select * from ".$setting['db']['pre']."se_count";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			$detail = "";
			foreach($record as $key => $value) {
				if($key=="date") continue;
				$detail .= "<td class=\"row\">".$record[$key]."</td>\n";
			}
			$record['detail'] = $detail;
			$tpl_tmp->Set_Loop('record', $record);
		}
		$db->Free();
		$tpl_tmp->Set_Variable('title', $setting['language']['plug_se_detect_title']);
	} else {
		$record = array();
		$record['idx'] = '';
		$record['idx_org'] = '';
		$record['ip'] = "";
		if($method == "edit") {
			$record['idx'] = $idx;
			$record['idx_org'] = $idx;
			$db->Query("select ip from ".$setting['db']['pre']."se_detect where idx='{$idx}'");
			while($tmp = $db->GetRS()) {
				$record['ip'] .= $tmp['ip']."\n";
			}
			$db->Free();
			HtmlTrans(&$record);
		}
		$tpl_tmp->Set_Variables($record);
		
		$tpl_tmp->Set_Variable('title', ($method=='add'?$setting['language']['plug_se_detect_add']:$setting['language']['plug_se_detect_edit']));
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