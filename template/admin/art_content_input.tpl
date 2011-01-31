<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this, checkForm_append)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="120">所属栏目：</td>
				<td class="row" width="680">
					<input type="hidden" name="news_id" value="<!--record_news_id-->" />
					<input type="hidden" name="web_id" value="<!--record_web_id-->" />
					<input type="hidden" name="pages" value="<!--record_pages-->" />
					<select id="cat_id" name="cat_id" onchange="profix_changed(this.value)" need="" />
						<option value="">请选择</option>
<!--loop:start key="catalog"-->
						<option value="<!--catalog_cat_id-->" <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
					</select> <span class="comment">（请选择当前文章所属的类别）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">文章标题：</td>
				<td class="row">
					<input name="subject" type="text" id="title" value="<!--record_subject-->" maxlength="100" need="" /> &nbsp; 
					<select id="profix" onchange="title_change()" style="width:80px"></select> &nbsp; 
					<input type="checkbox" class="cbox" name="style[]" id="style_b" value="b" <!--check_b--> / /><label for="style_b">粗体</label> &nbsp; 
					<input type="checkbox" class="cbox" name="style[]" id="style_i" value="i" <!--check_i--> / /><label for="style_i">斜体</label> &nbsp; 
					<select id="color_list_title" name="style[]" style="width:60px"></select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">关 键 字：</td>
				<td class="row"><input name="tag" type="text" value="<!--record_tag-->" maxlength="30" need="" /> 
				<span class="comment">（用于搜索相关资讯，多个关键字用逗号分隔）</span></td>
			</tr>
			<tr>
				<td class="cat" width="80">作者出处：</td>
				<td class="row"><input name="original" type="text" maxlength="50" value="<!--record_original-->" /> <span class="comment">（文章来源）</span></td>
			</tr>
			<tr>
				<td class="cat" width="80">跳转网址：</td>
				<td class="row"><input name="link" type="text" maxlength="100" value="<!--record_link-->" /> <span class="comment">（点击文章标题所链接到的网址）</span></td>
			</tr>
			<tr>
				<td class="cat">文章图示：</td>
				<td class="row">
					<input style="width:205px" name="image" type="text" maxlength="50" value="<!--record_image-->" /> &nbsp; 
					<input class="btn" type="button" onClick="openDialog('upload_img.php?image', 400, 120, 1)" value="上传" /> <span class="comment">（用于推荐文章的图形显示）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">置顶模式：</td>
				<td class="row">
<!--loop:start key="setop_mode"-->
					<input type="radio" id="setop_mode_<!--setop_mode_key-->" class="cbox" name="setop_mode" value="<!--setop_mode_key-->" <!--setop_mode_checked--> /><label for="setop_mode_<!--setop_mode_key-->" /> <!--setop_mode_value--></label> &nbsp;
<!--loop:end--> <span class="comment">（文章置顶模式）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">置顶位置：</td>
				<td class="row">
<!--loop:start key="setop"-->
				<input type="checkbox" id="setop_<!--setop_key-->" class="cbox" name="setop[]" value="<!--setop_key-->" <!--setop_checked--> /><label for="setop_<!--setop_key-->" /> <!--setop_value--></label> &nbsp;
<!--loop:end--> <span class="comment">（文章置顶位置，可复选）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">文章描述：</td>
				<td class="row">
					<textarea name="describe" style="width:100%;height:54px;" need="" /><!--record_describe--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80" valign="top">主要内容：</td>
				<td class="row">
					<input name="get_remote_file" class="cbox" id="get_remote_file" type="checkbox" value="1" <!--get_remote_file--> /><label for="get_remote_file">自动复制外网图片到本地</label>&nbsp; 
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>
						<textarea id="content" name="content" style="width:100%; height:400px;"><!--record_content--></textarea>
					</div>
					<div>
						<iframe src="attachment.php?method=add" name="attach" width="720" height="25" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no" ALLOWTRANSPARENCY="true" onload="setIframe()"></iframe>
					</div>
				<td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="row">
					<input class="btn" name="attach_list" type="hidden" value="|">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 附 件 " onclick="attach_edit()" />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript" src="tinymce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	mode : "exact",
	elements : "content",
	language : "zh",
	theme : "advanced",
	plugins : "bbscode,advlink,advimage,subtitle,safari,pagebreak,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,insertdatetime,visualchars,nonbreaking,xhtmlxtras,template",

	theme_advanced_buttons1 : "fullscreen,preview,|,undo,redo,newdocument,cleanup,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor,|,sub,sup",
	theme_advanced_buttons2 : "pagebreak,Subtitle,bbscode,|,cut,copy,paste,pastetext,pasteword,bbscode,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,media,|,insertdate,inserttime,charmap,|,code",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
	
	entity_encoding : "raw",
	add_unload_trigger : false,
	remove_linebreaks : false,
	
	content_css : "css/content.css",
	
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",
	
	template_replace_values : {
		username : "A9VG",
		staffid : "20121212"
	}
});

var cat_sub_list = new Array();
<!--loop:start key="cat_sub"-->
cat_sub_list['<!--cat_sub_cat_id-->'] = "<!--cat_sub_cat_sub-->";
<!--loop:end-->

function attach_add(str) {
	tinyMCE.execCommand("mceInsertContent", false, str);
}

function attach_remove(aid) {
	var content;
	content = tinyMCE.get('content').getContent();
	var re = new RegExp("<A href\\=\".+?\\?"+aid+"\.+?<\\/A>", "ig");
	content = content.replace(re, "");
	tinyMCE.get('content').setContent(content);
	return;
}

function attach_edit() {
	window.open('attachment.php?news_id=<!--news_id-->&method=edit&attach_list='+document.forms[0].attach_list.value,'','width=600,height=300,scrollbars=1');
	return;
}

function profix_changed(cat_id) {
	if(cat_id==null || cat_id=="") {
		$id("profix").disabled = true;
		return;
	}
	if(typeof(cat_id)=="undefined") cat_id = $id("cat_id").value;
	var profix = $id("profix");
	var the_list = new Array();
	var i = 0;
	profix.innerHTML = "";
	profix.options.add(new Option("无前缀", "", 0, 0));
	if(cat_sub_list[cat_id].length>0) {
		profix.disabled = false;
		the_list = cat_sub_list[cat_id].split(",");
		for(i=0; i<the_list.length; i++) {
			profix.options.add(new Option(the_list[i], the_list[i], 0, 0));
		}
	} else {
		profix.disabled = true;
	}
	return;
}

function title_change() {
	var obj = $id('title');
	var theProfix = $id("profix").value;
	obj.focus();
	obj.value = obj.value.replace(/\[.+?\]/g, "");
	if(theProfix.length>1) {
		obj.value = "[" + theProfix + "]" + obj.value;
	}
	return;
}

function checkForm_append(theForm) {
	if(theForm.describe.value=="") theForm.describe.value = theForm.subject.value;
	if(theForm.link.value!="" && $id("content").value=="") {
		$id("content").value = theForm.link.value;
	}
	return true;
}

function setIframe() {
	document.getElementsByName('attach')[0].height = attach.document.body.scrollHeight;
}

function add_color(obj_select, theColor){
	if(obj_select.tagName.toLowerCase() != "select") return;
	var color_list = new Array('black','dimgray','red','orange','pink','yellow','blue','green');
	var curIndex = 0;
	var selIndex = 0;
	obj_select.innerHTML = "";
	for(var i=0; i<color_list.length; i++){
		curIndex = obj_select.options.length;
		obj_select.options[curIndex] = new Option(color_list[i], color_list[i]);
		obj_select.options[curIndex].style.backgroundColor = color_list[i];
		obj_select.options[curIndex].style.color = color_list[i];
		if(color_list[i]==theColor) selIndex = curIndex;
	}
	obj_select.selectedIndex = selIndex
}

add_color($id("color_list_title"), "<!--check_c-->");
profix_changed(<!--record_cat_id-->);
</script>
