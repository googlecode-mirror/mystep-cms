<div class="title"><!--title--></div>
<div align="left">
	<form method="post" action="?method=<!--method-->_ok">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">搜索引擎：</td>
				<td class="row">
					<input name="idx" type="text" value="<!--idx-->" maxlength="20" />
					<input type="hidden" name="idx_org" value="<!--idx-->" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">关键字：</td>
				<td class="row">
					<input name="keyword" type="text" value="<!--keyword-->" maxlength="200" />
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">所属IP：</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<textarea name="ip" style="width:100%; height:400px;"><!--ip--></textarea>
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
