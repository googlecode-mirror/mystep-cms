<?php
require("../inc.php");
include("sql.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";

$id = $req->getReq("id");
$log_info = "";
switch($method) {
	case "add":
	case "edit":
	case "list":
	case "view":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['plugin_custom_sql_delete'];
		unset($sql_list[$id]);
		$sql_list = array_values($sql_list);
		$content = "<?PHP
\$sql_list = ".var_export($sql_list, true).";			
?>";
		WriteFile("sql.php", $content, "wb");
		$goto_url = $setting['info']['self'];
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			if(!preg_match("/^(select|show).+/i", $_POST['sql']) || preg_match("/ into /i", $_POST['sql'])) {
				showInfo($setting['language']['plugin_custom_sql_error_sql']);
			} else {
				unset($_POST['id']);
				if($method=="add_ok") {
					$log_info = $setting['language']['plugin_custom_sql_add'];
					$sql_list[] = $_POST;
				} else {
					$log_info = $setting['language']['plugin_custom_sql_edit'];
					$sql_list[$id] = $_POST;
				}
				$content = "<?PHP
\$sql_list = ".var_export($sql_list, true).";			
?>";
				WriteFile("sql.php", $content, "wb");
			}
			$goto_url = $setting['info']['self'];
		}
		break;
	case "export":
		$log_info = $setting['language']['plugin_custom_sql_export'];
		$xls = new MyXls;
		$xls->init($sql_list[$id]['name'], $sql_list[$id]['name']);
		$xls->addRow();
		$xls->addCells(explode(",", $sql_list[$id]['fields']));
		$db->Query($sql_list[$id]['sql']);
		while($record = $db->GetRS()) {
			$xls->addRow();
			$xls->addCells($record);
		}
		$xls->makeFile();
		break;
	default:
		$goto_url = $setting['info']['self'];
}

if(!empty($log_info)) {
	write_log($log_info, "id=".$id);
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $id, $sql_list;

	$tpl_info = array(
		"idx" => (($method!="list" && $method!="view")?"input":$method),
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);
	
	if($method == "view") {
		$the_sql = $sql_list[$id];
		$fields = explode(",", $the_sql['fields']);
		$max_count = count($fields);
		for($i=0; $i<$max_count; $i++) {
			$tpl->Set_Loop('fields', array("name" => $fields[$i]));
		}
		$page = $req->getGet("page");
		if(empty($page)) $page = 1;
		$counter = $db->GetSingleResult("select count(*) as counter from (".$the_sql['sql'].") a");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?method=view&id=".$id, $page);
		$tpl->Set_Variables($page_arr);
		$the_sql['sql'] .= " limit {$page_start}, {$page_size}";
		$db->Query($the_sql['sql']);
		$max_count = count($fields);
		$n = 1 + ($page - 1) * $page_size;
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$record = array_values($record);
			$record['no'] = $n++;
			$record['data'] = "";
			for($i=0; $i<$max_count; $i++) {
				$record['data'] .= "<td class=\"row\">".$record[$i]."</td>\n";
			}
			$tpl->Set_Loop('record', $record);
		}
		$tpl->Set_Variable('title', $setting['language']['plugin_custom_sql_title']);
		$tpl->Set_Variable('title_2', $the_sql['name']);
		$tpl->Set_Variable('id', $id);
	} elseif($method == "list") {
		$max_count = count($sql_list);
		for($i=0; $i<$max_count; $i++) {
			$sql_list[$i]['id'] = $i;
			$sql_list[$i]['no'] = $i+1;
			$tpl->Set_Loop('record', $sql_list[$i]);
		}
		$tpl->Set_Variable('title', $setting['language']['plugin_custom_sql_title']);
	} else {
		if($method == "edit") {
			$record = $sql_list[$id];
			$record['id'] = $id;
			HtmlTrans(&$record);
		} else {
			$record = array();
			$record['id'] = 0;
			$record['name'] = "";
			$record['sql'] = "";
		}
		$tpl->Set_Variables($record);
		
		$tpl->Set_Variable('title', ($method=='add'?$setting['language']['plugin_custom_sql_add']:$setting['language']['plugin_custom_sql_edit']));
		$tpl->Set_Variable('method', $method);
		$tpl->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$db->Free();
	$mystep->show($tpl);
	return;
}
?>