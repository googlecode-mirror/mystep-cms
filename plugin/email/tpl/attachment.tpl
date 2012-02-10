<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--> - 后台管理</title>
<meta http-equiv="Pragma" contect="no-cache">
<meta http-equiv="Expires" contect="-1">
<meta http-equiv="windows-Target" contect="_top">
<meta http-equiv="Content-Type" content="text/html; charset=<!--charset-->" />
<link rel="stylesheet" type="text/css" media="all" href="../../<!--path_admin-->/style.css" />
<script language="JavaScript" src="../../script/jquery.js"></script>
<script language="JavaScript" src="../../script/jquery.addon.js"></script>
<script language="JavaScript" src="../../script/global.js"></script>
<script language="JavaScript" src="../../script/admin.js"></script>
</head>
<body>
<div id="page_ole">
	<div id="page_main">
<form name="upload" method="post" ACTION="?method=add" ENCTYPE="multipart/form-data">
	<table border="0" cellspacing="0">
		<tr id="load">
			<td style="padding:10px 10px 10px 10px;">
				<input type="hidden" name="MAX_FILE_SIZE" value="<!--MaxSize-->">
				<div id="files">
					<div style="padding-bottom:5px; display:none;">
						<b>选择文件：</b>
						<select name="embed[]">
							<option value="0">附件</option>
							<option value="1">嵌入</option>
						</select> &nbsp;
						<input type="file" name="the_file[]" onchange="upload_add_file();" />
					</div>
				</div>
				<div style="padding-bottom:5px;">
					<input type="button" name="Submit" value=" 上传附件 " onclick="check()" />
					(文件大小限制：<font color='red'><!--Max_size--></font>)
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
	</div>
</div>
</body>
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
	if($("#files div").length>max_upload ) {
		alert("同时最多上传 " + max_upload + " 个文件！");
		return;
	}
	var obj = $("#files div:first");
	obj.clone().appendTo("#files").show();
	parent.setIframe();
	return;
}
function setAttachment(data) {
	for(var i=0,m=data.length; i<m; i++) {
		parent.$id("attachment").value += data[i].join("|")+"\n";
		$("<span />").html(data[i][1]).attr("idx", data[i][0]).css({"background-color":"#cccccc","cursor":"pointer","padding":"2px 6px 2px 6px","margin-right":"10px"}).hover(
			function() {
				$(this).css("background-color","#999999");
			},
			function() {
				$(this).css("background-color","#cccccc");
			}
		).click(
			function() {
				if(confirm("是否确认删除该附件？")) {
					$("iframe[name=attach]", parent.document.body).attr("src", "attachment.php?method=delete&idx="+$(this).attr("idx"));
				}
			}
		).appendTo(parent.$("#attachment_list"));
		if(data[i][3]==1) {
			var content, html;
			content = parent.tinyMCE.get('content').getContent();
			if(data[i][2].indexOf("image")!=-1) {
				html = '<img id="'+data[i][0]+'" src="'+data[i][1]+'" title="插入图片占位" alt="插入图片占位" />';
			} else {
				html = '<a id="'+data[i][0]+'" href="'+data[i][1]+'">'+data[i][1]+'</a>';
			}
			content += "\n<br />\n"+html;
			parent.tinyMCE.get('content').setContent(content);
		}
	}
}
function delAttachment(idx) {
	parent.$id("attachment").value = parent.$id("attachment").value.replace(new RegExp(idx+".+\n"),"");
	parent.$("#attachment_list").find("span[idx="+idx+"]").remove();
	var content = parent.tinyMCE.get('content').getContent();
	var re = new RegExp("<a id\\=\""+idx+".+?<\\/a>", "g");
	content = content.replace(re, "");
	re = new RegExp("<img id\\=\""+idx+".+? />", "g");
	content = content.replace(re, "");
	parent.tinyMCE.get('content').setContent(content);
}
$(function(){
	upload_add_file();
	<!--script-->
	parent.setIframe();
});
</script>
</html>