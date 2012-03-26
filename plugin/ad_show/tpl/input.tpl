<div class="title"><!--title--></div>
<div align="left">
	<script type="text/javascript" src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<script type="text/javascript" src="../../script/jquery.date_input.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">客户名称：</td>
				<td class="row"><input name="ad_client" type="text" size="20" maxlength="40" value="<!--ad_client-->" need=""></td>
			</tr>
			<tr>
				<td class="cat" width="80">广告索引：</td>
				<td class="row">
					<input id="idx" name="idx" type="text" size="20" maxlength="40" value="<!--idx-->" need="">
					<select class="btn" onchange="$id('idx').value=this.value">
						<option value="">请选择</option>
<!--loop:start key="idx"-->
						<option value="<!--idx_idx-->" <!--idx_selected-->><!--idx_idx--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">广告链接：</td>
				<td class="row">
					<input name="ad_url" type="text" size="20" maxlength="100" value="<!--ad_url-->" need="url_" />
					<input name="id" type="hidden" value="<!--id-->">
				</td>
			</tr>
			<tr>
				<td class="cat">广告文件：</td>
				<td class="row"><input name="ad_file" type="text" maxlength="100" value="<!--ad_file-->" />
					<input type="button" class="btn" onClick="showPop('uploadFile','广告文件上传','url','upload.php',420, 100)" value="上传" />
				</td>
			</tr>
			<tr>
				<td class="cat">显示文字：</td>
				<td class="row"><input name="ad_text" type="text" size="20" maxlength="100" value="<!--ad_text-->" need="" /></td>
			</tr>
			<tr>
				<td class="cat" width="80">广告类型：</td>
				<td class="row">
					<select name="ad_mode">
<!--loop:start key="ad_mode"-->
						<option value="<!--ad_mode_idx-->" <!--ad_mode_selected-->><!--ad_mode_mode--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">显示级别：</td>
				<td class="row">
					<input name="ad_level" type="text" size="40" maxlength="10" value="<!--ad_level-->" need="digital_">
				</td class="row">
			</tr>
			<tr>
				<td class="cat">截止日期：</td>
				<td class="row">
					<input name="exp_date" type="text" size="40" maxlength="20" value="<!--exp_date-->" need="date">
				</td>
			</tr>
			<tr>
				<td class="cat" valign="top">相关备注：</td>
				<td class="row">
					<textarea name="comment" style="width:670px" rows="5"><!--comment--> </textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 确 定 " name="Submit" />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " name="reset" />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回	" name="return" onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script language="JavaScript">
if(typeof($.setupJMPopups)=="undefined") $.getScript("../../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});
</script>