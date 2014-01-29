<?php
require("inc.php");

includeCache("plugin");
$method = $req->getGet("method");
if(empty($method)) $method = "list";
$idx = $req->getReq("idx");
$idx = preg_replace("/\W/", "", $idx);
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
		if(!empty($idx) || is_dir($plugin_path.$idx)) {
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
		}
		break;
	case "delete":
		if($record = $db->result($setting['db']['pre']."plugin", "idx", array("idx","=",$idx))) {
			build_page("list");
		} else {
			$log_info = $setting['language']['admin_web_plugin_delete'];
			MultiDel(ROOT_PATH."/plugin/".$idx);
		}
		break;
	case "active":
		$log_info = $setting['language']['admin_web_plugin_active'];
		$db->update($setting['db']['pre']."plugin", array("active"=>"((1-active))"), array("idx","=",$idx));
		deleteCache("plugin");
		MultiDel(ROOT_PATH."/".$setting['path']['cache']."/plugin/");
		delTplCache($setting['gen']['template']);
		break;
	case "order":
		$log_info = $setting['language']['admin_web_plugin_order'];
		for($i=0,$m=count($_POST['idx']); $i<$m; $i++) {
			if(!is_numeric($_POST['order'][$i])) $_POST['order'][$i] = 1;
			$db->update($setting['db']['pre']."plugin", array("order"=>$_POST['order'][$i]), array("idx","=",$_POST['idx'][$i]));
		}
		deleteCache("plugin");
		MultiDel(ROOT_PATH."/".$setting['path']['cache']."/plugin/");
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

		$cache_path = ROOT_PATH."/".$setting['path']['template']."/cache/";
		if($handle = opendir($cache_path)) {
			while (false !== ($file = readdir($handle))) {
				if($file!="." && $file!="..") {
					MultiDel($cache_path.$file);
				}
			}
			closedir($handle);
		}

		if($method=="install") {
			if(isset($_POST['subweb'])) {
				if($_POST['subweb'][0]=="all") {
					$subweb = "";
				} else {
					$subweb = ",".join($_POST['subweb'], ",").",";
				}
			} else {
				$subweb = ",";
			}
			$db->update($setting['db']['pre']."plugin",array("subweb"=>$subweb),array("idx","=",$idx));
			
			if(isset($_POST['plugin_setting'])) {
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
		}
		break;
	case "setting_ok":
		if(count($_POST) == 0) {
			$goto_url = $setting['info']['self'];
		} else {
			$log_info = $setting['language']['admin_web_plugin_setup'];
			if(isset($_POST['subweb'])) {
				if($_POST['subweb'][0]=="all") {
					$subweb = "";
				} else {
					$subweb = ",".join($_POST['subweb'], ",").",";
				}
			} else {
				$subweb = ",";
			}
			$db->update($setting['db']['pre']."plugin",array("subweb"=>$subweb),array("idx","=",$idx));
			MultiDel(ROOT_PATH."/".$setting['path']['cache']."/plugin/");
			deleteCache("plugin");
			MultiDel(ROOT_PATH."/".$setting['path']['cache']."/plugin/");
			
			if(isset($_POST['plugin_setting'])) {
				include($plugin_path.$idx."/config.php");
				foreach($_POST['plugin_setting'][$idx] as $key => $value) {
					if(is_array($value)) {
						$_POST['plugin_setting'][$idx][$key] = implode(",", $value);
					}
					if(isset($_POST['plugin_setting'][$idx][$key."_r"])) {
						if(empty($_POST['plugin_setting'][$idx][$key])) $_POST['plugin_setting'][$idx][$key] = $plugin_setting[$idx][$key];
						unset($_POST['plugin_setting'][$idx][$key."_r"]);
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
		}
		break;
	case "update":
		$result = array();
		$header = array();
		$header['Referer'] = "http://".$req->GetServer("HTTP_HOST")."/update/";
		$update_url = $setting['gen']['update'];
		if(is_file($plugin_path.$idx."/info.php")) {
			include($plugin_path.$idx."/info.php");
			if(isset($info['update_url'])) $update_url = $info['update_url'];
		}
		$update_info = GetRemoteContent($update_url."/plugin.php?p=".$idx."&cs=".$setting['gen']['charset'], $header);
		$update_info = base64_decode($update_info);
		$update_info = unserialize($update_info);
		$strFind = array("{db_name}", "{pre}", "{charset}");
		$strReplace = array($setting['db']['name'], $setting['db']['pre'], $setting['db']['charset']);
		for($i=0,$m=count($update_info['sql']); $i<$m; $i++) {
			$db->Query(str_replace($strFind, $strReplace, $update_info['sql'][$i]));
		}
		if($m>0) {
			$result['info'] = sprintf($setting['language']['admin_update_sql'], $m);
		} else {
			$result['info'] = "";
		}
		$plugin_path = ROOT_PATH."/plugin/".$idx;
		$list = array();
		for($i=0,$m=count($update_info['file']); $i<$m; $i++) {
			MakeDir(dirname($plugin_path."/".$update_info['file'][$i]));
			if(isWriteable($plugin_path."/".$update_info['file'][$i])) {
				if(empty($update_info['content'][$i])) {
					@unlink($plugin_path."/".$update_info['file'][$i]);
				} elseif($update_info['content'][$i]==".") {
					MakeDir($plugin_path."/".$update_info['file'][$i]);
				} else {
					WriteFile($plugin_path."/".$update_info['file'][$i], $update_info['content'][$i], "wb");
				}
			} else {
				$list[] = $i;
			}
		}
		$result['link'] = "";
		$m = count($list);
		if($m>0) {
			require(ROOT_PATH."/source/class/myzip.class.php");
			$dir = ROOT_PATH."/".$setting['path']['upload']."/tmp/";
			$zipfile = $dir."update_".$idx."_".date("Ymd").".zip";
			$dir = $dir."update/".date("Ymd/");
			$files = array();
			for($i=0; $i<$m; $i++) {
				if($update_info['content'][$list[$i]]==".") continue;
				$files[$i] = $dir.$idx.$update_info['file'][$list[$i]];
				WriteFile($files[$i], $update_info['content'][$list[$i]], "wb");
			}
			if(zip($files, $zipfile, $dir)) {
				$result['link'] = $setting['web']['url']."/".$setting['path']['upload']."/tmp/".basename($zipfile);
			}
			MultiDel($dir);
			$result['info'] .= "\n". $setting['language']['admin_update_error'];
		} else {
			$result['info'] .= "\n". sprintf($setting['language']['admin_update_file'], count($update_info['file']));
		}
		echo toJson($result, $setting['db']['charset']);
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
		if($plugin_info = json_decode(GetRemoteContent($setting['gen']['update']."/plugin.php?l=".$setting['gen']['language']))) {
			foreach($plugin_info as $key => $value) {
				$update_info[$key] = array();
				$update_info[$key]['idx'] = $key;
				$update_info[$key]['name'] = getString($value->name);
				$update_info[$key]['ver'] = $value->ver;
				$update_info[$key]['intro'] = getString($value->intro);
			}
			unset($plugin_info);
		} else {
			$update_info = array();
		}
		$fso = $mystep->getInstance("MyFSO");
		$plugin_list = $fso->Get_List($plugin_path);
		$max_count = count($plugin_list['dir']);
		$n = 0;
		for($i=0; $i<$max_count; $i++) {
			if(is_file($plugin_list['dir'][$i]."/info.php")) {
				$info = array();
				include($plugin_list['dir'][$i]."/info.php");
				$update_info_hash = array();
				if(isset($info['update_url'])) {
					if(isset($update_info_hash[md5($info['update_url'])])) {
						$plugin_info_remote = $update_info_hash[md5($info['update_url'])];
					} else {
						if($plugin_info_remote = json_decode(GetRemoteContent($info['update_url']."/plugin.php?l=".$setting['gen']['language']))) {
							$update_info_hash[md5($info['update_url'])] = $plugin_info_remote;
						} else {
							$plugin_info_remote = new stdClass;
						}
					}
					if(isset($plugin_info_remote->$info['idx'])) {
						$update_info[$info['idx']] = array();
						$update_info[$info['idx']]['idx'] = $info['idx'];
						$update_info[$info['idx']]['name'] = getString($plugin_info_remote->$info['idx']->name);
						$update_info[$info['idx']]['ver'] = $plugin_info_remote->$info['idx']->ver;
						$update_info[$info['idx']]['intro'] = getString($plugin_info_remote->$info['idx']->intro);
					}
				}
				if(isset($update_info[$info['idx']]) && $info['ver']<$update_info[$info['idx']]['ver']) {
					$info['ver_new'] = $update_info[$info['idx']]['ver'];
					$info['update'] = "";
				} else {
					$info['ver_new'] = "";
					$info['update'] = "none";
				}
				if($plugin_info = getParaInfo("plugin", "idx", $info['idx'])) {
					$info['order'] = $plugin_info['order'];
					$info['active'] = $plugin_info['active']?$setting['language']['close']:$setting['language']['open'];
					$tpl_tmp->Set_Loop("plugin_list_1", $info);
				} else {
					$n++;
					$tpl_tmp->Set_Loop("plugin_list_2", $info);
				}
				unset($update_info[$info['idx']]);
			}
		}
		foreach($update_info as $key => $value) {
			$tpl_tmp->Set_Loop("plugin_list_3", $value);
		}
		$tpl_tmp->Set_If('empty_2', $n==0);
		$tpl_tmp->Set_If('empty_3', (count($update_info)==0));
		$tpl_tmp->Set_Variable('self', $setting['info']['self']);
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_plugin_title']);
		
		global $db;
		$db->select($setting['db']['pre']."admin_cat", "file, count(*) as counter", array("file","!=","###"), array("group"=>"file","having"=>array("counter","n>",1)));
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
		$max_count = count($website);
		for($i=0; $i<$max_count; $i++) {
			$tpl_tmp->Set_Loop('subweb', array("web_id"=>$website[$i]['web_id'], "name"=>$website[$i]['name'], "checked"=>""));
		}
		include($plugin_path.$idx."/class.php");
		$check_info = call_user_func(array($info['class'], "check"));
		$color = "black";
		$info = $check_info;
		if(empty($check_info)) {
			$color = "green";
			$info = $setting['language']['admin_web_plugin_check_ok'];
		}
		$check_info = '<span style="color:'.$color.'">'.$info.'</span>';
		$tpl_tmp->Set_Variable('check', $check_info);
		$tpl_tmp->Set_Variable('subweb', "");
	}
	$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting, $idx'));
	unset($tpl_tmp);
	$mystep->show($tpl);
	return;
}
?>