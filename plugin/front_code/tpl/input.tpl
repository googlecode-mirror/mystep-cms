<div class="title"><!--title--></div>
<div align="center">
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
				<td class="cat" width="80">功能描述：</td>
				<td class="row">
					<input name="description" type="text" value="<!--description-->" maxlength="200" />
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">代码内容：</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<textarea name="content" style="width:100%; height:400px;"><!--content--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
