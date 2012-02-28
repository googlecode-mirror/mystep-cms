<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";

$mid = $req->getReq("mid");
$id = $req->getReq("id");
$log_info = "";

if(!empty($mid) && $method=="list") $method = "list_reg";
if(!empty($id) && $method=="edit") $method = "edit_reg";

switch($method) {
	case "add":
	case "edit":
	case "list":
	case "edit_reg":
	case "list_reg":
	case "confirm":
		build_page($method);
		break;
	case "export":
		if(file_exists("setting/".$mid.".php")) {
			$log_info = "注册信息导出";
			include("setting/".$mid.".php");
			$title_list = array();
			$title_list[] = "编号";
			foreach($para as $key => $value) {
				$title_list[] = $value["title"];
			}
			$title_list[] = "确认邮件";
			$title_list[] = "报名日期";

			$xls = $mystep->getInstance("MyXls", $plugin_setting['meeting']['name'], "报名情况");
			$xls->addRow();
			$xls->addCells($title_list);
			$db->Query("select * from ".$setting['db']['pre']."meeting_".$mid." order by id asc");
			while($record = $db->GetRS()) {
				$xls->addRow();
				$xls->addCells($record);
			}
			$xls->makeFile();
		}
		break;
	case "add_reg_ok":
		if(!empty($_GET['name'])) {
			$log_info = "添加注册";
			$db->Query("insert into ".$setting['db']['pre']."meeting_{$mid} (id, name, company, add_date) values(0, '".$_GET['name']."', '".$_GET['name']."', curdate())");
			$goto_url = $setting['info']['self']."?method=edit&mid={$mid}&id=".$db->getInsertID();
		}
		break;
	case "edit_reg_ok":
		$log_info = "编辑注册";
		if(empty($_POST['date_checkin'])) unset($_POST['date_checkin']);
		if(empty($_POST['date_checkout'])) unset($_POST['date_checkout']);
		unset($_POST['mid']);
		foreach($_POST as $key => $value) {
			if(is_array($value)) $_POST[$key] = implode(",", $value);
		}
		$str_sql = $db->buildSQL($setting['db']['pre']."meeting_".$mid, $_POST, "update", "id={$id}");
		$db->Query($str_sql);
		$goto_url = $setting['info']['self']."?mid={$mid}";
		break;
	case "add_ok":
		require("config.php");
		$log_info = "添加会议";
		$sql_item = array();
		$sql_item['mid'] = 0;
		$sql_item['web_id'] = $_POST['web_id'];
		$sql_item['name'] = $_POST['name'];
		$sql_item['name_en'] = $_POST['name_en'];
		$sql_item['notes'] = $_POST['notes'];
		$sql_item['add_date'] = date("Y-m-d H:i:s");
		$str_sql = $db->buildSQL($setting['db']['pre']."meeting", $sql_item, "insert", "");
		$db->Query($str_sql);
		$mid = $db->getInsertID();
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, {$catid}, '".mysql_real_escape_string($sql_item['name'])."', 'meeting.php?mid={$mid}', '../plugin/meeting/', {$sql_item['web_id']}, 0, '".$info['intro']."')");
		if(empty($_POST["tpl_reg_cn"])) $_POST["tpl_reg_cn"] = GetFile("tpl/default_regist_cn.tpl");
		if(empty($_POST["tpl_reg_en"])) $_POST["tpl_reg_en"] = GetFile("tpl/default_regist_en.tpl");
		if(empty($_POST["tpl_reglist_cn"])) $_POST["tpl_reglist_cn"] = GetFile("tpl/default_reglist_cn.tpl");
		if(empty($_POST["tpl_reglist_en"])) $_POST["tpl_reglist_en"] = GetFile("tpl/default_reglist_en.tpl");
		if(empty($_POST["tpl_mail_cn"])) $_POST["tpl_mail_cn"] = GetFile("tpl/default_mail_cn.tpl");
		if(empty($_POST["tpl_mail_en"])) $_POST["tpl_mail_en"] = GetFile("tpl/default_mail_en.tpl");
		if(empty($_POST["tpl_edit_reg"])) $_POST["tpl_edit_reg"] = GetFile("tpl/edit_reg.tpl");
		WriteFile("setting/{$mid}_regist_cn.tpl", $_POST["tpl_reg_cn"], "wb");
		WriteFile("setting/{$mid}_regist_en.tpl", $_POST["tpl_reg_en"], "wb");
		WriteFile("setting/{$mid}_reglist_cn.tpl", $_POST["tpl_reglist_cn"], "wb");
		WriteFile("setting/{$mid}_reglist_en.tpl", $_POST["tpl_reglist_en"], "wb");
		WriteFile("setting/{$mid}_mail_cn.tpl", $_POST["tpl_mail_cn"], "wb");
		WriteFile("setting/{$mid}_mail_en.tpl", $_POST["tpl_mail_en"], "wb");
		WriteFile("setting/{$mid}_edit_reg.tpl", $_POST["tpl_edit_reg"], "wb");
		if(empty($_POST["itemlist"])) {
			include("setting/default.php");
			$para = var_export($para, true);
		} else {
			$_POST["itemlist"] = chg_charset($_POST["itemlist"], $setting['gen']['charset'], "utf-8");
			$json = json_decode($_POST["itemlist"]);
			$para = var_export($json, true);
			$para = str_replace("stdClass::__set_state(", "", $para);
			$para = str_replace("))", ")", $para);
			$para = chg_charset($para, "utf-8", $setting['gen']['charset']);
		}
		WriteFile("setting/{$mid}.php", '<?php
$para = '.str_replace("\r", "", $para).';		
?>', "wb");
		deleteCache("admin_cat");
		include("setting/{$mid}.php");
		$str_sql = "
CREATE TABLE `".$setting['db']['pre']."meeting_".$mid."` (
	`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,";
		foreach($para as $key => $value) {
			switch($value['type']) {
				case "text":
					if(empty($value['length'])) $value['length'] = 100;
					$str_sql .= "\n	`".$key."` Char(".$value['length'].")";
					break;
				case "radio":
				case "select":
					add_slash($value['value']['cn']);
					$list = "'".implode("', '", $value['value']['cn'])."'";
					$str_sql .= "\n	`".$key."` Enum(".$list.")";
					break;
				case "checkbox":
					add_slash($value['value']['cn']);
					$list = "'".implode("', '", $value['value']['cn'])."'";
					$str_sql .= "\n	`".$key."` Set(".$list.")";
					break;
				case "textarea":
					$str_sql .= "\n	`".$key."` text";
					break;
				default:
					break;
			}
			if(strlen($value['default'])>0) {
				$str_sql .= " default '".$value['default']."'";
			}
			$str_sql .= ",";
		}
		$str_sql .= "
	`mailed` BOOL NOT NULL DEFAULT 0,
	`add_date` DATETIME,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=".$setting['gen']['charset']." COMMENT='".mysql_real_escape_string($sql_item['name'])."';
";
		$db->Query($str_sql);
		break;
	case "edit_ok":
		$log_info = "编辑会议";
		$sql_item = array();
		$sql_item['web_id'] = $_POST['web_id'];
		$sql_item['name'] = $_POST['name'];
		$sql_item['name_en'] = $_POST['name_en'];
		$sql_item['notes'] = $_POST['notes'];
		$str_sql = $db->buildSQL($setting['db']['pre']."meeting", $sql_item, "update", "mid={$mid}");
		$db->Query($str_sql);
		include("config.php");
		$db->query("update ".$setting['db']['pre']."admin_cat set name='".mysql_real_escape_string($sql_item['name'])."', web_id='".$sql_item['web_id']."' where file='meeting.php?mid={$mid}' and pid={$catid}");
		if(empty($_POST["tpl_reg_cn"])) $_POST["tpl_reg_cn"] = GetFile("tpl/default_regist_cn.tpl");
		if(empty($_POST["tpl_reg_en"])) $_POST["tpl_reg_en"] = GetFile("tpl/default_regist_en.tpl");
		if(empty($_POST["tpl_reglist_cn"])) $_POST["tpl_reglist_cn"] = GetFile("tpl/default_reglist_cn.tpl");
		if(empty($_POST["tpl_reglist_en"])) $_POST["tpl_reglist_en"] = GetFile("tpl/default_reglist_en.tpl");
		if(empty($_POST["tpl_mail_cn"])) $_POST["tpl_mail_cn"] = GetFile("tpl/default_mail_cn.tpl");
		if(empty($_POST["tpl_mail_en"])) $_POST["tpl_mail_en"] = GetFile("tpl/default_mail_en.tpl");
		if(empty($_POST["tpl_edit_reg"])) $_POST["tpl_edit_reg"] = GetFile("tpl/edit_reg.tpl");
		WriteFile("setting/{$mid}_regist_cn.tpl", $_POST["tpl_reg_cn"], "wb");
		WriteFile("setting/{$mid}_regist_en.tpl", $_POST["tpl_reg_en"], "wb");
		WriteFile("setting/{$mid}_reglist_cn.tpl", $_POST["tpl_reglist_cn"], "wb");
		WriteFile("setting/{$mid}_reglist_en.tpl", $_POST["tpl_reglist_en"], "wb");
		WriteFile("setting/{$mid}_mail_cn.tpl", $_POST["tpl_mail_cn"], "wb");
		WriteFile("setting/{$mid}_mail_en.tpl", $_POST["tpl_mail_en"], "wb");
		WriteFile("setting/{$mid}_edit_reg.tpl", $_POST["tpl_edit_reg"], "wb");
		
		if(empty($_POST["itemlist"])) {
			include("setting/{$mid}.php");
			$para = var_export($para, true);
		} else {
			$_POST["itemlist"] = chg_charset($_POST["itemlist"], $setting['gen']['charset'], "utf-8");
			$json = json_decode($_POST["itemlist"]);
			$para = var_export($json, true);
			$para = str_replace("stdClass::__set_state(", "", $para);
			$para = str_replace("))", ")", $para);
			$para = chg_charset($para, "utf-8", $setting['gen']['charset']);
		}
		WriteFile("setting/{$mid}.php", '<?php
$para = '.str_replace("\r", "", $para).';		
?>', "wb");
		deleteCache("admin_cat");
		unset($para);
		include("setting/{$mid}.php");
		$sql_list = array();
		$del_item = array();
		foreach($para as $key => $value) {
			if(isset($value['op'])) {
				$item_type = "";
				switch($value['type']) {
					case "text":
						if(empty($value['length'])) $value['length'] = 100;
						$item_type .= "`".$key."` Char(".$value['length'].")";
						break;
					case "radio":
					case "select":
						add_slash($value['value']['cn']);
						$list = "'".implode("', '", $value['value']['cn'])."'";
						$item_type .= "`".$key."` Enum(".$list.")";
						break;
					case "checkbox":
						add_slash($value['value']['cn']);
						$list = "'".implode("', '", $value['value']['cn'])."'";
						$item_type .= "`".$key."` Set(".$list.")";
						break;
					case "textarea":
						$item_type .= "`".$key."` text";
						break;
					default:
						break;
				}
				if(strlen($value['default'])>0) {
					$str_sql .= " default '".$value['default']."'";
				}
				switch($value['op']) {
					case "op_add":
						$sql_list[] = "alter table ".$setting['db']['pre']."meeting_{$mid} add ".$item_type;
						break;
					case "op_edit":
						$sql_list[] = "alter table ".$setting['db']['pre']."meeting_{$mid} modify ".$item_type;
						break;
					case "op_remove":
						$sql_list[] = "alter table ".$setting['db']['pre']."meeting_{$mid} drop `{$key}`";
						$del_item[] = $key;
						break;
					default:
						$sql_list[] = "alter table ".$setting['db']['pre']."meeting_{$mid} change `".$value['op']."` ".$item_type;
						break;
				}
				unset($para[$key]['op']);
			}
		}
		for($i=0; $i<count($del_item); $i++) {
			unset($para[$del_item[$i]]);
		}
		WriteFile("setting/{$mid}.php", '<?php
$para = '.var_export($para, true).';		
?>', "wb");
		$db->BatchExec($sql_list);
		break;
	case "delete":
		if(!empty($id)) {
			$log_info = "删除注册信息";
			$db->Query("delete from ".$setting['db']['pre']."meeting_{$mid} where id = '{$id}'");
		} else {
			$log_info = "删除会议";
			include("config.php");
			$db->query("truncate table ".$setting['db']['pre']."meeting_".$mid);
			$db->query("drop table ".$setting['db']['pre']."meeting_".$mid);
			$db->Query("delete from ".$setting['db']['pre']."meeting where mid = '{$mid}'");
			$db->query("delete from ".$setting['db']['pre']."admin_cat where file='meeting.php?mid={$mid}' and pid={$catid}");
			unlink("setting/{$mid}_regist_cn.tpl");
			unlink("setting/{$mid}_regist_en.tpl");
			unlink("setting/{$mid}_reglist_cn.tpl");
			unlink("setting/{$mid}_reglist_en.tpl");
			unlink("setting/{$mid}_mail_cn.tpl");
			unlink("setting/{$mid}_mail_en.tpl");
			unlink("setting/{$mid}_edit_reg.tpl");
			unlink("setting/{$mid}.php");
			deleteCache("admin_cat");
		}
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	default:
		$goto_url = $setting['info']['self'];
}

if(!empty($log_info)) {
	write_log($log_info, "mid=".$mid."&id=".$id);
	if(empty($goto_url)) $goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $id, $mid;

	$tpl_info = array(
		"idx" => "main",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__))),
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	if($method=="list" || $method=="list_reg" || $method=="add" || $method=="edit") {
		$tpl_info['style'] .= "/tpl/";
	} else {
		$tpl_info['style'] .= "/setting/";
	}
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	if($method=="edit_reg") {
		$tpl_info['idx'] = $mid."_edit_reg";
	} else {
		$tpl_info['idx'] = $method;
	}
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if($method=="confirm") {
		global $para, $record;
		$record = $db->getSingleRecord("select * from ".$setting['db']['pre']."meeting_{$mid} where id=".$id);
		if($record===false || !file_exists("setting/{$mid}.php")) {
			$tpl->Set_Variable('main', showInfo("指定的记录不存在或配置文件缺失！", 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		$db->Query("update ".$setting['db']['pre']."meeting_{$mid} set mailed=1 where id='".$record['id']."'");
		include("setting/".$mid.".php");
		$tpl_info['idx'] = "{$mid}_mail_".(empty($record['name'])?"en":"cn");
		$tpl_tmp->ClearError();
		$tpl_tmp->init($tpl_info);
		if(empty($record['name'])) $record['name'] = $record['name_en'];
		$tpl_tmp->Set_Variables($record, 'record');
		$meeting = $db->GetSingleRecord("select * from ".$setting['db']['pre']."meeting where mid='{$mid}'");
		$tpl_tmp->Set_Variables($meeting);
		$tpl_tmp->allow_script = true;
	} elseif($method == "list_reg") {
		$page = $req->getGet("page");
		$keyword = mysql_real_escape_string($req->getGet("keyword"));
		$order = $req->getGet("order");
		$tpl_tmp->Set_Variable('order', $order);
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$condition = "1=1";
		$condition .= empty($keyword)?"":" and (id='$keyword' or company like '%$keyword%' or company_en like '%$keyword%' or name like '%$keyword%' or name_en like '%$keyword%')";

		//navigation
		$counter = $db->GetSingleResult("select count(*) as counter from ".$setting['db']['pre']."meeting_{$mid} where {$condition}");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?mid={$mid}&keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);
		
		//main list
		$str_sql = "select * from ".$setting['db']['pre']."meeting_{$mid} where {$condition}";
		$str_sql.= " order by ".(empty($order)?" ":"{$order} {$order_type}, ")."id {$order_type}";
		$str_sql.= " limit {$page_start}, {$page_size}";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			if(empty($record['name'])) $record['name'] = $record['name_en'];
			if(empty($record['company'])) $record['company'] = $record['company_en'];
			$record['confirm'] = "";
			if($record['mailed']!="已发") $record['confirm'] = ' &nbsp;<a href="?method=confirm&mid='.$mid.'&id='.$record['id'].'" target="_blank">确认</a>';
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('meeting_name', $db->GetSingleResult("select name from ".$setting['db']['pre']."meeting where mid=".$mid));
		$tpl_tmp->Set_Variable('title', '注册信息浏览');
		$tpl_tmp->Set_Variable('keyword', $keyword);
		$tpl_tmp->Set_Variable('order_type_org', $order_type);	
		$order_type = $order_type=="asc"?"desc":"asc";
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('keyword', $keyword);
	} elseif($method == "edit_reg") {
		global $para, $record;
		$record = $db->GetSingleRecord("select * from ".$setting['db']['pre']."meeting_{$mid} where id='{$id}'");
		if($record===false || !file_exists("setting/{$mid}.php")) {
			$tpl->Set_Variable('main', showInfo("指定的记录不存在或配置文件缺失！", 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		HtmlTrans(&$record);
		$tpl_tmp->Set_Variables($record, "record");
		$tpl_tmp->Set_Variable('meeting_name', $db->GetSingleResult("select name from ".$setting['db']['pre']."meeting where mid=".$mid));
		$tpl_tmp->Set_Variable('title', '注册信息更新');
		$tpl_tmp->Set_Variable('method', 'edit_reg');
		include("setting/{$mid}.php");
		$tpl_tmp->allow_script = true;
	} elseif($method == "list") {
		$db->Query("select * from ".$setting['db']['pre']."meeting order by mid desc");
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			if($record['web_id']==0) {
				$record['web_id'] = "仅管理面板";
			} elseif($record['web_id']==255) {
				$record['web_id'] = "全部子站";
			} else {
				$webinfo = getParaInfo("website", "web_id", $record['web_id']);
				$record['web_id'] = $webinfo['name'];
			}
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', '会议浏览');
		$tpl_tmp->Set_Variable('order_type_org', $order_type);
		$order_type = $order_type=="asc"?"desc":"asc";
		$tpl_tmp->Set_Variable('order_type', $order_type);
		global $admin_cat;
		$tpl_tmp->Set_Variable('admin_cat', toJson($admin_cat, $setting['gen']['charset']));
	} elseif($method == "edit") {
		$record = $db->GetSingleRecord("select * from ".$setting['db']['pre']."meeting where mid='{$mid}'");
		if($record===false) {
			$tpl->Set_Variable('main', showInfo("指定的记录不存在！", 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		$tpl_tmp->Set_Variables($record);
		$tpl_tmp->Set_Variable('title', '修改会议项目');
		$tpl_tmp->Set_Variable('method', 'edit');
		$max_count = count($GLOBALS['website']);
		for($i=0; $i<$max_count; $i++) {
			$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
		}
		$db->Free();
		include("setting/{$mid}.php");
		$tpl_tmp->Set_Variable('reg_item', toJson($para, $setting['gen']['charset']));
		$tpl_tmp->Set_Variable('tpl_reg_cn', htmlspecialchars(GetFile("setting/{$mid}_regist_cn.tpl")));
		$tpl_tmp->Set_Variable('tpl_reg_en', htmlspecialchars(GetFile("setting/{$mid}_regist_en.tpl")));
		$tpl_tmp->Set_Variable('tpl_reglist_cn', htmlspecialchars(GetFile("setting/{$mid}_reglist_cn.tpl")));
		$tpl_tmp->Set_Variable('tpl_reglist_en', htmlspecialchars(GetFile("setting/{$mid}_reglist_en.tpl")));
		$tpl_tmp->Set_Variable('tpl_mail_cn', htmlspecialchars(GetFile("setting/{$mid}_mail_cn.tpl")));
		$tpl_tmp->Set_Variable('tpl_mail_en', htmlspecialchars(GetFile("setting/{$mid}_mail_en.tpl")));
		$tpl_tmp->Set_Variable('tpl_edit_reg', htmlspecialchars(GetFile("setting/{$mid}_edit_reg.tpl")));
	} elseif($method == "add") {
		$tpl_tmp->Set_Variable('title', '添加会议');
		$tpl_tmp->Set_Variable('method', 'add');
		$max_count = count($GLOBALS['website']);
		for($i=0; $i<$max_count; $i++) {
			$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
		}
		$db->Free();
		if(file_exists("setting/".$mid.".php")) {
			include("setting/".$mid.".php");
			$tpl_tmp->Set_Variable('tpl_reg_cn', htmlspecialchars(GetFile("setting/".$mid."_regist_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_reg_en', htmlspecialchars(GetFile("setting/".$mid."_regist_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_reglist_cn', htmlspecialchars(GetFile("setting/".$mid."_reglist_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_reglist_en', htmlspecialchars(GetFile("setting/".$mid."_reglist_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_mail_cn', htmlspecialchars(GetFile("setting/".$mid."_mail_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_mail_en', htmlspecialchars(GetFile("setting/".$mid."_mail_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_edit_reg', htmlspecialchars(GetFile("setting/".$mid."_edit_reg.tpl")));
		} else {
			include("setting/default.php");
			$tpl_tmp->Set_Variable('tpl_reg_cn', htmlspecialchars(GetFile("tpl/default_regist_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_reg_en', htmlspecialchars(GetFile("tpl/default_regist_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_reglist_cn', htmlspecialchars(GetFile("tpl/default_reglist_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_reglist_en', htmlspecialchars(GetFile("tpl/default_reglist_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_mail_cn', htmlspecialchars(GetFile("tpl/default_mail_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_mail_en', htmlspecialchars(GetFile("tpl/default_mail_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_edit_reg', htmlspecialchars(GetFile("tpl/edit_reg.tpl")));
		}
		$tpl_tmp->Set_Variable('reg_item', toJson($para, $setting['gen']['charset']));
	}
	$tpl_tmp->Set_Variable('mid', $mid);
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting, $para'));
	$db->Free();
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>