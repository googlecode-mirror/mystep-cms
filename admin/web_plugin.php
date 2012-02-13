<?php
require("inc.php");

includeCache("plugin");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$idx = $req->getReq("idx");
$log_info = "";
$plugin_path = ROOT_PATH."/plugin/";

switch($method) {
	case "view":
	case "list":
	case "upload":
	case "setting":
		if($method=="view" && ($plugin_info = getParaInfo("plugin", "idx", $idx))) {
			$goto_url = $setting['info']['self'];
		} else {
			build_page($method);
		}
		break;
	case "unpack":
		$log_info = $setting['language']['admin_web_plugin_upload'];
		$script = "";
		if(count($_POST) > 0){
			$path_upload = $setting['path']['upload']."/tmp/".date("Ym")."/";
			$upload = new MyUploader;
			$upload->init(ROOT_PATH."/".$path_upload, true);
			$upload->DoIt(false);
			if($upload->upload_result[0]['error'] == 0) {
				$theFile = ROOT_PATH."/".$path_upload."/".$upload->upload_result[0]['new_name'];
				$mypack = $mystep->getInstance("MyPack", ROOT_PATH."/plugin/", $theFile);
				if($result = $mypack->DoIt("unpack")) {
					$result = $setting['language']['admin_web_plugin_upload_done'];
				} else {
					$result = $setting['language']['admin_web_plugin_upload_failed'];
				}
				unset($mypack);
				unlink($theFile);
				$script = "
					var theOLE = null;
					theOLE = parent.parent || parent.dialogArguments || parent.opener;
					alert('".$result."');
					theOLE.location.reload();
				";
			} else {
				$script = "
					alert('".$upload->upload_result[0]['message']."');
					if(parent.parent==null){parent.close();}else{parent.parent.$.closePopupLayer();}
				";
			}
			unset($upload);
		}
		build_page("upload");
		break;
	case "pack":
		$pack_file = ROOT_PATH."/cache/plugin/".$idx.".plugin";
		$mypack = $mystep->getInstance("MyPack", $plugin_path.$idx, $pack_file);
		$mypack->DoIt();
		//echo $mypack->GetResult();
		header("Content-type: application/octet-stream");
		header("Accept-Ranges: bytes");
		header("Accept-Length: ".filesize($pack_file));
		header("Content-Disposition: attachment; filename=".$idx.".plugin");
		echo GetFile($pack_file);
		$mystep->pageEnd(false);
		break;
	case "delete":
		if($record = $db->getSingleRecord("select idx from ".$setting['db']['pre']."plugin where `idx`='".$idx."'")) {
			build_page("list");
		} else {
			$log_info = $setting['language']['admin_web_plugin_delete'];
			MultiDel(ROOT_PATH."/plugin/".$idx);
		}
		break;
	case "active":
		$log_info = $setting['language']['admin_web_plugin_active'];
		$db->Query("update ".$setting['db']['pre']."plugin set `active`=1-`active` where `idx`='".$idx."'");
		deleteCache("plugin");
		delTplCache($setting['gen']['template']);
		break;
	case "order":
		$log_info = $setting['language']['admin_web_plugin_order'];
		for($i=0,$m=count($_POST['idx']); $i<$m; $i++) {
			if(!is_numeric($_POST['order'][$i])) $_POST['order'][$i] = 1;
			$db->Query("update ".$setting['db']['pre']."plugin set `order`=".$_POST['order'][$i]." where `idx`='".$_POST['idx'][$i]."'");
		}
		deleteCache("plugin");
		break;
	case "install":
	case "uninstall":
		include($plugin_path.$idx."/info.php");
		include($plugin_path.$idx."/class.php");
		if(isset($info['class'])) {
			$log_info = $method=="install"?$setting['language']['admin_web_plugin_install']:$setting['language']['admin_web_plugin_uninstall'];
			call_user_func(array($info['class'], $method));
		} else {
			$goto_url = $setting['info']['self'];
		}
		deleteCache("plugin");
		MultiDel(ROOT_PATH."/".$setting['path']['cache']."/plugin/");
		
		if($method=="install" && isset($_POST['plugin_setting'])) {
			foreach($_POST['plugin_setting'][$idx] as $key => $value) {
				if(is_array($value)) {
					$_POST['plugin_setting'][$idx][$key] = implode(",", $value);
				}
			}
			$result = <<<mystep
<?php
/*--settings--*/
?>
mystep;
			$result = str_replace("/*--settings--*/", makeVarsCode($_POST['plugin_setting'], '$plugin_setting'), $result);
			WriteFile($plugin_path.$idx."/config.php", $result, "wb");
		}
		break;
	case "setting_ok":
		if(count($_POST) == 0 || !isset($_POST['plugin_setting'])) {
			$goto_url = $setting['info']['self'];
		} else {
			$log_info = $setting['language']['admin_web_plugin_setup'];
			
			if($_POST['subweb'][0]=="all") {
				$subweb = "";
			} else {
				$subweb = ",".join($_POST['subweb'], ",").",";
			}
			$db->Query('update '.$setting['db']['pre'].'plugin set subweb="'.$subweb.'" where idx="'.$idx.'"');
			MultiDel(ROOT_PATH."/cache/plugin/");
			deleteCache("plugin");
			
			foreach($_POST['plugin_setting'][$idx] as $key => $value) {
				if(is_array($value)) {
					$_POST['plugin_setting'][$idx][$key] = implode(",", $value);
				}
			}
			$result = <<<mystep
<?php
/*--settings--*/
?>
mystep;
			$result = str_replace("/*--settings--*/", makeVarsCode($_POST['plugin_setting'], '$plugin_setting'), $result);
			WriteFile($plugin_path.$idx."/config.php", $result, "w");
		}
		break;
	default:
		build_page("list");
}

if(!empty($log_info)) {
	write_log($log_info, "idx={$idx}");
	$goto_url = $setting['info']['self'];
}
$mystep->pageEnd(false);


function build_page($method) {
	global $mystep, $req, $tpl, $tpl_info, $plugin, $setting, $idx, $plugin_path, $website;

	$tpl_info['idx'] = "web_plugin_".$method;
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	$tpl_tmp->allow_script = true;

	if($method == "list") {
		$fso = $mystep->getInstance("MyFSO");
		$plugin_list = $fso->Get_List($plugin_path);
		$max_count = count($plugin_list['dir']);
		$n = 0;
		for($i=0; $i<$max_count; $i++) {
			if(is_file($plugin_list['dir'][$i]."/info.php")) {
				include($plugin_list['dir'][$i]."/info.php");
				$info['id'] = ++$n;
				$info['install'] = "";
				$info['uninstall'] = "";
				if($plugin_info = getParaInfo("plugin", "idx", $info['idx'])) {
					$info['order'] = $plugin_info['order'];
					$info['install'] = "none";
				} else {
					$info['uninstall'] = "none";
					$info['order'] = 0;
				}
				$info['active'] = $plugin_info['active']?$setting['language']['close']:$setting['language']['open'];
				$tpl_tmp->Set_Loop("plugin_list", $info);
			}
		}
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_plugin_title']);
		
		global $db;
		$db->Query("select file, count(*) as counter from ms_admin_cat where file!='###' group by file having counter>1");
		$dp_list = "";
		while($cur = $db->getRS()) {
			$dp_list .= $cur['file']."  (".$cur['counter'].")\\n";
		}
		$tpl_tmp->Set_Variable('dp_list', $dp_list);
	} elseif($method=="setting") {
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_plugin_setup']);
		$plugin_info = getParaInfo("plugin", "idx", $idx);
		include($plugin_path.$idx."/info.php");
		if($plugin_info===false) {
			$tpl->Set_Variable('main', showInfo($setting['language']['admin_web_plugin_err'], 0));
			$mystep->show($tpl);
			$mystep->pageEnd(false);
		}
		$max_count = count($website);
		for($i=0; $i<$max_count; $i++) {
			$tpl_tmp->Set_Loop('subweb', array("web_id"=>$website[$i]['web_id'], "name"=>$website[$i]['name'], "checked"=>strpos($plugin_info['subweb'], ",".$website[$i]['web_id'].",")!==false?"checked":""));
		}
		$info['description'] = nl2br($info['description']);
		$tpl_tmp->Set_Variable('idx', $plugin_info['idx']);
		$tpl_tmp->Set_Variable('name', $plugin_info['name']);
		$tpl_tmp->Set_Variable('subweb', $plugin_info['subweb']);
		$tpl_tmp->Set_Variable('description', $info['description']);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
	} elseif($method=="upload") {
		global $script;
		$tpl_tmp->Set_Variable('script', $script);
		$tpl_tmp->Set_Variable('self', $setting['info']['self']);
		$Max_size = ini_get('upload_max_filesize');
		$tpl_tmp->Set_Variable('Max_size', $Max_size);
		$tpl_tmp->Set_Variable('MaxSize', GetFileSize($Max_size));
	} else {
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_plugin_install']);
		include($plugin_path.$idx."/info.php");
		$info['description'] = nl2br($info['description']);
		$tpl_tmp->Set_Variables($info);
		$tpl_tmp->Set_Variable('back_url', $req->getServer("HTTP_REFERER"));
		include($plugin_path.$idx."/class.php");
		$check_info = call_user_func(array($info['class'], "check"));
		if(empty($check_info)) $check_info = '<span style="color:green">'.$setting['language']['admin_web_plugin_check_ok'].'</span>';
		$tpl_tmp->Set_Variable('check', $check_info);
	}
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting, $idx'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>