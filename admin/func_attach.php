<?php
require("inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$id = $req->getGet("id");
$log_info = "";

switch($method) {
	case "list":
		build_page();
		break;
	case "delete":
		$log_info = $setting['language']['admin_func_attach_delete'];
		$record = $db->record($setting['db']['pre']."attachment", "*", array("id", "n=", $id));
		if($record !== false) {
			$the_path = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d/", substr($record['file_time'],0, 10));
			$the_ext = GetFileExt($record['file_name']);
			if($the_ext=="php") $the_ext = "txt";
			$the_file = $record['file_time'].substr(md5($record['file_size']),0,5).".".$the_ext;
			MultiDel($the_path.$the_file);
			MultiDel($the_path."preview/".$the_file);
			MultiDel($the_path."cache/".$the_file);
			MultiDel($the_path."preview/cache/".$the_file);
			$db->delete($setting['db']['pre']."attachment", array("id", "n=", $id));
		}
		$db->Free();
		break;
	case "clear":
		$log_info = $setting['language']['admin_func_attach_clean'];
		$file_list = array();
		$db->select($setting['db']['pre']."attachment", "*", array(array("news_id","n=",0),array("file_count","n<",5,"and"),array("file_count","f<","((UNIX_TIMESTAMP()-60*60*24*3)*1000)","and")));
		while($record = $db->GetRS()) {
			$file_list[] = $record;
		}
		$db->Free();
		for($i=0,$m=count($file_list); $i<$m; $i++) {
			$the_path = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d/", substr($record['file_time'],0, 10));
			$the_ext = GetFileExt($record['file_name']);
			if($the_ext=="php") $the_ext = "txt";
			$the_file = $file_list[$i]['file_time'].".".$the_ext;
			MultiDel($the_path.$the_file);
			MultiDel($the_path."preview/".$the_file);
			MultiDel($the_path."cache/".$the_file);
			MultiDel($the_path."preview/cache/".$the_file);
			$db->delete($setting['db']['pre']."attachment", array("id", "n=", $file_list[$i]['id']));
		}
		break;
	default:
		break;
}

if(!empty($log_info)) {
	write_log($log_info, "id={$id}");
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);

function build_page() {
	global $mystep, $req, $db, $tpl, $tpl_info, $setting, $id;

	$tpl_info['idx'] = "func_attach";
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

	$order = $req->getGet("order");
	$order_type = $req->getGet("order_type");
	if(empty($order_type)) $order_type = "desc";
	$keyword = $req->getGet("keyword");
	$tpl_tmp->Set_Variable('keyword', $keyword);
	
	$condition = array();
	if(!empty($keyword)) $condition[] = array("file_name","like",$keyword);
	$counter = $db->result($setting['db']['pre']."attachment","count(*)",$condition);
	$page = $req->getGet("page");
	list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
	$tpl_tmp->Set_Variables($page_arr);

	if(empty($order)) $order="id";
	$the_order = array();
	$the_order[] = "$order $order_type";
	if($order!="id") $the_order[] = "id desc";
	$db->select($setting['db']['pre']."attachment", "*", $condition, array("order"=>$the_order,"limit"=>"$page_start, $page_size"));
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
		$record['web_url'] = $setting['web']['url'];
		$record['file_time'] = date("Y-m-d H:m:s", substr($record['file_time'],0, 10));
		$tpl_tmp->Set_Loop('record', $record);
	}
	$tpl_tmp->Set_Variable('title', $setting['language']['admin_func_attach_title']);
	$db->Free();
	
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>