<?php
require("inc.php");
$path_upload = ROOT_PATH."/".$setting['path']['upload'].date("/Y/m/d/");
$script = "";
set_time_limit(0);

$upload = $mystep->getInstance("MyUploader", $path_upload, true);
$upload->DoIt(false);
$watermark = ($setting['watermark']['mode'] & 2) ? 1 : 0;

if($upload->upload_result[0]['error'] == 0) {
	$upload->upload_result[0]['name'] = getString(urldecode($upload->upload_result[0]['name']));
	$ext = strtolower(strrchr($upload->upload_result[0]['name'], "."));
	$name = str_replace($ext, "", $upload->upload_result[0]['name']);
	$upload->upload_result[0]['name'] = substrPro($name, 0, 80).$ext;
	$ext = str_replace(".", "", $ext);
	$upload->upload_result[0]['new_name'] = str_replace(".upload", "", $upload->upload_result[0]['new_name']);
	$db->insert($setting['db']['pre']."attachment", array(0,0,0,$upload->upload_result[0]['name'],$upload->upload_result[0]['type'],$upload->upload_result[0]['size'],'',substr($upload->upload_result[0]['new_name'],0,13),0,'',$req->getSession('username'),$watermark));
	$new_id = $db->GetInsertId();
	if($new_id != 0) {
		$upload->upload_result[0]['att_id'] = $new_id;
		if(strpos($upload->upload_result[0]['type'],"image")===0) {
			$upload->MakeDir("{$path_upload}/preview/");
			$img_info = GetImageSize("{$path_upload}/".$upload->upload_result[0]['new_name']);
			$the_width = $img_info[0];
			$the_height = $img_info[1];
			$zoom = 400;
			if($the_width > $zoom) {
				$the_height *= $zoom/$the_width;
				$the_width = (INT)$zoom;
				img_thumb($path_upload."/".$upload->upload_result[0]['new_name'], $the_width, $the_height,$path_upload."/preview/".$upload->upload_result[0]['new_name']);
			} else {
				copy($path_upload."/".$upload->upload_result[0]['new_name'], $path_upload."/preview/".$upload->upload_result[0]['new_name']);
			}
		}
		$script .= "parent.document.forms[0].attach_list.value += '{$new_id}|';\n";
		$err_msg[] = $upload->upload_result[0]['name']." - ".$setting['language']['admin_attachment_upload_done'];
	} else {
		unlink("{$path_upload}/".$upload->upload_result[0]['new_name']);
		$upload->upload_result[0]['att_id'] = 0;
		$upload->upload_result[0]['error'] = 10;
		$upload->upload_result[0]['message'] = $setting['language']['admin_attachment_upload_dberr'];
	} 
} else {
	$upload->upload_result[0]['att_id'] = 0;
}
echo toJson($upload->upload_result[0], $setting['gen']['charset']);
/*att_id, name, new_name, type, tmp_name, error, size, message*/
$mystep->pageEnd(false);
?>