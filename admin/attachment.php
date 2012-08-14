<?php
require("inc.php");
$method	= $req->getGet("method");
$path_upload = ROOT_PATH."/".$setting['path']['upload'];
$script = "";
set_time_limit(0);
switch($method) {
	case "add_ok":
		$comment = $req->getPost('comment');
		$watermark = ($req->getPost('watermark')=="")?0:1;
		$path_upload .= date("/Y/m/d/");
		$upload = $mystep->getInstance("MyUploader", $path_upload, true);
		$upload->DoIt(false);
		$err_msg = array();
		$add_str = array();
		$max_count = count($upload->upload_result);
		for($i=0; $i<$max_count; $i++) {
			if($upload->upload_result[$i]['error'] == 0) {
				$ext = strrchr($upload->upload_result[$i]['name'], ".");
				$name = str_replace($ext, "", $upload->upload_result[$i]['name']);
				$upload->upload_result[$i]['name'] = substrPro($name, 0, 80).$ext;
				$upload->upload_result[$i]['new_name'] = str_replace(".upload", "", $upload->upload_result[$i]['new_name']);
				$str_sql = "insert into ".$setting['db']['pre']."attachment values(0, 0, 0, '".$upload->upload_result[$i]['name']."', '".$upload->upload_result[$i]['type']."', '".$upload->upload_result[$i]['size']."', '{$comment}', '".substr($upload->upload_result[$i]['new_name'],0,13)."', 0, '', '".$req->getSession('username')."', {$watermark})";
				$db->Query($str_sql);
				$new_id = $db->GetInsertId();
				if($new_id != 0) {
					if(strpos($upload->upload_result[$i]['type'],"image")===0) {
						$upload->MakeDir("{$path_upload}/preview/");
						$img_info = GetImageSize("{$path_upload}/".$upload->upload_result[$i]['new_name']);
						$the_width = $img_info[0];
						$the_height = $img_info[1];
						$zoom = $req->getPost('zoom');
						if(empty($zoom)) $zoom = 240;
						if($the_width > $zoom) {
							$the_height *= $zoom/$the_width;
							$the_width = (INT)$zoom;
							img_thumb($path_upload."/".$upload->upload_result[$i]['new_name'], $the_width, $the_height,$path_upload."/preview/".$upload->upload_result[$i]['new_name']);
						} else {
							copy($path_upload."/".$upload->upload_result[$i]['new_name'], $path_upload."/preview/".$upload->upload_result[$i]['new_name']);
						}
						$add_str[] = "<br /><a id=\"att_{$new_id}\" href=\"{$setting['web']['url']}/files/show.htm?{$new_id}\" target=\"_blank\"><img src=\"{$setting['web']['url']}/files/?{$new_id}\" alt=\"".($req->getPost("comment")==""?$upload->upload_result[$i]['name']:$req->getPost("comment"))."\" /></a><br />";
					} else {
						$add_str[] = "<br /><a id=\"att_{$new_id}\" href=\"{$setting['web']['url']}/files?{$new_id}\" target=\"_blank\">".($req->getPost("comment")==""?$upload->upload_result[$i]['name']:$req->getPost("comment"))."</a><br />";
					}
					$script .= "parent.document.forms[0].attach_list.value += '{$new_id}|';\n";
					$err_msg[] = $upload->upload_result[$i]['name']." - ".$setting['language']['admin_attachment_upload_done'];
				} else {
					unlink("{$path_upload}/".$upload->upload_result[$i]['new_name']);
					$err_msg[] = $upload->upload_result[$i]['name']." - ".$setting['language']['admin_attachment_upload_dberr'];
				} 
			} else {
				$err_msg[] = $upload->upload_result[$i]['name']." - ".$setting['language']['admin_attachment_upload_failed']." - ".$upload->upload_result[$i]['message'];
			}
		}
		$err_msg = implode("\\n",$err_msg);
		$add_str = implode("\\n",$add_str);
		$script .= <<<mystep
					window.onload = parent.setIframe;
					parent.attach_add('{$add_str}');
					parent.\$.closePopupLayer();
					parent.alert("{$err_msg}", true);

mystep;
		$tpl_info['idx'] = "script";
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
		$tpl_tmp->Set_Variable('script', $script);
		break;
	case "add":
		$tpl_info['idx'] = "attachment_add";
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
		$Max_size = ini_get('upload_max_filesize');
		$tpl_tmp->Set_Variable('Max_size', $Max_size);
		$tpl_tmp->Set_Variable('MaxSize', GetFileSize($Max_size));
		$watermark_use = ($setting['watermark']['mode'] & 2) ? "checked" : "";
		$tpl_tmp->Set_Variable('watermark_use', $watermark_use);
		break;
	case "edit_ok":
		$req->getPost();
		if(isset($del_att)) {
			$max_count = count($del_att);
			for($i=0; $i<$max_count; $i++) {
				$the_file = explode("::", $del_att[$i]);
				$time = substr($the_file[1], 0, 10);
				unlink($path_upload.date("/Y/m/d/", $time).$the_file[1]);
				unlink($path_upload.date("/Y/m/d/", $time)."preview/".$the_file[1]);
				unlink($path_upload.date("/Y/m/d/", $time)."cache/".$the_file[1]);
				unlink($path_upload.date("/Y/m/d/", $time)."preview/cache/".$the_file[1]);
				$db->Query("delete from ".$setting['db']['pre']."attachment where id = ".$the_file[0]);
				$script .= <<<mystep
						var theOLE = parent || opener;
						theOLE.document.forms[0].attach_list.value = theOLE.document.forms[0].attach_list.value.replace('{$the_file[0]}|', '');
						theOLE.attach_remove('{$the_file[0]}');

mystep;
			}
		}
		if(strlen($watermark_yes)>2) {
			$db->Query("update ".$setting['db']['pre']."attachment set watermark=1 where id in ({$watermark_yes})");
		}
		if(strlen($watermark_no)>2) {
			$db->Query("update ".$setting['db']['pre']."attachment set watermark=0 where id in ({$watermark_no})");
		}
		$script .= '
			if(parent==null){
				self.opener = null;
				self.close();
				location.href = "./";
			} else {
				parent.$.closePopupLayer();
			}
		';
		$tpl_info['idx'] = "script";
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
		$tpl_tmp->Set_Variable('script', $script);
		break;
	case "edit":
		$tpl_info['idx'] = "attachment_edit";
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
		$news_id = $req->getGet("news_id");
		$attach_list = $req->getGet("attach_list");
		$attach_list = explode("|", $attach_list);
		$str_sql = "select * from ".$setting['db']['pre']."attachment where ";
		$max_count = count($attach_list);
		for($i=0; $i<$max_count; $i++) {
			if(!empty($attach_list[$i])) $str_sql .= "id={$attach_list[$i]} or ";
		}
		$str_sql .= (empty($news_id) ? "1=0" : "news_id={$news_id}");
		$db->Query($str_sql);
		$att_more = true;
		while($record = $db->GetRS()) {
			$att_more = false;
			$record['check'] = $record['watermark'] ? "checked" : "";
			$record['file_name_new'] = $record['file_time'].substr(md5($record['file_size']),0,5);
			$record['file_ext'] = strrchr($record['file_name'], ".");
			$tpl_tmp->Set_Loop("record", $record);
		}
		$db->Free();
		$script = "";
		if($att_more) {
			$script = "
				if(parent==null){
					self.opener = null;
					self.close();
					location.href = './';
				} else {
					parent.\$.closePopupLayer();
				}
				parent.alert('".$setting['language']['admin_attachment_edit_err']."', true);
			";
		}
		$tpl_tmp->Set_Variable('script', $script);
		break;
	case "mine":
		$tpl_info['idx'] = "attachment_mine";
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);

		$order = $req->getGet("order");
		$order_type = $req->getGet("order_type");
		if(empty($order_type)) $order_type = "desc";
		$keyword = $req->getGet("keyword");
		$tpl_tmp->Set_Variable('keyword', $keyword);

		$str_sql = "select count(*) as counter from ".$setting['db']['pre']."attachment where add_user='".$_SESSION['username']."'";
		if(!empty($keyword)) $str_sql.= " and file_name like '%{$keyword}%'";
		$counter = $db->GetSingleResult($str_sql);
		$page = $req->getGet("page");
		list($page_arr, $page_start, $page_size) = GetPageList($counter, "?keyword={$keyword}&order={$order}&order_type={$order_type}", $page);
		$tpl_tmp->Set_Variables($page_arr);

		$str_sql = "select * from ".$setting['db']['pre']."attachment where add_user='".$_SESSION['username']."'";
		if(!empty($keyword)) $str_sql.= " and file_name like '%{$keyword}%'";
		if(empty($order)) $order="id";
		$str_sql.= " order by $order {$order_type}".(($order=="id")?"":", id desc");
		$str_sql.= " limit $page_start, $page_size";
		$db->Query($str_sql);
		$att_more = true;
		$tpl_tmp->Set_Variable('order_type_org', $order_type);
		if($order_type=="desc") {
			$order_type = "asc";
		} else {
			$order_type = "desc";
		}
		$tpl_tmp->Set_Variable('order', $order);
		$tpl_tmp->Set_Variable('order_type', $order_type);
		while($record = $db->GetRS()) {
			$att_more = false;
			HtmlTrans(&$record);
			$record['web_url'] = $setting['web']['url'];
			$record['file_time'] = date("Y-m-d H:m:s", substr($record['file_time'],0, 10));
			$tpl_tmp->Set_Loop('record', $record);
		}
		$db->Free();
		$script = "";
		if($att_more) {
			$script = "
				if(parent==null){
					self.opener = null;
					self.close();
					location.href = './';
				} else {
					parent.\$.closePopupLayer();
				}
				parent.alert('".$setting['language']['admin_attachment_edit_err']."', true);
			";
		}
		$tpl_tmp->Set_Variable('script', $script);
		break;
	case "download":
		$id = $req->getGet("id");
		if(empty($id)) {
			header("HTTP/1.0 404 Not Found");
		} else {
			$db->Query("select * from ".$setting['db']['pre']."attachment where id = '{$id}'");
			if($record = $db->GetRS()) {
				$the_file = $path_upload.date("/Y/m/d/", substr($record['file_time'],0, 10)).$record['file_time'].strrchr($record['file_name'],".");
				if(!is_file($the_file)) {
					header("HTTP/1.0 404 Not Found");
				} else {
					$db->Query("update ".$setting['db']['pre']."attachment set file_count = file_count + 1 where id = {$id}");
					header("Content-type: ".$record['file_type']);
					header("Accept-Ranges: bytes");
					header("Accept-Length: ".$record['file_size']);
					header("Content-Disposition: attachment; filename=".$record['file_name']);
					readfile($the_file);
				}
				$db->Free();
			} else {
				header("HTTP/1.0 404 Not Found");
			}
		}
		$mystep->pageEnd(false);
		break;
	default:
		$script .= '
			if(parent==null){
				self.opener = null;
				self.close();
				location.href = "./";
			} else {
				parent.$.closePopupLayer();
			}
		';
		$tpl_info['idx'] = "script";
		$tpl_tmp = $mystep->getInstance("MyTpl", $tpl_info);
		$tpl_tmp->Set_Variable('script', $script);
}


$tpl->Set_Variable('main', $tpl_tmp->Get_Content('$db, $setting'));
unset($tpl_tmp);
$db->Free();
$mystep->show($tpl);
$mystep->pageEnd(false);
?>