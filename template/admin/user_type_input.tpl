<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="120">分类名称：<span>*</span></td>
				<td class="row">
					<input name="type_id" type="hidden" value="<!--type_id-->" />
					<input id="type_name" name="type_name" type="text" maxlength="20" value="<!--type_name-->" need="" />
				</td>
			</tr>
<!--loop:start key="user_power"-->
			<tr>
				<td class="cat" width="120"><!--user_power_name-->：<span>*</span></td>
				<td class="row">
					<input name="<!--user_power_idx-->" type="text" maxlength="100" value="<!--user_power_value-->" need="<!--user_power_format-->" />
					<span class="comment">（<!--user_power_comment-->）</span>
				</td>
			</tr>
<!--loop:end-->
			<tr class="row">
				<td align="center" colspan="2">
					<input class="btn" type="Submit" value=" 提 交 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
