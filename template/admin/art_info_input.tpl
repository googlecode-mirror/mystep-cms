<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">所属子站：</td>
				<td class="row">
					<select name="web_id">
						<option value="0">未限定</option>
<!--loop:start key="website"-->
						<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
					<span class="comment">（当前内容所属的子网站）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">展示标题：<span>*</span></td>
				<td class="row">
					<input name="subject" type="text" id="title" value="<!--subject-->" maxlength="100" need="" />
					<input type="hidden" name="id" value="<!--id-->" />
					<span class="comment">（用于info标签的title属性）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">展示内容：</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<div>
						<textarea name="content" id="content" style="width:100%; height:400px;"><!--content--></textarea>
					</div>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
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
<script type="text/javascript" language="JavaScript" src="../script/tinymce/jquery.tinymce.js"></script>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
$(function() {
	$('textarea').tinymce({
		// Location of TinyMCE script
		script_url : '../script/tinymce/tiny_mce.js',

		// General options
		language : "cn",
		theme : "advanced",
		plugins : "bbscode,source_code,style,table,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,insertdatetime,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "fullscreen,preview,|,undo,redo,removeformat,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor,|,tablecontrols",
		theme_advanced_buttons2 : "upload,|,hr,styleprops,sub,sup,|,cut,copy,paste,pastetext,pasteword,bbscode,source_code,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,media,showImage,|,insertdate,inserttime,charmap,|,format,code,change",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		
		// Custom settings
		preformatted : false,
		remove_linebreaks : false,
		apply_source_formatting : true,
		convert_fonts_to_spans : true,
		verify_html : true,
		paste_auto_cleanup_on_paste : true,
		dialog_type : "modal",
		relative_urls : true,
		invalid_elements : "script",
		extended_valid_elements : "form[action|method|name],"+
															"textarea[class|type|title|name|rows|cols],"+
															"input[type|name|value|checked|src|alt|size|maxlength],"+
															"button[name|value|type],"+
															"select[name|size|multiple|onchange],"+
															"iframe[src|frameborder=0|width|height|align|scrolling|name],"+
															"center,"+
															"script[charset|defer|language|src|type]",
		forced_root_block : "div",
		flash_wmode : "transparent",
		flash_quality : "high",
		flash_menu : "false",

		// Example content CSS (should be your site CSS)
		content_css : "../images/editor.css",
		entity_encoding : "raw",
		add_unload_trigger : false,

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Custom Functions
		handle_event_callback : function(e) {
			if(e.ctrlKey && e.keyCode==13) {
				if(checkForm(document.forms[0], checkForm_append)) document.forms[0].submit();
			}
		},
		oninit : function() {
			var content = tinyMCE.get('content').getContent();
			content = content.replace(/mce\:script/g, "script");
			content = content.replace(/_mce_src/g, "src");
			tinyMCE.get('content').setContent(content);
		},

		setup : function(ed) {
			ed.addButton('upload', {
				title : '附件上传',
				image : 'images/file.gif',
				onclick : function() {
					showPop('upload','附件上传','url','attachment.php?method=add',560, 150);
				}
			});
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
			ed.addButton('showImage', {
				title : '图片展示',
				image : 'images/show.png',
				onclick : function() {
					var theContent = ed.selection.getContent();
					var result = "";
					if(theContent.length<10) return;
					var img_list = theContent.match(/<img.+?src=('|")?.+?\1.*?>/ig);
					if(img_list == null) return;
					for(var i=0,m=img_list.length;i<m;i++) {
						if(img_list[i].match(/src=('|")?(.+?)\1/i)) {
							theContent = theContent.replace(img_list[i], "");
							result += '<img src="' + RegExp.$2 + '" />';
						}
					}
					ed.execCommand('mceReplaceContent', false, theContent);
					theContent = ed.getContent().match(/<div id\="ms_showImage">.+?<\/div>/);
					if(theContent!=null) {
						result = theContent[0].replace("</div>", result + "</div>");
						theContent = ed.getContent().replace(theContent[0], "") + result;
					} else {
						theContent = ed.getContent() + '\n<div id="ms_showImage">' + result + '</div>';
					}
					theContent = theContent.replace(/<(\w+)(.*?)>[\xa0\r\n\s\u3000]+<\/\1>[\r\n]*/ig, "");
					ed.setContent(theContent);
				}
			});
			ed.onDblClick.add(function(ed, e) {
				e = e.target;
				if(e.nodeName === 'IMG') {
					if(confirm("是否将 "+e.src+" 设定为新闻标题图?")) {
						$id("image").value = e.src;
					}
				} else if(e.nodeName === 'A') {
					if(confirm("是否将 "+e.href+" 设定为跳转网址?")) {
						$id("link").value = e.href;
					}
				}
			});
		},

		// Replace values for the template plugin
		template_replace_values : {
			username : "mystep",
			staffid : "31415926"
		}
	});
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
//]]> 
</script>
