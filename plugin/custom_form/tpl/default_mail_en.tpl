<div class="title">用户确认信发送</div>
<div align="left">
<form method="post" action="?method=mail">
<TABLE BORDER="0" WIDTH="700" CELLSPACING="1" CELLPADDING="2" ALIGN="center">
	<TR>
		<TD>
			<BR />
			<div style="text-align:center;font-size:20px;font-weight:bold;">代表ID：<!--record_id--></div>
			<BR />
			<div>下面是默认邮件的内容，发送前请根据实际情况修改。</div>
			<BR />
			<input type="hidden" name="mid" value="<!--mid-->" />
			<b>邮件主题：</b><input type="text" name="subject" value="<!--name_en-->" size="50" /><BR /><BR />
			<b>邮件地址：</b><input type="text" name="email" value="<!--record_email-->" size="50" /><BR /><BR />
			<b>发 件 人：</b><input type="text" name="sender_name" value="" size="50" /><BR /><BR />
			<b>回复地址：</b><input type="text" name="sender_email" value="" size="50" /><BR /><BR />
			<textarea name="content" cols="110" rows="40" id="content">
Dear <span style="font-weight:bold;color:#aa0000"><!--record_name_en--></span> :<br />
<br />
Welcome to <b>"<!--name_en-->"</b>！
<br />
Your online registration has been received. Please confirm the following information has been recorded correctly:<br /><br />
<?php
global $record;
foreach($para as $key => $value) {
	if(empty($value['title_en'])) continue;
	if(is_array($value['value'])) {
		$idx = array_search($record[$key], $value['value']['cn']);
		if(!is_null($idx)) {
			$record[$key] = $value['value']['en'][$idx];
		}
	}
	echo "<b>".$value['title_en']."：</b> ";
	if($value['type']=='file') {
		$data = explode("::", $record[$key]);
		$path = "http://".$setting['info']['web']['host'].dirname($_SERVER["PHP_SELF"])."/";
		if(strpos($data, "image/")!==false) {
			echo '<a href="'.$path.'file.php?mid='.$mid.'&id='.$id.'&f='.$key.'" target="_blank"><img src="file.php?mid='.$mid.'&id='.$id.'&f='.$key.'" height="80" /></a>';
		} else {
			echo '<a href="'.$path.'file.php?mid='.$mid.'&id='.$id.'&f='.$key.'" target="_blank">'.$data[0].'</a>';
		}
	} else {
		echo $record[$key];
	}
	echo "<br />";
}
?>
<br />
Please check-in and pay for your room charge at the hotel's reception on your arrival.<br />
<br />
Please remit your registration fee <!--record_total--> RMB:<br />
<b>Beneficiary Name:</b> CFNA<br />
<b>Account No.</b> 110060194145300004859 (for USD) / 110060194385300004948 (for EUR)<br />
<b>Name of Bank:</b> Bank of Communications Beijing Branch<br />
<b>Address of Bank:</b> No.33, Jinrong Str., Xicheng Dist.,Beijing, 100032 China<br />
<b>Swift Code:</b> COMMCNSHBJG<br />
 <br />
<span style="font-weight:bold;color:#aa0000"><!--name_en--></span><br />
<b>Tel:</b> +86-10-87109800<br />
<b>Fax:</b> +86-10-87109800<br />
<b>Email:</b> cccfna@cccfna.org.cn<br />
<b>website:</b> <?=$setting['web']['url']?>
			</textarea>
		</TD>
	</TR>
	<TR>
		<TD HEIGHT="30" ALIGN="CENTER">
			<input style="padding:10px;margin:10px;" type="submit" value="使用系统程序发送" />
			<input style="padding:10px;margin:10px;" type="button" value="使用邮件程序发送" onclick="formmail('<!--record_email--> ', '<!--name_en-->', tinyMCE.get('content').getContent());" />
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
