<?php
require("../inc.php");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$id = $req->getReq("id");
$log_info = "";

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "export":
		$xls = $mystep->getInstance("MyXls", $plugin_setting['meeting']['name'], "ad_info_".$id);
		$xls->addRow();
		$xls->addCells(array("type","ip","date"));
		if($fp=@fopen("ipdata/".$id.".csv","r")) {
			while($record = fgetcsv($fp, 1000, ",")) {
				$xls->addRow();
				$xls->addCells($record);
			}
			fclose($fp);
		}
		$xls->makeFile();
		break;
	case "delete":
		$log_info = $setting['language']['plugin_ad_show_delete'];
		$db->delete($setting['db']['pre']."ad_show", array("id","n=",$id));
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			if($method=="add_ok") {
				$log_info = $setting['language']['plugin_ad_show_add'];
				$_POST['add_date'] = date("Y-m-d H:i:s");
				$db->insert($setting['db']['pre']."ad_show", $_POST, true);
			} else {
				if(empty($_POST['expire'])) unset($_POST['expire']);
				$log_info = $setting['language']['plugin_ad_show_edit'];
				$db->update($setting['db']['pre']."ad_show", $_POST, array("id","n=",$id));
			}
		}
		break;
	default:
		$goto_url = $setting['info']['self'];
		break;
}
if(!empty($log_info)) {
	write_log($log_info, "id=".$id);
	if(empty($goto_url)) $goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $db, $setting, $id;

	$tpl_info = array(
		"idx" => "main",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);

	$tpl_info['idx'] = ($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	$ad_mode = explode(",", $setting['language']['plugin_ad_show_mode']);
	if($method == "list") {
		$order = $req->getGet("order");
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$counter = $db->result($setting['db']['pre']."ad_show", "count(*)");
		$page = $req->getGet("page");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);
		
		if(empty($order)) $order="id";
		$the_order = array();
		$the_order[] = "$order $order_type";
		if($order!="id") $the_order[] = "id desc";
		$db->select($setting['db']['pre']."ad_show","*","",array("order"=>$the_order,"limit"=>"$page_start, $page_size"));
		
		$tpl_tmp->Set_Variable('order_type_org', $order_type);
		if($order_type=="desc") {
			$order_type = "asc";
		} else {
			$order_type = "desc";
		}
		$tpl_tmp->Set_Variable('order', $order);
		$tpl_tmp->Set_Variable('order_type', $order_type);
		
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$record['ad_mode'] = $ad_mode[$record['ad_mode']];
			$tpl_tmp->Set_Loop('record', $record);
		}
		$db->Free();
		$tpl_tmp->Set_Variable('title', $setting['language']['plugin_ad_show_title']);
	} else {
		if($method == "edit") {
			$record = $db->record($setting['db']['pre']."ad_show","*",array("id","n=",$id));
			if($record===false) {
				$tpl_tmp->Set_Variable('main', showInfo($setting['language']['plugin_ad_show_error'], 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			}
			HtmlTrans(&$record);
			$db->Free();
		} else {
			$record = array();
			$record['id'] = 0;
			$record['idx'] = "";
			$record['ad_client'] = "";
			$record['ad_url'] = "";
			$record['ad_mode'] = 1;
			$record['ad_file'] = "";
			$record['ad_text'] = "";
			$record['ad_level'] = 1;
			$record['exp_date'] = "";
			$record['comment'] = "";
		}
		$tpl_tmp->Set_Variables($record);
		
		for($i=0,$m=count($ad_mode);$i<$m;$i++) {
			$tpl_tmp->Set_Loop('ad_mode', array("idx"=>$i, "mode"=>$ad_mode[$i], "selected"=>($i==$record['ad_mode']?"selected":"")));
		}
		
		$db->select($setting['db']['pre']."ad_show", "distinct idx");
		while($record = $db->GetRS()) {
			$record['selected'] = $record['idx']==$idx?"selected":"";
			$tpl_tmp->Set_Loop('idx', $record);
		}
		$db->Free();
		
		$tpl_tmp->Set_Variable('title', ($method=='add'?$setting['language']['plugin_ad_show_add']:$setting['language']['plugin_ad_show_edit']));
		$tpl_tmp->Set_Variable('method', $method);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	}
	
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>