<?php
require("inc.php");

includeCache("news_cat", false);
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$cat_id = $req->getReq("cat_id");
$log_info = "";

if(!empty($cat_id)) {
	if($webInfo = getParaInfo("news_cat", "cat_id", $cat_id)) {
		if(!$op_mode && $web_id!=$webInfo['web_id']) {
			echo showInfo($setting['language']['admin_art_catalog_error']);
			$mystep->pageEnd(false);
		}
	} else {
		echo showInfo($setting['language']['admin_art_catalog_error']);
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
		$log_info = $setting['language']['admin_art_catalog_delete'];
		function multiDelData($catid) {
			global $db, $setting;
			$db->delete($setting['db']['pre']."news_cat", array("cat_id","n=",$catid));
			$db->delete($setting['db']['pre']."news_show", array("cat_id","n=",$catid));
			$db->delete($setting['db']['pre']."news_detail", array("cat_id","n=",$catid));
			$catid_list = array();
			$db->select($setting['db']['pre']."news_cat", "cat_id", array("cat_main","n=",$catid));
			while($record = $db->GetRS()) {$catid_list[] = $record['cat_id'];}
			$db->free();
			$max_count = count($catid_list);
			for($i=0; $i<$max_count; $i++) {
				multiDelData($catid_list[$i]);
			}
			return;
		}
		multiDelData($cat_id);
		deleteCache("news_cat");
		break;
	case "order":
		$log_info = $setting['language']['admin_art_catalog_change'];
		for($i=0,$m=count($_POST['cat_id']);$i<$m;$i++) {
			$db->update($setting['db']['pre']."news_cat", array("cat_order"=>$_POST['cat_order'][$i]), array("cat_id","n=",$_POST['cat_id'][$i]));
		}
		deleteCache("news_cat");
		break;
	case "up":
	case "down":
		$log_info = $setting['language']['admin_art_catalog_change'];
		list($cat_main, $cat_layer, $web_id)=array_values($db->record($setting['db']['pre']."news_cat", "cat_main, cat_layer, web_id", array("cat_id","n=",$cat_id)));
		$db->select($setting['db']['pre']."news_cat", "cat_id, cat_order, web_id",array(array("cat_layer","n=",$cat_layer),array("cat_main","n=",$cat_main,"and"),array("web_id","n=",$web_id,"and")),array("order"=>"cat_order"));
		while($record[] = $db->GetRS()) {}
		$db->Free();
		$max_count = count($record)-1;
		for($i=0; $i<$max_count; $i++) {
			if($record[$i]['cat_id']!=$cat_id) continue;
			if($method=="up") {
				if($i>0) {
					$db->update($setting['db']['pre']."news_cat", array("cat_order",$record[$i-1]['cat_order']), array("cat_id","n=",$cat_id));
					$db->update($setting['db']['pre']."news_cat", array("cat_order",$record[$i]['cat_order']), array("cat_id","n=",$record[$i-1]['cat_id']));
				}
			} elseif($method=="down") {
				if($i<count($record)-2) {
					$db->update($setting['db']['pre']."news_cat", array("cat_order",$record[$i+1]['cat_order']), array("cat_id","n=",$cat_id));
					$db->update($setting['db']['pre']."news_cat", array("cat_order",$record[$i]['cat_order']), array("cat_id","n=",$record[$i+1]['cat_id']));
				}
			}
			break;
		}
		deleteCache("news_cat");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			if($_POST['cat_main']==0) {
				$_POST['cat_layer'] = 1;
			} else {
				$_POST['cat_layer'] = 1 + $db->result($setting['db']['pre']."news_cat", "cat_layer", array("cat_id", "n=", $_POST['cat_main']));
			}
			$_POST['cat_show'] = array_sum($_POST['cat_show']);
			if(is_null($_POST['cat_show'])) $_POST['cat_show'] = 0;
			$view_lvl_org = $_POST['view_lvl_org'];
			unset($_POST['view_lvl_org']);
			$notice_org = $_POST['notice_org'];
			unset($_POST['notice_org']);
			$merge = $_POST['merge'];
			unset($_POST['merge']);
			$template = "";
			if($_POST['cat_type']==3) $template = $_POST['template'];
			unset($_POST['template']);
			if($_POST['cat_type']==3 && $template=="") $_POST['cat_type'] = 1;
			if($method=="add_ok") {
				$log_info = $setting['language']['admin_art_catalog_add'];
				$_POST['cat_order'] = 1 + $db->result($setting['db']['pre']."news_cat", "max(cat_order)");
				$db->insert($setting['db']['pre']."news_cat", $_POST, true);
			} else {
				if(!is_null($merge) && $_POST['cat_main']!=0 && $_POST['cat_main']!=$cat_id) {
					$log_info = $setting['language']['admin_art_catalog_merge'];
					$db->update($setting['db']['pre']."news_cat",array("cat_id",$_POST['cat_main']),array("cat_main","n=",$cat_id));
					$db->update($setting['db']['pre']."news_show",array("cat_id",$_POST['cat_main']),array("cat_id","n=",$cat_id));
					$db->update($setting['db']['pre']."news_detail",array("cat_id",$_POST['cat_main']),array("cat_id","n=",$cat_id));
					$db->delete($setting['db']['pre']."news_cat", array("cat_id",$cat_id));
				} else {
					$log_info = $setting['language']['admin_art_catalog_edit'];
					function multiChange($catid, $layer) {
						global $db, $setting;
						if($layer>100) showInfo($setting['language']['admin_art_catalog_error']);
						$db->update($setting['db']['pre']."news_cat",array("cat_layer"=>$layer),array("cat_id","n=",$catid));
						$catid_list = array();
						$db->select($setting['db']['pre']."news_cat", "cat_id", array("cat_main","n=",$catid));
						while($record = $db->GetRS()) {$catid_list[] = $record['cat_id'];}
						$db->free();
						for($i=0,$m=count($catid_list); $i<$m; $i++) {
							multiChange($catid_list[$i], $layer+1);
						}
						return;
					}
					multiChange($cat_id, $_POST['cat_layer']);
					$db->update($setting['db']['pre']."news_cat", $_POST, array("cat_id","n=",$cat_id));
					$setting_sub = getSubSetting($webInfo['web_id']);
					if($setting['db']['name']==$setting_sub['db']['name']) {
						$setting['db']['pre_sub'] = $setting_sub['db']['pre'];
					} else {
						$setting['db']['pre_sub'] = $setting_sub['db']['name'].".".$setting_sub['db']['pre'];
					}
					if($view_lvl_org!=$_POST['view_lvl'] && is_numeric($_POST['view_lvl'])) {
						$db->update($setting['db']['pre_sub']."news_show", array("view_lvl", $_POST['view_lvl']), array(array("cat_id","n=",$cat_id), array("view_lvl","n=",$view_lvl_org,"and")));
					}
					if($notice_org!=$_POST['notice']) {
						$db->update($setting['db']['pre_sub']."news_show", array("notice", $_POST['notice']), array(array("cat_id","n=",$cat_id), array("notice","=",$notice_org,"and")));
					}
				}
			}
			if($method=="add_ok") {
				$cat_id = $db->GetInsertId();
				if($group['power_cat']!="all") {
					$db->update($setting['db']['pre']."user_group", array("power_cat", "concat(power_cat, ',".$cat_id."')"), array("group_id","n=",$usergroup));
					deleteCache("user_group");
				}
			}
			deleteCache("news_cat");
			$the_file = ROOT_PATH."/".$setting['path']['template']."/default/list_cat_".$cat_id.".tpl";
			if(!empty($template)) {
				WriteFile($the_file, $template, "wb");
			} else {
				@unlink($the_file);
			}
		}
		break;
	default:
		$goto_url = $setting['info']['self'];
}

if(!empty($log_info)) {
	write_log($log_info, "cat_id={$cat_id}");
	$goto_url = basename(($method=="up" || $method=="down" || $method=="delete") ? $req->getServer("HTTP_REFERER") : $req->getServer("PHP_SELF"));
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $tpl, $tpl_info, $setting, $news_cat, $cat_id, $group;

	$tpl_info['idx'] = "art_catalog_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$tpl_tmp->Set_Variable("group", toJson($group, $setting['gen']['charset']));
		$tpl_tmp->Set_Variable("news_cat", toJson($news_cat, $setting['gen']['charset']));
		$max_count = count($news_cat);
		for($i=0; $i<$max_count; $i++) {
			if(!$GLOBALS['op_mode'] && $news_cat[$i]['web_id']!=$setting['info']['web']['web_id']) continue;
			if($group['power_cat']!="all" && strpos(','.$group['power_cat'].',', ','.$news_cat[$i]['cat_id'].',')===false) continue;
			$news_cat[$i]['cat_name'] = ((isset($news_cat[$i+1]) && $news_cat[$i+1]['cat_layer']==$news_cat[$i]['cat_layer'])?"�� ":"�� ").$news_cat[$i]['cat_name'];
			for($j=1; $j<$news_cat[$i]['cat_layer']; $j++) {
				$news_cat[$i]['cat_name'] = "&nbsp; ".$news_cat[$i]['cat_name'];
			}
			$news_cat[$i]['cat_name'] = preg_replace("/^�� /", "", preg_replace("/^�� /", "", $news_cat[$i]['cat_name']));
			$web = getParaInfo("website", "web_id", $news_cat[$i]['web_id']);
			$news_cat[$i]['web_name'] = $web['name'];
			if(empty($news_cat[$i]['web_name'])) $news_cat[$i]['web_name'] = $setting['language']['admin_art_catalog_public'];
			$news_cat[$i]['web_url'] = $web['host'];
			if(strpos($news_cat[$i]['web_url'], ",")!==false) $news_cat[$i]['web_url'] = substr($news_cat[$i]['web_url'], 0, strpos($news_cat[$i]['web_url'], ","));
			$news_cat[$i]['web_url'] = "http://".$news_cat[$i]['web_url'];
			$tpl_tmp->Set_Loop('record', $news_cat[$i]);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_art_catalog_catalog']);
	} else {
		if($method == "edit") {
			$show_merge = "inline";
			$record = $db->record($setting['db']['pre']."news_cat", "*", array("cat_id","n=",$cat_id));
			if($record===false) {
				$tpl->Set_Variable('main', showInfo($setting['language']['admin_art_catalog_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			HtmlTrans(&$record);
			$record['cat_show_1'] = ($record['cat_show'] & 1) ? "checked" : "";
			$record['cat_show_2'] = ($record['cat_show'] & 2) ? "checked" : "";
			$record['cat_show_4'] = ($record['cat_show'] & 4) ? "checked" : "";
			$record['cat_type_0'] = ($record['cat_type']==0) ? "selected" : "";
			$record['cat_type_1'] = ($record['cat_type']==1) ? "selected" : "";
			$record['cat_type_2'] = ($record['cat_type']==2) ? "selected" : "";
			$record['cat_type_3'] = ($record['cat_type']==3) ? "selected" : "";
			$record['template'] = "";
			$web_disabled = "disabled";
			$the_file = ROOT_PATH."/".$setting['path']['template']."/default/list_cat_".$cat_id.".tpl";
			if(file_exists($the_file)) $record['template'] = GetFile($the_file);
		} else {
			$show_merge = "none";
			$record = array();
			$record['cat_id'] = 0;
			$record['web_id'] = 0;
			$record['cat_main'] = 0;
			$record['cat_name'] = "";
			$record['cat_idx'] = "";
			$record['cat_sub'] = "";
			$record['cat_keyword'] = "";
			$record['cat_comment'] = "";
			$record['cat_image'] = "";
			$record['cat_link'] = "";
			$record['view_lvl'] = 0;
			$record['view_lvl_org'] = 0;
			$record['notice'] = "";
			$record['notice_org'] = "";
			$record['cat_type'] = 0;
			$web_disabled = "";
			$record['cat_show_1'] = "checked";
			$record['cat_show_2'] = "checked";
			$record['cat_show_4'] = "checked";
			$record['cat_type_0'] = "selected";
			$record['cat_type_1'] = "";
			$record['cat_type_2'] = "";
			$record['cat_type_3'] = "";
			$record['template'] = "";
			if(!$GLOBALS['op_mode']) $record['web_id'] = $setting['info']['web']['web_id'];
		}
		
		$max_count = count($GLOBALS['website']);
		for($i=0; $i<$max_count; $i++) {
			$GLOBALS['website'][$i]['selected'] = $GLOBALS['website'][$i]['web_id']==$record['web_id']?"selected":"";
			$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
		}
			
		$tpl_tmp->Set_Variables($record);
		
		$cur_layer = 99;
		$max_count = count($news_cat);
		for($i=0; $i<$max_count; $i++) {
			if(($method == "edit" || !$GLOBALS['op_mode']) && $news_cat[$i]['web_id']!=$record['web_id']) continue;
			if($group['power_cat']!="all" && strpos(','.$group['power_cat'].',', ','.$news_cat[$i]['cat_id'].',')===false) continue;
			if($news_cat[$i]['cat_id']==$record['cat_id']) {
				$cur_layer = $news_cat[$i]['cat_layer'];
				continue;
			}
			//if(!empty($news_cat[$i]['cat_link'])) continue;
			if($news_cat[$i]['cat_layer'] > $cur_layer) {
				continue;
			} else {
				$cur_layer = 99;
			}
			$news_cat[$i]['cat_name'] = ((isset($news_cat[$i+1]) && $news_cat[$i+1]['cat_layer']==$news_cat[$i]['cat_layer'])?"�� ":"�� ").$news_cat[$i]['cat_name'];
			for($j=1; $j<$news_cat[$i]['cat_layer']; $j++) {
				$news_cat[$i]['cat_name'] = "&nbsp;".$news_cat[$i]['cat_name'];
			}
			$news_cat[$i] = preg_replace("/^�� /", "", preg_replace("/^�� /", "", $news_cat[$i]));
			$tpl_tmp->Set_Loop('catalog', array('cat_id'=>$news_cat[$i]['cat_id'], 'cat_name'=>$news_cat[$i]['cat_name'], 'web_id'=>$news_cat[$i]['web_id'],'selected'=>($record['cat_main']==$news_cat[$i]['cat_id']?"selected":"")));
		}
		
		$tpl_tmp->Set_Variable('title', ($method=='add'?$setting['language']['admin_art_catalog_add']:$setting['language']['admin_art_catalog_edit']));
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('show_merge', $show_merge);
		$tpl_tmp->Set_Variable('web_disabled', $web_disabled);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$tpl_tmp->Set_Variable('web_id', $setting['info']['web']['web_id']);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>