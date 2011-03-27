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
		$db->Query("delete from ".$setting['db']['pre']."users where user_id = '{$user_id}'");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			if($_POST['username'] != $_POST['username_org'] && $db->GetSingleResult("select user_id from ".$setting['db']['pre']."users where username='".$_POST['username']."'")!= "") {
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
					$qry_str = $db->buildSQL($setting['db']['pre']."users", $_POST, "insert");
				} else {
					$qry_str = $db->buildSQL($setting['db']['pre']."users", $_POST, "update", "user_id=".$user_id);
				}
				$db->Query($qry_str);
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
		$condition = "1=1";
		$condition .= empty($keyword)?"":" and username like '%$keyword%'";
		$condition .= empty($group_id)?"":" and group_id='{$group_id}'";
		$condition .= empty($type_id)?"":" and type_id='{$type_id}'";
		
		$str_sql = "select count(*) as counter from ".$setting['db']['pre']."users where {$condition}";
		$counter = $db->GetSingleResult($str_sql);
		$page = $req->getGet("page");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&group_id={$group_id}&type_id={$type_id}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);

		$str_sql = "select * from ".$setting['db']['pre']."users where {$condition}";
		$str_sql.= " order by ".(empty($order)?"":"{$order} {$order_type}, ")."user_id {$order_type}";
		$str_sql.= " limit {$page_start}, {$page_size}";

		$db->Query($str_sql);
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
		
		$db->Query("select * from ".$setting['db']['pre']."users where user_id='{$user_id}'");
		$record  = $db->GetRS();
		if(!$record) {
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