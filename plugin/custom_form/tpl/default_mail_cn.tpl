<div class="title">用户确认信发送</div>
<div align="left">
<form method="post" action="?method=mail" onsubmit="return send_mail()">
<TABLE BORDER="0" WIDTH="700" CELLSPACING="1" CELLPADDING="2" ALIGN="center">
	<TR>
		<TD>
			<BR />
			<div style="text-align:center;font-size:20px;font-weight:bold;">代表ID：<!--record_id--></div>
			<BR />
			<div>下面是默认邮件的内容，发送前请根据实际情况修改。</div>
			<BR />
			<input type="hidden" name="mid" value="<!--mid-->" />
			<input type="hidden" name="subject" value="<!--name-->" />
			<input type="hidden" name="email" value="<!--record_email-->" />
			<input type="hidden" name="sender_name" value="" />
			<input type="hidden" name="sender_email" value="" />
			<textarea name="content" cols="110" rows="40" id="content">
尊敬的 <span style="font-weight:bold;color:#aa0000"><!--record_name--></span><br />
欢迎您参加<b>“<!--name-->”</b>！<br />
您填表信息已经收到。请确认下列表单信息正确无误：<br /><br />
<?php
global $record;
foreach($para as $key => $value) {
	if($value['manager']=='true') continue;
	if(empty($value['title'])) continue;
	echo "<b>".$value['title']."：</b> ".$record[$key]."<br />";
}
?>
<br />
<span style="font-weight:bold;color:#aa0000"><!--name--></span><br />
<b>Tel:</b> +86-10-87109800<br />
<b>Fax:</b> +86-10-87109800<br />
<b>Email:</b> windy2006@gmail.com<br />
<b>website:</b> <?=$setting['web']['url']?><br />
			</textarea>
		</TD>
	</TR>
	<TR>
		<TD HEIGHT="30" ALIGN="CENTER">
			<input style="padding:10px;margin:10px;" type="submit" value="系统程序发送" />
			<input style="padding:10px;margin:10px;" type="button" value="邮件程序发送" onclick="send_mail_app('<!--record_email--> ', '<!--name-->', tinyMCE.get('content').getContent());" />
			<input style="padding:10px;margin:10px;" type="button" class="normal" value="返回列表页面" name="return" onClick="history.go(-1)" />
		</TD>
	</TR>
</TABLE>
</form>
</div>

<script language="JavaScript" type="text/javascript" src="../../script/tinymce/jquery.tinymce.js"></script>
<script language="JavaScript" type="text/JavaScript">
//<![CDATA[
var the_email = "<?=$record['email']?>";

function send_mail_app(email, subject, content)	{
	if(the_email.length<5) {
		alert("无可用 Email，请核实数据！");
		return;
	}
	subject = subject.replace(/&/g, "%26");
	subject = subject.replace(/\s/g, "%20");
	subject = subject.replace(/#/g, "%23");
	subject = UrlEncode(subject);
	
	if(content.length>1000) {
		content = content.replace(/<br(.+?)>/g, "\n");
		content = content.replace(/<(\/)?\w+[^>]*>/g, "");
		content = content.replace(/&/g, "%26");
		content = content.replace(/\s/g, "%20");
		content = content.replace(/#/g, "%23");
		content = content.replace(/\n/g, "%0D%0A");
	} else {
		content = UrlEncode(content);
	}
	
	if(content.length>1900) {
		window.location="mailto:"+email+"?subject="+subject+"&body="+UrlEncode("由于邮件内容过长，无法自动调用邮件程序！<br /><br />请将内容直接复制到邮件程序，或通过系统程序发送！");
	} else {
		window.location="mailto:"+email+"?subject="+subject+"&body="+content;
	}
}

function send_mail() {
	if(the_email.length<5) {
		alert("无可用 Email，请核实数据！");
		return false;	
	}
	loadingShow("正在发送邮件，稍后会返回列表页面！");
	return true;
}

$(function() {
	var new_setting = {};
	new_setting.plugins = "safari,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template";
	new_setting.theme_advanced_buttons1 = "fullscreen,preview,|,undo,redo,newdocument,removeformat,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor,|,sub,sup";
	new_setting.theme_advanced_buttons2 = "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,media,|,insertdate,inserttime,charmap,|,code";
	new_setting.forced_root_block = "p";
	tinyMCE_init("content", new_setting);
});

//]]>
</script>
