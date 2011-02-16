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
		$log_info = "删除附件";
		$db->Query("select * from ".$setting['db']['pre']."attachment where id={$id}");
		if($record = $db->GetRS()) {
			$the_path = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d/", substr($record['file_time'],0, 10));
			$the_ext = GetFileExt($record['file_name']);
			if($the_ext=="php") $the_ext = "txt";
			$the_file = $record['file_time'].".".$the_ext;
			MultiDel($the_path.$the_file);
			MultiDel($the_path."preview/".$the_file);
			$db->Query("delete from ".$setting['db']['pre']."attachment where id={$id}");
		}
		$db->Free();
		break;
	case "clear":
		$log_info = "清除未关联附件";
		$file_list = array();
		$db->Query("select * from ".$setting['db']['pre']."attachment where news_id=0 and file_count<5 and file_time<((UNIX_TIMESTAMP()-60*60*24*3)*1000)");
		while($record = $db->GetRS()) {
			$file_list[] = $record;
		}
		$db->Free();
		$max_count = count($file_list);
		for($i=0; $i<$max_count; $i++) {
			$the_path = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d/", substr($record['file_time'],0, 10));
			$the_ext = GetFileExt($record['file_name']);
			if($the_ext=="php") $the_ext = "txt";
			$the_file = $file_list[$i]['file_time'].".".$the_ext;
			MultiDel($the_path.$the_file);
			MultiDel($the_path."preview/".$the_file);
			$db->Query("delete from ".$setting['db']['pre']."attachment where id={$file_list[$i]['id']}");
		}
		break;
	default:
		break;
}

if(!empty($log_info)) {
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"]."&id={$id}", $log_info);
	$goto_url = $self;
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

	$str_sql = "select count(*) as counter from ".$setting['db']['pre']."attachment";
	if(!empty($keyword)) $str_sql.= " where file_name like '%{$keyword}%'";
	$counter = $db->GetSingleResult($str_sql);
	$page = $req->getGet("page");
	list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
	$tpl_tmp->Set_Variables($page_arr);

	$str_sql = "select * from ".$setting['db']['pre']."attachment";
	if(!empty($keyword)) $str_sql.= " where file_name like '%{$keyword}%'";
	if(empty($order)) $order="id";
	$str_sql.= " order by $order {$order_type}".(($order=="id")?"":", id desc");
	$str_sql.= " limit $page_start, $page_size";
	$db->Query($str_sql);
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
	$tpl_tmp->Set_Variable('title', '附件管理');
	$db->Free();
	
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>