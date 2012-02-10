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
<script language="JavaScript" src="../../script/addon.js"></script>
</head>
<body>
<div id="page_ole">
	<div id="page_main">
<div class="title"><!--title--></div>
<div align="center">
	<script type="text/javascript" src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="if(!checkForm(this)){loadingShow();return false}">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">邮件主题：</td>
				<td class="row">
					<input name="subject" type="text" value="<!--subject-->" maxlength="120" need="" />
					<input type="hidden" name="id" value="<!--id-->" />
					<input type="hidden" name="send_date" value="<!--send_date-->" />
					<select name="priority" style="width:40px;">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
					</select>
					<select name="single" style="width:80px;">
						<option value="0">统一发送</option>
						<option value="1">逐个发送</option>
					</select>
					（<!--send_date-->）
				</td>
			</tr>
			<tr>
				<td colspan="2" class="cat">邮件格式可以为标准邮件地址，也可以为“发件人名称 <邮件地址>”的格式，每行一个邮件地址</td>
			</tr>
			<tr>
				<td class="cat">发件地址：</td>
				<td class="row">
					<input name="from" type="text" value="<!--from-->" maxlength="80" need="" /> &nbsp; 
					<input name="notification" id="notification" type="checkbox" class="cbox" value="checked" <!--notification--> /><label for="notification">阅读收条</label>
				</td>
			</tr>
			<tr>
				<td class="cat">回复地址：</td>
				<td class="row">
					<textarea name="reply" style="width:100%;height:54px;" need="" /><!--reply--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat">接收地址：</td>
				<td class="row">
					<textarea name="to" style="width:100%;height:54px;" /><!--to--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat">抄送地址：</td>
				<td class="row">
					<textarea name="cc" style="width:100%;height:54px;" /><!--cc--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat">暗送地址：</td>
				<td class="row">
					<textarea name="bcc" style="width:100%;height:54px;" /><!--bcc--></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="cat">请输入合法的邮件头，每行一个。如果不了解，请不要随便填写，错误的邮件头会造成邮件无法正确发送</td>
			</tr>
			<tr>
				<td class="cat">邮 件 头：</td>
				<td class="row">
					<textarea name="header" style="width:100%;height:54px;" need="" /><!--header--></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="cat">邮件内容：</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>
						<textarea id="content" name="content" style="width:100%; height:400px;"><!--content--></textarea>
					</div>
				<td>
			</tr>
			<tr>
				<td class="cat">邮件附件：</td>
				<td class="row">
					<div id="attachment_list"></div>
					<input type="hidden" id="attachment" name="attachment" value="<!--attachment-->" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>
						<iframe src="attachment.php" name="attach" width="720" height="25" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" ALLOWTRANSPARENCY="true" onload="setIframe()"></iframe>
					</div>
				<td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="row">
					<input class="btn" type="Submit" onclick="loadingShow()" value=" 发 送 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<div id="bar_loading"><img src="../../images/loading.gif" alt="邮件发送" width="400" height="10" /><br / >正在发送邮件，请耐心等待！</div>
<script type="text/javascript" src="../../script/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	mode : "exact",
	elements : "content",
	language : "zh",
	theme : "advanced",
	plugins : "quote,bbscode,advlink,advimage,subtitle,safari,pagebreak,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,insertdatetime,visualchars,nonbreaking,xhtmlxtras,template",

	theme_advanced_buttons1 : "fullscreen,preview,|,undo,redo,newdocument,removeformat,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor,|,sub,sup",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,bbscode,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,media,|,insertdate,inserttime,charmap,|,code",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
	
	content_css: "../images/editor.css",
	entity_encoding : "raw",
	add_unload_trigger : false,
	remove_linebreaks : false,
	
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",
	
	template_replace_values : {
		username : "mystep",
		staffid : "31415926"
	}
});
function setIframe() {
	$name('attach', 0).height = 0;
	$name('attach', 0).height = $("iframe[name=attach]").contents().find("body").get(0).scrollHeight;
}
$(function(){
	$("select[name=priority]").val(<!--priority-->);
	$("select[name=single]").val(<!--single-->);
	if($id("attachment").value.length>0) {
		var data = $id("attachment").value.replace(/\r/g, "").split("\n");
		for(var i=0,m=data.length;i<m;i++) {
			if(data[i]=="") continue;
			data[i] = data[i].split("|");
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
						$("iframe[name=attach]").attr("src", "attachment.php?method=delete&idx="+$(this).attr("idx"));
					}
				}
			).appendTo($("#attachment_list"));
		}
	}
	return;
});
</script>
	</div>
</div>
</body>
</html>