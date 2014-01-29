<?php
$ms_sign = 8;
require("../inc.php");
$method = $req->getGet("method");
$log_info = "";
$script = "";
switch($method) {
	case "delete":
		$idx = $req->getReq("idx");
		if(!empty($idx)) @unlink(dirname(__FILE__)."/attachment/".$idx);
		$script = '
delAttachment("'.$idx.'");
';
		break;
	case "add":
		if(!empty($_FILES)) {
				array_pop($_POST['embed']);
				array_shift($_POST['embed']);
				$files = array();
				$path_upload = dirname(__FILE__)."/attachment/";
				$upload = $mystep->getInstance("MyUploader", $path_upload, true);
				$upload->DoIt(false);
				$message = array();
				$max_count = count($upload->upload_result);
				for($i=0; $i<$max_count; $i++) {
					if($upload->upload_result[$i]['error'] == 0) {
						$upload->upload_result[$i]['name'] = strtolower($upload->upload_result[$i]['name']);
						$ext = strrchr($upload->upload_result[$i]['name'], ".");
						$name = str_replace($ext, "", $upload->upload_result[$i]['name']);
						rename($path_upload.$upload->upload_result[$i]['new_name'], $path_upload.str_replace(".upload", "", str_replace($ext, "", $upload->upload_result[$i]['new_name'])));
						$upload->upload_result[$i]['name'] = substrPro($name, 0, 80).$ext;
						$upload->upload_result[$i]['new_name'] = str_replace(".upload", "", $upload->upload_result[$i]['new_name']);
						$files[] = array(str_replace($ext, "", $upload->upload_result[$i]['new_name']), $upload->upload_result[$i]['name'], $upload->upload_result[$i]['type'], $_POST['embed'][$i]);
						$message[] = $upload->upload_result[$i]['name']." - ".$setting['language']['plugin_email_upload_done'];
					} else {
						$message[] = $upload->upload_result[$i]['name']." - ".$setting['language']['plugin_email_upload_failed']." - ".$upload->upload_result[$i]['message'];
					}
				}
				$message = implode("\\n",$message);
				if(!empty($message)) {
					$script = '
	alert("'.$message.'");
	setAttachment('.toJson($files,$setting['gen']['charset']).');
';
				}
		}
		break;
	default:
		break;
}
build_page();
$mystep->pageEnd(false);

function build_page() {
	global $mystep, $setting, $script;
	$tpl_info = array(
		"idx" => "attachment",
		"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
		"path" => ROOT_PATH."/".$setting['path']['template'],
	);
	$tpl = $mystep->getInstance("MyTpl", $tpl_info);

	$Max_size = ini_get('upload_max_filesize');
	$tpl->Set_Variable('script', $script);
	$tpl->Set_Variable('Max_size', $Max_size);
	$tpl->Set_Variable('MaxSize', GetFileSize($Max_size));
	$tpl->Set_Variable('path_admin', $setting['path']['admin']);
	$mystep->show($tpl);
	return;
}
?>