<div class="title">Send Confirm Email</div>
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
			<input type="hidden" name="subject" value="<!--name_en-->" />
			<input type="hidden" name="email" value="<!--record_email-->" />
			<TEXTAREA name="content" COLS="110" ROWS="40" id="content">
Dear <span style="font-weight:bold;color:#aa0000"><!--record_name_en--></span> :<br />
<br />
Welcome to <b>"<!--name_en-->"</b>！<br />
<br />
Your online submit information has been received. Please confirm the following information has been recorded correctly:<br />
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
	echo "<b>".$value['title_en']."：</b>".$record[$key]."<br />\n";
}
?>
<br />
<span style="font-weight:bold;color:#aa0000"><!--name_en--></span><br />
<b>Tel:</b> +86-10-87109800<br />
<b>Fax:</b> +86-10-87109800<br />
<b>Email:</b> windy2006@gmail.com<br />
<b>website:</b> <?=$setting['web']['url']?><br />
			</TEXTAREA>
		</TD>
	</TR>
	<TR>
		<TD HEIGHT="30" ALIGN="CENTER">
			<input style="padding:10px;margin:10px;" type="submit" value="系统程序发送" />
			<input style="padding:10px;margin:10px;" type="button" value="邮件程序发送" onclick="send_mail_app('<!--record_email--> ', '<!--name_en-->', tinyMCE.get('content').getContent());" />
			<input style="padding:10px;margin:10px;" type="button" class="normal" value="返回列表页面" name="return" onClick="history.go(-1)" />
		</TD>
	</TR>
</TABLE>
</form>
</div>
<script type="text/javascript" language="JavaScript" src="../../script/tinymce/tiny_mce.js"></script>
<script language="JavaScript" type="text/JavaScript">
//<![CDATA[
var the_email = "<?=$record['email']?>";
function send_mail_app(email, subject, content)	{
	if(the_email.length<5) {
		alert("无可用 Email，请核实数据！");
		return;
	}
	//content = content.replace(/<(\/)?\w+[^>]+>/g, "");
	content = content.replace(/&/g, "%26");
	content = content.replace(/\n/g, "%0D%0A");
	content = content.replace(/\s/g, "%20");
	content = content.replace(/#/g, "%23");
	content = UrlEncode(content);
	subject = subject.replace(/&/g, "%26");
	subject = subject.replace(/\s/g, "%20");
	subject = subject.replace(/#/g, "%23");
	subject = UrlEncode(subject);
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

tinyMCE.init({
	mode : "exact",
	elements : "content",
	language : "zh",
	theme : "advanced",
	plugins : "safari,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	theme_advanced_buttons1 : "fullscreen,preview,|,undo,redo,newdocument,removeformat,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor,|,sub,sup,format",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,media,|,insertdate,inserttime,charmap,|,code,change",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
	
	content_css: "../../images/editor.css",
	entity_encoding : "raw",
	add_unload_trigger : false,
	
	preformatted : false,
	remove_linebreaks : false,
	apply_source_formatting : true,
	convert_fonts_to_spans : true,
	verify_html : true,
	paste_auto_cleanup_on_paste : true,
	extended_valid_elements : "textarea[class|type|title],script[charset|defer|language|src|type]",
	forced_root_block : "div",
	force_br_newlines : true,
	force_p_newlines : false,
	
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",
	
	oninit : function() {
		var content = tinyMCE.get('content').getContent();
		content = content.replace(/mce\:script/g, "script");
		content = content.replace(/_mce_src/g, "src");
		content = content.replace(/\n/g, "<br />\n");
		tinyMCE.get('content').setContent(content);
	},
	
	setup : function(ed) {
		ed.addButton('change', {
			title : 'Div/P 模式切换',
			image : 'images/div.png',
			onclick : function() {
				var content = tinyMCE.get('content').getContent();
				if(content.indexOf("<div")==-1) {
					content = content.replace(/<p(.*?)>([\w\W]+?)<\/p>/ig, "<div$1>$2</div>");
				} else {
					content = content.replace(/<div(.*?)>([\w\W]+?)<\/div>/ig, "<p$1>$2</p>");
				}
				tinyMCE.get('content').setContent(content);
			}
		});
		ed.addButton('format', {
			title : '代码清理',
			image : 'images/format.png',
			onclick : function() {
				var content = tinyMCE.get('content').getContent();
				if(content.indexOf("<div")==-1) {
					content = content.replace(/(<br(\s\/)?>)+/ig, "</p><p>");
					content = content.replace(/<p(.*?)>[\xa0\r\n\s\u3000]+/ig, "<p$1>");
					content = content.replace(/<\/p><p/g, "<\/p>\n<p");
				} else {
					content = content.replace(/(<br(\s\/)?>)+/ig, "</div><div>");
					content = content.replace(/<div(.*?)>[\xa0\r\n\s\u3000]+/ig, "<div$1>");
					content = content.replace(/<\/div><div/g, "<\/div>\n<div");
				}
				content = content.replace(/mso\-[^;]+?;/ig, "");
				content = content.replace(/[\xa0]/g, "");
				content = content.replace(/<\/td>/g, "&nbsp;</td>");
				while(content.search(/<(\w+)[^>]*><\!\-\- pagebreak \-\-\><\/\1>[\r\n\s]*/)!=-1) content = content.replace(/<(\w+)[^>]*><\!\-\- pagebreak \-\-\><\/\1>[\r\n\s]*/g, "<!-- pagebreak -->");
				while(content.search(/<(\w+)[^>]*>[\s\r\n]*<\/\1>[\r\n\s]*/)!=-1) content = content.replace(/<(\w+)[^>]*>[\s\r\n]*<\/\1>[\r\n\s]*/g, "");
				while(content.search(/<\/(\w+)><\1([^>]*)>/g)!=-1) content = content.replace(/<\/(\w+)><\1([^>]*)>/g, "");
				content = content.replace(/  /g, String.fromCharCode(160)+" ");
				tinyMCE.get('content').setContent(content);
			}
		});
	},
	
	template_replace_values : {
		username : "mystep",
		staffid : "31415926"
	}
});
//]]>
</script>
