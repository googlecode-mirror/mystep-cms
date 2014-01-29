<?php
require("inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$user_id = $req->getReq("user_id");
$log_info = "";

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_user_detail_delete'];
		$db->delete($setting['db']['pre']."users", array("user_id","n=",$user_id));
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			if($_POST['username'] != $_POST['username_org'] && $db->result($setting['db']['pre']."users","user_id",array("username","=",$_POST['username']))!==false) {
				$tpl->Set_Variable('main', showInfo(sprintf($setting['language']['admin_user_detail_error2'], $_POST['username']), 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			} else {
				$log_info = ($method=="add_ok"?$setting['language']['admin_user_detail_add']:$setting['language']['admin_user_detail_edit']);
				if(empty($_POST['password'])) {
					unset($_POST['password']);
				} else {
					$_POST['password'] = md5($_POST['password']);
				}
				unset($_POST['user_id'], $_POST['username_org'], $_POST['password_c']);
				if($method=="add_ok") {
					$_POST['regdate'] = $_SERVER['REQUEST_TIME'];
					$db->insert($setting['db']['pre']."users", $_POST);
				} else {
					$db->update($setting['db']['pre']."users", $_POST, array("user_id","n=",$user_id));
				}
			}
		}
		break;
	default:
		build_page("list");
}

if(!empty($log_info)) {
	write_log($log_info, "uid={$user_id}");
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);


function build_page($method) {
	global $mystep, $req, $db, $tpl, $user_id, $user_group, $user_type, $tpl_info, $setting;

	$tpl_info['idx'] = "user_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

	if($method == "list") {
		//navigation
		$order = $req->getGet("order");
		$tpl_tmp->Set_Variable('order', $order);
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$keyword = $req->getGet("keyword");
		$group_id = $req->getGet("group_id");
		$type_id = $req->getGet("type_id");

		$condition = array();
		if(!empty($keyword)) $condition[] = array("username", "like", $keyword);
		if(!empty($group_id)) $condition[] = array("group_id", "n=", $group_id);
		if(!empty($type_id)) $condition[] = array("type_id", "n=", $type_id);
		
		$counter = $db->result($setting['db']['pre']."users","count(*)",$condition);
		$page = $req->getGet("page");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&group_id={$group_id}&type_id={$type_id}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);

		if(empty($order)) $order="user_id";
		$the_order = array();
		$the_order[] = "$order $order_type";
		if($order!="user_id") $the_order[] = "user_id desc";
		$db->select($setting['db']['pre']."users", "*", $condition, array("order"=>$the_order,"limit"=>"$page_start, $page_size"));
		$tpl_tmp->para_list['record'] = array();
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$record['regdate'] = date("Y-m-d H:i:s", $record['regdate']);
			$type_info = getParaInfo("user_type", "type_id", $record['type_id']);
			$record['group_name'] = $type_info['type_name'];
			if($group_info = getParaInfo("user_group", "group_id", $record['group_id'])) {
				$record['group_name'] .= " £¨".$group_info['group_name']."£©"; 
			}
			$tpl_tmp->Set_Loop('record', $record);
		}
		
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_user_detail_title']);
		$tpl_tmp->Set_Variable('order_type_org', $order_type);
		if($order_type=="asc") {
			$order_type = "desc";
		} else {
			$order_type = "asc";
		}
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('group_id', $group_id);
		$tpl_tmp->Set_Variable('type_id', $type_id);
		$tpl_tmp->Set_Variable('keyword', $keyword);
	} elseif($method=="edit") {
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_user_detail_edit']);
		
		$record  = $db->record($setting['db']['pre']."users", "*", array("user_id","n=",$user_id));
		if($record!==false) {
			$tpl->Set_Variable('main', showInfo($setting['language']['admin_user_detail_error'], 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		
		$group_id = $record['group_id'];
		$type_id = $record['type_id'];
		$tpl_tmp->Set_Variables($record);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	} else {
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_user_detail_add']);
		$group_id = 0;
		$type_id = 1;
		$record['user_id'] = 0;
		$record['username'] = "";
		$record['email'] = "";
		$tpl_tmp->Set_Variables($record);
	}

	$max_count = count($user_group);
	for($i=0; $i<$max_count; $i++) {
		$user_group[$i]["selected"] = ($user_group[$i]['group_id']==$group_id?"selected":"");
		$tpl_tmp->Set_Loop('user_group', $user_group[$i]);
	}
	
	$max_count = count($user_type);
	for($i=0; $i<$max_count; $i++) {
		$user_type[$i]["selected"] = ($user_type[$i]['type_id']==$type_id?"selected":"");
		$tpl_tmp->Set_Loop('user_type', $user_type[$i]);
	}
	
	$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	$tpl_tmp->Set_Variable('method', $method);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$db->Free();
	$mystep->show($tpl);
	return;
}
?>