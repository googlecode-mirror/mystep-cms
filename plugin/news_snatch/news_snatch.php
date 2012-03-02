<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "rule";

$id = $req->getReq("id");
$log_info = "";
$info_snatch = "cache/snatch.html";
$info_import = "cache/import.html";

require("rule/list.php");
switch($method) {
	case "rule":
	case "rule_add":
	case "rule_edit":
	case "news":
	case "news_edit":
	case "snatch":
	case "import":
		build_page($method);
		break;
	case "rule_add_ok":
		$log_info = $setting['language']['plugin_news_snatch_rule_add'];
		$new_rule = array();
		$new_rule['name'] = $_POST["name"];
		$new_rule['url'] = $_POST["url"];
		$new_rule['notes'] = $_POST["notes"];
		$new_rule['date'] = date("Y-m-d H:i:s");
		$new_rule['idx'] = md5($new_rule['name'].$new_rule['date']);
		$new_rule['para'] = $_POST["para"];
		if(!empty($new_rule['para'])) eval("\$new_rule['para'] = ".$new_rule['para'].";");
		WriteFile("rule/".$new_rule['idx']."_snatch.php", $_POST["rule_snatch"], "wb");
		WriteFile("rule/".$new_rule['idx']."_import.php", $_POST["rule_import"], "wb");
		$rules[] = $new_rule;
		WriteFile("rule/list.php", '<?php
$rules = '.var_export($rules, true).';		
?>', "wb");
		break;
	case "rule_edit_ok":
		$log_info = $setting['language']['plugin_news_snatch_rule_edit'];
		$rules[$id]['name'] = $_POST["name"];
		$rules[$id]['url'] = $_POST["url"];
		$rules[$id]['notes'] = $_POST["notes"];
		$rules[$id]['date'] = date("Y-m-d H:i:s");
		$rules[$id]['para'] = $_POST["para"];
		if(!empty($rules[$id]['para'])) eval("\$rules[\$id]['para'] = ".$rules[$id]['para'].";");
		WriteFile("rule/".$rules[$id]['idx']."_snatch.php", $_POST["rule_snatch"], "wb");
		WriteFile("rule/".$rules[$id]['idx']."_import.php", $_POST["rule_import"], "wb");
		WriteFile("rule/list.php", '<?php
$rules = '.var_export($rules, true).';		
?>', "wb");
		$goto_url = $setting['info']['self']."?method=rule";
		break;
	case "rule_delete":
		$log_info = $setting['language']['plugin_news_snatch_rule_delete'];
		unlink("rule/".$rules[$id]['idx']."_snatch.php");
		unlink("rule/".$rules[$id]['idx']."_import.php");
		unset($rules[$id]);
		WriteFile("rule/list.php", '<?php
$rules = '.var_export($rules, true).';		
?>', "wb");
		$goto_url = $setting['info']['self']."?method=rule";
		break;
	case "news_delete":
		$log_info = $setting['language']['plugin_news_snatch_news_delete'];
		$db->Query("delete from ".$setting['db']['pre']."news_snatch where id = '{$id}'");
		$goto_url = $setting['info']['self']."?method=news";
		break;
	case "news_edit_ok":
		$log_info = $setting['language']['plugin_news_snatch_news_edit'];
		unset($_POST['id']);
		$db->Query($db->buildSQL($setting['db']['pre']."news_snatch", $_POST, "update", "id={$id}"));
		$goto_url = $setting['info']['self']."?method=news";
		break;
	case "news_truncate":
		$log_info = $setting['language']['plugin_news_snatch_news_snatch'];
		$db->Query("truncate table ".$setting['db']['pre']."news_snatch");
		$goto_url = $setting['info']['self']."?method=news";
		break;
	case "news_snatch":
		ignore_user_abort("on");
		set_time_limit(0);
		//$log_info = $setting['language']['plugin_news_snatch_snatch'];
		$idx = $rules[$id]['idx'];
		require("rule/".$idx."_snatch.php");
		if($info = snatchGetInfo($rules[$id]['url'], $rules[$id]['para'])) {
			$record = array();
			$record['id'] = 0;
			$record['idx'] = $idx;
			$record['url'] = "";
			$record['original'] = "";
			$record['subject'] = "";
			$record['item_1'] = "";
			$record['item_2'] = "";
			$record['item_3'] = "";
			$record['item_4'] = "";
			$record['item_5'] = "";
			$record['item_6'] = "";
			$record['item_7'] = "";
			$record['item_8'] = "";
			$record['item_9'] = "";
			$record['add_date'] = date("Y-m-d H:i:s");
			$record['content'] = "";
			$info['cache_path'] = "cache/".date("Ymd")."/".$idx."/";
			$info["page"] = 1;
			$info["page_start"] = 1;
			$info["page_max"] = 999;
			$info["url"] = $rules[$id]['url'];
			$info["para"] = $rules[$id]['para'];
			$info["counter"] = 1;
			if(isset($rules[$id]['para']['page_start'])) $info["page_start"] = $rules[$id]['para']['page_start'];
			if(isset($rules[$id]['para']['page_max'])) $info["page_max"] = $rules[$id]['para']['page_max'];
			for($info["page"]=$info["page_start"]; $info["page"]<=$info['page_count']; $info["page"]++) {
				if($info["page"]>$info["page_max"]) break;
				snatch_log('<div class="page" style="font-size:16px;font-weight:bold;">'.sprintf($setting['language']['plugin_news_snatch_info_snatching'], $info["page"]).'</div>');
				if(snatchGetList($record, $info)) {
					snatch_log('<div class="succeed" style="color:green;">'.sprintf($setting['language']['plugin_news_snatch_info_snatch_list'], $info["page"], $info['page_count']).'</div>');
				} else {
					snatch_log('<div class="failed" style="color:red;">'.$setting['language']['plugin_news_snatch_info_snatch_failed'].'</div>');
				}
				snatch_log('<div class="split">-------------------------------</div>');
			}
			snatch_log('<div class="page">'.sprintf($setting['language']['plugin_news_snatch_info_snatch_page'], ($info["page"]-1)).'</div>');
		} else {
			snatch_log('<div class="page">'.$setting['language']['plugin_news_snatch_info_snatch_error'].'</div>');
		}
		snatch_log('<div class="page">'.date("Y-m-d H:i:s").'</div>');
		$goto_url = $setting['info']['self'];
		break;
	case "news_import":
		ignore_user_abort("on");
		set_time_limit(0);
		//$log_info = $setting['language']['plugin_news_snatch_import'];
		$news_show = array();
		$news_show['news_id'] = 0;
		$news_show['cat_id'] = 1;
		$news_show['web_id'] = 1;
		$news_show['subject'] = "";
		$news_show['style'] = "";
		$news_show['views'] = 0;
		$news_show['describe'] = "";
		$news_show['original'] = "";
		$news_show['link'] = "";
		$news_show['tag'] = "";
		$news_show['image'] = "";
		$news_show['setop'] = 0;
		$news_show['order'] = 0;
		$news_show['view_lvl'] = "0";
		$news_show['pages'] = 1;
		$news_show['add_user'] = $setting['info']['user']['name'];
		$news_show['add_date'] = date("Y-m-d H:i:s");
		$news_show['notice'] = "";
		$news_show['ctype'] = 1;
		
		$news_detail = array();
		$news_detail['id'] = 0;
		$news_detail['news_id'] = 0;
		$news_detail['cat_id'] = 0;
		$news_detail['page'] = 1;
		$news_detail['sub_title'] = "";
		$news_detail['content'] = "";
		
		$idx = $req->getReq("idx");
		$para = array();
		for($i=0, $m=count($rules); $i<$m; $i++) {
			if($rules[$i]['idx']==$idx) {
				$para = $rules[$i]['para'];
				break;
			}
		}
		if(isset($para['web_id']) && $web_info = getParaInfo("website", "web_id", $para['web_id'])) {
			include(ROOT_PATH."/include/config_".$web_info['idx'].".php");
		} else {
			include(ROOT_PATH."/include/config_main.php");
		}
		$setting_sub['db']['pre'] = $setting_sub['db']['name'].".".$setting_sub['db']['pre'];
		require("rule/".$idx."_import.php");
		if(!empty($id)) {
			if($record=$db->getSingleRecord("select * from ".$setting['db']['pre']."news_snatch where id=".$id)) {
				importData($record, $para);
				$db->Query("delete from ".$setting['db']['pre']."news_snatch where id='".$id."'");
			}
			$goto_url = $setting['info']['self']."?method=news";
		} else {
			$id_list = array();
			$db->Query("select id from ".$setting['db']['pre']."news_snatch where idx='".$idx."' order by add_date asc, id asc");
			while($record=$db->GetRS()) {
				$id_list[] = $record['id'];
			}
			import_log('<div class="page" style="font-size:16px;font-weight:bold;">'.$setting['language']['plugin_news_import_start'].'</div>');
			for($i=0,$m=count($id_list);$i<$m;$i++) {
				if($record=$db->getSingleRecord("select * from ".$setting['db']['pre']."news_snatch where id=".$id_list[$i])) {
					if($check = $db->getSingleRecord("select news_id from ".$setting_sub['db']['pre']."news_show where subject='".mysql_real_escape_string($record['subject'])."' and add_date='".$record['add_date']."'")) {
						import_log('<div class="item">'.($i+1).' - <a href="'.$record['url'].'" target="_blank">'.$record['subject'].'</a> <span class="failed" style="color:red;">'.$setting['language']['plugin_news_import_failed'].'</span></div>');
					} else {
						importData($record, $para);
						import_log('<div class="item">'.($i+1).' - <a href="'.$record['url'].'" target="_blank">'.$record['subject'].'</a> <span class="succeed" style="color:green;">'.$setting['language']['plugin_news_import_succeed'].'</span></div>');		
					}
					$db->Query("delete from ".$setting['db']['pre']."news_snatch where id='".$record['id']."'");
				}
			}
			import_log('<div class="page">'.sprintf($setting['language']['plugin_news_import_done'], $i).'</div>');
		}
		import_log('<div class="split">-------------------------------</div>');
		import_log('<div class="page">'.date("Y-m-d H:i:s").'</div>');
		$goto_url = $setting['info']['self'];
		break;
	case "rule_import":
		$script = "";
		if(count($_POST) > 0){
			$path_upload = $setting['path']['upload']."/tmp/".date("Ym")."/";
			$upload = new MyUploader;
			$upload->init(ROOT_PATH."/".$path_upload, true);
			$upload->DoIt(false);
			if($upload->upload_result[0]['error'] == 0) {
				$theFile = ROOT_PATH."/".$path_upload."/".$upload->upload_result[0]['new_name'];
				$code = toJson(unserialize(base64_decode(file_get_contents($theFile))), $setting['gen']['charset']);
				$script = "
					var theOLE = null;
					theOLE = parent.parent || parent.dialogArguments || parent.opener;
					theOLE.newRule = {$code};
					theOLE.importRule();
					if(parent.parent==null){parent.close();}else{parent.parent.$.closePopupLayer();}
					
				";
				$script = str_replace("<!-- pagebreak -->", "<pagebreak>", $script);
				unlink($theFile);
			} else {
				$script = "
					alert('".$upload->upload_result[0]['message']."');
					if(parent.parent==null){parent.close();}else{parent.parent.$.closePopupLayer();}
				";
			}
			unset($upload);
		}
		build_page("upload");
		break;
	case "rule_export":
		$log_info = $setting['language']['plugin_news_snatch_export'];
		$cur_rule = $rules[$id];
		$cur_rule['para'] = var_export($cur_rule['para'], true);
		$cur_rule['rule_snatch'] = GetFile("rule/".$cur_rule['idx']."_snatch.php");
		$cur_rule['rule_import'] = GetFile("rule/".$cur_rule['idx']."_import.php");
		$content = chunk_split(base64_encode(serialize($cur_rule)));
		if(ob_get_length()) ob_end_clean();
		header("Content-type: text/plain");
		header("Accept-Ranges: bytes");
		header("Accept-Length: ".strlen($content));
		header("Content-Disposition: attachment; filename=".$cur_rule['name'].".rule");
		echo $content;
		break;
	default:
		$goto_url = $setting['info']['self'];
}

if(!empty($log_info)) {
	write_log($log_info, "id=".$id);
	if(empty($goto_url)) $goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $id, $rules, $info_snatch, $info_import;

	$tpl_info = array(
		"idx" => "main",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	if($method=="rule_add" || $method=="rule_edit") {
		$tpl_info['idx'] = "rule_input";
	} else {
		$tpl_info['idx'] = $method;
	}
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method=="rule") {
		$i=1;
		foreach($rules as $key => $value) {
			$value['no'] = $i++;
			$value['id'] = $key;
			$value['counter'] = $db->getSingleResult("select count(*) from ".$setting['db']['pre']."news_snatch where idx='".$value['idx']."'");
			$tpl_tmp->Set_Loop('record', $value);
		}
	} elseif($method=="rule_add") {
		//no script
	} elseif($method=="rule_edit") {
		$rule = array();
		$rule['id'] = $id;
		$rule['name'] = $rules[$id]['name'];
		$rule['url'] = $rules[$id]['url'];
		$rule['notes'] = $rules[$id]['notes'];
		if(empty($rules[$id]['para'])) {
			$rule['para'] = "";
		} else {
			$rule['para'] = var_export($rules[$id]['para'], true);
		}
		$rule['rule_snatch'] = htmlspecialchars(GetFile("rule/".$rules[$id]['idx']."_snatch.php"));
		$rule['rule_import'] = htmlspecialchars(GetFile("rule/".$rules[$id]['idx']."_import.php"));
		$tpl_tmp->Set_Variables($rule);
	} elseif($method=="news") {
		$page = $req->getGet("page");
		$keyword = $req->getGet("keyword");
		$order = $req->getGet("order");
		$tpl_tmp->Set_Variable('order', $order);
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$condition = "1=1";
		if(!empty($keyword)) $condition .= " and subject like '%".mysql_real_escape_string($keyword)."%'";
		$counter = $db->GetSingleResult("select count(*) as counter from ".$setting['db']['pre']."news_snatch where {$condition}");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?method=news&keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);
		if($counter>0) {
			$str_sql = "select id, idx, url, original, subject from ".$setting['db']['pre']."news_snatch where {$condition}";
			$str_sql.= " order by ".(empty($order)?" ":"{$order} {$order_type}, ")."id {$order_type}";
			$str_sql.= " limit {$page_start}, {$page_size}";
			$db->Query($str_sql);
			while($record = $db->GetRS()) {
				HtmlTrans(&$record);
				$tpl_tmp->Set_Loop('record', $record);
			}
		}
		$tpl_tmp->Set_Variable('keyword', $keyword);
		$tpl_tmp->Set_Variable('order_type_org', $order_type);	
		$order_type = $order_type=="asc"?"desc":"asc";
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('keyword', $keyword);
	} elseif($method=="news_edit") {
		$record = $db->GetSingleRecord("select * from ".$setting['db']['pre']."news_snatch where id='{$id}'");
		if(!$record) {
			$tpl->Set_Variable('main', showInfo($setting['language']['admin_art_content_error'], 0));
			echo $tpl->Read_Cache();
			return;
		}
		HtmlTrans(&$record);
		$tpl_tmp->Set_Variables($record, "record");
	} elseif($method=="snatch") {
		$refresh = 600;
		if(isset($rules[$id]['para']['refresh'])) $refresh = $rules[$id]['para']['refresh'];
		if(false && file_exists($info_snatch) && (time()-filemtime($info_snatch))<$refresh && $req->getReq("f")=="") {
			$show = $setting['language']['plugin_news_snatch_interrupt'];
		} else {
			$show = "";
			if(file_exists($info_snatch)) unlink($info_snatch);
		}
		$tpl_tmp->Set_Variable('id', $id);
		$tpl_tmp->Set_Variable('refresh', $refresh);
		$tpl_tmp->Set_Variable('info_file', $info_snatch);
		$tpl_tmp->Set_Variable('show', addslashes($show));
	} elseif($method=="import") {
		$idx = $req->getReq("idx");
		$para = array();
		for($i=0, $m=count($rules); $i<$m; $i++) {
			if($rules[$i]['idx']==$idx) {
				$para = $rules[$i]['para'];
				break;
			}
		}
		$refresh = 600;
		if(isset($para['refresh'])) $refresh = $para['refresh'];
		if(false && file_exists($info_import) && (time()-filemtime($info_import))<$refresh && $req->getReq("f")=="") {
			$show = $setting['language']['plugin_news_import_interrupt'];
		} else {
			$show = "";
			if(file_exists($info_import)) unlink($info_import);
		}
		$tpl_tmp->Set_Variable('id', $id);
		$tpl_tmp->Set_Variable('idx', $idx);
		$tpl_tmp->Set_Variable('refresh', $refresh);
		$tpl_tmp->Set_Variable('info_file', $info_import);
		$tpl_tmp->Set_Variable('show', addslashes($show));
	} elseif($method=="upload") {
		global $script;
		$tpl_tmp->Set_Variable('script', $script);
		$tpl_tmp->Set_Variable('self', $setting['info']['self']);
		$Max_size = ini_get('upload_max_filesize');
		$tpl_tmp->Set_Variable('Max_size', $Max_size);
		$tpl_tmp->Set_Variable('MaxSize', GetFileSize($Max_size));
	}
	$tpl_tmp->Set_Variable('title', $setting['language']['plugin_news_snatch_title_'.$method]);
	$tpl_tmp->Set_Variable('id', $id);
	$tpl_tmp->Set_Variable('method', $method);
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting'));
	$db->Free();
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}

function snatch_log($log, $charset="gbk") {
	global $info_snatch;
	if($charset!="utf-8") $log = chg_charset($log, $charset, "utf-8");
	writeFile($info_snatch, $log.chr(13), "ab");
	return;
}

function import_log($log, $charset="gbk") {
	global $info_import;
	if($charset!="utf-8") $log = chg_charset($log, $charset, "utf-8");
	writeFile($info_import, $log.chr(13), "ab");
	return;
}
?>