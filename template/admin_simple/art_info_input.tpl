<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">展示标题：<span>*</span></td>
				<td class="row">
					<input name="subject" type="text" id="title" value="<!--subject-->" maxlength="100" need="" />
					<input type="hidden" name="id" value="<!--id-->" />
					<input type="hidden" name="web_id" value="<!--web_id-->" />
					<span class="comment">（用于info标签的title属性）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">展示内容：</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<div>
						<textarea name="content" style="width:100%; height:400px;"><!--content--></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="row">
					<input class="btn" name="attach_list" type="hidden" value="<!--attach_list-->">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 附 件 " onclick="attach_edit()" />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript" src="../script/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
if(typeof($.setupJMPopups)=="undefined") $.getScript("../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});
tinyMCE.init({
	mode : "textareas",
	language : "zh",
	theme : "advanced",
	plugins : "safari,pagebreak,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	theme_advanced_buttons1 : "newdocument,fullscreen,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor,|,sub,sup,|,charmap,media",
	theme_advanced_buttons2 : "upload,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,removeformat,code,preview,change",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
	content_css : "css/content.css",

	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",
	
	setup : function(ed) {
		ed.addButton('upload', {
			title : 'upload',
			image : 'images/file.gif',
			onclick : function() {
		     showPop('upload','附件上传','url','attachment.php?method=add',560, 150);
		  }
		});
		ed.addButton('change', {
			title : 'Div Mode',
			image : 'images/div.png',
			onclick : function() {
				var content = tinyMCE.get('content').getContent();
				if(content.indexOf("<div>")==-1) {
					content = content.replace(/<p>(.+?)<\/p>/ig, "<div>$1</div>");
				} else {
					content = content.replace(/<div>(.+?)<\/div>/ig, "<p>$1</p>");
				}
				tinyMCE.get('content').setContent(content);
		  }
		});
	},

	dialog_type : "modal",
	relative_urls : true,
	remove_linebreaks : false,
	invalid_elements : "",
	event_elements : "a,img,span,div",
	extended_valid_elements : "iframe[src|frameborder=0|width|height|align|scrolling|name],"+
							"script[src|type|language],"+
							"form[action|method|name],"+
							"center,"+
							"input[type|name|value|checked|src|alt|size|maxlength],"+
							"button[name|value|type],"+
							"select[name|size|multiple|onchange],"+
							"textarea[name|rows|cols]",
	
	flash_wmode : "transparent",
	flash_quality : "high",
	flash_menu : "false",
	
	handle_event_callback : "myHandleEvent",

	template_replace_values : {
		username : "mystep",
		staffid : "31415926"
	}
});

function myHandleEvent(e) {
	if (e.type=="blur") {
		if (tinyMCE.selectedInstance){
			tinyMCE.selectedInstance.formElement.value = tinyMCE.selectedInstance.getHTML();
		}
	}
	return true;
}

function setIframe(idx) {
	if($id("popupLayer_"+idx)) {
		theFrame = $("#popupLayer_"+idx).find("iframe");
		theHeight = theFrame.contents().find("body")[0].scrollHeight + 20;
		if(theHeight>650) theHeight = 650;
		theFrame.height(theHeight);
		$("#popupLayer_"+idx).height($("#popupLayer_"+idx+"_title").height()+theHeight);
		$("#popupLayer_"+idx+"_content").height(theHeight);
	}
}

function attach_add(str) {
	tinyMCE.execCommand("mceInsertContent", false, str);
}

function attach_remove(aid) {
	var content;
	content = tinyMCE.get('content').getContent();
	var re = new RegExp("<a id\\=\"att_"+aid+".+?<\\/a>", "ig");
	content = content.replace(re, "");
	tinyMCE.get('content').setContent(content);
	return;
}

function attach_edit() {
	showPop('attach','附件管理','url','attachment.php?method=edit&attach_list='+document.forms[0].attach_list.value, 600, 200);
	return;
}
</script>
