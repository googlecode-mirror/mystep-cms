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
<!--loop:start key="plugin_list" time="15"-->
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
				<a style="display:<!--plugin_list_uninstall-->" href="?method=uninstall&idx=<!--plugin_list_idx-->" onclick="return confirm('是否确认删除该插件？ 请按确定继续。')">卸载</a>
				<a style="display:<!--plugin_list_uninstall-->" href="?method=active&idx=<!--plugin_list_idx-->"><!--plugin_list_active--></a>
				<a style="display:<!--plugin_list_uninstall-->" href="?method=setting&idx=<!--plugin_list_idx-->">设置</a> 
			</td>
		</tr>
<!--loop:end-->
		<tr>
			<td colspan="8" align="center" class="cat">
				<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
				<input class="btn" type="reset" value=" 重 置 " />
			</td>
		</tr>
	</table>
	</form>
</div>
