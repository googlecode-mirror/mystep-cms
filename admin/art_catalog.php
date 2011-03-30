<?php
require("inc.php");

includeCache("news_cat");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$cat_id = $req->getReq("cat_id");
$log_info = "";

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
			$db->Query("delete from ".$setting['db']['pre']."news_cat where cat_id = '{$catid}'");
			$db->Query("delete from ".$setting['db']['pre']."news_show where cat_id = '{$catid}'");
			$db->Query("delete from ".$setting['db']['pre']."news_detail where cat_id = '{$catid}'");
			$catid_list = array();
			$db->Query("select cat_id from ".$setting['db']['pre']."news_cat where cat_main = '{$catid}'");
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
	case "up":
	case "down":
		function setPosition($cat_id, $mode) {
			global $db, $setting;
			list($cat_main, $cat_layer)=array_values($db->GetSingleRecord("select cat_main, cat_layer from ".$setting['db']['pre']."news_cat where cat_id='{$cat_id}'"));
			$db->Query("select cat_id, cat_order from ".$setting['db']['pre']."news_cat where cat_layer='{$cat_layer}' and cat_main='{$cat_main}' order by cat_order");
			while($record[] = $db->GetRS()) {}
			$db->Free();
			$max_count = count($record)-1;
			for($i=0; $i<$max_count; $i++) {
				if($record[$i]['cat_id']!=$cat_id) continue;
				if($mode=="up") {
					if($i>0) {
						$db->Query("update ".$setting['db']['pre']."news_cat set cat_order=".$record[$i-1]['cat_order']." where cat_id='{$cat_id}'");
						$db->Query("update ".$setting['db']['pre']."news_cat set cat_order=".$record[$i]['cat_order']." where cat_id='".$record[$i-1]['cat_id']."'");
					}
				} elseif($mode=="down") {
					if($i<count($record)-2) {
						$db->Query("update ".$setting['db']['pre']."news_cat set cat_order=".$record[$i+1]['cat_order']." where cat_id='{$cat_id}'");
						$db->Query("update ".$setting['db']['pre']."news_cat set cat_order=".$record[$i]['cat_order']." where cat_id='".$record[$i+1]['cat_id']."'");
					}
				}
				break;
			}
			return;
		}
		$log_info = $setting['language']['admin_art_catalog_change'];
		setPosition($cat_id, $method);
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
				$_POST['cat_layer'] = 1 + $db->GetSingleResult("select cat_layer from ".$setting['db']['pre']."news_cat where cat_id='".$_POST['cat_main']."'");
			}
			$_POST['cat_show'] = array_sum($_POST['cat_show']);
			if(is_null($_POST['cat_show'])) $_POST['cat_show'] = 0;
			if($method=="add_ok") {
				$log_info = $setting['language']['admin_art_catalog_add'];
				$_POST['cat_order'] = 1 + $db->GetSingleResult("select max(cat_order) from ".$setting['db']['pre']."news_cat");
				$str_sql = $db->buildSQL($setting['db']['pre']."news_cat", $_POST, "insert", "a");
			} else {
				$log_info = $setting['language']['admin_art_catalog_edit'];
				function multiChange($catid, $layer) {
					global $db, $setting;
					$db->Query("update ".$setting['db']['pre']."news_cat set cat_layer='{$layer}' where cat_id = '{$catid}'");
					$catid_list = array();
					$db->Query("select cat_id from ".$setting['db']['pre']."news_cat where cat_main = '{$catid}'");
					while($record = $db->GetRS()) {$catid_list[] = $record['cat_id'];}
					$db->free();
					$max_count = count($catid_list);
					for($i=0; $i<$max_count; $i++) {
						multiChange($catid_list[$i], $layer+1);
					}
					return;
				}
				multiChange($cat_id, $_POST['cat_layer']);
				$str_sql = $db->buildSQL($setting['db']['pre']."news_cat", $_POST, "update", "cat_id={$cat_id}");
			}
			$db->Query($str_sql);
			if($method=="add_ok" && $group['power_cat']!="all") {
				$db->Query("update ".$setting['db']['pre']."user_group set power_cat = concat(power_cat, ',".$db->GetInsertId()."') where group_id='".$usergroup."'");
				deleteCache("user_group");
			}
			deleteCache("news_cat");
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
		$tpl_tmp->Set_Variable("group", json_encode(chg_charset($group, $setting['gen']['charset'], "utf-8")));
		$tpl_tmp->Set_Variable("news_cat", json_encode(chg_charset($news_cat, $setting['gen']['charset'], "utf-8")));
		$max_count = count($news_cat);
		for($i=0; $i<$max_count; $i++) {
			if(!$GLOBALS['op_mode'] && $news_cat[$i]['web_id']!=$setting['info']['web']['web_id']) continue;
			$news_cat[$i]['cat_name'] = ((isset($news_cat[$i+1]) && $news_cat[$i+1]['cat_layer']==$news_cat[$i]['cat_layer'])?"©À ":"©¸ ").$news_cat[$i]['cat_name'];
			for($j=1; $j<$news_cat[$i]['cat_layer']; $j++) {
				$news_cat[$i]['cat_name'] = "&nbsp;".$news_cat[$i]['cat_name'];
			}
			$news_cat[$i]['cat_name'] = preg_replace("/^©À /", "", preg_replace("/^©¸ /", "", $news_cat[$i]['cat_name']));
			$web = getParaInfo("website", "web_id", $news_cat[$i]['web_id']);
			$news_cat[$i]['web_name'] = $web['name'];
			if(empty($news_cat[$i]['web_name'])) $news_cat[$i]['web_name'] = $setting['language']['admin_art_catalog_public'];
			$tpl_tmp->Set_Loop('record', $news_cat[$i]);
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_art_catalog_catalog']);
	} else {
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."news_cat where cat_id='{$cat_id}'");
			$record  = $db->GetRS();
			$db->Free();
			if(!$record) {
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
			//$web_disabled = ($record['cat_main']==0)?"":"disabled";
			$web_disabled = "disabled";
		} else {
			$record = array();
			$record['cat_id'] = 0;
			$record['web_id'] = 0;
			$record['cat_main'] = 0;
			$record['cat_name'] = "";
			$record['cat_idx'] = "";
			$record['cat_sub'] = "";
			$record['cat_comment'] = "";
			$record['cat_image'] = "";
			$record['cat_link'] = "";
			$web_disabled = "";
			$record['cat_show_1'] = "checked";
			$record['cat_show_2'] = "checked";
			$record['cat_show_4'] = "checked";
			$record['cat_type_0'] = "selected";
			$record['cat_type_1'] = "";
			$record['cat_type_2'] = "";
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
			if($news_cat[$i]['cat_id']==$record['cat_id']) {
				$cur_layer = $news_cat[$i]['cat_layer'];
				continue;
			}
			if(!empty($news_cat[$i]['cat_link'])) continue;
			if($news_cat[$i]['cat_layer'] > $cur_layer) {
				continue;
			} else {
				$cur_layer = 99;
			}
			$news_cat[$i]['cat_name'] = ((isset($news_cat[$i+1]) && $news_cat[$i+1]['cat_layer']==$news_cat[$i]['cat_layer'])?"©À ":"©¸ ").$news_cat[$i]['cat_name'];
			for($j=1; $j<$news_cat[$i]['cat_layer']; $j++) {
				$news_cat[$i]['cat_name'] = "&nbsp;".$news_cat[$i]['cat_name'];
			}
			$news_cat[$i] = preg_replace("/^©À /", "", preg_replace("/^©¸ /", "", $news_cat[$i]));
			$tpl_tmp->Set_Loop('catalog', array('cat_id'=>$news_cat[$i]['cat_id'], 'cat_name'=>$news_cat[$i]['cat_name'], 'web_id'=>$news_cat[$i]['web_id'],'selected'=>($record['cat_main']==$news_cat[$i]['cat_id']?"selected":"")));
		}
		
		$tpl_tmp->Set_Variable('title', ($method=='add'?$setting['language']['admin_art_catalog_add']:$setting['language']['admin_art_catalog_edit']));
		$tpl_tmp->Set_Variable('method', $method);
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