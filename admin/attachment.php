<?php
require("inc.php");

$method	= $req->getGet("method");
$close_win = false;
$path_upload = ROOT_PATH."/".$setting['path']['upload'];

ob_start();
switch($method) {
	case "add_ok":
		$comment = $req->getPost('comment');
		$watermark = ($req->getPost('watermark')=="")?0:1;
		$path_upload .= date("/Y/m/d/");
		$upload = $mystep->getInstance("MyUploader", $path_upload, true);
		$upload->DoIt(false);
		echo <<<mystep
			<script language="JavaScript">
mystep;
		$err_msg = array();
		$add_str = array();
		$max_count = count($upload->upload_result);
		for($i=0; $i<$max_count; $i++) {
			if($upload->upload_result[$i]['error'] == 0) {
				$upload->upload_result[$i]['name'] = strtolower($upload->upload_result[$i]['name']);
				$ext = strrchr($upload->upload_result[$i]['name'], ".");
				$name = str_replace($ext, "", $upload->upload_result[$i]['name']);
				$upload->upload_result[$i]['name'] = substrPro($name, 0, 80).$ext;
				$upload->upload_result[$i]['new_name'] = str_replace(".upload", "", $upload->upload_result[$i]['new_name']);
				$qrl_str = "insert into ".$setting['db']['pre']."attachment values(0, 0, '".$upload->upload_result[$i]['name']."', '".$upload->upload_result[$i]['type']."', '".$upload->upload_result[$i]['size']."', '{$comment}', '".str_replace(strrchr($upload->upload_result[$i]['new_name'],"."),"",$upload->upload_result[$i]['new_name'])."', 0, '', '".$req->getSession('username')."', {$watermark})";
				$db->Query($qrl_str);
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
						$add_str[] = "<br /><A href=\"{$setting['web']['url']}/files/show.htm?{$new_id}\" target=\"_blank\"><img src=\"{$setting['web']['url']}/".str_replace(ROOT_PATH, "", $path_upload)."/preview/{$upload->upload_result[$i]['new_name']}\" alt=\"".($req->getPost("comment")==""?$upload->upload_result[$i]['name']:$req->getPost("comment"))."\" /></A><br />";
					} else {
						$add_str[] = "<br /><A href=\"{$setting['web']['url']}/files?{$new_id}\" target=\"_blank\">".($req->getPost("comment")==""?$upload->upload_result[$i]['name']:$req->getPost("comment"))."</A><br />";
					}
					echo "
						parent.document.forms[0].attach_list.value += '{$new_id}|';
						";
					$err_msg[] = $upload->upload_result[$i]['name']." - 上传成功！";
				} else {
					unlink("{$path_upload}/".$upload->upload_result[$i]['new_name']);
					$err_msg[] = $upload->upload_result[$i]['name']." - 记录至数据库时出错！";
				} 
			} else {
				$err_msg[] = $upload->upload_result[$i]['name']." - 上传时出错 - ".$upload->upload_result[$i]['message'];
			}
		}
		$err_msg = implode("\\n",$err_msg);
		$add_str = implode("\\n",$add_str);
		echo <<<mystep

					window.onload = parent.setIframe;
					parent.attach_add('{$add_str}');
					alert("{$err_msg}");
				</script>

mystep;
	case "add":
		echo <<<mystep
			<script language="JavaScript">
			function check(){
				var objs = document.getElementsByName("the_file[]");
				for(var i=0; i<objs.length; i++) {
					if(objs[i].value.length>0) break;
				}
				if (i==objs.length){
					alert("上传文件不能为空！");
				} else {
					document.getElementById("load").style.display = "none";
					document.getElementById("wait").style.display = "";
					document.upload.submit();
				}
			}
			function upload_add_file(){
				var max_upload = 10;
				if($("#files div").length>=max_upload ) {
					alert("同时最多上传 " + max_upload + " 个文件！");
					return;
				}
				var obj = $("#files div:first");
				obj.clone().appendTo("#files");
				parent.setIframe();
				return;
			}
			</script>
			<form name="upload" method="post" ACTION="?method=add_ok" ENCTYPE="multipart/form-data">
				<table border="0" cellspacing="0">
					<tr id="load">
						<td style="padding:10px 10px 10px 10px;">

mystep;

			$Max_size = ini_get('upload_max_filesize');
			$str = "(上传限度：<font color='red'>{$Max_size}</font>)";
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
			$watermark_use = ($watermark_use & 2) ? "checked" : "";
			echo <<<mystep
							<input type="hidden" name="MAX_FILE_SIZE" value="{$Max_size}">
							<div id="files">
								<div style="padding-bottom:5px">
									<b>选择文件：</b>
									<input type="file" name="the_file[]" size="60" onchange="upload_add_file();">
								</div>
							</div>
							<div style="padding-bottom:5px">
								<b>链接文字：</b>
								<input type="text" name="comment" size="70">
							</div>
							<div style="padding-bottom:5px;">
								<b>预览图宽：</b>
								<select name="zoom">
									<option value="800"> 800 像素 </option>
									<option value="700"> 700 像素 </option>
									<option value="600" selected> 600 像素 </option>
									<option value="500"> 500 像素 </option>
									<option value="400"> 400 像素 </option>
									<option value="300"> 300 像素 </option>
								</select> &nbsp;
								<input type="checkbox" id="watermark" name="watermark" value="1" {$watermark_use}> <label for="watermark">添加图片水印</label> &nbsp; {$str} &nbsp;  &nbsp; 
								<input type="button" name="Submit" value=" 上传文件 " onclick="check()">
							</div>
						</td>
					</tr>
					<tr id=wait style="display:none">
						<td align="center">
							正在上传，请稍侯......
						</td>
					</tr>
				</table>
			</form>

mystep;
		break;
	case "edit_ok":
		$req->getPost();
		if(isset($del_att)) {
			$max_count = count($del_att);
			for($i=0; $i<$max_count; $i++) {
				$the_file = split("::", $del_att[$i]);
				$time = substr(str_replace(strrchr($the_file[1], "."), "", $the_file[1]), 0, 10);
				unlink($path_upload.date("/Y/m/d/", $time).$the_file[1]);
				unlink($path_upload.date("/Y/m/d/", $time)."preview/".$the_file[1]);
				$db->Query("delete from ".$setting['db']['pre']."attachment where id = ".$the_file[0]);
				echo <<<mystep
					<script>
						opener.document.forms[0].attach_list.value = opener.document.forms[0].attach_list.value.replace('{$the_file[0]}|', '');
						opener.attach_remove({$the_file[0]});
					</script>
mystep;
			}
		}
		if(strlen($watermark_yes)>2) {
			$db->Query("update ".$setting['db']['pre']."attachment set watermark=1 where id in ({$watermark_yes})");
		}
		if(strlen($watermark_no)>2) {
			$db->Query("update ".$setting['db']['pre']."attachment set watermark=0 where id in ({$watermark_no})");
		}
		$close_win = true;
		break;
	case "edit":
		$news_id = $req->getGet("news_id");
		$attach_list = $req->getGet("attach_list");
		echo <<<mystep
		<form name="attach_edit" method="post" action="?method=edit_ok" onsubmit="return setWatermark()">
		<script language="JavaScript">
		function check_it(group, mode) {
			var all_box = document.getElementsByName(group);
			for(var i=0; i<all_box.length; i++) {
				all_box[i].checked = mode;
			}
			return;
		}
		function setWatermark() {
			var all_box = document.getElementsByName('watermark[]');
			var watermark_yes = watermark_no = "";
			for(var i=0; i<all_box.length; i++) {
				if(all_box[i].checked) {
					watermark_yes += all_box[i].value + ",";
				} else {
					watermark_no += all_box[i].value + ",";
				}
			}
			document.getElementById('watermark_yes').value = watermark_yes + "0";
			document.getElementById('watermark_no').value = watermark_no + "0";
			return true;
		}
		</script>
		<style>
			#page_ole {margin:auto; min-width:100px; padding:20px 0px 20px 0px;}
			td {padding:5px 5px 5px 5px;}
		</style>
		<input type="hidden" id="watermark_yes" name="watermark_yes" value=""><input type="hidden" id="watermark_no" name="watermark_no" value="">
		<table align="center" width="560" border="1" bordercolorlight="#000000" bordercolordark="#FFFFFF" cellpadding="0" cellspacing="0">
			<tr class="cat">
				<td>删除</td><td>文件名</td><td>文件类型</td><td>文件大小</td><td>上传时间</td><td>下载次数</td><td>水印</td>
			</tr>
mystep;
		$attach_list = split("\|", $attach_list);
		$qrl_str = "select * from ".$setting['db']['pre']."attachment where ";
		$max_count = count($attach_list);
		for($i=0; $i<$max_count; $i++) {
			if(!empty($attach_list[$i])) $qrl_str .= "id={$attach_list[$i]} or ";
		}
		$qrl_str .= (empty($news_id) ? "1=0" : "news_id={$news_id}");
		$db->Query($qrl_str);
		$att_more = true;
		while($record = $db->GetRS()) {
			$att_more = false;
			$record['checkeds'] = $record['watermark'] ? "checked" : "";
			echo "
			<tr class='row'>
				<td align='center'><input type='checkbox' name='del_att[]' value='".$record['id']."::".$record['file_time'].strrchr($record['file_name'],".")."'></td>
				<td><a href='?method=download&id=".$record['id']."' target='_blank'>".$record['file_name']."</a></td>
				<td>".$record['file_type']."</td>
				<td align='right'>".$record['file_size']."</td>
				<td>".$record['file_time']."</td>
				<td align='center'>".$record['file_count']."</td>
				<td align='center'><input type='checkbox' name='watermark[]' value='{$record['id']}' {$record['checkeds']}></td>
			</tr>
			";
		}
		if($att_more) {
			echo "<script>alert('当前文档不存在附件！');self.close();</script>";
		}
		echo <<<mystep
			<tr class="cat">
				<td align='center'><input type="checkbox" onclick="check_it('del_att[]', this.checked)"></td>
				<td colspan="5" align="center">全部选取</td>
				<td align='center'><input type="checkbox" onclick="check_it('watermark[]', this.checked)"></td>
			</tr>
		</table>
		<table align="center">
			<tr>
				<td align="center" colspan="2"><br>
					<input type="Submit" value=" 确 定 " name="Submit">&nbsp;&nbsp;
					<input type="button" value=" 关 闭	" name="return" onClick="self.close()">
				</td>
			</tr>
		</table>
		</form>
mystep;
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
			} else {
				header("HTTP/1.0 404 Not Found");
			}
		}
		$mystep->pageEnd(false);
		break;
	default:
		$close_win = true;
}
if($close_win) {
	echo <<<mystep
<script>
	self.close();
	location.href = "/";
</script>
mystep;
}

$content = ob_get_contents();
ob_clean();
$tpl->Set_Variable("main", $content);
$mystep->show($tpl);
$mystep->pageEnd(false);
?>