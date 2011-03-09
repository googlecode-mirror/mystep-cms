<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form name="link_edit" method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="80">链接名称：</td>
				<td class="row">
					<input name="id" type="hidden" value="<!--id-->" />
					<input name="link_name" type="text" size="20" maxlength="40" value="<!--link_name-->" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat">链接索引：</td>
				<td class="row">
					<input name="idx" id="idx" type="text" size="20" maxlength="20" value="<!--idx-->" need="" /> &nbsp;
					<select class="btn" onchange="$id('idx').value=this.value">
						<option value="">请选择</option>
<!--loop:start key="idx"-->
						<option value="<!--idx_idx-->" <!--idx_selected-->><!--idx_idx--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">链接地址：</td>
				<td class="row">
					<input name="link_url" type="text" size="20" maxlength="100" value="<!--link_url-->" need="url" />
				</td>
			</tr>
			<tr>
				<td class="cat">链接图形：</td>
				<td class="row">
					<input name="image" type="text" maxlength="100" value="<!--image-->" /> &nbsp;
					<input class="btn" type="button" onClick="openDialog('upload_img.php?image', 400, 120, 1)" value="上传" />
				</td>
			</tr>
			<tr>
				<td class="cat">显示级别：</td>
				<td class="row">
					<input name="level" type="text" size="40" maxlength="50" value="<!--level-->" need="digital_">
				</td>
			</tr>
			<tr>
				<td class="row" colspan="2" align="center">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
