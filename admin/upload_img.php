<?php
require("inc.php");
$parent_element = $_SERVER['QUERY_STRING'];
if(empty($parent_element)) $parent_element = "image";

$script = "";
if(count($_POST) > 0){
	$path_upload = $setting['path']['upload']."/pic/".date("Ym")."/";
	$upload = new MyUploader;
	$upload->init("../".$path_upload, true);
	$upload->DoIt();
	if($upload->upload_result[0]['error'] == 0) {
		$script = "
			if(parent.dialogArguments) {
				parent.dialogArguments.document.forms[0].{$parent_element}.value = '{$web_url}/{$path_upload}/".$upload->upload_result[0]['new_name']."';
			} else if(parent.opener) {
				parent.opener.document.forms[0].{$parent_element}.value = '{$web_url}/{$path_upload}/".$upload->upload_result[0]['new_name']."';
			}
			alert('".$setting['language']['admin_upload_img_ok']."');
			parent.close();
		";
	} else {
		$script = "
			alert('".$upload->upload_result[0]['message']."');
			parent.close();
		";
	}
}

$tpl_info['idx'] = "upload_img";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$tpl_tmp->Set_Variable('script', $script);
$tpl_tmp->Set_Variable('parent_element', $parent_element);
$tpl_tmp->Set_Variable('self', $setting['info']['self']);
$Max_size = ini_get('upload_max_filesize');
$tpl_tmp->Set_Variable('Max_size', $Max_size);
switch(strtoupper(substr($Max_size,-1))){
	case "M":
		$Max_size = ((int)str_replace("M","",$Max_size)) * 1024 * 1024;
		break;
	case "K":
		$Max_size = ((int)str_replace("K","",$Max_size)) * 1024;
		break;
	default:
		$Max_size = 1024 * 1024;
		break;
}
$tpl_tmp->Set_Variable('MaxSize', $Max_size);
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
$db->Free();
$mystep->show($tpl);
$mystep->pageEnd(false);
?>