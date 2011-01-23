<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?update" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr> 
				<td class="cat" colspan="4">缓存过期时间设置</td>
			</tr>
			<tr align="center"> 
				<td class="cat" width="30">序号</td>
				<td class="cat">页面文件名（用于缓存的php页面）</td>
				<td class="cat">缓存生效期（单位：秒）</td>
				<td class="cat" width="120">操作</td>
			</tr>
<!--loop:start key="expire"-->
			<tr> 
				<td class="cat"><!--expire_idx--></td>
				<td class="row"><input name="page[]" type="text" size="10" maxlength="10" value="<!--expire_page-->" need="alpha" /></td>
				<td class="row"><input name="expire[]" type="text" size="10" maxlength="20" value="<!--expire_expire-->" need="digital" /></td>
				<td class="row" align="center">
					<input class="btn" type="button" onclick="add(this)" style="width:50px;" value="增加" />
					<input class="btn" type="button" onclick="del(this)" style="width:50px;" value="删除" />
				</td>
			</tr>
<!--loop:end-->
			<tr>
				<td class="row" colspan="4">缓存模式：
					<input type="radio" class="cbox" id="cache_1" name="cache" value="true" <!--cache_1--> /><label for="cache_1">开启</label>
					<input type="radio" class="cbox" id="cache_2" name="cache" value="false" <!--cache_2--> /><label for="cache_2">关闭</label>
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
function add(obj) {
	obj = $(obj).parent().parent().clone();
	obj.find("input:first").val("");
	obj.find("td:first").text($("#input_area tr").length - 3);
	$("#input_area tr:last").prev().before(obj);
}

function del(obj) {
	obj = $(obj).parent().parent();
	if(obj.find("input")[0].defaultValue.toLowerCase()!="default") obj.remove();
}
</script>