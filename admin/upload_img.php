<?php
require("inc.php");
$para = explode("|",$_SERVER['QUERY_STRING']);
$parent_element = $para[0];
$width = $para[1];
$height = $para[2];
if(empty($parent_element)) $parent_element = "image";
set_time_limit(0); 

$script = "";
if(count($_POST) > 0){
	$path_upload = $setting['path']['upload']."/pic/".date("Ym")."/";
	$upload = new MyUploader;
	$upload->init("../".$path_upload, true);
	$upload->DoIt();
	if($upload->upload_result[0]['error'] == 0) {
		$the_file = $path_upload."/".$upload->upload_result[0]['new_name'];
		if(!empty($width) && !empty($height)) {
			img_thumb(ROOT_PATH."/".$the_file, $width, $height, ROOT_PATH."/".$the_file.".thumb");
			unlink(ROOT_PATH."/".$the_file);
			rename(ROOT_PATH."/".$the_file.".thumb", ROOT_PATH."/".$the_file);
		}
		$script = "
			var theOLE = null;
			theOLE = parent.parent || parent.dialogArguments || parent.opener;
			theOLE.document.forms[0].{$parent_element}.value = '".$web_url."/".$the_file."';
			alert('".$setting['language']['admin_upload_img_ok']."');
			if(parent.parent==null){parent.close();}else{parent.parent.$.closePopupLayer();}
			
		";
	} else {
		$script = "
			alert('".$upload->upload_result[0]['message']."');
			if(parent.parent==null){parent.close();}else{parent.parent.$.closePopupLayer();}
		";
	}
}

$tpl_info['idx'] = "upload_img";
$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
$tpl_tmp->Set_Variable('script', $script);
$tpl_tmp->Set_Variable('para', implode("|", $para));
$tpl_tmp->Set_Variable('self', $setting['info']['self']);
$Max_size = ini_get('upload_max_filesize');
$tpl_tmp->Set_Variable('Max_size', $Max_size);
$tpl_tmp->Set_Variable('MaxSize', GetFileSize($Max_size));
$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
$db->Free();
$mystep->show($tpl);
$mystep->pageEnd(false);
?>