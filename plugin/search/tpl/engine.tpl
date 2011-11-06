<div class="title"><!--title--></div>
<div align="center">
	<script language="JavaScript" src="../../script/checkForm.js"></script>
	<form method="post" action="?method=update" onsubmit="return checkForm(this)">
		<table id="input_area" cellSpacing="0" cellPadding="0" align="center">
			<tr align="center">
			<td class="cat" width="30">序号</td>
				<td class="cat" width="120">索引</td>
				<td class="cat">网址</td>
				<td class="cat" width="120">操作</td>
			</tr>
<!--loop:start key="record"-->
			<tr class="row" align="center">
				<td class="cat"><!--record_idx--></td>
				<td class="row"><input name="key[]" type="text" size="10" style="width:120px;" maxlength="10" value="<!--record_key-->" need="name_" /></td>
				<td class="row"><input name="value[]" type="text" size="10" style="width:450px;" maxlength="80" value="<!--record_value-->" need="url_" /></td>
				<td class="row" align="center">
					<input class="btn" type="button" onclick="add(this)" style="width:50px;" value="增加" />
					<input class="btn" type="button" onclick="del(this)" style="width:50px;" value="删除" />
				</td>
			</tr>
<!--loop:end-->
			<tr>
				<td class="row" colspan="4" align="center">
					<input class="btn" type="Submit" value=" 确认修改 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重置数据 " />
				</td>
			</tr>
		</table>
	</form>
</div>
<script Language="JavaScript">
function add(obj) {
	obj = $(obj).parent().parent().clone();
	obj.find("input:first").val("");
	obj.find("input").eq(1).val("");
	obj.find("td:first").text($("#input_area tr").length - 1);
	$("#input_area tr:last").before(obj);
}
function del(obj) {
	obj = $(obj).parent().parent();
	if(obj.find("input")[0].defaultValue.toLowerCase()!="default") obj.remove();
}
</script>