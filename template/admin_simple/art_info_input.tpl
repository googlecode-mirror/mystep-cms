<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">չʾ���⣺<span>*</span></td>
				<td class="row">
					<input name="subject" type="text" id="title" value="<!--subject-->" maxlength="100" need="" />
					<input type="hidden" name="id" value="<!--id-->" />
					<input type="hidden" name="web_id" value="<!--web_id-->" />
					<span class="comment">������info��ǩ��title���ԣ�</span>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">չʾ���ݣ�</td>
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
					<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onclick="attach_edit()" />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script language="JavaScript" type="text/javascript" src="../script/tinymce/jquery.tinymce.js"></script>
<script language="JavaScript" type="text/javascript" src="../script/jquery.powerupload.js"></script>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
var news_id = 0;
var web_url = "<!--web_url-->";
var upload_limit = "<!--MaxSize-->";
$(function() {
	var new_setting = {};
	new_setting.plugins = "bbscode,source_code,style,table,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,insertdatetime,visualchars,nonbreaking,xhtmlxtras,template";
	new_setting.theme_advanced_buttons1 = "fullscreen,preview,|,undo,redo,removeformat,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor,|,tablecontrols";
	new_setting.theme_advanced_buttons2 = "upload,|,hr,styleprops,sub,sup,|,cut,copy,paste,pastetext,pasteword,bbscode,source_code,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,media,showImage,|,insertdate,inserttime,charmap,|,format,code,change";
	new_setting.forced_root_block = "div";
	tinyMCE_init("content", new_setting);
});
//]]> 
</script>
