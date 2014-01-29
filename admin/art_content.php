<?php
require("inc.php");

set_time_limit(1200);
ignore_user_abort("on");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$news_id = $req->getReq("news_id");
$cat_id = $req->getReq("cat_id");
$log_info = "";

includeCache("news_cat");
$setting_sub = getSubSetting($web_id);
if($setting['db']['name']==$setting_sub['db']['name']) {
	$setting['db']['pre_sub'] = $setting_sub['db']['pre'];
} else {
	$setting['db']['pre_sub'] = $setting_sub['db']['name'].".".$setting_sub['db']['pre'];
}

if(!empty($news_id)) {
	$web_id_news = $db->result($setting['db']['pre_sub']."news_show","web_id",array("news_id","n=",$news_id));
	if($web_id_news===false || (!$op_mode && $web_id!=$web_id_news)) {
		echo showInfo($setting['language']['admin_art_content_error']);
		$mystep->pageEnd(false);
	}
}

if($method=="edit_ok" || $method=="delete") {
	$record = $db->record($setting['db']['pre_sub']."news_show", "cat_id, add_date", array("news_id","n=",$news_id));
	$cat_id = $record['cat_id'];
	$add_date = $record['add_date'];
	unset($record);
	if($group['power_func']!="all" && ($setting['info']['time_start']/1000-strtotime($add_date))/(60*60*24)>60) {
		$tpl->Set_Variable('main', showInfo($setting['language']['admin_art_content_locked'], 0));
		$mystep->show($tpl);
		$mystep->pageEnd(false);
	}
}

if($group['power_cat']!="all" && !empty($cat_id) && strpos(",".$group['power_cat'].",", ",".$cat_id.",")===false) {
	$tpl->Set_Variable('main', showInfo($setting['language']['admin_art_content_nopower'], 0));
	$mystep->show($tpl);
	$mystep->pageEnd(false);
}

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		if(!$op_mode && $web_id!=$_GET['web_id']) {
			$goto_url = $setting['info']['self'];
		} else {
			$log_info = $setting['language']['admin_art_content_delete'];
			$sql_list = array();
			$db->delete($setting['db']['pre_sub']."news_show", array("news_id","n=",$news_id));
			$db->delete($setting['db']['pre_sub']."news_detail", array("news_id","n=",$news_id));
			$db->select($setting['db']['pre_sub']."attachment", "*",array(array("web_id","n=",$web_id), array("news_id","n=",$news_id)));
			while($record = $db->GetRS()) {
				$the_path = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d/", substr($record['file_time'],0, 10));
				$the_ext = GetFileExt($record['file_name']);
				if($the_ext=="php") $the_ext = "txt";
				$the_file = $record['file_time'].".".$the_ext;
				MultiDel($the_path.$the_file);
				MultiDel($the_path."cache/".$the_file);
				MultiDel($the_path."preview/".$the_file);
				MultiDel($the_path."preview/cache/".$the_file);
				$sql_list[] = $db->delete($setting['db']['pre']."attachment", array("id", "n=", $record['id']), false);
			}
			$db->Free();
			$db->BatchExec($sql_list);
			delCacheFile($news_id, $setting_sub["info"]['web_id']);
		}
		break;
	case "unlock":
		if(!$op_mode) {
			$goto_url = $req->getServer("HTTP_REFERER");
		} else {
			$log_info = $setting['language']['admin_art_content_unlock'];
			$db->update($setting['db']['pre_sub']."news_show", array("add_date","now()"), array("news_id","n=",$news_id));
		}
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} elseif(!$op_mode && $web_id!=$_POST['web_id']) {
			$goto_url = $setting['info']['self'];
		} else {
			if(empty($_POST['expire'])) unset($_POST['expire']);
			$multi_cata = $_POST['multi_cata'];
			$_POST['style'] = implode(",", $_POST['style']);
			$_POST['content'] = preg_replace("/ mso(\-\w+)+\:[^;]+?;/", "", $_POST['content']);
			$_POST['content'] = preg_replace("/[\/]+files/", "/files", $_POST['content']);
			//$_POST['content'] = preg_replace("/<\/(\w+)><\\1([^>]*)>/", "", $_POST['content']);
			while(preg_match("/<(\w+)[^>]*><\!\-\- pagebreak \-\-\><\/\\1>[\r\n\s]*/m", $_POST['content'])) $_POST['content'] = preg_replace("/<(\w+)[^>]*><\!\-\- pagebreak \-\-\><\/\\1>[\r\n\s]*/m", "<!-- pagebreak -->", $_POST['content']);
			while(preg_match("/<(\w+)[^>]*>[\s\r\n]*<\/\\1>[\r\n\s]*/m", $_POST['content'])) $_POST['content'] = preg_replace("/<(\w+)[^>]*>[\s\r\n]*<\/\\1>[\r\n\s]*/m", "", $_POST['content']);
			$_POST['content'] = str_replace('="../', '="'.$setting['web']['url'].'/', $_POST['content']);
			$content = explode("<!-- pagebreak -->", $_POST['content']);
			unset($_POST['content'], $_POST['multi_cata']);
			$sub_title = array();
			$max_count = count($content);
			for($i=0; $i<$max_count; $i++) {
				if(preg_match("/<span.+?mceSubtitle.+?>(.+)<\/span>/i", $content[$i], $matches)) {
					$sub_title[$i] = $matches[1];
					$sub_title[$i] = strip_tags($sub_title[$i]);
					$sub_title[$i] = substrPro($sub_title[$i], 0, 98);
					$content[$i] = preg_replace("/[\r\n]*(<(\w+)>)?<span.+?mceSubtitle.+?>.+<\/span>(<\/\\2>)?[\r\n]*/i", "", $content[$i]);
					$sub_title[$i] = str_replace("&nbsp;", " ", $sub_title[$i]);
					if(strlen(preg_replace("/[\s\r\n\t]/", "", $sub_title[$i]))<4) {
						$sub_title[$i] = $_POST['subject']." - ".($i+1);
					}
				} else {
					$sub_title[$i] = $_POST['subject']." - ".($i+1);
				}
			}
			$attach_list = $_POST['attach_list'];
			unset($_POST['attach_list']);
			$_POST['tag'] = str_replace("¡¢", ",", $_POST['tag']);
			$_POST['tag'] = str_replace("£¬", ",", $_POST['tag']);
			$_POST['tag'] = str_replace(" ", "_", $_POST['tag']);
			if($_POST['setop_mode']==0) {
				$_POST['setop'] = 0;
			} else {
				$_POST['setop'] = array_sum($_POST['setop']);
				if(is_null($_POST['setop'])) {
					$_POST['setop'] = 0;
				} else {
					$_POST['setop'] += ($_POST['setop_mode'] * 1024);
				}
			}
			unset($_POST['setop_mode']);
			$get_remote_file = $_POST['get_remote_file'];
			unset($_POST['get_remote_file']);
			$db->ReConnect(true, $setting['db']['name']);
			
			if($method=="add_ok") {
				$log_info = $setting['language']['admin_art_content_add'];
				$_POST['add_user'] = $req->getSession("username");
				$_POST['add_date'] = "now()";
				
				$tag = explode(",", $_POST['tag']);
				$max_count = count($tag);
				for($n=0; $n<$max_count; $n++) {
					$tag[$n] = trim($tag[$n], "_");
					if(strlen(trim($tag[$n]))<2) continue;
					$tag[$n] = substrPro($tag[$n], 0, 15);
					$tag[$n] = mysql_real_escape_string($tag[$n]);
					if($db->result($setting['db']['pre_sub']."news_tag", "id", array("tag", "=", $tag[$n]))) {
						$db->update($setting['db']['pre_sub']."news_tag", array("count"=>"+1", "update_date"=>"UNIX_TIMESTAMP()"), array("tag", "=", $tag[$n]));
					} else {
						$db->insert($setting['db']['pre_sub']."news_tag", array(0, $tag[$n], 1, 0, "UNIX_TIMESTAMP()", "UNIX_TIMESTAMP()"));
					}
				}
				$db->insert($setting['db']['pre_sub']."news_show", $_POST);
				$news_id = $db->GetInsertId();
			} else {
				$log_info = $setting['language']['admin_art_content_edit'];
				unset($_POST['news_id']);
				$db->delete($setting['db']['pre_sub']."news_detail", array("news_id", "n=", $news_id));
				$db->update($setting['db']['pre_sub']."news_show", $_POST, array("news_id", "n=", $news_id));
				delCacheFile($news_id, $setting_sub["info"]['web_id']);
			}

			$cur_rec = array();
			$max_count = count($sub_title);
			for($i=0; $i<$max_count; $i++) {
				$cur_rec['id'] = 0;
				$cur_rec['cat_id'] = $_POST['cat_id'];
				$cur_rec['news_id'] = $news_id;
				$cur_rec['page'] = $i+1;
				$cur_rec['sub_title'] = $sub_title[$i];
				$cur_rec['content'] = $content[$i];
				$db->insert($setting['db']['pre_sub']."news_detail", $cur_rec);
			}
			
			$attach_list = explode("|", $attach_list);
			$condition = array();
			for($i=0,$m=count($attach_list); $i<$m; $i++) {
				if(!empty($attach_list[$i])) {
					$condition[] = array("id", "n=", $attach_list[$i], "or");
				}
			}
			if(!empty($condition)) {
				$db->update($setting['db']['pre']."attachment", array("news_id"=>$news_id, "web_id"=>$web_id), $condition);
			}
			$db->update($setting['db']['pre']."attachment", array("tag"=>$_POST['tag']), array("news_id", "n=", $news_id));
			$db->update($setting['db']['pre_sub']."news_show", array("pages"=>count($sub_title)), array("news_id", "n=", $news_id));
			
			if($get_remote_file) GetPictures_news($news_id, $web_id, $content);
			
			$cid_list = explode(',', $multi_cata);
			$theCat = $_POST['cat_id'];
			$sql_list = array();
			$_POST['add_user'] = $req->getSession("username");
			$_POST['setop'] = 0;
			for($i=0,$m=count($cid_list);$i<$m;$i++) {
				if(is_numeric($cid_list[$i]) && $theCat!=$cid_list[$i]) {
					$_POST['cat_id'] = $cid_list[$i];
					$_POST['link'] = getUrl("read", array($news_id, $_POST['cat_id']), 1, $_POST['web_id']);
					$_POST['add_date'] = "now()";
					$sql_list[] = $db->insert($setting['db']['pre_sub']."news_show", $_POST, "", false);
				}
			}
			$db->BatchExec($sql_list);
		}
		break;
	default:
		$goto_url = $setting['info']['self'];
}

if(!empty($log_info)) {
	write_log($log_info, "news_id={$news_id}");
	$goto_url = ($method=="unlock" ||$method=="delete") ? $req->getServer("HTTP_REFERER") : ($setting['info']['self']."?web_id=".$web_id."&cat_id=".$cat_id);
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $tpl, $tpl_info, $setting, $news_cat, $news_id, $cat_id, $group, $web_id, $setting_sub;
	$top_mode_list = array(
			"0"	=>	$setting['language']['admin_art_content_top_mode_1'],
			"1"	=>	$setting['language']['admin_art_content_top_mode_2'],
			"2"	=>	$setting['language']['admin_art_content_top_mode_3'],
			);
	$top_list = array(
			"1"	=>	$setting['language']['admin_art_content_top_1'],
			"2"	=>	$setting['language']['admin_art_content_top_2'],
			"4"	=>	$setting['language']['admin_art_content_top_3'],
			);
	
	$tpl_info['idx'] = "art_content_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($cat_info = getParaInfo("news_cat", "cat_id", $cat_id)) $web_id = $cat_info['web_id'];
	$check_i = "";
	$check_b = "";
	$check_c = "";
	
	if(empty($group['power_cat'])) $group['power_cat'] = 0;
	if($method == "list") {
		$page = $req->getGet("page");
		$keyword = $req->getGet("keyword");
		$order = $req->getGet("order");
		$tpl_tmp->Set_Variable('order', $order);
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$condition = array();
		if(!empty($web_id)) $condition[] = array("web_id", "n=", $web_id, "and");
		if(!empty($cat_id)) $condition[] = array("cat_id", "n=", $cat_id, "and");
		if(!empty($keyword)) $condition[] = array(array(array("subject", "like", $keyword), array("tag", "like", $keyword)), "and");
		if($group['power_cat']!="all") $condition[] = array("cat_id", "nin", $group['power_cat'], "and");

		//navigation
		$counter = $db->result($setting['db']['pre_sub']."news_show", "count(*)", $condition);
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&cat_id={$cat_id}&web_id={$web_id}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);
		
		//main list
		$the_order = array();
		if(!empty($cat_id) && $order!="setop") $the_order[] = "order desc";
		if($order=="setop") $order_type = "desc";
		if(!empty($order)) $the_order[] = "{$order} {$order_type}";
		$the_order[] = "news_id {$order_type}";
		$sql = $db->buildSel_join(array(
				array(
					"name" => $setting['db']['pre_sub']."news_show",
					"idx" => "a",
					"col" => "*",
					"condition" => $condition,
					"order" => $the_order
				),
				array(
					"name" => $setting['db']['pre']."news_cat",
					"idx" => "b",
					"col" => "cat_idx, cat_name",
					"join" => "cat_id",
				)
			), "", array("limit"=>"{$page_start}, {$page_size}"));
		$db->Query($sql);
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			if(empty($record['link'])) {
				$record['link'] = getUrl("read", array($record['news_id'], $record['cat_id']), 1, $record['web_id']);
			}
			$tpl_tmp->Set_Loop('record', $record);
		}
		$title = empty($cat_id) ? $setting['language']['admin_art_content_list_all'] : $db->result($setting['db']['pre']."news_cat", "cat_name", array("cat_id","n=",$cat_id));
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_art_content_list_article']." - ".$setting_sub['web']['title']." - ".$title);
		$tpl_tmp->Set_Variable('keyword', $keyword);
		$tpl_tmp->Set_Variable('cat_id', $cat_id);
		$tpl_tmp->Set_Variable('order_type_org', $order_type);	
		$order_type = $order_type=="asc"?"desc":"asc";
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('keyword', $keyword);
	} elseif($method == "edit") {
		$record = $db->record($setting['db']['pre_sub']."news_show", "*", array("news_id","n=",$news_id));
		if(!$record) {
			$tpl->Set_Variable('main', showInfo($setting['language']['admin_art_content_error'], 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		HtmlTrans(&$record);
		$tpl_tmp->Set_Variables($record, "record");
		$cat_id = $record['cat_id'];
		$setop = (INT)$record['setop'];
		foreach($top_list as $key=>$value) {
			$key = (INT)$key;
			$tpl_tmp->Set_Loop('setop', array("key"=>$key, "value"=>$value, "checked"=>(($setop&$key)==$key)?"checked":""));
			if(($setop&$key)==$key) $setop -= $key;
		}
		$setop /= 1024;
		foreach($top_mode_list as $key=>$value) {
			$key = (INT)$key;
			$tpl_tmp->Set_Loop('setop_mode', array("key"=>$key, "value"=>$value, "checked"=>($setop==$key)?"checked":""));
		}
		$theStyle = explode(",", $record['style']);
		$max_count = count($theStyle);
		for($i=0;$i<$max_count;$i++) {
			if($theStyle[$i]=="i") {
				$check_i = "checked";
			} elseif(($theStyle[$i]=="b")) {
				$check_b = "checked";
			} else {
				$check_c = $theStyle[$i];
			}
		}
		$content = array();
		$db->select($setting['db']['pre_sub']."news_detail", "*", array("news_id","n=",$news_id), array("order"=>"page"));
		while($record = $db->GetRS()) {
			$record['content'] = str_replace("&", "&#38;", $record['content']);
			HtmlTrans(&$record);
			$record['content'] = "<span class=\"mceSubtitle\">".$record['sub_title']."</span>\n".$record['content'];
			$content[] = $record['content'];
		}
		
		$Max_size = round(GetFileSize(ini_get('upload_max_filesize'))/1024/1024,2);
		$tpl_tmp->Set_Variable('MaxSize', $Max_size);
		$tpl_tmp->Set_Variable('record_content', implode("\n<p><img src=\"../script/tinymce/plugins/pagebreak/img/trans.gif\" class=\"mcePageBreak mceItemNoResize\" /></p>\n", $content));
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_art_content_edit']);
	} else {
		$checked = "checked";
		foreach($top_mode_list as $key=>$value) {
			$key = (INT)$key;
			$tpl_tmp->Set_Loop('setop_mode', array("key"=>$key, "value"=>$value, "checked"=>$checked));
			$checked = "";
		}
		foreach($top_list as $key=>$value) {
			$key = (INT)$key;
			$tpl_tmp->Set_Loop('setop', array("key"=>$key, "value"=>$value, "checked"=>""));
		}
		$record = array();
		$record['news_id'] = 0;
		$record['cat_id'] = $cat_id;
		$record['web_id'] = $web_id;
		$record['subject'] = "";
		$record['style'] = "";
		$record['describe'] = "";
		$record['original'] = "";
		$record['link'] = "";
		$record['tag'] = "";
		$record['image'] = "";
		$record['content'] = "";
		$record['pages'] = 1;
		$record['order'] = 0;
		if(!empty($cat_id) && $cat_info = getParaInfo("news_cat", "cat_id", $cat_id)) {
			$record['view_lvl'] = $cat_info['view_lvl'];
			$record['notice'] = $cat_info['notice'];
		} else {
			$record['view_lvl'] = 0;
			$record['notice'] = "";
		}
		$Max_size = round(GetFileSize(ini_get('upload_max_filesize'))/1024/1024,2);
		$tpl_tmp->Set_Variable('MaxSize', $Max_size);
		$tpl_tmp->Set_Variables($record, "record");
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_art_content_add']);
	}
	
	//news image
	$condition = array();
	if(!empty($web_id)) $condition = array("web_id","n=",$web_id);
	$db->select($setting['db']['pre']."news_image", "*", $condition, array("order"=>"id asc"));
	while($record = $db->GetRS()) {
		HtmlTrans(&$record);
		$tpl_tmp->Set_Loop('news_image', $record);
	}

	//catalog select
	if(empty($web_id)) $web_id=1;
	$max_count = count($news_cat);
	for($i=0; $i<$max_count; $i++) {
		if(($method != "add" || $setting['info']['web']['web_id']!=1) && $news_cat[$i]['web_id']!=$web_id) continue;
		//if(!empty($news_cat[$i]['cat_link'])) continue;
		$news_cat[$i]['cat_name'] = ((isset($news_cat[$i+1]) && $news_cat[$i+1]['cat_layer']==$news_cat[$i]['cat_layer'])?"©À ":"©¸ ").$news_cat[$i]['cat_name'];
		for($j=1; $j<$news_cat[$i]['cat_layer']; $j++) {
			$news_cat[$i]['cat_name'] = "&nbsp;".$news_cat[$i]['cat_name'];
		}
		$news_cat[$i] = preg_replace("/^©À /", "", preg_replace("/^©¸ /", "", $news_cat[$i]));
		$tpl_tmp->Set_Loop('catalog', array('cat_id'=>$news_cat[$i]['cat_id'], 'web_id'=>$news_cat[$i]['web_id'], 'cat_name'=>$news_cat[$i]['cat_name'], 'view_lvl'=>$news_cat[$i]['view_lvl'], 'selected'=>($cat_id==$news_cat[$i]['cat_id']?"selected":"")));
		$tpl_tmp->Set_Loop('cat_sub', array('cat_id'=>$news_cat[$i]['cat_id'], 'cat_sub'=>$news_cat[$i]['cat_sub']));
	}
	
	$tpl_tmp->Set_Variable('check_b', $check_b);
	$tpl_tmp->Set_Variable('check_i', $check_i);
	$tpl_tmp->Set_Variable('check_c', $check_c);
	$tpl_tmp->Set_Variable('get_remote_file', $setting['content']['get_remote_img']?"checked":"");
	$tpl_tmp->Set_Variable('method', $method);
	$tpl_tmp->Set_Variable('web_id', $web_id);
	$tpl_tmp->Set_Variable('cat_id', $cat_id);
	$tpl_tmp->Set_Variable('news_id', $news_id);
	$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	
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