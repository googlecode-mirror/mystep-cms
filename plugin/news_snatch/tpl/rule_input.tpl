<div class="title"><!--title--></div>
<div align="center">
	<script language="JavaScript" src="../../script/checkForm.js"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat">�������ƣ�</td>
				<td class="row">
					<input class="input" name="name" type="text" size="20" maxlength="20" value="<!--name-->" need="">
					<input name="id" type="hidden" value="<!--id-->">
				</td>
			</tr>
			<tr>
				<td class="cat">�ɼ���ַ��</td>
				<td class="row">
					<input class="input" name="url" type="text" size="20" maxlength="200" value="<!--url-->" need="url">
				</td>
			</tr>
			<tr>
				<td class="cat">����˵����</td>
				<td class="row">
					<input class="input" name="notes" type="text" size="20" maxlength="120" value="<!--notes-->" need="">
				</td>
			</tr>
			<tr>
				<td class="cat">��ز�����</td>
				<td class="row">
					<textarea name="para" style="width:100%;" rows="10"><!--para--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat" valign="top">�ɼ�����</td>
				<td class="row">
					<textarea name="rule_snatch" style="width:100%;" rows="10" need=""><!--rule_snatch--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat" valign="top">�������</td>
				<td class="row">
					<textarea name="rule_import" style="width:100%;" rows="10" need=""><!--rule_import--></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" style="padding:20px 0px 20px 0px;">
					<input class="btn" type="Submit" value=" ȷ �� " name="Submit">&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " name="reset">&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� ��	" name="return" onClick="location.href='<!--back_url-->'">
			</tr>
		</table>
	</form>
</div>
