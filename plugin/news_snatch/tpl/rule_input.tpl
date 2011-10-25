<div class="title"><!--title--></div>
<div align="center">
	<script language="JavaScript" src="../../script/checkForm.js"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat">规则名称：</td>
				<td class="row">
					<input class="input" name="name" type="text" size="20" maxlength="20" value="<!--name-->" need="" />
					<input name="id" type="hidden" value="<!--id-->">
				</td>
			</tr>
			<tr>
				<td class="cat">采集网址：</td>
				<td class="row">
					<input class="input" name="url" type="text" size="20" maxlength="200" value="<!--url-->" need="url" />
				</td>
			</tr>
			<tr>
				<td class="cat">内容说明：</td>
				<td class="row">
					<input class="input" name="notes" type="text" size="20" maxlength="120" value="<!--notes-->" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat">相关参数：</td>
				<td class="row">
					<textarea name="para" style="width:690px;" rows="10"><!--para--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat" valign="top">采集规则：</td>
				<td class="row">
					<textarea name="rule_snatch" style="width:690px;" rows="10" need="" /><!--rule_snatch--></textarea>
				</td>
			</tr>
			<tr>
				<td class="cat" valign="top">导入规则：</td>
				<td class="row">
					<textarea name="rule_import" style="width:690px;" rows="10" need="" /><!--rule_import--></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" style="padding:20px 0px 20px 0px;">
					<input class="btn" type="Submit" value=" 确 定 " name="Submit" />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " name="reset" />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 导 入 " onclick="showPop('upload','导入采集规则','url','news_snatch.php?method=rule_import',420, 100)" />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " name="return" onClick="location.href='<!--back_url-->'" />
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript" language="javascript">
if(typeof($.setupJMPopups)=="undefined") $.getScript("../../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});
var newRule = null;
function importRule() {
	if(typeof(newRule)=="object" && newRule!=null) {
		if(newRule.para=="''") newRule.para = "";
		$("#input_area input[name='name']").val(newRule.name);
		$("#input_area input[name='url']").val(newRule.url);
		$("#input_area input[name='notes']").val(newRule.notes);
		$("#input_area textarea[name='para']").val(newRule.para);
		$("#input_area textarea[name='rule_snatch']").val(newRule.rule_snatch.replace("<pagebreak>", "<"+"!-- pagebreak -->"));
		$("#input_area textarea[name='rule_import']").val(newRule.rule_import.replace("<pagebreak>", "<"+"!-- pagebreak -->"));
	} else {
		alert("文件格式错误！");
	}
	newRule = null;
}
</script>
