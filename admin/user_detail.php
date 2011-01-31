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
		$log_info = "删除用户";
		$db->Query("delete from ".$setting['db']['pre']."users where user_id = '{$user_id}'");
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) == 0) {
			$goto_url = $self;
		} else {
			if($_POST['username'] != $_POST['username_org'] && $db->GetSingleResult("select user_id from ".$setting['db']['pre']."users where username='".$_POST['username']."'")!= "") {
				$tpl->Set_Variable('main', showInfo("您所注册的 ".$_POST['username']." 已经存在！", 0));
				$mystep->show($tpl);
				$mystep->pageEnd(false);
			} else {
				$log_info = ($method=="add_ok"?"添加用户":"编辑用户");
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
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"]."&uid={$user_id}", $log_info);
	$goto_url = $self;
}
$mystep->pageEnd(false);


function build_page($method) {
	global $mystep, $req, $db, $tpl, $user_id, $user_group, $tpl_info, $setting;

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
		$condition = "1=1";
		$condition .= empty($keyword)?"":" and username like '%$keyword%'";
		$condition .= empty($group_id)?"":" and group_id='{$group_id}'";
		
		$str_sql = "select count(*) as counter from ".$setting['db']['pre']."users where {$condition}";
		$counter = $db->GetSingleResult($str_sql);
		$page = $req->getGet("page");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&group_id={$group_id}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);

		$str_sql = "select * from ".$setting['db']['pre']."users where {$condition}";
		$str_sql.= " order by ".(empty($order)?"":"{$order} {$order_type}, ")."user_id {$order_type}";
		$str_sql.= " limit {$page_start}, {$page_size}";

		$db->Query($str_sql);
		$tpl_tmp->para_list['record'] = array();
		while($record = $db->GetRS()) {
			HtmlTrans(&$record);
			$record['regdate'] = date("Y-m-d H:i:s", $record['regdate']);
			$group_info = getParaInfo("user_group", "group_id", $record['group_id']);
			$record['group_name'] = $group_info['group_name'];
			$tpl_tmp->Set_Loop('record', $record);
		}
		
		for($i=0; $i<count($user_group); $i++) {
			$user_group[$i]["selected"] = ($user_group[$i]['group_id']==$group_id?"selected":"");
			$tpl_tmp->Set_Loop('user_group', $user_group[$i]);
		}
		
		$tpl_tmp->Set_Variable('title', '用户列表');
		$tpl_tmp->Set_Variable('order_type_org', $order_type);
		if($order_type=="asc") {
			$order_type = "desc";
		} else {
			$order_type = "asc";
		}
		$tpl_tmp->Set_Variable('order_type', $order_type);
		$tpl_tmp->Set_Variable('group_id', $group_id);
		$tpl_tmp->Set_Variable('keyword', $keyword);
	} elseif($method=="edit") {
		$tpl_tmp->Set_Variable('title', '用户编辑');
		
		$db->Query("select * from ".$setting['db']['pre']."users where user_id='{$user_id}'");
		$record  = $db->GetRS();
		if(!$record) {
			$tpl->Set_Variable('main', showInfo("指定 ID 的用户不存在！", 0));
			$mystep->pageEnd(false);
		}
		for($i=0; $i<count($user_group); $i++) {
			$user_group[$i]["selected"] = ($user_group[$i]['group_id']==$record['group_id']?"selected":"");
			$tpl_tmp->Set_Loop('user_group', $user_group[$i]);
		}
		$tpl_tmp->Set_Variables($record);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	} else {
		$tpl_tmp->Set_Variable('title', '用户添加');
		for($i=0; $i<count($user_group); $i++) {
			$user_group[$i]["selected"] = ($user_group[$i]['group_id']==2?"selected":"");
			$tpl_tmp->Set_Loop('user_group', $user_group[$i]);
		}
		$record['user_id'] = 0;
		$record['username'] = "";
		$record['email'] = "";
		$tpl_tmp->Set_Variables($record);
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