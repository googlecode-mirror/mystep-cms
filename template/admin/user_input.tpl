<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/check_form.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="if(password.value==password_c.value){return checkForm(this)}else{alert('两次输入的密码不一致！');return false;}">
		<table id="input_area" width="400" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td class="cat" width="80">用户名称：</td>
				<td class="row">
					<input name="user_id" type="hidden" value="<!--user_id-->">
					<input name="username" type="text" size="20" maxlength="20" value="<!--username-->" need="">
					<input name="username_org" type="hidden" size="20" maxlength="20" value="<!--username-->">
				</td>
			</tr>
			<tr> 
				<td class="cat" width="80">用户密码：</td>
				<td class="row">
					<input name="password" type="password" size="20" maxlength="20" value="">
				</td>
			</tr>
			<tr> 
				<td class="cat" width="80">密码确认：</td>
				<td class="row">
					<input name="password_c" type="password" size="20" maxlength="20" value="">
				</td>
			</tr>
			<tr> 
				<td class="cat" width="80">电子邮件：</td>
				<td class="row">
					<input name="email" type="email" size="20" maxlength="20" need="email" value="<!--email-->">
				</td>
			</tr>
			<tr> 
				<td class="cat" width="80">组群选择：</td>
				<td class="row">
					<select name="group_id">
<!--loop:start key="user_group"-->
						<option value="<!--user_group_group_id-->" <!--user_group_selected-->><!--user_group_group_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr> 
				<td colspan="4" class="cat" align="center">
					<input class="btn" type="Submit" value=" 确 定 ">&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 ">&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回	" onClick="location.href='<!--back_url-->'">
				</td>
			</tr>
		</table>
	</form>
</div>