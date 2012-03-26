<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
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
				<td class="cat" colspan="2">模板内容：<span class="comment">（高级模式中按 F11 - 全屏 , Shift+Tab - 缩进, Shift+Backspace - 反缩进）</span></td>
			</tr>
			<tr>
				<td colspan="2" style="width:800px;overflow:hidden;">
					<textarea id="file_content" name="file_content" style="width:100%;height:400px;" wrap='off'><!--file_content--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 切 换 " onClick="setIt()" />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
$.getScript("../script/jquery.codemirror.js");
var editor = null;
var hlLine = null;
function setIt() {
	if(editor == null) {
		loadingShow("脚本载入中，请稍候");
		$('#file_content').codemirror({
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
			},
			function(){
				$('.CodeMirror').css({width:'800px','overflow':"hidden","text-align":"left"});
				editor = $.codemirror_get_editor(0);
				hlLine = editor.setLineClass(0, "activeline");
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
</script>