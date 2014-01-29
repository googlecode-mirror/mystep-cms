<?php
require("inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$id = $req->getGet("id");
$log_info = "";

$setting_sub = getSubSetting($web_id);
if($setting['db']['name']==$setting_sub['db']['name']) {
	$setting['db']['pre_sub'] = $setting_sub['db']['pre'];
} else {
	$setting['db']['pre_sub'] = $setting_sub['db']['name'].".".$setting_sub['db']['pre'];
}

switch($method) {
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_art_tag_delete'];
		$tag = $db->result($setting['db']['pre_sub']."news_tag", "tag", array("id","n=",$id));
		$db->update($setting['db']['pre_sub']."news_show", array("tag"=>''), array("id","n=",$id));
		$db->update($setting['db']['pre_sub']."news_show", array("tag"=>"REPLACE(tag, '".$tag.",', '')"), array("tag","like",$tag));
		$db->update($setting['db']['pre_sub']."news_show", array("tag"=>"REPLACE(tag, ',".$tag."', '')"), array("tag","like",$tag));
		$db->delete($setting['db']['pre_sub']."news_tag", array("id","n=",$id));
		break;
	case "rebuild":
		set_time_limit(0);
		$log_info = $setting['language']['admin_art_tag_rebuild'];
		$db_tmp = new MySQL;
		$db_tmp->init($setting['db']['host'], $setting['db']['user'], $setting['db']['pass'], $setting['db']['charset']);
		$db_tmp->Connect(false);
		$db_tmp->SelectDB($setting['db']['name']);
		$db_tmp->update($setting['db']['pre_sub']."news_tag", array("count"=>0));
		$db->ReConnect(true, $setting['db']['name']);
		
		$n = 1;
		$db->select($setting['db']['pre_sub']."news_show", "news_id, tag", array(), array("order"=>"news_id"));
		while($record = $db->GetRS()) {
			$the_tag = $record['tag'];
			$the_tag = str_replace("¡¢", ",", $the_tag);
			$the_tag = str_replace("£¬", ",", $the_tag);
			$the_tag = str_replace("¡¡", " ", $the_tag);
			$the_tag = str_replace(" ", "_", $the_tag);
			$the_tag = explode(",", $the_tag);
			$max_count = count($the_tag);
			for($n=0; $n<$max_count; $n++) {
				$the_tag[$n] = trim($the_tag[$n], "_");
				$the_tag[$n] = mysql_real_escape_string($the_tag[$n]);
				if(strlen($the_tag[$n])<3 || preg_match("/[\d\.]+/", $the_tag[$n])) {
					$db_tmp->update($setting['db']['pre_sub']."news_show", array("tag"=>"replace('".$the_tag[$n].",', '', tag)"), array("news_id", "n=", $record['news_id']));
					$db_tmp->update($setting['db']['pre_sub']."news_show", array("tag"=>"replace(',".$the_tag[$n]."', '', tag)"), array("news_id", "n=", $record['news_id']));
					continue;
				}
				if(strlen($the_tag[$n]>50)) {
					$the_tag[$n] = substrPro($the_tag[$n], 0, 50);
				}
				if($db_tmp->result($setting['db']['pre_sub']."news_tag", "id", array("tag","=",$the_tag[$n]))) {
					$db_tmp->update($setting['db']['pre_sub']."news_tag", array("count"=>"+1","update_date"=>"UNIX_TIMESTAMP()"), array("tag","=",$the_tag[$n]));
				} else {
					$db_tmp->insert($setting['db']['pre_sub']."news_tag", array(0, $the_tag[$n], 1, 0, "UNIX_TIMESTAMP()", "UNIX_TIMESTAMP()"));
				}
			}
			if(++$n%50===0) {
				$db_tmp->ReConnect(false, $setting['db']['name']);
			}
		}
		$db_tmp->delete($setting['db']['pre_sub']."news_tag", array(array("count","n<",2), array("click","n<",5,"and"), array("add_date","f<","UNIX_TIMESTAMP()-60*60*24*10","and")));
		$db->Free();

		$n = 1;
		$db->select($setting['db']['pre_sub']."news_tag", "id, tag");
		while($record = $db->GetRS()) {
			$counter = $db_tmp->result($setting['db']['pre_sub']."news_show", "count(*)", array("tag","like",$record['tag']));
			$db_tmp->update($setting['db']['pre_sub']."news_tag", array("count"=>$counter), array("id","n=",$record['id']));
			if(++$n%50===0) {
				$db_tmp->ReConnect(false, $setting['db']['name']);
			}
		}
		$db_tmp->Close();
		unset($db_tmp);
		break;
	default:
		break;
}

if(!empty($log_info)) {
	write_log($log_info, "id={$id}");
	$goto_url = $setting['info']['self']."?web_id=".$web_id;
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $tpl, $tpl_info, $setting, $id, $web_id, $setting_sub;

	$tpl_info['idx'] = "art_tag";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	$order = $req->getGet("order");
	if(empty($order)) $order = "id";
	$order_type = $req->getGet("order_type");
	if(empty($order_type)) $order_type = "desc";
	$keyword = $req->getGet("keyword");
	$tpl_tmp->Set_Variable('keyword', $keyword);

	$page = $req->getGet("page");
	
	$condition = array();
	if(!empty($keyword)) $condition = array("tag","like",$keyword);
	$counter = $db->result($setting['db']['pre_sub']."news_tag", "count(*)", $condition);
	list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}&web_id={$web_id}", $page);
	$tpl_tmp->Set_Variables($page_arr);
	
	$db->select($setting['db']['pre_sub']."news_tag", "*", $condition, array("order"=>"{$order} {$order_type}", "limit"=>"$page_start, $page_size"));
	while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$record['link'] = getUrl("tag", urlencode($record['tag']), 1, $web_id);
			$record['add_date'] = date("Y-m-d", $record['add_date']);
			$record['update_date'] = date("Y-m-d", $record['update_date']);
			$tpl_tmp->Set_Loop('record', $record);
	}

	$tpl_tmp->Set_Variable('order_type_org', $order_type);
	if($order_type=="desc") {
		$order_type = "asc";
	} else {
		$order_type = "desc";
	}
	$tpl_tmp->Set_Variable('order', $order);
	$tpl_tmp->Set_Variable('order_type', $order_type);
	$tpl_tmp->Set_Variable('title', $setting['language']['admin_art_tag_title']);
	$tpl_tmp->Set_Variable('web_id', $web_id);
	$max_count = count($GLOBALS['website']);
	for($i=0; $i<$max_count; $i++) {
		$GLOBALS['website'][$i]['selected'] = $GLOBALS['website'][$i]['web_id']==$web_id?"selected":"";
		$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
	}
	$db->Free();
	
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>