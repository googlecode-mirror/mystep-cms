<html>
<head>
<title>图片上传</title>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<style type="text/css">
body {
	Font-Size: 12px;
	border: 0px;
	margin: 0px;
	padding: 0px;
	background-color: buttonface;
	font-family: 宋体,Arial;
	cursor: default;
}
td {
	Font-Size: 12px;
}
input {
	Font-Size: 12px;
	height: 18px;
	padding: 0px;
}
</style>
<script language="JavaScript" src="../script/global.js"></script>
<script language="JavaScript">
<?php
require("../include/config.php");
$parent_element = $_SERVER['QUERY_STRING'];
if(empty($parent_element)) $parent_element = "image";
if(count($_POST) > 0){
	require("../source/function/global.php");
	require("../source/class/abstract.class.php");
	require("../source/class/myuploader.class.php");
	$path_upload = $setting['path']['upload']."/pic/".date("Ym")."/";
	$upload = new MyUploader;
	$upload->init("../".$path_upload, true);
	$upload->DoIt();
	if($upload->upload_result[0]['error'] == 0) {
		echo "
			if(parent.dialogArguments) {
				parent.dialogArguments.document.forms[0].{$parent_element}.value = '{$web_url}/{$path_upload}/".$upload->upload_result[0]['new_name']."';
			} else if(parent.opener) {
				parent.opener.document.forms[0].{$parent_element}.value = '{$web_url}/{$path_upload}/".$upload->upload_result[0]['new_name']."';
			}
		";
		echo "alert('图像已成功上传');\n";
		echo "parent.close();\n";
	} else {
		echo "alert('".$upload->upload_result[0]['message']."');\n";
		echo "parent.close();\n";
	}
	echo "
</script>
</head>
</html>
	";
	exit();
} else {
	echo "
	if(typeof(window.dialogArguments)=='undefined' && typeof(window.opener)=='undefined') {
		self.close();
		location.href = '/';
	}
	";
}
?>

function check_img(the_file){
	var ext_list = "gif,jpg,png,swf";
	if(the_file.lastIndexOf(".") == -1) return false;
	var the_ext  = the_file.substr(the_file.lastIndexOf(".")+1).toLowerCase();
	return ext_list.indexOf(the_ext)!=-1?true:false;
}

function check(){
  if (document.upload.the_file.value.length==0){
	alert("上传文件不能为空！");
	document.upload.the_file.focus();
  }else if(check_img(document.upload.the_file.value)){
  	document.getElementById("load").style.display = "none";
  	document.getElementById("wait").style.display = "";
		document.upload.submit();
  }else{
 	alert("只能上传图形文件！");
 	document.upload.the_file.outerHTML = document.upload.the_file.outerHTML;
	document.upload.the_file.focus();
  }
}

window.focus();
if(window.opener!=undefined) window.resizeTo(400,160);
</script>
</head>
<body scroll="no">
<br />
<form name="upload" method="post" ACTION="<?=basename(__FILE__)."?".$parent_element?>" target="upload_img" ENCTYPE="multipart/form-data" >
  <table border="0" cellspacing="0" align="center">
    <tr id=load>
      <td>
<?php
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
echo "	  <input type='hidden' name='MAX_FILE_SIZE' value='{$Max_size}'>\n";
?>
	上传图像：
	<input type="file" name="the_file" size="35"><br /><br />
	<center>
	  <input type="button" name="Submit" value=" 上 传 " onclick="check()">
	  <?=$str?>
	  <input type="button" name="Close" value=" 关 闭 " onclick="self.close()">
	</center>
      </td>
    </tr>
    <tr id=wait style="display:none">
      <td align="center">
        正在上传，请稍侯......
      </td>
    </tr>
  </table>
</form>
<iframe scrolling="no" name="upload_img" src="about:blank" MARGINHEIGHT="0" MARGINWIDTH="0" style="display:none;"></iframe>
</body>
</html>