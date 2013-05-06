<div class="title"><!--title--></div>
<div align="left">
	<script language="JavaScript" src="../../script/checkForm.js"></script>
	<form method="post" action="?method=reply" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">所属项目：</td>
				<td class="row">
					<input name="id" type="hidden" value="<!--id-->" />
					<input name="idx" type="hidden" value="<!--idx-->" />
					<!--topic-->
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">发布人：</td>
				<td class="row">
					<input name="name" type="text" value="<!--name-->" maxlength="100" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">电子邮件：</td>
				<td class="row">
					<input name="email" type="text" value="<!--email-->" maxlength="100" need="email" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">问题类型：</td>
				<td class="row">
					<input name="type" type="text" value="<!--type-->" maxlength="100" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">优先级别：</td>
				<td class="row">
					<select id="priority" name="priority">
						<option value="0">无</option>
						<option value="1" style="background-color:#009900;">一般</option>
						<option value="2" style="background-color:#999900;">重要</option>
						<option value="3" style="background-color:#990000;">亟待</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">问题状态：</td>
				<td class="row">
					<select id="status" name="status">
						<option value="0" style="background-color:#990000;">未处理</option>
						<option value="1" style="background-color:#999900;">处理中</option>
						<option value="2" style="background-color:#009900;">已解决</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">问题主题：</td>
				<td class="row">
					<input name="subject" type="text" value="<!--subject-->" maxlength="100" />
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">详细内容：</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<textarea name="message" style="width:798px; height:200px;"><!--message--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">回复问题：</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<textarea name="reply" style="width:798px; height:200px;"><!--reply--></textarea>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<label><input type="checkbox" name="sendmail" /> 发送邮件</label>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="history.go(-1)" />
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