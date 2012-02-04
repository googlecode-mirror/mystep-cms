<div class="title"><!--title--></div>
<div align="center">
<form method="post" action="?method=order">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">排序</td>
			<td class="cat" width="30">编号</td>
			<td class="cat" width="100">插件名称</td>
			<td class="cat" width="60">插件版本</td>
			<td class="cat">插件描述</td>
			<td class="cat">版权信息</td>
			<td class="cat" width="90">相关操作</td>
		</tr>
<!--loop:start key="plugin_list"-->
		<tr class="row" align="center">
			<td>
				<input type="hidden" name="idx[]" value="<!--plugin_list_idx-->" size="2" />
				<input type="text" name="order[]" value="<!--plugin_list_order-->" size="2" />
			</td>
			<td><!--plugin_list_id--></td>
			<td><!--plugin_list_name--></td>
			<td><!--plugin_list_ver--></td>
			<td><!--plugin_list_intro--></td>
			<td><!--plugin_list_copyright--></td>
			<td align="center">
				<a style="display:<!--plugin_list_install-->" href="?method=view&idx=<!--plugin_list_idx-->">安装</a> 
				<a style="display:<!--plugin_list_install-->" href="?method=uninstall&idx=<!--plugin_list_idx-->" onclick="return confirm('本功能主要用于清除安装未成功的插件残留，可能会造成一些错误记录！ 请按确定继续。')">清除</a> 
				<a style="display:<!--plugin_list_uninstall-->" href="?method=uninstall&idx=<!--plugin_list_idx-->" onclick="return confirm('是否确认删除该插件？ 请按确定继续。')">卸载</a>
				<a style="display:<!--plugin_list_uninstall-->" href="?method=active&idx=<!--plugin_list_idx-->"><!--plugin_list_active--></a>
				<a style="display:<!--plugin_list_uninstall-->" href="?method=setting&idx=<!--plugin_list_idx-->">设置</a> 
				<a style="display:<!--plugin_list_install-->" href="?method=delete&idx=<!--plugin_list_idx-->" onclick="return confirm('是否确认删除当前插件？')">删除</a> 
			</td>
		</tr>
<!--loop:end-->
		<tr>
			<td colspan="8" align="center" class="cat">
				<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
				<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
				<input class="btn" type="button" value=" 导 入 " onclick="showPop('upload','导入插件','url','web_plugin.php?method=upload',420, 100)" />
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
var dp_list = "<!--dp_list-->";
if(dp_list.length>1) {
	alert("发现如下插件文件存在管理文件名重复，这将影响网站权限的分配，请确认并修正：\n\n" + dp_list);
}
</script>
