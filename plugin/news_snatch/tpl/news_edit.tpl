<div class="title"><!--title--></div>
<div align="left">
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
						<textarea id="content" name="content" style="width:100%; height:400px;" need=""><!--record_content--></textarea>
					</div>
				<td>
			</tr>
			<tr>
				<td class="cat" colspan="2" align="center" style="padding:20px">
					<input class="btn" type="Submit" value=" 提 交 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回	" onClick="location.href='<!--back_url-->'">
				</td>
			</tr>
		</table>
	</form>
</div>
<script language="JavaScript" type="text/javascript" src="../../script/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript">
$(function(){
	var new_setting = {};
	new_setting.plugins = "quote,bbscode,advlink,advimage,subtitle,safari,pagebreak,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,insertdatetime,visualchars,nonbreaking,xhtmlxtras,template";
	new_setting.theme_advanced_buttons1 = "fullscreen,preview,|,undo,redo,newdocument,removeformat,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor,|,sub,sup";
	new_setting.theme_advanced_buttons2 = "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,media,|,insertdate,inserttime,charmap,|,code";
	new_setting.forced_root_block = "p";
	tinyMCE_init("content", new_setting);
});
</script>
