<div class="title"><!--title--></div>
<div align="center">
	<form method="post" action="?method=<!--method-->_ok">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">�������棺</td>
				<td class="row">
					<input name="idx" type="text" value="<!--idx-->" maxlength="20" />
					<input type="hidden" name="idx_org" value="<!--idx-->" />
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">����IP��</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<textarea name="ip" style="width:100%; height:400px;"><!--ip--></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="row">
					<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>