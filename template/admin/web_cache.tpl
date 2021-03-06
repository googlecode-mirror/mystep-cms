<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
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
				<td class="row" colspan="4">页面缓存：
					<input type="radio" class="cbox" id="cache_1" name="cache" value="true" <!--cache_1--> /><label for="cache_1">开启</label>
					<input type="radio" class="cbox" id="cache_2" name="cache" value="false" <!--cache_2--> /><label for="cache_2">关闭</label>
					<span class="comment">开启页面缓存，减少固定时间内的查询频率，增强网站效率</span>
				</td>
			</tr>
			<tr>
				<td class="row" colspan="4">数据缓存：
<?PHP
include(ROOT_PATH."/include/config-detail.php");
echo "<select name=\"cache_mode\">\n";
foreach($setting_type['web']['cache_mode'][1] as $key => $value) {
	$checked = $value==$setting['web']['cache_mode']?"selected":"";
	echo '<option value="'.$value.'" '.$checked.'>'.$key.'</option>'."\n";
}
echo "</select>";
?>
					<span class="comment">开启数据缓存，减少数据重复查询，以提高效率</span>
				</td>
			</tr>
			<tr>
				<td class="row" colspan="4">
					缓存清理：
					<input type="checkbox" class="cbox" id="ccache_1" name="ccache[]" value="1" /><label for="ccache_1">模板缓存</label>
					<input type="checkbox" class="cbox" id="ccache_2" name="ccache[]" value="2" /><label for="ccache_2">变量缓存</label>
					<input type="checkbox" class="cbox" id="ccache_3" name="ccache[]" value="3" /><label for="ccache_3">脚本缓存</label>
					<input type="checkbox" class="cbox" id="ccache_4" name="ccache[]" value="4" /><label for="ccache_4">插件缓存</label>
					<input type="checkbox" class="cbox" id="ccache_5" name="ccache[]" value="5" /><label for="ccache_5">会话缓存</label>
					<input type="checkbox" class="cbox" id="ccache_8" name="ccache[]" value="6" /><label for="ccache_8">图片缓存</label>
					<input type="checkbox" class="cbox" id="ccache_6" name="ccache[]" value="7" checked /><label for="ccache_6">页面缓存</label>
					<input type="checkbox" class="cbox" id="ccache_7" name="ccache[]" value="8" checked /><label for="ccache_7">数据缓存</label>
					&nbsp; <input class="btn" type="button" onclick="cclean()" value="清理" /><br />
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
					<input type="checkbox" class="cbox" id="ccache_all" onclick="checkIt(this.checked)" /><label for="ccache_all">全选</label>
					&nbsp;&nbsp; 
					<span class="comment">清理缓存所占用的磁盘空间，也可以使相关更改立即生效</span>
					
				</td>
			</tr>
			<tr>
				<td class="row" colspan="4" align="center">
					<input class="btn" type="Submit" value=" 确认修改 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重置数据 " />&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	</form>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
function add(obj) {
	obj = $(obj).parent().parent().clone();
	obj.find("input:first").val("");
	obj.find("td:first").text($("#input_area tr").length - 5);
	$("#input_area tr:last").prev().prev().prev().before(obj);
}

function del(obj) {
	obj = $(obj).parent().parent();
	if(obj.find("input")[0].defaultValue.toLowerCase()!="default") obj.remove();
}

function cclean() {
	loadingShow("正在清空网站缓存，请耐心等待！");
	var theForm = $("form").get(0);
	theForm.action = "?clean";
	theForm.submit();
}
function checkIt(mode) {
	$("input[name='ccache[]']").attr("checked", mode);
}
//]]> 
</script>