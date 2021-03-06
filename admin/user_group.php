<?php
require("inc.php");

includeCache("news_cat");
includeCache("admin_cat");
includeCache("website");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$group_id = $req->getGet("group_id");
$log_info = "";

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_user_group_delete'];
		$group_id = $req->getGet("group_id");
		if($group_id>2) {
			$db->delete($setting['db']['pre']."user_group", array("group_id","n=",$group_id));
			deleteCache("user_group");
		}
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			if($_POST['power_func'][0]=="all") {
				$_POST['power_func'] = "all";
			} else {
				$_POST['power_func'] = join($_POST['power_func'], ",");
			}
			if($_POST['power_cat'][0]=="all") {
				$_POST['power_cat'] = "all";
			} else {
				$_POST['power_cat'] = join($_POST['power_cat'], ",");
			}
			if($_POST['power_web'][0]=="all") {
				$_POST['power_web'] = "all";
			} else {
				$_POST['power_web'] = join($_POST['power_web'], ",");
			}
			$log_info = ($method=="add_ok"?$setting['language']['admin_user_group_add']:$setting['language']['admin_user_group_edit']);
			$db->replace($setting['db']['pre']."user_group", $_POST);
			deleteCache("user_group");
		}
		break;
	default:
		build_page("list");
}

if(!empty($log_info)) {
	write_log($log_info, "group_id=".$group_id);
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);


function build_page($method) {
	global $mystep, $req, $db, $tpl, $group_id, $tpl_info, $admin_cat, $admin_cat_plat, $news_cat, $website, $setting;

	$tpl_info['idx'] = "user_group_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

	if($method == "list") {
		$db->select($setting['db']['pre']."user_group", "*", "", array("order"=>"group_id"));
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			if($record['power_func']=="all") {
				$record['power_func'] = $setting['language']['admin_user_group_power_all'];
			} elseif($record['power_func']=="") {
				$record['power_func'] = $setting['language']['admin_user_group_power_none'];
			} else {
				$thePowerFunc = explode(",", $record['power_func']);
				$record['power_func'] = "";
				$max_count = count($thePowerFunc);
				for($i=0; $i<$max_count; $i++) {
					$theFunc = getParaInfo("admin_cat_plat", "id", $thePowerFunc[$i]);
					$record['power_func'] .= $theFunc['name'].", ";
				}
				$record['power_func'] = substr($record['power_func'], 0, -2);
			}
			if($record['power_cat']=="all") {
				$record['power_cat'] = $setting['language']['admin_user_group_cat_all'];
			} elseif($record['power_cat']=="") {
				$record['power_cat'] = $setting['language']['admin_user_group_cat_none'];
			} else {
				$thePowerCata = explode(",", $record['power_cat']);
				$record['power_cat'] = "";
				$max_count = count($thePowerCata);
				for($i=0; $i<$max_count; $i++) {
					$theCata = getParaInfo("news_cat", "cat_id", $thePowerCata[$i]);
					$record['power_cat'] .= $theCata['cat_name'].", ";
				}
				$record['power_cat'] = substr($record['power_cat'], 0, -2);
			}
			if($record['power_web']=="all") {
				$record['power_web'] = $setting['language']['admin_user_group_web_all'];
			} elseif($record['power_web']=="") {
				$record['power_web'] = $setting['language']['admin_user_group_web_none'];
			} else {
				$thePowerWeb = explode(",", $record['power_web']);
				$record['power_web'] = "";
				$max_count = count($thePowerWeb);
				for($i=0; $i<$max_count; $i++) {
					$theWeb = getParaInfo("website", "web_id", $thePowerWeb[$i]);
					$record['power_web'] .= $theWeb['name'].", ";
				}
				$record['power_web'] = substr($record['power_web'], 0, -2);
			}
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_user_group_title']);
	} else {
		$tpl_tmp->Set_Variable('title', ($method == "add"?$setting['language']['admin_user_group_add']:$setting['language']['admin_user_group_edit']));
		
		if($method == "edit") {
			$record = $db->record($setting['db']['pre']."user_group","*",array("group_id","n=",$group_id));
			if($record === false) {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_user_group_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
		} else {
			$record['group_id'] = 0;
			$record['group_name'] = "";
			$record['power_func'] = "";
			$record['power_cat'] = "";
			$record['power_web'] = "";
		}
		$tpl_tmp->Set_Variables($record);
		
		$tpl_tmp->Set_Variable('power_web_all_checked', $record['power_web']=="all"?"checked":"");
		$max_count = count($website);
		for($i=0; $i<$max_count; $i++) {
			$tpl_tmp->Set_Loop('power_web', array("web_id"=>$website[$i]['web_id'], "name"=>$website[$i]['name'], "checked"=>strpos(",".$record['power_web'].",", ",".$website[$i]['web_id'].",")!==false?"checked":""));
		}
		
		$tpl_tmp->Set_Variable('power_func_all_checked', $record['power_func']=="all"?"checked":"");
		$max_count = count($admin_cat);
		for($i=0; $i<$max_count; $i++) {
			$tpl_tmp->Set_Loop('power_func', array("key"=>$admin_cat[$i]['id'], "value"=>$admin_cat[$i]['name'], "pid"=>$admin_cat[$i]['pid'], "checked"=>strpos(",".$record['power_func'].",", ",".$admin_cat[$i]['id'].",")!==false?"checked":""));
			if(isset($admin_cat[$i]['sub'])) {
				$max_count1 = count($admin_cat[$i]['sub']);
				for($j=0; $j<$max_count1; $j++) {
					$tpl_tmp->Set_Loop('power_func', array("key"=>$admin_cat[$i]['sub'][$j]['id'], "value"=>($j+1==count($admin_cat[$i]['sub'])?"�� ":"�� ").$admin_cat[$i]['sub'][$j]['name'], "pid"=>$admin_cat[$i]['sub'][$j]['pid'], "checked"=>strpos(",".$record['power_func'].",", ",".$admin_cat[$i]['sub'][$j]['id'].",")!==false?"checked":""));
				}
			}
		}
		
		$tpl_tmp->Set_Variable('power_cat_all_checked', $record['power_cat']=="all"?"checked":"");
		$max_count = count($news_cat);
		for($i=0; $i<$max_count; $i++) {
			$news_cat[$i]['cat_name'] = ((isset($news_cat[$i+1]) && $news_cat[$i+1]['cat_layer']==$news_cat[$i]['cat_layer'])?"�� ":"�� ").$news_cat[$i]['cat_name'];
			for($j=1; $j<$news_cat[$i]['cat_layer']; $j++) {
				$news_cat[$i]['cat_name'] = " &nbsp;".$news_cat[$i]['cat_name'];
			}
			$news_cat[$i]['cat_name'] = preg_replace("/^�� /", "", preg_replace("/^�� /", "", $news_cat[$i]['cat_name']));
			$news_cat[$i]['checked'] = (strpos(",".$record['power_cat'].",", ",".$news_cat[$i]['cat_id'].",")!==false)?"checked":"";
			$tpl_tmp->Set_Loop('power_cat', $news_cat[$i]);
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