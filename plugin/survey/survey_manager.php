<?php
require("../inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$id = $req->getReq("id");
$log_info = "";
$mydb = $mystep->getInstance("MyDB", "survey", dirname(__FILE__)."/data/");


switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['plugin_survey_delete'];
		$db->Query("delete from ".$setting['db']['pre']."survey where id = '$id'");
		$mydb->resetDB("survey_{$id}");
		$mydb->deleteTBL();
		$mydb->resetDB("user_{$id}");
		$mydb->deleteTBL();
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) > 0) {
			$_POST['expire'] *= 60*60*24;
			if($method=="add_ok") {
				$log_info = $setting['language']['plugin_survey_add'];;
				$_POST['add_date'] = $setting['info']['time_start']/1000;
				$str_sql = $db->buildSQL($setting['db']['pre']."survey", $_POST, "insert", "a");
			} else {
				$log_info = $setting['language']['plugin_survey_edit'];
				unset($_POST['id']);
				$str_sql = $db->buildSQL($setting['db']['pre']."survey", $_POST, "update", "id={$id}");
			}
			$db->Query($str_sql);
			
			if($method=="add_ok") {
				$id = $db->GetInsertId();
				$mydb->resetDB("survey_{$id}");
				$db_setting = array(
					array("idx",40),
					array("catalog",40),
					array("title",100),
					array("image",150),
					array("url",150),
					array("vote",10),
				);
				$mydb->createTBL($db_setting);
				$mydb->resetDB("user_{$id}");
				$db_setting = array(
					array("username",20),
					array("vote_list",470),
				);
				$mydb->createTBL($db_setting);
				$mydb->closeTBL();
				$goto_url = $setting['info']['self']."?method=edit&id={$id}";
			}
		} else {
			$goto_url = $setting['info']['self'];
		}
		break;
	case "add_item":
		$log_info = $setting['language']['plugin_survey_add_item'];
		$_POST['idx'] = $setting['info']['time_start'];
		$mydb->resetDB("survey_{$id}");
		$mydb->insertDate($_POST, 1);
		$mydb->closeTBL();
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "del_item":
		$log_info = $setting['language']['plugin_survey_delete_item'];
		$idx = $req->getGet('idx');
		$mydb->resetDB("survey_{$id}");
		$record = $mydb->queryDate("idx=".$idx, true, &$fp_pos, &$row_pos);
		$mydb->deleteDate($row_pos);
		$mydb->closeTBL();
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "import":
		$log_info = $setting['language']['plugin_survey_import'];
		$mydb->resetDB("survey_{$id}");
		$path_upload = $setting['path']['upload']."/tmp/".date("Ym")."/";
		$upload = new MyUploader;
		$upload->init(ROOT_PATH."/".$path_upload, true);
		$upload->DoIt(false);
		if(count($upload->upload_result)>0) {
			if($upload->upload_result[0]['error']==0) {
				$theFile = ROOT_PATH."/".$path_upload."/".$upload->upload_result[0]['new_name'];
				$handle = fopen($theFile, "r");
				while($data = fgets($handle, 1000)) $mydb->insertDate(explode(",",preg_replace("/[\r\n]/", "", $data)));
				fclose($handle);
				unlink($theFile);
			} else {
				WriteError($upload->upload_result[0]['message']);
			}
		}
		$mydb->closeTBL();
		unset($upload);
		$goto_url = $req->getServer("HTTP_REFERER");
		break;
	case "empty":
		$log_info = $setting['language']['plugin_survey_empty'];
		$mydb->resetDB("survey_{$id}");
		$mydb->emptyTBL();
		$mydb->resetDB("user_{$id}");
		$mydb->emptyTBL();
		$mydb->closeTBL();
		$goto_url = $self."?method=edit&id={$id}";
		break;
	case "export":
		$log_info = $setting['language']['plugin_survey_export'];
		$xls = $mystep->getInstance("MyXls", $db->getSingleResult("select subject from ".$setting['db']['pre']."survey where id='{$id}'"), $setting['language']['plugin_survey_export_title']);
		$mydb->resetDB("survey_{$id}");
		$record = $mydb->queryAll();
		$xls->addRow();
		$xls->addCells(explode(",", $setting['language']['plugin_survey_export_items']));
		$max_count = count($record);
		for($i=0; $i<$max_count; $i++) {
			$xls->addRow();
			$xls->addCells($record[$i]);
		}
		$xls->addSheet($setting['language']['plugin_survey_user']);
		$mydb->resetDB("user_{$id}");
		$record = $mydb->queryAll();
		$xls->addRow();
		$xls->addCells(explode(",", $setting['language']['plugin_survey_user_items']));
		$max_count = count($record);
		for($i=0; $i<$max_count; $i++) {
			$xls->addRow();
			$xls->addCells($record[$i]);
		}
		$mydb->closeTBL();
		$xls->makeFile();
		break;
	default:
		break;
}

if(!empty($log_info)) {
	write_log($log_info, "id=".$id);
	if(empty($goto_url)) $goto_url = $setting['info']['self'];
}
$mydb->closeTBL();
unset($mydb);
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $mydb, $setting, $id;
	$tpl_info = array(
		"idx" => "main",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method=="add" || $method=="edit") {
		$tpl_info['idx'] = "input";
	} else {
		$tpl_info['idx'] = "list";
	}
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "list") {
		$page = $req->getGet("page");
		$order = $req->getGet("order");
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$counter = $db->GetSingleResult("select count(*) as counter from ".$setting['db']['pre']."survey");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);
		if($counter>0) {
			$str_sql = "select * from ".$setting['db']['pre']."survey";
			if(empty($order)) $order="id";
			$str_sql.= " order by $order {$order_type}".(($order=="id")?"":", id desc");
			$str_sql.= " limit $page_start, $page_size";
			$db->Query($str_sql);
			while($record = $db->GetRS()) {
				HtmlTrans(&$record);
				switch($record['max_select']) {
					case 0:
						$record['max_select'] = $setting['language']['plugin_survey_select_0'];
						break;
					case 1:
						$record['max_select'] = $setting['language']['plugin_survey_select_1'];
						break;
					default:
						$record['max_select'] = sprintf($setting['language']['plugin_survey_select_2'], $record['max_select']);
				}
				$record['add_date'] = date("Y-m-d", $record['add_date']);
				$record['expire'] = ceil((int)$record['expire']/(60*60*24));
				$record['expire'] = $record['expire']==0?$setting['language']['plugin_survey_expire_1']:($record['expire'].$setting['language']['plugin_survey_expire_2']);
				$tpl_tmp->Set_Loop('record', $record);
			}
		}
		$tpl_tmp->Set_Variable('order_type_org', $order_type);	
		$order_type = $order_type=="asc"?"desc":"asc";
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_survey_title']);
	} else {
		if($method == "edit") {
			$db->Query("select * from ".$setting['db']['pre']."survey where id='{$id}'");
			$record  = $db->GetRS();
			$db->Free();
			if(!$record) {
				$tpl->Set_Variable('main', showInfo($setting['language']['plugin_survey_error'], 0));
				echo $tpl->Read_Cache();
				return;
			}
			HtmlTrans(&$record);
			$record['expire'] = ceil((int)$record['expire']/(60*60*24));
			$record['expire'] = $record['expire']==0?("<option value=\"0\">".$setting['language']['plugin_survey_expire_1']."</option>"):("<option value=\"{$record['expire']}\">".$record['expire'].$setting['language']['plugin_survey_expire_2']."</option>");
			
			$mydb->resetDB("survey_{$id}");
			$item_list=$mydb->queryAll();
			if($item_list!==false) {
				for($i=0,$m=count($item_list);$i<$m;$i++) {
					$item_list[$i]['no'] = $i+1;
				}
			} else {
				$item_list = array();
			}
			$tpl_tmp->Set_Loop('item_list', $item_list, true);
			$mydb->closeTBL();
		} else {
			$record['max_select'] = 1;
		}
		$tpl_tmp->Set_Variables($record, "record");
		$tpl_tmp->judge_list['edit'] = ($method == "edit");
		$tpl_tmp->Set_Variable('title', ($method == "add"?$setting['language']['plugin_survey_add']:$setting['language']['plugin_survey_edit']));
		$tpl_tmp->Set_Variable('show_item', ($method == "add"?"none":"block"));
		$tpl_tmp->Set_Variable('method', $method);
	}
	$tpl_tmp->Set_Variable('max_size', ini_get('upload_max_filesize'));
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting'));
	$db->Free();
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>