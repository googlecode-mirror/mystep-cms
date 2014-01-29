<?php
require("../inc.php");
include("agent.php");

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
		$log_info = $setting['language']['plugin_se_detect_delete'];
		$db->delete($setting['db']['pre']."se_detect",array("idx","=",$idx));
		$db->update($setting['db']['pre']."se_count", array($setting['language']['etc']=>"((`".$setting['language']['etc']."` + `".$idx."`))"));
		$db->exec("alter","table",$setting['db']['pre']."se_count","drop",$idx);
		unset($agent[$idx]);
		$content = "<?PHP
\$agent = ".var_export($agent, true).";			
?>";
		WriteFile("agent.php", $content, "wb");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			unset($agent[$_POST['idx_org']]);
			$agent[$_POST['idx']] = $_POST['keyword'];
			$ip_info = array();
			$db->select($setting['db']['pre']."se_detect", "ip,count");
			while($record = $db->GetRS()) {
				$ip_info[$record['ip']] = $record['count'];
			}
			$db->Free();
			if($method=="add_ok") {
				$log_info = $setting['language']['plugin_se_detect_add'];
				$keys = array_keys($agent);
				$db->exec("alter","table",$setting['db']['pre']."se_count","add","`{$idx}` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL after `".$keys[count($keys)-2]."`");
			} else {
				$log_info = $setting['language']['plugin_se_detect_edit'];
				if($_POST['idx_org']!=$_POST['idx']) {
					$db->delete($setting['db']['pre']."se_detect",array("idx",$_POST['idx_org']));
					$db->exec("alter","table",$setting['db']['pre']."se_count","change","`".$_POST['idx_org']."` `".$_POST['idx']."` MEDIUMINT UNSIGNED DEFAULT 0 NOT NULL");
				}
			}
			$_POST['ip'] = str_replace("\r", "", $_POST['ip']);
			$ip_list = explode("\n", $_POST['ip']);
			unset($_POST['ip'], $_POST['idx_org'], $_POST['keyword']);
			for($i=0,$m=count($ip_list);$i<$m;$i++) {
				if(strlen($ip_list[$i])<5) continue;
				$_POST['ip'] = $ip_list[$i];
				$_POST['ip'] = str_replace("\n", "", $_POST['ip']);
				$_POST['count'] = 0;
				if(isset($ip_info[$_POST['ip']])) $_POST['count'] = $ip_info[$_POST['ip']];
				$db->replace($setting['db']['pre']."se_detect", $_POST);
			}
			$content = "<?PHP
\$agent = ".var_export($agent, true).";			
?>";
			WriteFile("agent.php", $content, "wb");
		}
		break;
	default:
		$goto_url = $setting['info']['self'];
}

if(!empty($log_info)) {
	write_log($log_info, "idx=".$idx);
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $idx, $agent;
	$tpl_info = array(
			"idx" => "main",
			"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
			"path" => ROOT_PATH."/".$setting['path']['template'],
			);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	$tpl_info['idx'] = (($method=="add" || $method=="edit")?"input":$method);
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if($method == "list") {
		foreach($agent as $key => $value) {
			$record = array();
			$record['idx'] = $key;
			$record['counter'] = $db->result($setting['db']['pre']."se_detect","count(*)",array("idx","=",$key));
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_se_detect_title']);
	} elseif($method == "view") {
		$counter = $db->result($setting['db']['pre']."se_count","count(*)");
		$tpl_tmp->Set_If('empty', ($counter==0));
		$page = $req->getGet("page");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?method=view", $page);
		$tpl_tmp->Set_Variables($page_arr);
		
		$fields = $db->GetTabFields($setting['db']['name'], $setting['db']['pre']."se_count");
		for($i=1, $m=count($fields); $i<$m; $i++) {
			$tpl_tmp->Set_Loop('se', array('idx'=>$fields[$i]));
		}
		$tpl_tmp->Set_Variable("field_count", $m);
		$db->select($setting['db']['pre']."se_count","*","",array("order"=>"date desc", "limit"=>"{$page_start}, {$page_size}"));
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
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_se_detect_title']);
	} else {
		$record = array();
		$record['idx'] = '';
		$record['idx_org'] = '';
		$record['keyword'] = "";
		$record['ip'] = "";
		if($method == "edit") {
			$record['idx'] = $idx;
			$record['idx_org'] = $idx;
			$record['keyword'] = $agent[$idx];
			$db->select($setting['db']['pre']."se_detect", "ip", array("idx","=",$idx));
			while($tmp = $db->GetRS()) {
				$record['ip'] .= $tmp['ip']."\n";
			}
			$db->Free();
			HtmlTrans(&$record);
		}
		$tpl_tmp->Set_Variables($record);
		
		$tpl_tmp->Set_Variable('title', ($method=='add'?$setting['language']['plugin_se_detect_add']:$setting['language']['plugin_se_detect_edit']));
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