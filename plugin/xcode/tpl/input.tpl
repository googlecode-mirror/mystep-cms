<div class="title"><!--title--></div>
<div align="left">
	<form method="post" action="?method=<!--method-->_ok">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">相关页面：</td>
				<td class="row">
					<input name="page" type="text" value="<!--page-->" maxlength="30" />
					<input type="hidden" name="idx" value="<!--idx-->" />
					<span class="comment">（请填写PHP脚本的文件名，如 info.php，留空为在所有页面执行）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">执行位置：</td>
				<td class="row">
					<select name="position">
						<option value="0">页首执行</option>
						<option value="1">页尾执行</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">功能描述：</td>
				<td class="row">
					<input name="description" type="text" value="<!--description-->" maxlength="200" />
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">代码内容：</td>
			</tr>
			<tr>
				<td colspan="2" align="center" style="background-color:#fff;">
					<textarea id="content" name="content" type="php" style="width:100%; height:400px;" wrap='off'><!--content--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 提 交 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script language="JavaScript">
$(function(){
	$("select[name=position]").val("<!--position-->");
});
$.getScript("/script/jquery.codemirror.js", setIt);
var editor = null;
var hlLine = null;
function setIt() {
	if(editor == null) {
		$('#content').codemirror({
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
</script>