<div align="center">
	<script language="JavaScript" type="text/javascript">if(top != window) top.location.href="login.php";</script>
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<FORM name="login" action="?login" method="post" onsubmit="return checkForm(this)">
	<div style="font-size:12px; font-weight:bold; font-size:14px; line-height:20px; color:red; padding:10px; text-align:center;"><!--err_msg--></div>
	<TABLE cellSpacing="0" cellPadding="0" width="350" border="0" align="center" style="border: 1px black dotted">
	<TR height="20">
		<TD colspan="2" align="center" colspan="2" class="cat">
		<b> �� ¼ ¼ �� �� </b>
		</TD>
	</TR>
	<tr height="40">
		<td width="100" align="right">�� �� ����</td>
		<td><input type="text" style="width:200px" name="user_name" value="" need="" /></td>
	</tr>
	<tr height="40">
		<td width="100" align="right"> �� &nbsp;�� ��</td>
		<td><input type="password" style="width:200px" name="user_psw" value="" need="" /></td>
	</tr>
	<tr height="40">
		<td width="100" align="right">�������룺</td>
		<td>
		<select name="keep" style="width:200px">
			<option value="0.05">������</option>
			<option value="1">һ��</option>
			<option value="7">һ��</option>
			<option value="30">һ��</option>
			<option value="90">һ��</option>
			<option value="180">����</option>
			<option value="365">һ��</option>
		</select>
		</td>
	</tr>
	<tr height="40">
		<td width="100" align="right">�� ֤ �룺</td>
		<td><input type="text" style="width:200px" name="check_code" value="" need="" /></td>
	</tr>
	<tr height="40">
		<td align="center" colspan="2"><img border="0" src="../vcode.php" onclick="this.src='../vcode.php?'+Math.random()" /><br /><br />�����ͼƬ�����������ͼƬ������֤�룩</td>
	</tr>
	<TR height="40">
		<TD colspan="2" align="center">
		<input type="hidden" name="referer" value="<!--referer-->" />
		<input type="submit" value=" �� ¼ " /> &nbsp; &nbsp;<input type="reset" value=" �� λ " />
		</TD>
	</TR>
	</TABLE>
	</FORM>
</div>
