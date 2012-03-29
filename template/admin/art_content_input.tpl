<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this, checkForm_append)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="120">所属栏目：<span>*</span></td>
				<td class="row" width="680">
					<input type="hidden" name="news_id" value="<!--record_news_id-->" />
					<input id="web_id" type="hidden" name="web_id" value="<!--record_web_id-->" />
					<input type="hidden" name="pages" value="<!--record_pages-->" />
					<select id="cat_id" name="cat_id" onchange="profix_changed(this.value);$id('web_id').value=this.options[this.selectedIndex].getAttribute('web_id');$id('view_lvl').value=this.options[this.selectedIndex].getAttribute('view_lvl');" need="" />
						<option value="">请选择</option>
<!--loop:start key="catalog"-->
						<option value="<!--catalog_cat_id-->" web_id="<!--catalog_web_id-->" view_lvl="<!--catalog_view_lvl-->" <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
					</select> &nbsp;
					<input style="width:80px" class="btn" type="button" onClick="showPop('newsCatalog','多栏目同时发布','id','newsCatalog',200);setMultiCata();" value="其他栏目" /> <span class="comment">（请选择当前文章所属的类别）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">文章标题：<span>*</span></td>
				<td class="row">
					<input name="subject" type="text" id="title" value="<!--record_subject-->" maxlength="100" need="" /> &nbsp;
					<select id="profix" onchange="title_change()" style="width:80px"></select> &nbsp;
					<input type="checkbox" class="cbox" name="style[]" id="style_b" value="b" <!--check_b--> /><label for="style_b">粗体</label> &nbsp;
					<input type="checkbox" class="cbox" name="style[]" id="style_i" value="i" <!--check_i--> /><label for="style_i">斜体</label> &nbsp;
					<select id="color_list_title" name="style[]" style="width:60px"></select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">关 键 字：<span>*</span></td>
				<td class="row"><input id="keyword" name="tag" type="text" value="<!--record_tag-->" maxlength="100" need="" />
				<span class="comment">（用于搜索相关资讯，多个关键字用逗号分隔）</span></td>
			</tr>
			<tr>
				<td class="cat" width="80">作者出处：</td>
				<td class="row"><input name="original" type="text" maxlength="50" value="<!--record_original-->" /> <span class="comment">（文章来源）</span></td>
			</tr>
			<tr>
				<td class="cat" width="80">跳转网址：</td>
				<td class="row"><input name="link" type="text" maxlength="150" value="<!--record_link-->" /> <span class="comment">（点击文章标题所链接到的网址）</span></td>
			</tr>
			<tr>
				<td class="cat">文章图示：</td>
				<td class="row">
					<input id="image" name="image" type="text" maxlength="150" value="<!--record_image-->" /> &nbsp;
					<input style="width:60px" class="btn" type="button" onClick="showPop('uploadImage','新闻图示上传','url','upload_img.php?image',420, 100)" value="上传" />
					<input style="width:60px" class="btn" type="button" onClick="showPop('newsImage','常用新闻图示选择','id','newsImage',570)" value="选择" />
					<span class="comment">（文章标题图形显示）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">阅读权限：<span>*</span></td>
				<td class="row"><input name="view_lvl" id="view_lvl" type="text" maxlength="2" value="<!--record_view_lvl-->" need="digital" /> <span class="comment">（浏览当前文章需要达到的级别）</span></td>
			</tr>
			<tr>
				<td class="cat">提示文字：</td>
				<td class="row"><input name="notice" type="text" size="20" maxlength="150" value="<!--record_notice-->" /> <span class="comment">（显示于文章指定位置的提示文字）</span></td>
			</tr>
			<tr>
				<td class="cat">列表排序：<span>*</span></td>
				<td class="row"><input name="order" type="text" maxlength="3" value="<!--record_order-->" need="digital" /> <span class="comment">（文章排序，序号越大越靠前）</span></td>
			</tr>
			<tr>
				<td class="cat" width="80">推送模式：</td>
				<td class="row">
<!--loop:start key="setop_mode"-->
					<input type="radio" id="setop_mode_<!--setop_mode_key-->" class="cbox" name="setop_mode" value="<!--setop_mode_key-->" <!--setop_mode_checked--> /><label for="setop_mode_<!--setop_mode_key-->" /> <!--setop_mode_value--></label> &nbsp;
<!--loop:end--> <span class="comment">（文章推送模式）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">推送位置：</td>
				<td class="row">
<!--loop:start key="setop"-->
				<input type="checkbox" id="setop_<!--setop_key-->" class="cbox" name="setop[]" value="<!--setop_key-->" <!--setop_checked--> /><label for="setop_<!--setop_key-->" /> <!--setop_value--></label> &nbsp;
<!--loop:end--> <span class="comment">（文章推送位置，可复选）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">文章描述：<span>*</span><br /><br />（限120字）</td>
				<td class="row">
					<textarea name="describe" style="width:100%;height:54px;" need=""><!--record_describe--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80" valign="top">主要内容：</td>
				<td class="row">
					<input name="get_remote_file" class="cbox" id="get_remote_file" type="checkbox" value="1" <!--get_remote_file--> /><label for="get_remote_file">自动复制外网图片到本地</label>
					&nbsp; &nbsp;
					[<a href="javascript:" onclick="attach_mine()">我的附件</a>]
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div>
						<textarea id="content" name="content" style="width:100%; height:400px;"><!--record_content--></textarea>
					</div>
				<td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" name="attach_list" type="hidden" value="|">
					<input class="btn" name="multi_cata" type="hidden" value="">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 附 件 " onclick="attach_edit()" />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>

<div id="newsImage" class="popshow">
<!--loop:start key="news_image"-->
	<dl>
		<dt><img src="<!--news_image_image-->" title="<!--news_image_keyword-->"	onclick="putImage(this)" /></dt>
		<dd><!--news_image_name--></dd>
	</dl>
<!--loop:end-->
</div>

<div id="newsCatalog" class="popshow">
	<div style="width:190px; height:200px; overflow-y:auto;">
<!--loop:start key="catalog"-->
		<input type="checkbox" name="multi_cata" value="<!--catalog_cat_id-->," /> <!--catalog_cat_name--> <br />
<!--loop:end-->
	</div>
	<div style="text-align:center;margin-top:10px;"><input class="btn" type="button" onClick="putMultiCata()" value=" 确 定 " /></div>
</div>

<script language="JavaScript type="text/javascript" src="../script/tinymce/tiny_mce.js"></script>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
if(typeof($.setupJMPopups)=="undefined") $.getScript("../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});

tinyMCE.init({
	mode : "exact",
	elements : "content",
	language : "zh",
	theme : "advanced",
	plugins : "quote,bbscode,source_code,advlink,advimage,subtitle,safari,pagebreak,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,insertdatetime,visualchars,nonbreaking,xhtmlxtras,template",

	theme_advanced_buttons1 : "fullscreen,preview,|,undo,redo,newdocument,removeformat,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,|,forecolor,backcolor,|,sub,sup,format",
	theme_advanced_buttons2 : "pagebreak,Subtitle,upload,|,cut,copy,paste,pastetext,pasteword,bbscode,source_code,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,image,media,|,insertdate,inserttime,charmap,|,code,change",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
	
	content_css: "../images/editor.css",
	entity_encoding : "raw",
	add_unload_trigger : false,
	
	preformatted : false,
	remove_linebreaks : false,
	apply_source_formatting : true,
	convert_fonts_to_spans : true,
	verify_html : true,
	paste_auto_cleanup_on_paste : true,
	extended_valid_elements : "textarea[class|type|title],script[charset|defer|language|src|type]",
	
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",
	
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
					content = content.replace(/<p(.*?)>(.+?)<\/p>/ig, "<div$1>$2</div>");
				} else {
					content = content.replace(/<div(.*?)>(.+?)<\/div>/ig, "<p$1>$2</p>");
				}
				tinyMCE.get('content').setContent(content);
			}
		});
		ed.addButton('format', {
			title : '文本格式化',
			image : 'images/format.png',
			onclick : function() {
				var content = tinyMCE.get('content').getContent();
				content = content.replace(/<div(.*?)>(.+?)<\/div>/ig, "<p$1>$2</p>");
				content = content.replace(/[\r\n]*<br(.*?)>[\r\n]*/ig, "</p>\n<p>");
				content = content.replace(/<p(.*?)>[\r\n\s　]+/ig, "<p$1>");
				content = content.replace(/mso\-[^;];/ig, "<p>");
				content = content.replace(/[\xa0]/g, "");
				content = content.replace(/<\/td>/g, "&nbsp;</td>");
				while(content.search(/<(\w+)[^>]*><\!\-\- pagebreak \-\-\><\/\1>[\r\n\s]*/)!=-1) content = content.replace(/<(\w+)[^>]*><\!\-\- pagebreak \-\-\><\/\1>[\r\n\s]*/g, "");
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

function putImage(obj) {
	$id("keyword").value = obj.title;
	$id("image").value = obj.getAttribute("src");
	$.closePopupLayer();
}

function putMultiCata() {
	var objs = $("#popupLayer_newsCatalog input[name='multi_cata']");
	var theList = "";
	for(var i=0, m=objs.length; i<m; i++) {
		if(objs[i].checked) theList += objs[i].value;
	}
	document.forms[0].multi_cata.value = theList;
	$.closePopupLayer();
}

function setMultiCata() {
	if(document.forms[0].multi_cata.value.length>0) {
		var objs = $("#popupLayer_newsCatalog input[name='multi_cata']");
		var theList = "," + document.forms[0].multi_cata.value;
		for(var i=0, m=objs.length; i<m; i++) {
			if(theList.indexOf(","+objs[i].value)!=-1) objs[i].checked = true;
		}
	}
}

var cat_sub_list = new Array();
<!--loop:start key="cat_sub"-->
cat_sub_list['<!--cat_sub_cat_id-->'] = "<!--cat_sub_cat_sub-->";
<!--loop:end-->

function attach_add(str) {
	tinyMCE.execCommand("mceInsertContent", false, str);
}

function attach_remove(aid) {
	var content, re;
	content = tinyMCE.get('content').getContent();
	re = new RegExp("<a id\\=\"att_"+aid+".+?<\\/a>", "ig");
	content = content.replace(re, "");
	re = new RegExp("(<br \\/>)*<img.+?files\\?"+aid+".+?>(<br \\/>)*", "ig");
	content = content.replace(re, "");
	re = new RegExp("<p>[\s\r\n]*<\\/p>", "ig");
	content = content.replace(re, "");
	re = new RegExp("<div>[\s\r\n]*<\\/div>", "ig");
	content = content.replace(re, "");
	tinyMCE.get('content').setContent(content);
	return;
}

function attach_edit() {
	showPop('attach','附件管理','url','attachment.php?news_id=<!--news_id-->&method=edit&attach_list='+document.forms[0].attach_list.value, 600, 200);
	return;
}

function attach_mine() {
	showPop('attach_mine','我的附件','url','attachment.php?method=mine', 600, 200);
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
	var flag = true;
	var theLen = theForm.describe.value.Tlength();
	if(theLen>240) {
		alert(printf("当前描述长度为 %1 字节，请限制在 %2 字节内！", theLen, 240));
		flag = false;
	}
	return flag;
}

function setIframe(idx) {
	if($id("popupLayer_"+idx)) {
		theFrame = $("#popupLayer_"+idx).find("iframe");
		theHeight = theFrame.contents().find("body")[0].scrollHeight + 20;
		//if(theHeight>650) theHeight = 650;
		theFrame.height(theHeight);
		$("#popupLayer_"+idx).height($("#popupLayer_"+idx+"_title").height()+theHeight);
		$("#popupLayer_"+idx+"_content").height(theHeight);
		$.setPopupLayersPosition();
	}
}

function add_color(obj_select, theColor){
	if(obj_select.tagName.toLowerCase() != "select") return;
	var color_list = new Array('', 'black','dimgray','red','orange','pink','yellow','blue','green');
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
	obj_select.selectedIndex = selIndex;
}

$(function(){
	add_color($id("color_list_title"), "<!--check_c-->");
	profix_changed(<!--record_cat_id-->);
});
//]]> 
</script>
