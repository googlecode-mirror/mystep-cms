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
						<textarea id="topic_intro" name="topic_intro" style="width:100%;height:200px;"><!--topic_intro--></textarea>
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
<script language="JavaScript" type="text/javascript" src="../../script/tinymce/jquery.tinymce.js"></script>
<script language="JavaScript">
if(typeof($.setupJMPopups)=="undefined") $.getScript("../../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
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
				height: 300,
				ext_css: "\
					.CodeMirror-fullscreen {background-color:#fff;display:block;position:absolute;top:0;left:0;width:100%;height:100%;z-index:9999;margin:0;padding:0;border:0px solid #BBBBBB;opacity:1;}\
					.activeline {background: #e8f2ff !important;}\
				",
				extraKeys: {
					"F11": function(cm) {
						var wrap = cm.getWrapperElement();
						var scroller = cm.getScrollerElement();
						if (/\bCodeMirror-fullscreen\b/.test(cm.getWrapperElement().className)) {
							wrap.className = wrap.className.replace(" CodeMirror-fullscreen", "");
							wrap.style.height = "";
							wrap.style.width = "";
							scroller.style.height = "";
							scroller.style.width = "";
							document.documentElement.style.overflow = "";
						} else {
							wrap.className += " CodeMirror-fullscreen";
							wrap.style.height = (window.innerHeight || (document.documentElement || document.body).clientHeight) + "px";
							wrap.style.width = "100%";
							scroller.style.height = "100%";
							scroller.style.width = "100%";
							document.documentElement.style.overflow = "hidden";
						}
						cm.refresh();
						return;
					},
					"Esc": function(cm) {
						var wrap = cm.getWrapperElement();
						var scroller = cm.getScrollerElement();
						if (/\bCodeMirror-fullscreen\b/.test(cm.getWrapperElement().className)) {
							wrap.className = wrap.className.replace(" CodeMirror-fullscreen", "");
							wrap.style.height = "";
							wrap.style.width = "";
							scroller.style.height = "";
							scroller.style.width = "";
							document.documentElement.style.overflow = "";
							cm.refresh();
						}
					},
					"Shift-Tab": function(cm) {
						var the_pos = cm.getCursor().line;
						var the_selection = cm.getSelection().split("\n");
						var the_line = cm.getLine(the_pos);
						var line_start = 0, line_end = 0;
						if(the_line.indexOf(the_selection[0])!=-1) {
							line_start = the_pos;
							line_end = the_pos + the_selection.length - 1;
						} else {
							line_start = the_pos - the_selection.length + 1;
							line_end = the_pos;
						}
						for(var i=line_start; i<=line_end; i++) {
							cm.setLine(i, "	" + cm.getLine(i));
						}
						cm.setSelection({line:line_start,ch:0}, {line:line_end,ch:999});
					},
					"Shift-Backspace": function(cm) {
						var the_pos = cm.getCursor().line;
						var the_line = cm.getLine(the_pos);
						var the_selection = cm.getSelection().split("\n");
						var line_start = 0, line_end = 0;
						if(the_line.indexOf(the_selection[0])!=-1) {
							line_start = the_pos;
							line_end = the_pos + the_selection.length - 1;
						} else {
							line_start = the_pos - the_selection.length + 1;
							line_end = the_pos;
						}
						for(var i=line_start; i<=line_end; i++) {
							cm.setLine(i, cm.getLine(i).replace(/^\s/, ""));
						}
						cm.setSelection({line:line_start,ch:0}, {line:line_end,ch:999});
					}
				}
			}, function(){
				if($.codemirror_error) {
					alert("脚本载入失败！");
				} else {
					$('.CodeMirror').css({width:'800px','overflow':"hidden","text-align":"left"});
					var editor = $.codemirror_get_editor(0);
					var hlLine = editor.addLineClass(0, "background", "activeline");
					editor.on("cursorActivity", function() {
					  var cur = editor.getLineHandle(editor.getCursor().line);
					  if (cur != hlLine) {
					    editor.removeLineClass(hlLine, "background", "activeline");
					    hlLine = editor.addLineClass(cur, "background", "activeline");
					  }
					});
					editor.refresh();
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
$(function() {
	var new_setting = {};
	new_setting.plugins = "safari,pagebreak,inlinepopups,preview,media,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template";
	new_setting.theme_advanced_buttons1 = "cut,copy,paste,|,undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,fontsizeselect,|,forecolor,backcolor,|,link,unlink,image,charmap,removeformt,code,preview";
	new_setting.theme_advanced_buttons2 = "";
	new_setting.forced_root_block = "p";
	tinyMCE_init("topic_intro", new_setting);
});
</script>