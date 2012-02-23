<div class="title"><!--title--></div>
<div align="center">
	<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="80">新闻标题：</td>
				<td class="row">
				<input id="title" name="subject" type="text" maxlength="150" need="" value="<!--record_subject-->">
				<input name="id" type="hidden" value="<!--record_id-->">
				<input name="idx" type="hidden" value="<!--record_idx-->">
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">来源网站：</td>
				<td class="row"><input name="original" type="text" value="<!--record_original-->" maxlength="60" need=""></td>
			</tr>
			<tr>
				<td class="cat" width="80">新闻网址：</td>
				<td class="row"><input name="url" type="text" value="<!--record_url-->" maxlength="150" need="url"></td>
			</tr>
			<tr>
				<td class="cat" width="80">采集文本 1：</td>
				<td class="row"><input name="item_1" type="text" value="<!--record_item_1-->" maxlength="150"></td>
			</tr>
			<tr>
				<td class="cat" width="80">采集文本 2：</td>
				<td class="row"><input name="item_2" type="text" value="<!--record_item_2-->" maxlength="150"></td>
			</tr>
			<tr>
				<td class="cat" width="80">采集文本 3：</td>
				<td class="row"><input name="item_3" type="text" value="<!--record_item_3-->" maxlength="150"></td>
			</tr>
			<tr>
				<td class="cat" width="80">采集文本 4：</td>
				<td class="row"><input name="item_4" type="text" value="<!--record_item_4-->" maxlength="150"></td>
			</tr>
			<tr>
				<td class="cat" width="80">采集文本 5：</td>
				<td class="row"><input name="item_5" type="text" value="<!--record_item_5-->" maxlength="150"></td>
			</tr>
			<tr>
				<td class="cat" width="80">采集文本 6：</td>
				<td class="row"><input name="item_6" type="text" value="<!--record_item_6-->" maxlength="150"></td>
			</tr>
			<tr>
				<td class="cat" width="80">采集文本 7：</td>
				<td class="row"><input name="item_7" type="text" value="<!--record_item_7-->" maxlength="150"></td>
			</tr>
			<tr>
				<td class="cat" width="80">采集文本 8：</td>
				<td class="row"><input name="item_8" type="text" value="<!--record_item_8-->" maxlength="150"></td>
			</tr>
			<tr>
				<td class="cat" width="80">采集文本 9：</td>
				<td class="row"><input name="item_9" type="text" value="<!--record_item_9-->" maxlength="150"></td>
			</tr>
			<tr>
				<td class="cat" colspan="2">主要内容：</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>
						<textarea name="content" style="width:100%; height:400px;" need=""><!--record_content--></textarea>
					</div>
				<td>
			</tr>
			<tr>
				<td class="cat" colspan="2" align="center" style="padding:20px">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回	" onClick="location.href='<!--back_url-->'">
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript" src="../../script/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	mode : "exact",
	elements : "content",
	language : "zh",
	theme : "advanced",
	plugins : "quote,bbscode,advlink,advimage,subtitle,safari,pagebreak,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,insertdatetime,visualchars,nonbreaking,xhtmlxtras,template",

	theme_advanced_buttons1 : "fullscreen,preview,|,undo,redo,newdocument,removeformat,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor,|,sub,sup,format",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,bbscode,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,media,|,insertdate,inserttime,charmap,|,code,change",
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
	
	setup : function(ed) {
		ed.addButton('change', {
			title : 'Div/P 模式切换',
			image : '../../admin/images/div.png',
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
		ed.addButton('format', {
			title : '文本格式化',
			image : '../../admin/images/format.png',
			onclick : function() {
				var content = tinyMCE.get('content').getContent();
				content = content.replace(/<div>(.+?)<\/div>/ig, "<p>$1</p>");
				content = content.replace(/[\r\n]*<br(.*?)>[\r\n]*/ig, "</p>\n<p>");
				content = content.replace(/<p>[\s　]+/ig, "<p>");
				tinyMCE.get('content').setContent(content);
			}
		});
	},
	
	template_replace_values : {
		username : "Windy2000",
		staffid : "19781226"
	}
});
</script>
