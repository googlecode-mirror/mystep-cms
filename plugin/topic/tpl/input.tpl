<div class="title"><!--title--></div>
<div align="left">
	<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="80">专题名称：</td>
				<td class="row">
					<input name="topic_name" type="text" maxlength="40" need="" value="<!--topic_name-->">
					<input name="topic_id" type="hidden" value="<!--topic_id-->">
					<span class="comment">（专题显示名称）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">专题索引：</td>
				<td class="row">
				<input name="topic_idx" type="text" maxlength="20" need="" value="<!--topic_idx-->"> <span class="comment">（用于专题调用）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">专题图示：</td>
				<td class="row">
					<input name="topic_image" type="text" maxlength="150" value="<!--topic_image-->" need="">
					<input style="width:60px" class="btn" type="button" onClick="showPop('uploadImage','专题图示上传','url','../../<!--path_admin-->/upload_img.php?topic_image',420, 100)" value="上传" />
					<span class="comment">（用于专题的图形显示）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">专题链接：</td>
				<td class="row">
				<input name="topic_link" type="text" maxlength="80" value="<!--topic_link-->"> <span class="comment">（对外链接）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">关 键 字：</td>
				<td class="row">
				<input name="topic_keyword" type="text" maxlength="150" need="" value="<!--topic_keyword-->"> <span class="comment">（用于搜索引擎检索的关键字）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">专题分类：</td>
				<td class="row">
				<input name="topic_cat" type="text" maxlength="120" need="" value="<!--topic_cat-->"> <span class="comment">（用逗号分隔各个分类）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">专题介绍：</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<div>
						<textarea name="topic_intro" style="width:100%;height:200px;"><!--topic_intro--></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">专题模板：</td>
			</tr>
			<tr>
				<td class="row" colspan="2" style="padding:0px;">
					<textarea id="topic_tpl" name="topic_tpl" style="width:100%;" rows="20" need="" /><!--topic_tpl--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="history.go(-1)" />
				</td>
			</tr>
		</table>
	</form>
</div>
<div style="display:<!--show_link-->">
	<div class="title">当前新闻专题链接维护</div>
	<div align="left">
		<form name="link_edit" method="post" action="topic_link.php?method=add" onsubmit="return checkForm(this)">
			<table id="input_area" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td class="cat" colspan="2">
						专题链接添加
						<input name="topic_id" type="hidden" value="<!--topic_id-->" />
						<input name="id" type="hidden" value="0" />
					</td>
				</tr>
				<tr>
					<td class="cat" width="90">链接名称：</td>
					<td class="row"><input name="link_name" type="text" maxlength="50" need="" value="" /> <span class="comment">（所链接文章的名称）</span></td>
				</tr>
				<tr>
					<td class="cat">链接地址：</td>
					<td class="row"><input name="link_url" type="text" maxlength="100" need="url" value="" /> <span class="comment">（所链接文章的网络地址）</span></td>
				</tr>
				<tr>
					<td class="cat">链接分类：</td>
					<td class="row">
					<select class="normal" name="link_cat" need="">
						<option value="">请选择</option>
					<!--loop:start key="style_list"-->
						<option value="<!--style_list_index-->"><!--style_list_style--></option>
					<!--loop:end-->
					</select>
					<span class="comment">（所添加链接的分类）</span></td>
				</tr>
				<tr>
					<td class="cat">链接排序：</td>
					<td class="row"><input name="link_order" type="text" maxlength="3" value="0" need="digital" /><span class="comment">（链接排序，序号越大越靠前）</span></td>
				</tr>
				<tr class="row">
					<td colspan="2" align="center">
						<input class="btn" type="Submit" value=" 确 定 " name="Submit" />&nbsp;&nbsp;
						<input class="btn" type="reset" value=" 重 置 " name="reset" />&nbsp;&nbsp;
						<input class="btn" type="button" value=" 清 空 " name="empty" onclick="location.href='topic_link.php?method=empty&topic_id=<!--topic_id-->'" />
					</td>
				</tr>
			</table>
		</form>
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="90">批量添加：</td>
				<td class="row">
					<input id="keyword" type="text" value="" onkeypress="if(window.event.keyCode==13)search_link(this.value)" /><span class="comment">（多个关键字请用空格分割）</span> &nbsp;
					<input type="button" class="btn" value="检索" onclick="search_link($id('keyword').value)" />
				</td>
			</tr>
		</table>
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
<!--loop:start key="link_list"-->
			<tr>
				<td class="cat" width="90" align="right">专题链接 <!--link_list_idx-->：</td>
				<td class="row">[<!--link_list_link_cat-->] <a href="<!--link_list_link_url-->" target="_blank"><!--link_list_link_name--></td>
				<td class="row" width="150" align="center"><a href="topic_link.php?method=delete&id=<!--link_list_id-->&topic_id=<!--link_list_topic_id-->"><b>删除链接</b></a></td>
			</tr>
<!--loop:end-->
		</table>
	</div>
</div>
<script type="text/javascript" src="../../script/tinymce/tiny_mce.js"></script>
<script language="JavaScript">
if(typeof($.setupJMPopups)=="undefined") $.getScript("../../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});

tinyMCE.init({
	mode : "exact",
	elements : "topic_intro",
	language : "zh",
	theme : "advanced",
	plugins : "safari,pagebreak,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	theme_advanced_buttons1 : "cut,copy,paste,|,undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,fontsizeselect,|,forecolor,backcolor,|,link,unlink,image,charmap,removeformt,code,preview",
	theme_advanced_buttons2 : "",
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

	template_replace_values : {
		username : "Windy2000",
		staffid : "19781226"
	}
});

function search_link(keyword) {
	if(keyword.replace(/\s/g, "")=="") {
		alert("请录入检索关键字");
		$id("keyword").focus();
	} else {
		showPop('searchArticle','网站文章检索','url','topic_link.php?method=search&topic_id=<!--topic_id-->&keyword='+keyword,600, 200);
	}
}

$.getScript("../../script/jquery.codemirror.js", setIt);
var editor = null;
var hlLine = null;
function setIt() {
	if(editor == null) {
		$('#topic_tpl').codemirror({
				lineWrapping: false,
				height: 400,
				ext_css: "\
					.CodeMirror-fullscreen {background-color:#fff;display:block;position:absolute;top:0;left:0;width:100%;height:100%;z-index:9999;margin:0;padding:0;border:0px solid #BBBBBB;opacity:1;}\
					.activeline {background: #e8f2ff !important;}\
				",
				onCursorActivity: function () {
					editor.setLineClass(hlLine, null, null);
					if(editor.getSelection().length==0) {
						hlLine = editor.setLineClass(editor.getCursor().line, "activeline");
					}
				},
				extraKeys: {
					"F11": function() {
						var scroller = editor.getScrollerElement();
						if (scroller.className.search(/\bCodeMirror-fullscreen\b/) === -1) {
							$(scroller).css({"position":"absolute"});
							$("body").css("overflow","hidden");
							scroller.className += " CodeMirror-fullscreen";
							scroller.style.height = "100%";
							scroller.style.width = "100%";
							editor.refresh();
						} else {
							$(scroller).css({"position":"static"});
							$("body").css("overflow","auto");
							scroller.className = scroller.className.replace(" CodeMirror-fullscreen", "");
							scroller.style.height = '';
							scroller.style.width = '';
							editor.refresh();
						}
					},
					"Esc": function() {
						var scroller = editor.getScrollerElement();
						if (scroller.className.search(/\bCodeMirror-fullscreen\b/) !== -1) {
							$(scroller).css({"position":"static"});
							$("body").css("overflow","auto");
							scroller.className = scroller.className.replace(" CodeMirror-fullscreen", "");
							scroller.style.height = '';
							scroller.style.width = '';
							editor.refresh();
						}
					},
					"Shift-Tab": function() {
						var the_pos = editor.getCursor().line;
						var the_selection = editor.getSelection().split("\n");
						var the_line = editor.getLine(the_pos);
						var line_start = 0, line_end = 0;
						if(the_line.indexOf(the_selection[0])!=-1) {
							line_start = the_pos;
							line_end = the_pos + the_selection.length - 1;
						} else {
							line_start = the_pos - the_selection.length + 1;
							line_end = the_pos;
						}
						for(var i=line_start; i<=line_end; i++) {
							editor.setLine(i, "	" + editor.getLine(i));
						}
						editor.setSelection({line:line_start,ch:0}, {line:line_end,ch:999});
					},
					"Shift-Backspace": function() {
						var the_pos = editor.getCursor().line;
						var the_line = editor.getLine(the_pos);
						var the_selection = editor.getSelection().split("\n");
						var line_start = 0, line_end = 0;
						if(the_line.indexOf(the_selection[0])!=-1) {
							line_start = the_pos;
							line_end = the_pos + the_selection.length - 1;
						} else {
							line_start = the_pos - the_selection.length + 1;
							line_end = the_pos;
						}
						for(var i=line_start; i<=line_end; i++) {
							editor.setLine(i, editor.getLine(i).replace(/^\s/, ""));
						}
						editor.setSelection({line:line_start,ch:0}, {line:line_end,ch:999});
					}
				}
			}, function(){
				if($.codemirror_error) {
					alert("脚本载入失败！");
				} else {
					$('.CodeMirror').css({width:'800px','overflow':"hidden","text-align":"left"});
					editor = $.codemirror_get_editor(0);
					hlLine = editor.setLineClass(0, "activeline");
				}
			}
		);
	} else {
		$('#file_content').val(editor.getValue());
		$('.CodeMirror').remove();
		$('#file_content').show();
		editor = null;
	}
}
function setIframe(idx) {
	if($id("popupLayer_"+idx)) {
		theFrame = $("#popupLayer_"+idx).find("iframe");
		theHeight = theFrame.contents().find("body")[0].scrollHeight + 30;
		theFrame.height(theHeight);
		theFrame.width(theFrame.width()-10);
		$("#popupLayer_"+idx).height($("#popupLayer_"+idx+"_title").height()+theHeight);
		$("#popupLayer_"+idx+"_content").height(theHeight);
		$.setPopupLayersPosition();
	}
}
</script>