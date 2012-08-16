<?php
require("inc.php");

$method = $req->getGet("method");
if($req->getServer("QUERY_STRING")=="") $method = "show";
if(empty($method)) $method = "list";
$log_info = "";
$idx = $req->getReq("idx");
if(empty($idx)) $idx = "default";
$tpl_path = ROOT_PATH."/".$setting['path']['template']."/";

switch($method) {
	case "add":
	case "edit":
	case "list":
	case "show":
		build_page($method);
		break;
	case "delete":
		$log_info = $setting['language']['admin_web_template_delete'];
		unlink($tpl_path.$idx."/".$req->getGet("file"));
		$idx .= "&file=".$req->getGet("file");
		break;
	case "remove":
		$log_info = $setting['language']['admin_web_template_remove'];
		if($idx=="default" || strpos($idx, "admin")!==false) {
			showInfo($setting['language']['admin_web_template_remove_error']);
		}
		MultiDel($tpl_path.$idx);
		MultiDel(ROOT_PATH."/images/".$idx);
		$idx = "";
		break;
	case "set":
		$log_info = $setting['language']['admin_web_template_set'];
		for($i=0,$m=count($_POST['web_id']);$i<$m;$i++) {
			$cfg_file = ROOT_PATH."/include/config_".$_POST['idx'][$i].".php";
			if(!is_file($cfg_file)) continue;
			include($cfg_file);
			$setting_sub['gen']['template'] = $_POST['tpl'][$i];
			$result = <<<mystep
<?php
\$setting_sub = array();

/*--settings--*/
?>
mystep;
			$result = str_replace("/*--settings--*/", makeVarsCode($setting_sub, '$setting_sub'), $result);
			WriteFile(ROOT_PATH."/include/config_".$_POST['idx'][$i].".php", $result, "w");
		}
		$idx = "";
		break;
	case "export":
		$log_info = $setting['language']['admin_web_template_export'];
		require(ROOT_PATH."/source/class/myzip.class.php");
		$dir = ROOT_PATH."/".$setting['path']['upload']."/tmp/";
		$zipfile = $dir."template_".$idx.".zip";
		@unlink($zipfile);
		$files = array();
		$files[] = $tpl_path.$idx."/";
		$files[] = ROOT_PATH."/images/".$idx."/";
		if(zip($files, $zipfile, ROOT_PATH."/")) {
			$content = file_get_contents($zipfile);
			header("Content-type: application/zip");
			header("Accept-Ranges: bytes");
			header("Accept-Length: ".strlen($content));
			header("Content-Disposition: attachment; filename=".getSafeCode("template_".$idx.".zip", "utf-8"));
			echo $content;
		} else {
			showInfo($setting['language']['admin_web_template_export_error']);
		}
		break;
	case "upload":
		$log_info = $setting['language']['admin_web_template_upload'];
		if(count($_POST) > 0){
			$path_upload = $setting['path']['upload']."/tmp/".date("Ym")."/";
			$upload = new MyUploader;
			$upload->init(ROOT_PATH."/".$path_upload, true);
			$upload->DoIt(false);
			if($upload->upload_result[0]['error'] == 0) {
				$theFile = ROOT_PATH."/".$path_upload."/".$upload->upload_result[0]['new_name'];
				require(ROOT_PATH."/source/class/myzip.class.php");
				$zip = new MyZip;
				$res = $zip->open($theFile);
				if($res === TRUE) {
					for($i=0; $i<$zip->numFiles; $i++) {
						$theName = $zip->getNameIndex($i);
						if((stripos($theName, "images/")!==0 && stripos($theName, "template/")!==0) || stripos($theName, "admin")>0 || stripos($theName, ".php")>0) {
							$zip->deleteIndex($i);
						}
					}
					$zip->close();
					if(unzip($theFile, ROOT_PATH)==false) {
						showInfo($setting['language']['admin_web_template_upload_error']);
					}
				} else {
					showInfo($setting['language']['admin_web_template_upload_error']);
				}
			} else {
				showInfo($setting['language']['admin_web_template_upload_error']);
			}
			unset($upload);
		}
		$idx = "";
		break;
	case "add_ok":
	case "edit_ok":
		if(count($_POST) > 0) {
			$log_info = $setting['language']['admin_web_template_edit'];
			if($_POST['file_name']=="style.css") {
				$the_file = ROOT_PATH."/images/".$idx."/style.css";
			} else {
				$ext = GetFileExt($_POST['file_name']);
				if($ext!="tpl") $_POST['file_name'] .= ".tpl";
				$the_file = $tpl_path.$idx."/".$_POST['file_name'];
			}
			$_POST['file_content'] = str_replace("  ", "\t", $_POST['file_content']);
			WriteFile($the_file, $_POST['file_content'], "wb");
		}
		break;
	default:
		build_page("show");
}

if(!empty($log_info)) {
	write_log($log_info, "idx={$idx}");
	$goto_url = $setting['info']['self'];
	if(!empty($idx)) $goto_url .= "?idx=".$idx;
}
$mystep->pageEnd(false);

function build_page($method="") {
	global $mystep, $req, $tpl, $tpl_info, $setting, $idx, $tpl_path, $method;
	
	$fso = $mystep->getInstance("MyFSO");
	$tpl_info['idx'] = "web_template";
	if($method!="show") $tpl_info['idx'] .= ($method=="list"?"_list":"_input");
	$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
	if($method=="show") {
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_template_title']);
		$tpl_tmp->Set_Variable('tpl_idx', $idx);
		
		$tpl_list = $fso->Get_List($tpl_path);
		$max_count = count($tpl_list['dir']);
		$the_list = array();
		for($i=0; $i<$max_count; $i++) {
			$tpl_list['dir'][$i] = basename($tpl_list['dir'][$i]);
			if($tpl_list['dir'][$i]=="cache" || strpos($tpl_list['dir'][$i],"admin")!==false) continue;
			$tpl_tmp->Set_Loop("tpl_list", array(
					"idx"=>$tpl_list['dir'][$i], 
					"img"=>is_file($tpl_path.$tpl_list['dir'][$i]."/sample.jpg")?("/".$setting['path']['template']."/".$tpl_list['dir'][$i]."/sample.jpg"):"/images/noimage.gif",
			));
			$the_list[] = $tpl_list['dir'][$i];
		}
		$tpl_tmp->Set_Variable('tpl_list', toJson($the_list, $setting['gen']['charset']));
		
		$max_count = count($GLOBALS['website']);
		for($i=0; $i<$max_count; $i++) {
			$setting_sub = getSubSetting($GLOBALS['website'][$i]['web_id']);
			$GLOBALS['website'][$i]['tpl'] = $setting_sub['gen']['template'];
			$tpl_tmp->Set_Loop("website", $GLOBALS['website'][$i]);
		}
		
	} elseif($method == "list") {
		$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_template_title']);
		$tpl_tmp->Set_Variable('tpl_idx', $idx);
		
		$tpl_list = $fso->Get_List($tpl_path);
		$max_count = count($tpl_list['dir']);
		for($i=0; $i<$max_count; $i++) {
			$tpl_list['dir'][$i] = basename($tpl_list['dir'][$i]);
			if($tpl_list['dir'][$i]=="cache") continue;
			$tpl_tmp->Set_Loop("tpl_list", array("idx"=>$tpl_list['dir'][$i], "selected"=>$tpl_list['dir'][$i]==$idx?"selected":""));
		}
		
		$css_file = ROOT_PATH."/images/".$idx."/style.css";
		if(is_file($css_file)) {
			$tpl_tmp->Set_Loop("file", array("name"=>"style.css", "size"=>GetFileSize(filesize($css_file)), "attr"=>($fso->Get_Attrib(substr(DecOct(fileperms($css_file)),-3))), "time"=>date("Y/m/d H:i:s", filemtime($css_file))));
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
			if($file['name']=="style.css") {
				$the_file = ROOT_PATH."/images/".$idx."/style.css";
				$file['type'] = "css";
			} else {
				$the_file = $tpl_path.$idx."/".$file['name'];
				$file['type'] = "htmlmixed";
			}
			if(is_file($the_file)) {
				$file['content'] = file_get_contents($the_file);
				$file['content'] = htmlspecialchars($file['content']);
				$file['content'] = str_replace("\t", "  ", $file['content']);
			}
			$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_template_edit']);
		} else {
			$file['name'] = "";
			$tpl_tmp->Set_Variable('title', $setting['language']['admin_web_template_add']);
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