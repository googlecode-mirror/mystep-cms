<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="120">权限名称：<span>*</span></td>
				<td class="row">
					<input name="power_id" type="hidden" value="<!--power_id-->" />
					<input name="name" type="text" maxlength="20" value="<!--name-->" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="120">权限索引：<span>*</span></td>
				<td class="row">
					<input name="idx_org" type="hidden" value="<!--idx-->" />
					<input name="idx" type="text" value="<!--idx-->" need="alpha" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="120">默 认 值：<span>*</span></td>
				<td class="row">
					<input id="value" name="value" type="text" value="<!--value-->" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="120">要求格式：</td>
				<td class="row">
					<input name="format_org" type="hidden" value="<!--format-->" />
					<select name="format" onchange="$id('value').setAttribute('need', this.value)">
						<option value="">任意字符串</option>
<!--loop:start key="format"-->
						<option value="<!--format_key-->" <!--format_select-->><!--format_value--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="120">权限描述：<span>*</span></td>
				<td class="row">
					<input name="comment" type="text" value="<!--comment-->" need="" />
				</td>
			</tr>
			<tr class="row">
				<td align="center" colspan="2">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
