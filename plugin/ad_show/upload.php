<?php
require("../inc.php");
$method = $req->getGet("method");
$log_info = "";
$script = "";

$script = "";
if(count($_POST) > 0){
	$path_upload = dirname(__FILE__)."/files/".date("Y")."/";
	$path_upload = str_replace("\\", "/", $path_upload);
	$upload = new MyUploader;
	$upload->init($path_upload, true);
	$upload->DoIt();
	if($upload->upload_result[0]['error'] == 0) {
		$script = "
			var theOLE = null;
			theOLE = parent.parent || parent.dialogArguments || parent.opener;
			theOLE.document.forms[0].ad_file.value = '".$setting['web']['url']."/".str_replace(ROOT_PATH, "", $path_upload)."/".$upload->upload_result[0]['new_name']."';
			if(parent.parent==null){parent.close();}else{parent.parent.$.closePopupLayer();}
			return;
		";
	} else {
		$script = "
			alert('".$upload->upload_result[0]['message']."');
			if(parent.parent==null){parent.close();}else{parent.parent.$.closePopupLayer();}
		";
	}
}

$tpl_info = array(
	"idx" => "main",
	"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
	"path" => ROOT_PATH."/".$setting['path']['template'],
);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);

$tpl_info['idx'] = "upload";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$tpl_tmp->Set_Variable('script', $script);
$tpl_tmp->Set_Variable('parent_element', $parent_element);
$tpl_tmp->Set_Variable('self', $setting['info']['self']);
$Max_size = ini_get('upload_max_filesize');
$tpl_tmp->Set_Variable('Max_size', $Max_size);
$tpl_tmp->Set_Variable('MaxSize', GetFileSize($Max_size));
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
$mystep->show($tpl);
$mystep->pageEnd(false);
?>