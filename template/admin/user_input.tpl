<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="if(password.value==password_c.value){return checkForm(this)}else{alert('������������벻һ�£�');return false;}">
		<table id="input_area" width="400" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td class="cat" width="80">�û����ƣ�<span>*</span></td>
				<td class="row">
					<input name="user_id" type="hidden" value="<!--user_id-->" />
					<input name="username" type="text" size="20" maxlength="20" value="<!--username-->" need="" />
					<input name="username_org" type="hidden" size="20" maxlength="20" value="<!--username-->" />
				</td>
			</tr>
			<tr> 
				<td class="cat" width="80">�û����룺</td>
				<td class="row">
					<input name="password" type="password" size="20" maxlength="20" value="" />
				</td>
			</tr>
			<tr> 
				<td class="cat" width="80">����ȷ�ϣ�</td>
				<td class="row">
					<input name="password_c" type="password" size="20" maxlength="20" value="" />
				</td>
			</tr>
			<tr> 
				<td class="cat" width="80">�����ʼ���<span>*</span></td>
				<td class="row">
					<input name="email" type="email" size="20" maxlength="20" need="email" value="<!--email-->" />
				</td>
			</tr>
			<tr> 
				<td class="cat" width="80">��Ⱥѡ��</td>
				<td class="row">
					<select name="group_id">
						<option value="0">��Ⱥ��Ȩ��</option>
<!--loop:start key="user_group"-->
						<option value="<!--user_group_group_id-->" <!--user_group_selected-->><!--user_group_group_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr> 
				<td class="cat" width="80">����ѡ��</td>
				<td class="row">
					<select name="type_id">
<!--loop:start key="user_type"-->
						<option value="<!--user_type_type_id-->" <!--user_type_selected-->><!--user_type_type_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr> 
				<td colspan="2" class="row" align="center">
					<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
