<div class="title"><!--title--></div>
<div align="left">
	<script language="JavaScript" src="../../script/checkForm.js"></script>
	<form method="post" action="?method=reply" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">������Ŀ��</td>
				<td class="row">
					<input name="id" type="hidden" value="<!--id-->" />
					<input name="idx" type="hidden" value="<!--idx-->" />
					<!--topic-->
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">�����ˣ�</td>
				<td class="row">
					<input name="name" type="text" value="<!--name-->" maxlength="100" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">�����ʼ���</td>
				<td class="row">
					<input name="email" type="text" value="<!--email-->" maxlength="100" need="email" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">�������ͣ�</td>
				<td class="row">
					<input name="type" type="text" value="<!--type-->" maxlength="100" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">���ȼ���</td>
				<td class="row">
					<select id="priority" name="priority">
						<option value="0">��</option>
						<option value="1" style="background-color:#009900;">һ��</option>
						<option value="2" style="background-color:#999900;">��Ҫ</option>
						<option value="3" style="background-color:#990000;">ؽ��</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">����״̬��</td>
				<td class="row">
					<select id="status" name="status">
						<option value="0" style="background-color:#990000;">δ����</option>
						<option value="1" style="background-color:#999900;">������</option>
						<option value="2" style="background-color:#009900;">�ѽ��</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">�������⣺</td>
				<td class="row">
					<input name="subject" type="text" value="<!--subject-->" maxlength="100" />
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">��ϸ���ݣ�</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<textarea name="message" style="width:798px; height:200px;"><!--message--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">�ظ����⣺</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<textarea name="reply" style="width:798px; height:200px;"><!--reply--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<label><input type="checkbox" name="sendmail" /> �����ʼ�</label>
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
<script language="JavaScript">
$(function(){
	$("select[name=status]").val("<!--status-->");
	$("select[name=priority]").val("<!--priority-->");
});
</script>