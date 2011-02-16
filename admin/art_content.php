<?php
require("inc.php");

includeCache("news_cat");

set_time_limit(600);
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$news_id = $req->getReq("news_id");
$cat_id = $req->getReq("cat_id");
$log_info = "";
if($method=="delete" || $method=="unlock") $cat_id = $db->GetSingleResult("select cat_id from ".$setting['db']['pre']."news_show where `news_id` = '{$news_id}'");

if($group['power_cat']!="all" && !empty($cat_id) && strpos(",".$group['power_cat'].",", ",".$cat_id.",")===false) {
	echo '<div style="text-align:center; font-size:36px; color:#f00; margin-top:100px;">您无权管理该栏目的文章！</div>';
	$mystep->pageEnd(false);
}

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = "删除文章";
		$db->Query("select * from ".$setting['db']['pre']."attachment where news_id = '{$news_id}'");
		while($record = $db->GetRS()){
			unlink($root_path.$path_upload.date("Y/m/d", substr($record['file_time'],0, 10))."/".$record['file_time'].strrchr($record['file_name'],"."));
			unlink($root_path.$path_upload.date("Y/m/d", substr($record['file_time'],0, 10))."/preview/".$record['file_time'].strrchr($record['file_name'],"."));
		}
		$db->Free();
		$sql_list = array();
		$db->Query("delete from ".$setting['db']['pre']."news_show where news_id = '{$news_id}'");
		$db->Query("delete from ".$setting['db']['pre']."news_detail where news_id = '{$news_id}'");
		$db->Query("select * from ".$setting['db']['pre']."attachment where news_id={$news_id}");
		while($record = $db->GetRS()) {
			$the_path = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d/", substr($record['file_time'],0, 10));
			$the_ext = GetFileExt($record['file_name']);
			if($the_ext=="php") $the_ext = "txt";
			$the_file = $record['file_time'].".".$the_ext;
			MultiDel($the_path.$the_file);
			MultiDel($the_path."preview/".$the_file);
			$sql_list[] = "delete from ".$setting['db']['pre']."attachment where id=".$record['id'];
		}
		$db->Free();
		$db->BatchExec($sql_list);
		delCacheFile($news_id);
		break;
	case "unlock":
		$log_info = "文章解锁";
		$db->Query("update ".$setting['db']['pre']."news_show set add_date=now() where news_id = '{$news_id}'");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $self;
		} else {
			$_POST['style'] = implode(",", $_POST['style']);
			if(get_magic_quotes_gpc()) strip_slash($_POST);
			$_POST['content'] = str_replace("<!-- pagebreak -->", "</p><!-- pagebreak --><p>", $_POST['content']);
			$_POST['content'] = preg_replace("/<p>[\r\n\s]*<\/p>/i", "", $_POST['content']);
			$content = explode("<!-- pagebreak -->", str_replace('="../', '="'.$setting['web']['url'].'/', $_POST['content']));
			unset($_POST['content']);
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
			$_POST['tag'] = str_replace("，", ",", $_POST['tag']);
			$_POST['tag'] = str_replace(" ", "_", $_POST['tag']);
			if($_POST['setop_mode']==0) {
				$_POST['setop'] = 0;
			} else {
				if(!isset($_POST['setop'])) {
					$_POST['setop'] = 0;
				} else {
					$_POST['setop'] = array_sum($_POST['setop']);
					if(is_null($_POST['setop'])) $_POST['setop'] = 0;
				}
				$_POST['setop'] += $_POST['setop_mode'];
			}
			unset($_POST['setop_mode']);
			$get_remote_file = $_POST['get_remote_file'];
			unset($_POST['get_remote_file']);
			$db->ReConnect(true);
			
			if($method=="add_ok") {
				$log_info = "添加文章";
				$_POST['add_user'] = $req->getSession("username");
				$_POST['add_date'] = "now()";
				
				$tag = explode(",", $_POST['tag']);
				$max_count = count($tag);
				for($n=0; $n<$max_count; $n++) {
					$tag[$n] = trim($tag[$n], "_");
					if(strlen(trim($tag[$n]))<2) continue;
					$tag[$n] = substrPro($tag[$n], 0, 15);
					$tag[$n] = mysql_real_escape_string($tag[$n]);
					if($db->GetSingleResult("select id from ".$setting['db']['pre']."news_tag where `tag` = '{$tag[$n]}'")) {
						$db->Query("update ".$setting['db']['pre']."news_tag set `count` = `count` + 1, update_date = UNIX_TIMESTAMP() where `tag` = '{$tag[$n]}'");
					} else {
						$db->Query("insert into ".$setting['db']['pre']."news_tag values(0, '{$tag[$n]}', 1, 0, UNIX_TIMESTAMP(), UNIX_TIMESTAMP())");
					}
				}
				
				$str_sql = $db->buildSQL($setting['db']['pre']."news_show", $_POST, "insert");
			} else {
				$log_info = "编辑文章";
				unset($_POST['news_id']);
				$db->Query("delete from ".$setting['db']['pre']."news_detail where news_id = '{$news_id}'");
				$str_sql = $db->buildSQL($setting['db']['pre']."news_show", $_POST, "update", "news_id={$news_id}");
				delCacheFile($news_id);
			}
			$db->Query($str_sql);
	
			if($method=="add_ok") $news_id = $db->GetInsertId();
			$cur_rec = array();
			$max_count = count($sub_title);
			for($i=0; $i<$max_count; $i++) {
				$cur_rec['id'] = 0;
				$cur_rec['cat_id'] = $_POST['cat_id'];
				$cur_rec['news_id'] = $news_id;
				$cur_rec['page'] = $i+1;
				$cur_rec['sub_title'] = $sub_title[$i];
				$cur_rec['content'] = $content[$i];
				$db->Query($db->buildSQL($setting['db']['pre']."news_detail", $cur_rec, "insert"));
			}
			
			$attach_list = split("\|", $attach_list);
			$att_chg = "";
			$max_count = count($attach_list);
			for($i=0; $i<$max_count; $i++) {
				if(!empty($attach_list[$i])) $att_chg .= "id={$attach_list[$i]} or ";
			}
			if(!empty($att_chg)) {
				$db->Query("update ".$setting['db']['pre']."attachment set news_id='{$news_id}' where ({$att_chg} 1=0)");
			}
			$db->Query("update ".$setting['db']['pre']."attachment set tag='".mysql_real_escape_string($_POST['tag'])."' where news_id='{$news_id}'");
			$db->Query("update ".$setting['db']['pre']."news_show set pages='".count($sub_title)."' where news_id='{$news_id}'");
	
			if($get_remote_file) GetPictures_news($news_id, $content);
		}
		break;
	default:
		$goto_url = $self;
}

if(!empty($log_info)) {
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"]."&news_id={$news_id}", $log_info);
	$goto_url = $self;
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $tpl, $tpl_info, $setting, $news_cat, $news_id, $cat_id, $group;
	$top_mode_list = array(
			"0"	=>	"不置顶",
			"128"	=>	"文字置顶",
			"64"	=>	"幻灯图片",
			);
	$top_list = array(
			"1"	=>	"首页",
			"2"	=>	"列表页",
			"4"	=>	"内容页",
			);
	
	$tpl_info['idx'] = "art_content_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	$web_id = 0;
	if($cat_info = getParaInfo("news_cat", "cat_id", $cat_id)) $web_id = $cat_info['web_id'];
	$check_i = "";
	$check_b = "";
	$check_c = "";
	
	if($method == "list") {
		$page = $req->getGet("page");
		$keyword = $req->getGet("keyword");
		$order = $req->getGet("order");
		$tpl_tmp->Set_Variable('order', $order);
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$condition = "1=1";
		$condition .= empty($cat_id)?"":" and a.cat_id ='{$cat_id}'";
		$condition .= empty($keyword)?"":" and (a.subject like '%$keyword%' or a.tag like '%$keyword%')";
		$condition .= $group['power_cat']=="all"?"":" and a.cat_id in (".$group['power_cat'].")";

		//navigation
		$counter = $db->GetSingleResult("select count(*) as counter from ".$setting['db']['pre']."news_show a where {$condition}");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&cat_id={$cat_id}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);
		
		//main list
		$str_sql = "select a.*, b.cat_idx, b.cat_name from ".$setting['db']['pre']."news_show a left join ".$setting['db']['pre']."news_cat b on a.cat_id=b.cat_id where {$condition}";
		$str_sql.= " order by ".(empty($order)?" ":"a.{$order} {$order_type}, ")."a.news_id {$order_type}";
		$str_sql.= " limit {$page_start}, {$page_size}";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			if(empty($record['link'])) $record['link'] = getFileURL($record['news_id'], $record['cat_idx'], $record['add_date']);
			$tpl_tmp->Set_Loop('record', $record);
		}
		$title = empty($cat_id)?"总列表":$db->GetSingleResult("select cat_name from ".$setting['db']['pre']."news_cat where cat_id='{$cat_id}'");
		$tpl_tmp->Set_Variable('title', "文章列表 - ".$title);
		$tpl_tmp->Set_Variable('keyword', $keyword);
		$tpl_tmp->Set_Variable('cat_id', $cat_id);
		$tpl_tmp->Set_Variable('order_type_org', $order_type);	
		$order_type = $order_type=="asc"?"desc":"asc";
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('keyword', $keyword);
	} elseif($method == "edit") {
		$record = $db->GetSingleRecord("select * from ".$setting['db']['pre']."news_show where news_id='{$news_id}'");
		if(!$record) {
			$tpl->Set_Variable('main', showInfo("指定的记录不存在！", 0));
			$mystep->pageEnd(false);
		}
		HtmlTrans(&$record);
		$tpl_tmp->Set_Variables($record, "record");
		$cat_id = $record['cat_id'];
		$setop = $record['setop'];
		foreach($top_mode_list as $key=>$value) {
			$key = (INT)$key;
			$tpl_tmp->Set_Loop('setop_mode', array("key"=>$key, "value"=>$value, "checked"=>(($key+$setop==0 || $key&$setop)?"checked":"")));
		}
		foreach($top_list as $key=>$value) {
			$key = (INT)$key;
			$tpl_tmp->Set_Loop('setop', array("key"=>$key, "value"=>$value, "checked"=>($key&$setop?"checked":"")));
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
		$db->Query("select * from ".$setting['db']['pre']."news_detail where news_id = {$news_id} order by page");
		$content = array();
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$record['content'] = "<p><span class=\"mceSubtitle\">".$record['sub_title']."</span></p>\n".$record['content'];
			$content[] = $record['content'];
		}
		
		$tpl_tmp->Set_Variable('record_content', implode("\n<!-- pagebreak -->\n", $content));
		$tpl_tmp->Set_Variable('title', '文章更新');
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
		$tpl_tmp->Set_Variables($record, "record");
		$tpl_tmp->Set_Variable('title', '文章添加');
	}

	//catalog select
	$max_count = count($news_cat);
	for($i=0; $i<$max_count; $i++) {
		if(!empty($news_cat[$i]['cat_link'])) continue;
		$news_cat[$i]['cat_name'] = ((isset($news_cat[$i+1]) && $news_cat[$i+1]['cat_layer']==$news_cat[$i]['cat_layer'])?"├ ":"└ ").$news_cat[$i]['cat_name'];
		for($j=1; $j<$news_cat[$i]['cat_layer']; $j++) {
			$news_cat[$i]['cat_name'] = "&nbsp;".$news_cat[$i]['cat_name'];
		}
		$news_cat[$i] = preg_replace("/^├ /", "", preg_replace("/^└ /", "", $news_cat[$i]));
		$tpl_tmp->Set_Loop('catalog', array('cat_id'=>$news_cat[$i]['cat_id'], 'cat_name'=>$news_cat[$i]['cat_name'], 'selected'=>($cat_id==$news_cat[$i]['cat_id']?"selected":"")));
		$tpl_tmp->Set_Loop('cat_sub', array('cat_id'=>$news_cat[$i]['cat_id'], 'cat_sub'=>$news_cat[$i]['cat_sub']));
	}

	$tpl_tmp->Set_Variable('check_b', $check_b);
	$tpl_tmp->Set_Variable('check_i', $check_i);
	$tpl_tmp->Set_Variable('check_c', $check_c);
	$tpl_tmp->Set_Variable('news_max_length', $setting['content']['max_length']);
	$tpl_tmp->Set_Variable('get_remote_file', $setting['content']['get_remote_img']?"checked":"");
	$tpl_tmp->Set_Variable('method', $method);
	$tpl_tmp->Set_Variable('cat_id', $cat_id);
	$tpl_tmp->Set_Variable('news_id', $news_id);
	$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	$db->Free();
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>