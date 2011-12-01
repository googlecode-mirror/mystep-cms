<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "search";
$topic_id = $req->getReq("topic_id");
$log_info = "";

switch($method) {
	case "search":
		$script = "";
		$web_id = $req->getReq("web_id");
		if(empty($web_id)) $web_id = 1;
		$keyword = $req->getGet("keyword");
		if(empty($keyword)) $script = "parent.$.closePopupLayer();";
		
		$tpl_info = array(
			"idx" => "main",
			"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
			"path" => ROOT_PATH."/".$setting['path']['template'],
		);
		$tpl = $mystep->getInstance("MyTpl", $tpl_info);
		$tpl_info['idx'] = "search";
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
		$tpl_tmp->Set_Variable('keyword', urlencode($keyword));
		
		$style_list = explode(",", $db->getSingleResult("select topic_cat from ".$setting['db']['pre']."topic where topic_id='{$topic_id}'"));
		$style_select = "";
		$max_count = count($style_list);
		for($i=0; $i<$max_count; $i++) {
			$style_select .= "<option value='{$i}'>{$style_list[$i]}</option>\n";
		}
		
		$setting_sub = getSubSetting($web_id);
		$db_pre = $setting_sub['db']['name'].".".$setting_sub['db']['pre'];
		$max_count = count($GLOBALS['website']);
		for($i=0; $i<$max_count; $i++) {
			$GLOBALS['website'][$i]['selected'] = $GLOBALS['website'][$i]['web_id']==$web_id?"selected":"";
			$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
		}
		
		$n=1;
		$keyword = "(a.subject like '%".str_replace(" ", "%' and a.subject like '%", $keyword)."%')";
		$db->Query("select a.news_id, a.subject, a.add_date, b.cat_name from ".$db_pre."news_show as a left join ".$setting['db']['pre']."news_cat as b on a.cat_id=b.cat_id where {$keyword} order by a.news_id desc limit 200");
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$record['n'] = $n++;
			$record['style_select'] = $style_select;
			$tpl_tmp->Set_Loop('record', $record);
		}
		$db->Free();
		$tpl_tmp->Set_Variable('topic_id', $topic_id);
		$tpl_tmp->Set_Variable('script', $script);
		$tpl->Set_Variable('path_admin', $setting['path']['admin']);
		$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
		unset($tpl_tmp);
		$mystep->show($tpl);
		break;
	case "delete":
		$log_info = $setting['language']['plugin_topic_delete_link'];
		$id = $req->getReq("id");
		$db->Query("delete from ".$setting['db']['pre']."topic_link where id='{$id}'");
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "empty":
		$log_info = $setting['language']['plugin_topic_empty_link'];
		$id = $req->getReq("id");
		$db->Query("delete from ".$setting['db']['pre']."topic_link where topic_id='{$topic_id}'");
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "add":
		$log_info = $setting['language']['plugin_topic_add_link'];
		$_POST['add_date'] = date("Y-m-d H:i:s");
		$str_sql = $db->buildSQL($setting['db']['pre']."topic_link", $_POST, "replace");
		$db->Query($str_sql);
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "batch_add":
		$log_info = $setting['language']['plugin_topic_add_link_batch'];
		$add_list = $req->getPost("add_list");
		$cat_list = $req->getPost("cat_list");
		$max_count = count($add_list);
		$record = array();
		for($i=0; $i<$max_count; $i++) {
			$item = explode("::", $add_list[$i]);
			$record['id'] = "0";
			$record['topic_id'] = $topic_id;
			$record['link_name'] = $item[1];
			$record['link_url'] = getFileURL($item[2], "", $req->getReq("web_id"));
			$record['link_cat'] = $cat_list[$item[0]-1];
			$record['link_order'] = "0";
			$record['add_date'] = date("Y-m-d H:i:s");
			
			$str_sql = $db->buildSQL($setting['db']['pre']."topic_link", $record, "replace");
			$db->Query($str_sql);
		}
		echo <<<mystep
<script language="JavaScript">
parent.location.reload();
</script>
mystep;
		break;
	default:
		break;
}

if(!empty($log_info)) {
	write_log($log_info, "topic_id=".$topic_id);
	if(empty($goto_url) && $method!="batch_add") $goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);
?>