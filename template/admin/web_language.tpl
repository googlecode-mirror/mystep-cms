<div class="title"><!--title--></div>
<div align="center">
	<form method="post" action="?update">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr> 
				<td class="cat" colspan="4">语言设置</td>
			</tr>
			<tr>
				<td class="row" colspan="4">
					语言选择：
					<select name="cur_lng" onchange="location.href='?cur_lng='+this.value">
						<option value="">默认语言</option>
<!--loop:start key="lng"-->
						<option value="<!--lng_name-->" <!--lng_selected-->><!--lng_name--></option>
<!--loop:end-->
					</select>
					作者：<a href="mailto:<!--lng_info_email-->"><!--lng_info_author--></a>（<!--lng_info_update--> For <!--lng_info_for-->）
				</td>
			</tr>
			<tr align="center"> 
				<td class="cat" width="30">序号</td>
				<td class="cat" width="120">语言索引</td>
				<td class="cat">显示文字</td>
				<td class="cat" width="60">操作</td>
			</tr>
<!--loop:start key="language"-->
			<tr> 
				<td class="cat"><!--language_idx--></td>
				<td class="row"><!--language_key--></td>
				<td class="row"><input name="language[<!--language_key-->]" type="text" size="10" style="width:500px;" maxlength="200" value="<!--language_value-->" /></td>
				<td class="row" align="center">
					<input class="btn" type="button" onclick="del(this)" style="width:50px;" value="删除" />
				</td>
			</tr>
<!--loop:end-->
			<tr> 
				<td class="cat" colspan="4">添加语言（会依据现有设置生成新的语言包，仅仅修改时，请留空！）</td>
			</tr>
			<tr> 
				<td class="row" colspan="4">
					语言索引：<input name="lng_new_idx" type="text" size="10" maxlength="200" value="" /> &nbsp; &nbsp;
					语言作者：<input name="lng_new_author" type="text" size="10" maxlength="200" value="" />
				</td>
			</tr>
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
function del(obj) {
	obj = $(obj).parent().parent();
	if(obj.find("input")[0].defaultValue.toLowerCase()!="default") obj.remove();
}
</script>