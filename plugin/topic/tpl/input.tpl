<div class="title"><!--title--></div>
<div align="left">
	<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="80">ר�����ƣ�</td>
				<td class="row">
					<input name="topic_name" type="text" maxlength="40" need="" value="<!--topic_name-->">
					<input name="topic_id" type="hidden" value="<!--topic_id-->">
					<span class="comment">��ר����ʾ���ƣ�</span>
				</td>
			</tr>
			<tr>
				<td class="cat">ר��������</td>
				<td class="row">
				<input name="topic_idx" type="text" maxlength="20" need="" value="<!--topic_idx-->"> <span class="comment">������ר����ã�</span>
				</td>
			</tr>
			<tr>
				<td class="cat">ר��ͼʾ��</td>
				<td class="row">
					<input name="topic_image" type="text" maxlength="150" value="<!--topic_image-->" need="">
					<input style="width:60px" class="btn" type="button" onClick="showPop('uploadImage','ר��ͼʾ�ϴ�','url','../../<!--path_admin-->/upload_img.php?topic_image',420, 100)" value="�ϴ�" />
					<span class="comment">������ר���ͼ����ʾ��</span>
				</td>
			</tr>
			<tr>
				<td class="cat">ר�����ӣ�</td>
				<td class="row">
				<input name="topic_link" type="text" maxlength="80" value="<!--topic_link-->"> <span class="comment">���������ӣ�</span>
				</td>
			</tr>
			<tr>
				<td class="cat">�� �� �֣�</td>
				<td class="row">
				<input name="topic_keyword" type="text" maxlength="150" need="" value="<!--topic_keyword-->"> <span class="comment">������������������Ĺؼ��֣�</span>
				</td>
			</tr>
			<tr>
				<td class="cat">ר����ࣺ</td>
				<td class="row">
				<input name="topic_cat" type="text" maxlength="120" need="" value="<!--topic_cat-->"> <span class="comment">���ö��ŷָ��������ࣩ</span>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">ר����ܣ�</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<div>
						<textarea id="topic_intro" name="topic_intro" style="width:100%;height:200px;"><!--topic_intro--></textarea>
					</div>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">ר��ģ�壺</td>
			</tr>
			<tr>
				<td class="row" colspan="2" style="padding:0px;">
					<textarea id="topic_tpl" name="topic_tpl" style="width:100%;" rows="20" need="" /><!--topic_tpl--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="history.go(-1)" />
				</td>
			</tr>
		</table>
	</form>
</div>
<div style="display:<!--show_link-->">
	<div class="title">��ǰ����ר������ά��</div>
	<div align="left">
		<form name="link_edit" method="post" action="topic_link.php?method=add" onsubmit="return checkForm(this)">
			<table id="input_area" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td class="cat" colspan="2">
						ר���������
						<input name="topic_id" type="hidden" value="<!--topic_id-->" />
						<input name="id" type="hidden" value="0" />
					</td>
				</tr>
				<tr>
					<td class="cat" width="90">�������ƣ�</td>
					<td class="row"><input name="link_name" type="text" maxlength="50" need="" value="" /> <span class="comment">�����������µ����ƣ�</span></td>
				</tr>
				<tr>
					<td class="cat">���ӵ�ַ��</td>
					<td class="row"><input name="link_url" type="text" maxlength="100" need="url" value="" /> <span class="comment">�����������µ������ַ��</span></td>
				</tr>
				<tr>
					<td class="cat">���ӷ��ࣺ</td>
					<td class="row">
					<select class="normal" name="link_cat" need="">
						<option value="">��ѡ��</option>
					<!--loop:start key="style_list"-->
						<option value="<!--style_list_index-->"><!--style_list_style--></option>
					<!--loop:end-->
					</select>
					<span class="comment">����������ӵķ��ࣩ</span></td>
				</tr>
				<tr>
					<td class="cat">��������</td>
					<td class="row"><input name="link_order" type="text" maxlength="3" value="0" need="digital" /><span class="comment">�������������Խ��Խ��ǰ��</span></td>
				</tr>
				<tr class="row">
					<td colspan="2" align="center">
						<input class="btn" type="Submit" value=" ȷ �� " name="Submit" />&nbsp;&nbsp;
						<input class="btn" type="reset" value=" �� �� " name="reset" />&nbsp;&nbsp;
						<input class="btn" type="button" value=" �� �� " name="empty" onclick="location.href='topic_link.php?method=empty&topic_id=<!--topic_id-->'" />
					</td>
				</tr>
			</table>
		</form>
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="90">������ӣ�</td>
				<td class="row">
					<input id="keyword" type="text" value="" onkeypress="if(window.event.keyCode==13)search_link(this.value)" /><span class="comment">������ؼ������ÿո�ָ</span> &nbsp;
					<input type="button" class="btn" value="����" onclick="search_link($id('keyword').value)" />
				</td>
			</tr>
		</table>
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
<!--loop:start key="link_list"-->
			<tr>
				<td class="cat" width="90" align="right">ר������ <!--link_list_idx-->��</td>
				<td class="row">[<!--link_list_link_cat-->] <a href="<!--link_list_link_url-->" target="_blank"><!--link_list_link_name--></td>
				<td class="row" width="150" align="center"><a href="topic_link.php?method=delete&id=<!--link_list_id-->&topic_id=<!--link_list_topic_id-->"><b>ɾ������</b></a></td>
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
		alert("��¼������ؼ���");
		$id("keyword").focus();
	} else {
		showPop('searchArticle','��վ���¼���','url','topic_link.php?method=search&topic_id=<!--topic_id-->&keyword='+keyword,600, 200);
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
					alert("�ű�����ʧ�ܣ�");
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