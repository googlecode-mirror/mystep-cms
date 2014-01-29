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
			$db->select($setting['db']['pre']."custom_form_".$mid, $col_list,"",array("order"=>"id asc"));
			while($record = $db->GetRS()) {
				if(function_exists("ext_func")) ext_func();
				$xls->addRow();
				$xls->addCells($record);
			}
			$xls->makeFile();
		}
		break;
	case "import":
		$log_info = "导入表单数据";
		if(count($_POST) > 0){
			$path_upload = $setting['path']['upload']."/tmp/".date("Ym")."/";
			$upload = new MyUploader;
			$upload->init(ROOT_PATH."/".$path_upload, true);
			$upload->DoIt(false);
			if($upload->upload_result[0]['error'] == 0) {
				$theFile = ROOT_PATH."/".$path_upload."/".$upload->upload_result[0]['new_name'];
				include("setting/{$mid}.php");
				if(!empty($_POST['empty'])) $db->delete($setting['db']['pre']."custom_form_".$mid);
				$fp = fopen($theFile,"r");
				while($data = fgetcsv($fp,1000,",")) {
					if(!is_numeric(trim($data[0]))) continue;
					$record = array();
					$data[0] = trim($data[0]);
					if(is_numeric($data[0])) {
						$record['id'] = $data[0];
					} else {
						$record['id'] = 0;
					}
					$n = 1;
					foreach($para as $key => $value) {
						$record[$key] = trim($data[$n++]);
					}
					if(isset($data[$n])) $record['mailed'] = trim($data[$n++]);
					if(isset($data[$n]) && strlen($data[$n])>10) $record['add_date'] = trim($data[$n]);
					$db->replace($setting['db']['pre']."custom_form_".$mid, $record);
					unset($record);
				}
				fclose($fp);
			}
			unset($upload);
		}
		build_page("list_data");
		break;
	case "add_data_ok":
		if(!empty($_GET['name'])) {
			$log_info = "添加表单数据";
			if(function_exists("ext_func")) ext_func();
			$db->insert($setting['db']['pre']."custom_form_".$mid,array("id"=>0,"name"=>$_GET['name'],"add_date"=>"curdate()"));
			$id = $db->getInsertID();
			$goto_url = $setting['info']['self']."?method=edit&mid={$mid}&id=".$id;
		}
		break;
	case "edit_data_ok":
		$log_info = "编辑表单数据";
		$keyword=$_POST['keyword'];
		unset($_POST['mid'], $_POST['keyword']);
		foreach($_POST as $key => $value) {
			if(is_array($value)) $_POST[$key] = implode(",", $value);
		}
		if(count($_FILES)>0) {
			$path_upload = dirname(__FILE__)."/setting/".$mid."/";
			MakeDir($path_upload);
			foreach($_FILES as $key => $value) {
				if(!empty($value['name'])) {
					$new_name = md5($value['name'].$value['type'].$value['size']);
					@unlink($path_upload.$new_name);
					move_uploaded_file($value['tmp_name'], $path_upload.$new_name);
					$_POST[$key] = $value['name']."::".$value['type']."::".$new_name;
				}
			}
		}
		
		if(function_exists("ext_func")) ext_func();
		$db->update($setting['db']['pre']."custom_form_".$mid, $_POST, array("id","n=",$id));
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
		if(!empty($_POST['expire'])) $sql_item['expire'] = $_POST['expire'];
		$sql_item['notes'] = $_POST['notes'];
		$sql_item['add_date'] = date("Y-m-d H:i:s");
		$db->insert($setting['db']['pre']."custom_form", $sql_item);
		$mid = $db->getInsertID();
		$db->insert($setting['db']['pre']."admin_cat",array(0, $catid,$sql_item['name'],'custom_form.php?mid='.$mid,'../plugin/custom_form/',$sql_item['web_id'],0,$sql_item['name']));
		if(empty($_POST["tpl_cf_submit_cn"])) $_POST["tpl_cf_submit_cn"] = GetFile("tpl/default_cf_submit_cn.tpl");
		if(empty($_POST["tpl_cf_submit_en"])) $_POST["tpl_cf_submit_en"] = GetFile("tpl/default_cf_submit_en.tpl");
		if(empty($_POST["tpl_cf_print_cn"])) $_POST["tpl_cf_print_cn"] = GetFile("tpl/default_cf_print_cn.tpl");
		if(empty($_POST["tpl_cf_print_en"])) $_POST["tpl_cf_print_en"] = GetFile("tpl/default_cf_print_en.tpl");
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
		
		$_POST["tpl_cf_print_cn"] = str_replace("&#160; ","	",$_POST["tpl_cf_print_cn"]);
		$_POST["tpl_cf_print_cn"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_print_cn"]);
		WriteFile("setting/{$mid}_cf_print_cn.tpl", $_POST["tpl_cf_print_cn"], "wb");
		
		$_POST["tpl_cf_print_en"] = str_replace("&#160; ","	",$_POST["tpl_cf_print_en"]);
		$_POST["tpl_cf_print_en"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_print_en"]);
		WriteFile("setting/{$mid}_cf_print_en.tpl", $_POST["tpl_cf_print_en"], "wb");
		
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
				case "file":
					$str_sql .= "\n	`".$key."` Char(255)";
					break;
				case "radio":
				case "select":
					add_slash($value['value']['cn']);
					$value['value']['cn'] = str_replace(",", "，", $value['value']['cn']);
					$list = "'".implode("', '", $value['value']['cn'])."'";
					$str_sql .= "\n	`".$key."` Enum(".$list.")";
					break;
				case "checkbox":
					add_slash($value['value']['cn']);
					$value['value']['cn'] = str_replace(",", "，", $value['value']['cn']);
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
		if(!empty($_POST['expire'])) $sql_item['expire'] = $_POST['expire'];
		$sql_item['notes'] = $_POST['notes'];
		$db->update($setting['db']['pre']."custom_form", $sql_item, array("mid","n=",$mid));
		include("config.php");
		$db->update($setting['db']['pre']."admin_cat", array("name"=>$sql_item['name'],"web_id"=>$sql_item['web_id']),array(array("file","=",'custom_form.php?mid='.$mid),array("pid","n=",$catid)));
		if(empty($_POST["tpl_cf_submit_cn"])) $_POST["tpl_cf_submit_cn"] = GetFile("tpl/default_cf_submit_cn.tpl");
		if(empty($_POST["tpl_cf_submit_en"])) $_POST["tpl_cf_submit_en"] = GetFile("tpl/default_cf_submit_en.tpl");
		if(empty($_POST["tpl_cf_print_cn"])) $_POST["tpl_cf_print_cn"] = GetFile("tpl/default_cf_print_cn.tpl");
		if(empty($_POST["tpl_cf_print_en"])) $_POST["tpl_cf_print_en"] = GetFile("tpl/default_cf_print_en.tpl");
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
		
		$_POST["tpl_cf_print_cn"] = str_replace("&#160; ","	",$_POST["tpl_cf_print_cn"]);
		$_POST["tpl_cf_print_cn"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_print_cn"]);
		WriteFile("setting/{$mid}_cf_print_cn.tpl", $_POST["tpl_cf_print_cn"], "wb");
		
		$_POST["tpl_cf_print_en"] = str_replace("&#160; ","	",$_POST["tpl_cf_print_en"]);
		$_POST["tpl_cf_print_en"] = str_replace(hexToStr("c2a0"),"	",$_POST["tpl_cf_print_en"]);
		WriteFile("setting/{$mid}_cf_print_en.tpl", $_POST["tpl_cf_print_en"], "wb");
		
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
					case "file":
						$item_type .= "`".$key."` Char(255)";
						break;
					case "radio":
					case "select":
						add_slash($value['value']['cn']);
						$value['value']['cn'] = str_replace(",", "，", $value['value']['cn']);
						$list = "'".implode("', '", $value['value']['cn'])."'";
						$item_type .= "`".$key."` Enum(".$list.")";
						break;
					case "checkbox":
						add_slash($value['value']['cn']);
						$value['value']['cn'] = str_replace(",", "，", $value['value']['cn']);
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
			$db->delete($setting['db']['pre']."custom_form_".$mid,array("id","n=",$id));
		} else {
			$log_info = "删除表单";
			include("config.php");
			$db->delete($setting['db']['pre']."custom_form_".$mid);
			$db->exec("drop","table",$setting['db']['pre']."custom_form_".$mid);
			$db->delete($setting['db']['pre']."custom_form", array("mid","n=",$mid));
			$db->delete($setting['db']['pre']."admin_cat", array(array("file","=",'custom_form.php?mid='.$mid),array("pid","n=",$catid)));
			unlink("setting/{$mid}_cf_submit_cn.tpl");
			unlink("setting/{$mid}_cf_submit_en.tpl");
			unlink("setting/{$mid}_cf_print_cn.tpl");
			unlink("setting/{$mid}_cf_print_en.tpl");
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
			MultiDel("setting/{$mid}/");
			deleteCache("admin_cat");
		}
		$goto_url = $req->getServer("HTTP_REFERER");
		$goto_url = getSafeCode($goto_url, $setting['gen']['charset']);
		break;
	case "mail":
		if(function_exists("ext_func")) ext_func();
		if(!empty($_POST['sender_name'])) $setting['web']['title'] = $_POST['sender_name'];
		if(!empty($_POST['sender_email'])) $setting['web']['email'] = $_POST['sender_email'];
		$mail = $mystep->getInstance("MyEmail", $setting['web']['email'], $setting['gen']['charset']);
		$mail->addEmail($setting['web']['email'], $setting['web']['title'], "reply");
		$mail->setSubject($_POST['subject']);
		$mail->setContent(str_replace("file.php?mid=", "http://".$setting['info']['web']['host'].dirname($_SERVER["PHP_SELF"])."/file.php?mid=", $_POST['content']));
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
		$record = $db->record($setting['db']['pre']."custom_form_".$mid,"*",array("id","n=",$id));
		if($record===false || !file_exists("setting/{$mid}.php")) {
			$tpl->Set_Variable('main', showInfo("指定的记录不存在或配置文件缺失！", 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		if(function_exists("ext_func")) ext_func();
		$db->update($setting['db']['pre']."custom_form_".$mid,array("mailed"=>1),array("id","n=",$record['id']));
		include("setting/".$mid.".php");
		$tpl_info['idx'] = "{$mid}_mail_".((empty($record['name']) && !empty($record['name_en']))?"en":"cn");
		$tpl_tmp->ClearError();
		$tpl_tmp->init($tpl_info);
		if(empty($record['name'])) $record['name'] = $record['name_en'];
		$tpl_tmp->Set_Variables($record, 'record');
		$custom_form = $db->record($setting['db']['pre']."custom_form","*",array("mid","n=",$mid));
		$tpl_tmp->Set_Variables($custom_form);
		$tpl_tmp->allow_script = true;
	} elseif($method == "list_data") {
		$page = $req->getGet("page");
		$order = $req->getGet("order");
		$tpl_tmp->Set_Variable('order', $order);
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		include_once("setting/{$mid}.php");
		$condition = array();
		if(!empty($keyword)) {
			if(is_numeric($keyword)) $condition[] = array("id","n=",$keyword,"or");
			foreach($para as $key => $value) {
				if($para[$key]['search']=='true') {
					switch($para[$key]['type']) {
						case "file":
						case "textarea":
							$condition[] = array($key,"like",$keyword,"or");
							break;
						case "radio":
						case "select":
							$condition[] = array($key,"=",$keyword,"or");
							break;
						case "text":
							if($para[$key]['format']=="digital" || $para[$key]['format']=="number") {
								$condition[] = array($key,"=",$keyword,"or");
							} else {
								$condition[] = array($key,"like",$keyword,"or");
							}
							break;
						case "checkbox":
							break;
						default:
							$condition[] = array($key,"=",$keyword,"or");
							break;
					}
				}
			}
		}
		
		$key_file = array();
		foreach($para as $key => $value) {
			if($para[$key]['type']=='file') $key_file[] = $key;
		}

		//navigation
		$counter = $db->result($setting['db']['pre']."custom_form_".$mid,"count(*)", $condition);
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?mid={$mid}&keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);
		
		//main list
		if(empty($order)) $order="id";
		$the_order = array();
		$the_order[] = "$order $order_type";
		if($order!="id") $the_order[] = "id ".$order_type;
		$db->select($setting['db']['pre']."custom_form_".$mid, "*", $condition, array("order"=>$the_order,"limit"=>"$page_start, $page_size"));
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			if(function_exists("ext_func")) ext_func();
			if(empty($record['name']) && !empty($record['name_en'])) $record['name'] = $record['name_en'];
			if(empty($record['company']) && !empty($record['company_en'])) $record['company'] = $record['company_en'];
			foreach($key_file as $key){
				if(empty($record[$key])) continue;
				$cur_file = explode("::", $record[$key]);
				if(strpos($cur_file[1],"image")!==false) {
					$record[$key] = '<a href="file.php?mid='.$mid.'&id='.$record['id'].'&f='.$key.'" target="_blank"><img src="file.php?mid='.$mid.'&id='.$record['id'].'&f='.$key.'" width="120" alt="'.$cur_file[0].'" /></a>';
				} else {
					$record[$key] = '<a href="file.php?mid='.$mid.'&id='.$record['id'].'&f='.$key.'" target="_blank">'.$cur_file[0].'</a>';
				}
			}
			$record['confirm'] = "";
			if($record['mailed']!="已发") $record['confirm'] = ' &nbsp;<a href="?method=confirm&mid='.$mid.'&id='.$record['id'].'">确认</a>';
			$tpl_tmp->Set_Loop('record', $record);
		}
		$tpl_tmp->Set_Variable('custom_form_name', $db->result($setting['db']['pre']."custom_form", "name", array("mid","n=",$mid)));
		$tpl_tmp->Set_Variable('title', '表单信息浏览');
		$tpl_tmp->Set_Variable('keyword', $keyword);
		$tpl_tmp->Set_Variable('order_type_org', $order_type);	
		$order_type = $order_type=="asc"?"desc":"asc";
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('keyword', $keyword);
	} elseif($method == "edit_data") {
		global $para, $record;
		$keyword = mysql_real_escape_string($req->getGet("keyword"));
		$record = $db->record($setting['db']['pre']."custom_form_".$mid,"*",array("id","n=",$id));
		if($record===false || !file_exists("setting/{$mid}.php")) {
			$tpl->Set_Variable('main', showInfo("指定的记录不存在或配置文件缺失！", 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		HtmlTrans(&$record);
		if(function_exists("ext_func")) ext_func();
		$tpl_tmp->Set_Variables($record, "record");
		$tpl_tmp->Set_Variable('custom_form_name', $db->result($setting['db']['pre']."custom_form", "name", array("mid","n=",$mid)));
		$tpl_tmp->Set_Variable('title', '表单信息更新');
		$tpl_tmp->Set_Variable('method', 'edit_data');
		$tpl_tmp->Set_Variable('keyword', $keyword);
		include("setting/{$mid}.php");
		$tpl_tmp->allow_script = true;
	} elseif($method == "list") {
		$db->select($setting['db']['pre']."custom_form","*","",array("order"=>"mid desc"));
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
		$record = $db->record($setting['db']['pre']."custom_form","*",array("mid","n=",$mid));
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
		include("setting/{$mid}.php");
		$tpl_tmp->Set_Variable('cf_item', toJson($para, $setting['gen']['charset']));
		$tpl_tmp->Set_Variable('tpl_cf_submit_cn', htmlspecialchars(GetFile("setting/{$mid}_cf_submit_cn.tpl")));
		$tpl_tmp->Set_Variable('tpl_cf_submit_en', htmlspecialchars(GetFile("setting/{$mid}_cf_submit_en.tpl")));
		$tpl_tmp->Set_Variable('tpl_cf_print_cn', htmlspecialchars(GetFile("setting/{$mid}_cf_print_cn.tpl")));
		$tpl_tmp->Set_Variable('tpl_cf_print_en', htmlspecialchars(GetFile("setting/{$mid}_cf_print_en.tpl")));
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
		if(file_exists("setting/".$mid.".php")) {
			include("setting/".$mid.".php");
			$tpl_tmp->Set_Variable('tpl_cf_submit_cn', htmlspecialchars(GetFile("setting/".$mid."_cf_submit_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_cf_submit_en', htmlspecialchars(GetFile("setting/".$mid."_cf_submit_en.tpl")));
			$tpl_tmp->Set_Variable('tpl_cf_print_cn', htmlspecialchars(GetFile("setting/".$mid."_cf_print_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_cf_print_en', htmlspecialchars(GetFile("setting/".$mid."_cf_print_en.tpl")));
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
			$tpl_tmp->Set_Variable('tpl_cf_print_cn', htmlspecialchars(GetFile("tpl/default_cf_print_cn.tpl")));
			$tpl_tmp->Set_Variable('tpl_cf_print_en', htmlspecialchars(GetFile("tpl/default_cf_print_en.tpl")));
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