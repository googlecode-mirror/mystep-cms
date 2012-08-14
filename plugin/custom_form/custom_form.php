<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";

$mid = $req->getReq("mid");
$id = $req->getReq("id");
$log_info = "";

if(!empty($mid) && $method=="list") $method = "list_data";
if(!empty($id) && $method=="edit") $method = "edit_data";

if(file_exists("setting/{$mid}_ext_script.php")) include("setting/{$mid}_ext_script.php");

switch($method) {
	case "add":
	case "edit":
	case "list":
	case "edit_data":
	case "list_data":
	case "confirm":
		build_page($method);
		break;
	case "export":
		if(file_exists("setting/".$mid.".php")) {
			$log_info = "表单信息导出";
			include("setting/".$mid.".php");
			$title_list = array();
			$title_list[] = "编号";
			$col_list = "id,";
			foreach($para as $key => $value) {
				$col_list .= "`".$key."`,";
				$title_list[] = $value["title"];
			}
			$col_list .= "`mailed`,`add_date`";
			$title_list[] = "确认邮件";
			$title_list[] = "填表日期";

			$xls = $mystep->getInstance("MyXls", $plugin_setting['custom_form']['name'], "表单提交情况");
			$xls->addRow();
			$xls->addCells($title_list);
			$db->Query("select ".$col_list." from ".$setting['db']['pre']."custom_form_".$mid." order by id asc");
			while($record = $db->GetRS()) {
				if(function_exists("ext_func")) ext_func();
				$xls->addRow();
				$xls->addCells($record);
			}
			$xls->makeFile();
		}
		break;
	case "import":
		$log_info = "导入数据";
		if(count($_POST) > 0){
			$path_upload = $setting['path']['upload']."/tmp/".date("Ym")."/";
			$upload = new MyUploader;
			$upload->init(ROOT_PATH."/".$path_upload, true);
			$upload->DoIt(false);
			if($upload->upload_result[0]['error'] == 0) {
				$theFile = ROOT_PATH."/".$path_upload."/".$upload->upload_result[0]['new_name'];
				include("setting/{$mid}.php");
				if(!empty($_POST['empty'])) $db->query("truncate table ".$setting['db']['pre']."custom_form_".$mid);
				$fp = fopen($theFile,"r");
				while($data = fgetcsv($fp,1000,",")) {
					if(!is_numeric(trim($data[0]))) continue;
					$record = array();
					$record['id'] = 0;
					$n = 1;
					foreach($para as $key => $value) {
						$record[$key] = trim($data[$n++]);
					}
					$sql = $db->buildSQL($setting['db']['pre']."custom_form_".$mid, $record, "insert", "a");
					unset($record);
					$db->query($sql);
				}
				fclose($fp);
			}
			unset($upload);
		}
		build_page("list_data");
		break;
	case "add_data_ok":
		if(!empty($_GET['name'])) {
			$log_info = "添加数据";
			if(function_exists("ext_func")) ext_func();
			$db->Query("insert into ".$setting['db']['pre']."custom_form_{$mid} (id, name, add_date) values(0, '".$_GET['name']."', curdate())");
			$goto_url = $setting['info']['self']."?method=edit&mid={$mid}&id=".$db->getInsertID();
		}
		break;
	case "edit_data_ok":
		$log_info = "编辑数据";
		if(empty($_POST['date_checkin'])) unset($_POST['date_checkin']);
		if(empty($_POST['date_checkout'])) unset($_POST['date_checkout']);
		$keyword=$_POST['keyword'];
		unset($_POST['mid'], $_POST['keyword']);
		foreach($_POST as $key => $value) {
			if(is_array($value)) $_POST[$key] = implode(",", $value);
		}
		if(function_exists("ext_func")) ext_func();
		$str_sql = $db->buildSQL($setting['db']['pre']."custom_form_".$mid, $_POST, "update", "id={$id}");
		$db->Query($str_sql);
		$goto_url = $setting['info']['self']."?mid={$mid}&keyword=".$keyword;
		break;
	case "add_ok":
		require("config.php");
		$log_info = "添加表单";
		$sql_item = array();
		$sql_item['mid'] = 0;
		$sql_item['web_id'] = $_POST['web_id'];
		$sql_item['name'] = $_POST['name'];
		$sql_item['name_en'] = $_POST['name_en'];
		$sql_item['notes'] = $_POST['notes'];
		$sql_item['add_date'] = date("Y-m-d H:i:s");
		$str_sql = $db->buildSQL($setting['db']['pre']."custom_form", $sql_item, "insert", "");
		$db->Query($str_sql);
		$mid = $db->getInsertID();
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, {$catid}, '".mysql_real_escape_string($sql_item['name'])."', 'custom_form.php?mid={$mid}', '../plugin/custom_form/', {$sql_item['web_id']}, 0, '".$info['intro']."')");
		if(empty($_POST["tpl_cf_submit_cn"])) $_POST["tpl_cf_submit_cn"] = GetFile("tpl/default_cf_submit_cn.tpl");
		if(empty($_POST["tpl_cf_submit_en"])) $_POST["tpl_cf_submit_en"] = GetFile("tpl/default_cf_submit_en.tpl");
		if(empty($_POST["tpl_cf_list_cn"])) $_POST["tpl_cf_list_cn"] = GetFile("tpl/default_cf_list_cn.tpl");
		if(empty($_POST["tpl_cf_list_en"])) $_POST["tpl_cf_list_en"] = GetFile("tpl/default_cf_list_en.tpl");
		if(empty($_POST["tpl_block_cf_list_cn"])) $_POST["tpl_block_cf_list_cn"] = GetFile("tpl/block_cf_list_cn.tpl");
		if(empty($_POST["tpl_block_cf_list_en"])) $_POST["tpl_block_cf_list_en"] = GetFile("tpl/block_cf_list_en.tpl");
		if(empty($_POST["tpl_mail_cn"])) $_POST["tpl_mail_cn"] = GetFile("tpl/default_mail_cn.tpl");
		if(empty($_POST["tpl_mail_en"])) $_POST["tpl_mail_en"] = GetFile("tpl/default_mail_en.tpl");
		if(empty($_POST["tpl_edit_data"])) $_POST["tpl_edit_data"] = GetFile("tpl/edit_data.tpl");
		if(empty($_POST["tpl_list_data"])) $_POST["tpl_list_data"] = GetFile("tpl/list_data.tpl");
		if(empty($_POST["ext_script"])) $_POST["ext_script"] = GetFile("setting/ext_script.php");
		
		$_POST["tpl_cf_submit_cn"] = str_replace("&#160; ","	",$_POST["tpl_cf_submit_cn"]);
		$_POST["tpl_cf_submit_cn"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_submit_cn"]);
		WriteFile("setting/{$mid}_cf_submit_cn.tpl", $_POST["tpl_cf_submit_cn"], "wb");
		
		$_POST["tpl_cf_submit_en"] = str_replace("&#160; ","	",$_POST["tpl_cf_submit_en"]);
		$_POST["tpl_cf_submit_en"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_submit_en"]);
		WriteFile("setting/{$mid}_cf_submit_en.tpl", $_POST["tpl_cf_submit_en"], "wb");
		
		$_POST["tpl_cf_list_cn"] = str_replace("&#160; ","	",$_POST["tpl_cf_list_cn"]);
		$_POST["tpl_cf_list_cn"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_list_cn"]);
		WriteFile("setting/{$mid}_cf_list_cn.tpl", $_POST["tpl_cf_list_cn"], "wb");
		
		$_POST["tpl_cf_list_en"] = str_replace("&#160; ","	",$_POST["tpl_cf_list_en"]);
		$_POST["tpl_cf_list_en"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_list_en"]);
		WriteFile("setting/{$mid}_cf_list_en.tpl", $_POST["tpl_cf_list_en"], "wb");
		
		$_POST["tpl_block_cf_list_cn"] = str_replace("&#160; ","	",$_POST["tpl_block_cf_list_cn"]);
		$_POST["tpl_block_cf_list_cn"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_block_cf_list_cn"]);
		WriteFile("setting/{$mid}_block_cf_list_cn.tpl", $_POST["tpl_block_cf_list_cn"], "wb");
		
		$_POST["tpl_block_cf_list_en"] = str_replace("&#160; ","	",$_POST["tpl_block_cf_list_en"]);
		$_POST["tpl_block_cf_list_en"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_block_cf_list_en"]);
		WriteFile("setting/{$mid}_block_cf_list_en.tpl", $_POST["tpl_block_cf_list_en"], "wb");
		
		$_POST["tpl_mail_cn"] = str_replace("&#160; ","	",$_POST["tpl_mail_cn"]);
		$_POST["tpl_mail_cn"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_mail_cn"]);
		WriteFile("setting/{$mid}_mail_cn.tpl", $_POST["tpl_mail_cn"], "wb");
		
		$_POST["tpl_mail_en"] = str_replace("&#160; ","	",$_POST["tpl_mail_en"]);
		$_POST["tpl_mail_en"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_mail_en"]);
		WriteFile("setting/{$mid}_mail_en.tpl", $_POST["tpl_mail_en"], "wb");
		
		$_POST["tpl_edit_data"] = str_replace("&#160; ","	",$_POST["tpl_edit_data"]);
		$_POST["tpl_edit_data"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_edit_data"]);
		WriteFile("setting/{$mid}_edit_data.tpl", $_POST["tpl_edit_data"], "wb");
		
		$_POST["tpl_list_data"] = str_replace("&#160; ","	",$_POST["tpl_list_data"]);
		$_POST["tpl_list_data"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_list_data"]);
		WriteFile("setting/{$mid}_list_data.tpl", $_POST["tpl_list_data"], "wb");
		
		$_POST["ext_script"] = str_replace("&#160; ","	",$_POST["ext_script"]);
		$_POST["ext_script"] = str_replace(hexToStr("c2a0"),"	",$_POST["ext_script"]);
		WriteFile("setting/{$mid}_ext_script.php", $_POST["ext_script"], "wb");
		
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
		if(function_exists("ext_func")) ext_func();
		WriteFile("setting/{$mid}.php", '<?php
$para = '.str_replace("\r", "", $para).';		
?>', "wb");
		deleteCache("admin_cat");
		include("setting/{$mid}.php");
		$str_sql = "
CREATE TABLE `".$setting['db']['pre']."custom_form_".$mid."` (
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
) ENGINE=MyISAM DEFAULT CHARSET=".$setting['db']['charset']." COMMENT='".mysql_real_escape_string($sql_item['name'])."';
";
		$db->Query($str_sql);
		break;
	case "edit_ok":
		$log_info = "编辑表单";
		$sql_item = array();
		$sql_item['web_id'] = $_POST['web_id'];
		$sql_item['name'] = $_POST['name'];
		$sql_item['name_en'] = $_POST['name_en'];
		$sql_item['notes'] = $_POST['notes'];
		$str_sql = $db->buildSQL($setting['db']['pre']."custom_form", $sql_item, "update", "mid={$mid}");
		$db->Query($str_sql);
		include("config.php");
		$db->query("update ".$setting['db']['pre']."admin_cat set name='".mysql_real_escape_string($sql_item['name'])."', web_id='".$sql_item['web_id']."' where file='custom_form.php?mid={$mid}' and pid={$catid}");
		if(empty($_POST["tpl_cf_submit_cn"])) $_POST["tpl_cf_submit_cn"] = GetFile("tpl/default_cf_submit_cn.tpl");
		if(empty($_POST["tpl_cf_submit_en"])) $_POST["tpl_cf_submit_en"] = GetFile("tpl/default_cf_submit_en.tpl");
		if(empty($_POST["tpl_cf_list_cn"])) $_POST["tpl_cf_list_cn"] = GetFile("tpl/default_cf_list_cn.tpl");
		if(empty($_POST["tpl_cf_list_en"])) $_POST["tpl_cf_list_en"] = GetFile("tpl/default_cf_list_en.tpl");
		if(empty($_POST["tpl_block_cf_list_cn"])) $_POST["tpl_block_cf_list_cn"] = GetFile("tpl/block_cf_list_cn.tpl");
		if(empty($_POST["tpl_block_cf_list_en"])) $_POST["tpl_block_cf_list_en"] = GetFile("tpl/block_cf_list_en.tpl");
		if(empty($_POST["tpl_mail_cn"])) $_POST["tpl_mail_cn"] = GetFile("tpl/default_mail_cn.tpl");
		if(empty($_POST["tpl_mail_en"])) $_POST["tpl_mail_en"] = GetFile("tpl/default_mail_en.tpl");
		if(empty($_POST["tpl_edit_data"])) $_POST["tpl_edit_data"] = GetFile("tpl/edit_data.tpl");
		if(empty($_POST["tpl_list_data"])) $_POST["tpl_list_data"] = GetFile("tpl/list_data.tpl");
		if(empty($_POST["ext_script"])) $_POST["ext_script"] = GetFile("setting/ext_script.php");
		
		$_POST["tpl_cf_submit_cn"] = str_replace("&#160; ","	",$_POST["tpl_cf_submit_cn"]);
		$_POST["tpl_cf_submit_cn"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_submit_cn"]);
		WriteFile("setting/{$mid}_cf_submit_cn.tpl", $_POST["tpl_cf_submit_cn"], "wb");
		
		$_POST["tpl_cf_submit_en"] = str_replace("&#160; ","	",$_POST["tpl_cf_submit_en"]);
		$_POST["tpl_cf_submit_en"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_submit_en"]);
		WriteFile("setting/{$mid}_cf_submit_en.tpl", $_POST["tpl_cf_submit_en"], "wb");
		
		$_POST["tpl_cf_list_cn"] = str_replace("&#160; ","	",$_POST["tpl_cf_list_cn"]);
		$_POST["tpl_cf_list_cn"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_list_cn"]);
		WriteFile("setting/{$mid}_cf_list_cn.tpl", $_POST["tpl_cf_list_cn"], "wb");
		
		$_POST["tpl_cf_list_en"] = str_replace("&#160; ","	",$_POST["tpl_cf_list_en"]);
		$_POST["tpl_cf_list_en"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_list_en"]);
		WriteFile("setting/{$mid}_cf_list_en.tpl", $_POST["tpl_cf_list_en"], "wb");
		
		$_POST["tpl_block_cf_list_cn"] = str_replace("&#160; ","	",$_POST["tpl_block_cf_list_cn"]);
		$_POST["tpl_block_cf_list_cn"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_block_cf_list_cn"]);
		WriteFile("setting/{$mid}_block_cf_list_cn.tpl", $_POST["tpl_block_cf_list_cn"], "wb");
		
		$_POST["tpl_block_cf_list_en"] = str_replace("&#160; ","	",$_POST["tpl_block_cf_list_en"]);
		$_POST["tpl_block_cf_list_en"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_block_cf_list_en"]);
		WriteFile("setting/{$mid}_block_cf_list_en.tpl", $_POST["tpl_block_cf_list_en"], "wb");
		
		$_POST["tpl_mail_cn"] = str_replace("&#160; ","	",$_POST["tpl_mail_cn"]);
		$_POST["tpl_mail_cn"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_mail_cn"]);
		WriteFile("setting/{$mid}_mail_cn.tpl", $_POST["tpl_mail_cn"], "wb");
		
		$_POST["tpl_mail_en"] = str_replace("&#160; ","	",$_POST["tpl_mail_en"]);
		$_POST["tpl_mail_en"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_mail_en"]);
		WriteFile("setting/{$mid}_mail_en.tpl", $_POST["tpl_mail_en"], "wb");
		
		$_POST["tpl_edit_data"] = str_replace("&#160; ","	",$_POST["tpl_edit_data"]);
		$_POST["tpl_edit_data"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_edit_data"]);
		WriteFile("setting/{$mid}_edit_data.tpl", $_POST["tpl_edit_data"], "wb");
		
		$_POST["tpl_list_data"] = str_replace("&#160; ","	",$_POST["tpl_list_data"]);
		$_POST["tpl_list_data"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_list_data"]);
		WriteFile("setting/{$mid}_list_data.tpl", $_POST["tpl_list_data"], "wb");
		
		$_POST["ext_script"] = str_replace("&#160; ","	",$_POST["ext_script"]);
		$_POST["ext_script"] = str_replace(hexToStr("c2a0"),"	",$_POST["ext_script"]);
		WriteFile("setting/{$mid}_ext_script.php", $_POST["ext_script"], "wb");
		
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
		if(function_exists("ext_func")) ext_func();
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
						$sql_list[] = "alter table ".$setting['db']['pre']."custom_form_{$mid} add ".$item_type;
						break;
					case "op_edit":
						$sql_list[] = "alter table ".$setting['db']['pre']."custom_form_{$mid} modify ".$item_type;
						break;
					case "op_remove":
						$sql_list[] = "alter table ".$setting['db']['pre']."custom_form_{$mid} drop `{$key}`";
						$del_item[] = $key;
						break;
					default:
						$sql_list[] = "alter table ".$setting['db']['pre']."custom_form_{$mid} change `".$value['op']."` ".$item_type;
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
		if(function_exists("ext_func")) ext_func();
		if(!empty($id)) {
			$log_info = "删除表单信息";
			$db->Query("delete from ".$setting['db']['pre']."custom_form_{$mid} where id = '{$id}'");
		} else {
			$log_info = "删除表单";
			include("config.php");
			$db->query("truncate table ".$setting['db']['pre']."custom_form_".$mid);
			$db->query("drop table ".$setting['db']['pre']."custom_form_".$mid);
			$db->Query("delete from ".$setting['db']['pre']."custom_form where mid = '{$mid}'");
			$db->query("delete from ".$setting['db']['pre']."admin_cat where file='custom_form.php?mid={$mid}' and pid={$catid}");
			unlink("setting/{$mid}_cf_submit_cn.tpl");
			unlink("setting/{$mid}_cf_submit_en.tpl");
			unlink("setting/{$mid}_cf_list_cn.tpl");
			unlink("setting/{$mid}_cf_list_en.tpl");
			unlink("setting/{$mid}_block_cf_list_cn.tpl");
			unlink("setting/{$mid}_block_cf_list_en.tpl");
			unlink("setting/{$mid}_mail_cn.tpl");
			unlink("setting/{$mid}_mail_en.tpl");
			unlink("setting/{$mid}_edit_data.tpl");
			unlink("setting/{$mid}_list_data.tpl");
			unlink("setting/{$mid}_ext_script.php");
			unlink("setting/{$mid}.php");
			deleteCache("admin_cat");
		}
		$goto_url = $req->getServer("HTTP_REFERER");
		$goto_url = getSafeCode($goto_url, $setting['gen']['charset']);
		break;
	case "mail":
		if(function_exists("ext_func")) ext_func();
		$mail = $mystep->getInstance("MyEmail", $setting['web']['email'], $setting['gen']['charset']);
		$mail->addEmail($setting['web']['email'], $setting['web']['title'], "reply");
		$mail->setFrom($setting['web']['email'], $setting['web']['title'], true);
		$mail->setSubject($_POST['subject']);
		$mail->setContent($_POST['content']);
		$mail->addEmail($_POST['email']);
		$mail->addHeader("Disposition-Notification-To", $setting['web']['email']);
		$flag = $mail->send($setting['email']);
		unset($mail);
		$goto_url = $setting['info']['self']."?mid=".$mid;
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
	global $mystep, $req, $db, $setting, $id, $mid, $record, $tpl_tmp;

	$tpl_info = array(
		"idx" => "main",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__))),
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	if($method=="list" || $method=="add" || $method=="edit") {
		$tpl_info['style'] .= "/tpl/";
	} else {
		$tpl_info['style'] .= "/setting/";
	}
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	if($method=="edit_data") {
		$tpl_info['idx'] = $mid."_edit_data";
	} elseif($method=="list_data") {
		$tpl_info['idx'] = $mid."_list_data";
	} else {
		$tpl_info['idx'] = $method;
	}
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if($method=="confirm") {
		global $para;
		$record = $db->getSingleRecord("select * from ".$setting['db']['pre']."custom_form_{$mid} where id=".$id);
		if($record===false || !file_exists("setting/{$mid}.php")) {
			$tpl->Set_Variable('main', showInfo("指定的记录不存在或配置文件缺失！", 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		if(function_exists("ext_func")) ext_func();
		$db->Query("update ".$setting['db']['pre']."custom_form_{$mid} set mailed=1 where id='".$record['id']."'");
		include("setting/".$mid.".php");
		$tpl_info['idx'] = "{$mid}_mail_".((empty($record['name']) && !empty($record['name_en']))?"en":"cn");
		$tpl_tmp->ClearError();
		$tpl_tmp->init($tpl_info);
		if(empty($record['name'])) $record['name'] = $record['name_en'];
		$tpl_tmp->Set_Variables($record, 'record');
		$custom_form = $db->GetSingleRecord("select * from ".$setting['db']['pre']."custom_form where mid='{$mid}'");
		$tpl_tmp->Set_Variables($custom_form);
		$tpl_tmp->allow_script = true;
	} elseif($method == "list_data") {
		$page = $req->getGet("page");
		$keyword = mysql_real_escape_string($req->getGet("keyword"));
		$order = $req->getGet("order");
		$tpl_tmp->Set_Variable('order', $order);
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$condition = "1=0";
		if(!empty($keyword)) {
			include("setting/{$mid}.php");
			foreach($para as $key => $value) {
				if($para[$key]['search']=='true') {
					switch($para[$key]['type']) {
						case "textarea":
							$condition .= " or `{$key}` like '%".$keyword."%'";
							break;
						case "radio":
						case "select":
							$condition .= " or `{$key}` = '".$keyword."'";
							break;
						case "text":
							if($para[$key]['format']=="digital" || $para[$key]['format']=="number") {
								$condition .= " or `{$key}` = '".$keyword."'";
							} else {
								$condition .= " or `{$key}` like '%".$keyword."%'";
							}
							break;
						case "checkbox":
							break;
						default:
							$condition .= " or `{$key}` = '".$keyword."'";
							break;
					}
				}
			}
		}
		if($condition=="1=0") $condition = "1=1";

		//navigation
		$counter = $db->GetSingleResult("select count(*) as counter from ".$setting['db']['pre']."custom_form_{$mid} where {$condition}");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?mid={$mid}&keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);
		
		//main list
		$str_sql = "select * from ".$setting['db']['pre']."custom_form_{$mid} where {$condition}";
		$str_sql.= " order by ".(empty($order)?" ":"{$order} {$order_type}, ")."id {$order_type}";
		$str_sql.= " limit {$page_start}, {$page_size}";
		$db->Query($str_sql);
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			if(function_exists("ext_func")) ext_func();
			$record['confirm'] = "";
			if($record['mailed']!="已发") $record['confirm'] = ' &nbsp;<a href="?method=confirm&mid='.$mid.'&id='.$record['id'].'">确认</a>';
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('custom_form_name', $db->GetSingleResult("select name from ".$setting['db']['pre']."custom_form where mid=".$mid));
		$tpl_tmp->Set_Variable('title', '表单信息浏览');
		$tpl_tmp->Set_Variable('keyword', $keyword);
		$tpl_tmp->Set_Variable('order_type_org', $order_type);	
		$order_type = $order_type=="asc"?"desc":"asc";
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('keyword', $keyword);
	} elseif($method == "edit_data") {
		global $para, $record;
		$keyword = mysql_real_escape_string($req->getGet("keyword"));
		$record = $db->GetSingleRecord("select * from ".$setting['db']['pre']."custom_form_{$mid} where id='{$id}'");
		if($record===false || !file_exists("setting/{$mid}.php")) {
			$tpl->Set_Variable('main', showInfo("指定的记录不存在或配置文件缺失！", 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		HtmlTrans(&$record);
		if(function_exists("ext_func")) ext_func();
		$tpl_tmp->Set_Variables($record, "record");
		$tpl_tmp->Set_Variable('custom_form_name', $db->GetSingleResult("select name from ".$setting['db']['pre']."custom_form where mid=".$mid));
		$tpl_tmp->Set_Variable('title', '表单信息更新');
		$tpl_tmp->Set_Variable('method', 'edit_data');
		$tpl_tmp->Set_Variable('keyword', $keyword);
		include("setting/{$mid}.php");
		$tpl_tmp->allow_script = true;
	} elseif($method == "list") {
		$db->Query("select * from ".$setting['db']['pre']."custom_form order by mid desc");
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
			$record['link_submit'] = getUrl("cf_submit", $record['mid']);
			$record['link_list'] = getUrl("cf_list", $record['mid']);
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('title', '表单浏览');
		$tpl_tmp->Set_Variable('order_type_org', $order_type);
		$order_type = $order_type=="asc"?"desc":"asc";
		$tpl_tmp->Set_Variable('order_type', $order_type);
		global $admin_cat;
		$tpl_tmp->Set_Variable('admin_cat', toJson($admin_cat, $setting['gen']['charset']));
	} elseif($method == "edit") {
		$record = $db->GetSingleRecord("select * from ".$setting['db']['pre']."custom_form where mid='{$mid}'");
		if($record===false) {
			$tpl->Set_Variable('main', showInfo("指定的记录不存在！", 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		if(function_exists("ext_func")) ext_func();
		$tpl_tmp->Set_Variables($record);
		$tpl_tmp->Set_Variable('title', '修改表单项目');
		$tpl_tmp->Set_Variable('method', 'edit');
		$max_count = count($GLOBALS['website']);
		for($i=0; $i<$max_count; $i++) {
			$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
		}
		$db->Free();
		include("setting/{$mid}.php");
		$tpl_tmp->Set_Variable('cf_item', toJson($para, $setting['gen']['charset']));
		$tpl_tmp->Set_Variable('tpl_cf_submit_cn', htmlspecialchars(GetFile("setting/{$mid}_cf_submit_cn.tpl")));
		$tpl_tmp->Set_Variable('tpl_cf_submit_en', htmlspecialchars(GetFile("setting/{$mid}_cf_submit_en.tpl")));
		$tpl_tmp->Set_Variable('tpl_cf_list_cn', htmlspecialchars(GetFile("setting/{$mid}_cf_list_cn.tpl")));
		$tpl_tmp->Set_Variable('tpl_cf_list_en', htmlspecialchars(GetFile("setting/{$mid}_cf_list_en.tpl")));
		$tpl_tmp->Set_Variable('tpl_block_cf_list_cn', htmlspecialchars(GetFile("setting/{$mid}_block_cf_list_cn.tpl")));
		$tpl_tmp->Set_Variable('tpl_block_cf_list_en', htmlspecialchars(GetFile("setting/{$mid}_block_cf_list_en.tpl")));
		$tpl_tmp->Set_Variable('tpl_mail_cn', htmlspecialchars(GetFile("setting/{$mid}_mail_cn.tpl")));
		$tpl_tmp->Set_Variable('tpl_mail_en', htmlspecialchars(GetFile("setting/{$mid}_mail_en.tpl")));
		$tpl_tmp->Set_Variable('tpl_edit_data', htmlspecialchars(GetFile("setting/{$mid}_edit_data.tpl")));
		$tpl_tmp->Set_Variable('tpl_list_data', htmlspecialchars(GetFile("setting/{$mid}_list_data.tpl")));
		$tpl_tmp->Set_Variable('ext_script', htmlspecialchars(GetFile("setting/{$mid}_ext_script.php")));
	} elseif($method == "add") {
		$tpl_tmp->Set_Variable('title', '添加表单');
		$tpl_tmp->Set_Variable('method', 'add');
		$max_count = count($GLOBALS['website']);
		for($i=0; $i<$max_count; $i++) {
			$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
		}
		$db->Free();
		if(file_exists("setting/".$mid.".php")) {
			include("setting/".$mid.".php");
			$tpl_tmp->Set_Variable('tpl_cf_submit_cn', htmlspecialchars(GetFile("setting/".$mid."_cf_submit_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_cf_submit_en', htmlspecialchars(GetFile("setting/".$mid."_cf_submit_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_cf_list_cn', htmlspecialchars(GetFile("setting/".$mid."_cf_list_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_cf_list_en', htmlspecialchars(GetFile("setting/".$mid."_cf_list_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_block_cf_list_cn', htmlspecialchars(GetFile("setting/".$mid."_block_cf_list_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_block_cf_list_en', htmlspecialchars(GetFile("setting/".$mid."_block_cf_list_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_mail_cn', htmlspecialchars(GetFile("setting/".$mid."_mail_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_mail_en', htmlspecialchars(GetFile("setting/".$mid."_mail_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_edit_data', htmlspecialchars(GetFile("setting/".$mid."_edit_data.tpl")));
			$tpl_tmp->Set_Variable('tpl_list_data', htmlspecialchars(GetFile("setting/".$mid."_list_data.tpl")));
			$tpl_tmp->Set_Variable('ext_script', htmlspecialchars(GetFile("setting/".$mid."_ext_script.php")));
		} else {
			include("setting/default.php");
			$tpl_tmp->Set_Variable('tpl_cf_submit_cn', htmlspecialchars(GetFile("tpl/default_cf_submit_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_cf_submit_en', htmlspecialchars(GetFile("tpl/default_cf_submit_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_cf_list_cn', htmlspecialchars(GetFile("tpl/default_cf_list_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_cf_list_en', htmlspecialchars(GetFile("tpl/default_cf_list_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_block_cf_list_cn', htmlspecialchars(GetFile("tpl/block_cf_list_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_block_cf_list_en', htmlspecialchars(GetFile("tpl/block_cf_list_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_mail_cn', htmlspecialchars(GetFile("tpl/default_mail_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_mail_en', htmlspecialchars(GetFile("tpl/default_mail_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_edit_data', htmlspecialchars(GetFile("tpl/edit_data.tpl")));
			$tpl_tmp->Set_Variable('tpl_list_data', htmlspecialchars(GetFile("tpl/list_data.tpl")));
			$tpl_tmp->Set_Variable('ext_script', htmlspecialchars(GetFile("setting/ext_script.php")));
		}
		$tpl_tmp->Set_Variable('cf_item', toJson($para, $setting['gen']['charset']));
		if(function_exists("ext_func")) ext_func();
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