<?php
require("inc.php");

$method = $req->getGet("method");
if(empty($method)) $method = "list";
$log_info = "";
$idx = $req->getReq("idx");
if(empty($idx)) $idx = "default";
$tpl_path = ROOT_PATH."/".$setting['path']['template']."/";

switch($method) {
	case "add":
	case "edit":
	case "list":
		build_page($method);
		break;
	case "delete":
		$log_info = "É¾³ýÄ£°å";
		unlink($tpl_path.$idx."/".$req->getGet("file"));
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) > 0) {
			$ext = GetFileExt($_POST['file_name']);
			if($ext!="tpl") $_POST['file_name'] .= ".tpl";
			$log_info = "±à¼­Ä£°å";
			$_POST['file_content'] = str_replace("  ", "\t", $_POST['file_content']);
			if(get_magic_quotes_gpc()) $_POST['file_content'] = stripslashes($_POST['file_content']);
			WriteFile($tpl_path.$idx."/".$_POST['file_name'], $_POST['file_content'], "wb");
		}
		break;
	default:
		build_page("list");
}

if(!empty($log_info)) {
	write_log("http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."?".$_SERVER["QUERY_STRING"]."&idx={$idx}", $log_info);
	$goto_url = $self."?idx=".$idx;
}
$mystep->pageEnd(false);

function build_page($method) {
	global $mystep, $req, $tpl, $tpl_info, $setting, $idx, $tpl_path, $method;
	
	$fso = $mystep->getInstance("MyFSO");
	$tpl_info['idx'] = "web_template_".($method=="list"?"list":"input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if($method == "list") {
		$tpl_tmp->Set_Variable('title', "ÍøÕ¾Ä£°å¹ÜÀí");
		$tpl_tmp->Set_Variable('tpl_idx', $idx);
		
		$tpl_list = $fso->Get_List($tpl_path);
		$max_count = count($tpl_list['dir']);
		for($i=0; $i<$max_count; $i++) {
			$tpl_list['dir'][$i] = basename($tpl_list['dir'][$i]);
			if($tpl_list['dir'][$i]=="cache") continue;
			$tpl_tmp->Set_Loop("tpl_list", array("idx"=>$tpl_list['dir'][$i], "selected"=>$tpl_list['dir'][$i]==$idx?"selected":""));
		}
		
		$file_list = $fso->Get_Tree($tpl_path.$idx, false, ".tpl");
		foreach($file_list as $key => $value) {
			$curFile = $value;
			$curFile['name'] = $key;
			$tpl_tmp->Set_Loop("file", $curFile);
		}
	} else {
		$file = array();
		$file['idx'] = $idx;
		$file['content'] = "";
		if($method=="edit") {
			$file['name'] = $req->getGet("file");
			if(is_file($tpl_path.$idx."/".$file['name'])) {
				$file['content'] = file_get_contents($tpl_path.$idx."/".$file['name']);
				$file['content'] = htmlspecialchars($file['content']);
				$file['content'] = str_replace("\t", "  ", $file['content']);
			}
			$tpl_tmp->Set_Variable('title', "Ä£°å±à¼­");
		} else {
			$file['name'] = "";
			$tpl_tmp->Set_Variable('title', "Ä£°åÌí¼Ó");
		}
		$tpl_tmp->Set_Variable('readonly', $method=="edit"?"readonly":"");
		$tpl_tmp->Set_Variables($file, "file");
	}

	$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	$tpl_tmp->Set_Variable('method', $method);
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>