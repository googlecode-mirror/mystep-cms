<div class="title"><!--title--></div>
<div align="center">
	<form method="post" action="?method=<!--method-->_ok">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">���ҳ�棺</td>
				<td class="row">
					<input name="page" type="text" value="<!--page-->" maxlength="30" />
					<input type="hidden" name="idx" value="<!--idx-->" />
					<span class="comment">������дPHP�ű����ļ������� info.php������Ϊ������ҳ��ִ�У�</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">����������</td>
				<td class="row">
					<input name="description" type="text" value="<!--description-->" maxlength="200" />
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">�������ݣ�</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<textarea name="content" style="width:100%; height:400px;"><!--content--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
