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
		$log_info = "删除用户组";
		$group_id = $req->getGet("group_id");
		if($group_id>2) {
			$db->Query("delete from ".$setting['db']['pre']."user_group where group_id = '{$group_id}'");
			deleteCache("user_group");
		}
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $self;
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
			$log_info = ($method=="add_ok"?"添加用户组":"编辑用户组");
			$qry_str = $db->buildSQL($setting['db']['pre']."user_group", $_POST);
			$db->Query($qry_str);
			deleteCache("user_group");
		}
		break;
	default:
		build_page("list");
}

if(!empty($log_info)) {
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"]."&group_name={$group_name}", $log_info);
	$goto_url = $self;
}
$mystep->pageEnd(false);


function build_page($method) {
	global $mystep, $req, $db, $tpl, $group_id, $tpl_info, $admin_cat, $admin_cat_plat, $news_cat, $website, $setting;

	$tpl_info['idx'] = "user_group_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

	if($method == "list") {
		$str_sql = "select * from ".$setting['db']['pre']."user_group order by group_id";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			if($record['power_func']=="all") {
				$record['power_func'] = "全部管理权限";
			} elseif($record['power_func']=="") {
				$record['power_func'] = "无管理权限";
			} else {
				$thePowerFunc = split(",", $record['power_func']);
				$record['power_func'] = "";
				for($i=0; $i<count($thePowerFunc); $i++) {
					$theFunc = getParaInfo("admin_cat_plat", "id", $thePowerFunc[$i]);
					$record['power_func'] .= $theFunc['name'].", ";
				}
				$record['power_func'] = substr($record['power_func'], 0, -2);
			}
			if($record['power_cat']=="all") {
				$record['power_cat'] = "全部栏目权限";
			} elseif($record['power_cat']=="") {
				$record['power_cat'] = "无栏目权限";
			} else {
				$thePowerCata = split(",", $record['power_cat']);
				$record['power_cat'] = "";
				for($i=0; $i<count($thePowerCata); $i++) {
					$theCata = getParaInfo("news_cat", "cat_id", $thePowerCata[$i]);
					$record['power_cat'] .= $theCata['cat_name'].", ";
				}
				$record['power_cat'] = substr($record['power_cat'], 0, -2);
			}
			if($record['power_web']=="all") {
				$record['power_web'] = "全部网站权限";
			} elseif($record['power_web']=="") {
				$record['power_web'] = "无网站权限";
			} else {
				$thePowerWeb = split(",", $record['power_web']);
				$record['power_web'] = "";
				for($i=0; $i<count($thePowerWeb); $i++) {
					$theWeb = getParaInfo("website", "web_id", $thePowerWeb[$i]);
					$record['power_web'] .= $theCata['name'].", ";
				}
				$record['power_web'] = substr($record['power_web'], 0, -2);
			}
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', '网站用户组群列表');
	} else {
		$tpl_tmp->Set_Variable('title', ($method == "add"?'用户组群添加':'用户组群编辑'));
		
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."user_group where group_id='{$group_id}'");
			if($record = $db->GetRS()) {
				//nothing
			} else {
				$tpl->Set_Variable('main', showInfo("指定 ID 的用户组不存在！", 0));
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
		for($i=0; $i<count($website); $i++) {
			$tpl_tmp->Set_Loop('power_web', array("web_id"=>$website[$i]['web_id'], "name"=>$website[$i]['name'], "checked"=>strpos(",".$record['power_web'].",", ",".$website[$i]['web_id'].",")!==false?"checked":""));
		}
		
		$tpl_tmp->Set_Variable('power_func_all_checked', $record['power_func']=="all"?"checked":"");
		for($i=0; $i<count($admin_cat); $i++) {
			$tpl_tmp->Set_Loop('power_func', array("key"=>$admin_cat[$i]['id'], "value"=>$admin_cat[$i]['name'], "pid"=>$admin_cat[$i]['pid'], "checked"=>strpos(",".$record['power_func'].",", ",".$admin_cat[$i]['id'].",")!==false?"checked":""));
			if(isset($admin_cat[$i]['sub'])) {
				for($j=0; $j<count($admin_cat[$i]['sub']); $j++) {
					$tpl_tmp->Set_Loop('power_func', array("key"=>$admin_cat[$i]['sub'][$j]['id'], "value"=>($j+1==count($admin_cat[$i]['sub'])?"└ ":"├ ").$admin_cat[$i]['sub'][$j]['name'], "pid"=>$admin_cat[$i]['sub'][$j]['pid'], "checked"=>strpos(",".$record['power_func'].",", ",".$admin_cat[$i]['sub'][$j]['id'].",")!==false?"checked":""));
				}
			}
		}
		
		$tpl_tmp->Set_Variable('power_cat_all_checked', $record['power_cat']=="all"?"checked":"");
		$max_count = count($news_cat);
		for($i=0; $i<$max_count; $i++) {
			$news_cat[$i]['cat_name'] = ((isset($news_cat[$i+1]) && $news_cat[$i+1]['cat_layer']==$news_cat[$i]['cat_layer'])?"├ ":"└ ").$news_cat[$i]['cat_name'];
			for($j=1; $j<$news_cat[$i]['cat_layer']; $j++) {
				$news_cat[$i]['cat_name'] = " &nbsp;".$news_cat[$i]['cat_name'];
			}
			$news_cat[$i]['cat_name'] = preg_replace("/^├ /", "", preg_replace("/^└ /", "", $news_cat[$i]['cat_name']));
			$news_cat[$i]['checked'] = (strpos(",".$record['power_cat'].",", ",".$news_cat[$i]['cat_id'].",")!==false)?"checked":"";
			$tpl_tmp->Set_Loop('power_cat', $news_cat[$i]);
		}

		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_temp);
	$mystep->show($tpl);
	return;
}
?>