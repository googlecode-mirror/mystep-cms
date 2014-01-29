<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="80">所属模板：</td>
				<td class="row">
					<!--file_idx-->
					<input name="idx" type="hidden" value="<!--file_idx-->" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">文件名称：<span>*</span></td>
				<td class="row">
					<input name="file_name" type="text" size="20" maxlength="20" value="<!--file_name-->" <!--readonly--> need="" />
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">模板内容：<span class="comment">（高级模式中按 Shift+Tab - 缩进, Shift+Backspace - 反缩进）</span></td>
			</tr>
			<tr>
				<td colspan="2" style="width:800px;overflow:hidden;background-color:#fff;">
					<textarea id="file_content" type="<!--file_type-->" name="file_content" style="width:100%;height:400px;" wrap='off'><!--file_content--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 提 交 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 切 换 " onClick="setIt()" />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
$.getScript("../script/jquery.codemirror.js", setIt);
var editor = null;
var hlLine = null;
function setIt() {
	if(editor == null) {
		loadingShow("脚本载入中，请稍候");
		$('#file_content').codemirror({
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
				loadingShow();
			}
		);
	} else {
		$('#file_content').val(editor.getValue());
		$('.CodeMirror').remove();
		$('#file_content').show();
		editor = null;
	}
}
//]]> 
</script>