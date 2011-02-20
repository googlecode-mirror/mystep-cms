<div class="title"><!--title--></div>
<div align="center">
	<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td align="center">
				<center>
				<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
					<tr align="center">
						<td class="cat" width="30">编号</td>
						<td class="cat" width="100">插件名称</td>
						<td class="cat" width="60">插件版本</td>
						<td class="cat">插件描述</td>
						<td class="cat">版权信息</td>
						<td class="cat" width="60">相关操作</td>
					</tr>
<!--loop:start key="plugin_list" time="15"-->
					<tr align="center">
						<td class="row"><!--plugin_list_id--></td>
						<td class="row"><!--plugin_list_name--></td>
						<td class="row"><!--plugin_list_ver--></td>
						<td class="row"><!--plugin_list_intro--></td>
						<td class="row"><!--plugin_list_copyright--></td>
						<td class="row" align="center">
							<a style="display:<!--plugin_list_uninstall-->" href="?method=setting&idx=<!--plugin_list_idx-->">设置</a> 
							<a style="display:<!--plugin_list_install-->" href="?method=install&idx=<!--plugin_list_idx-->">安装</a> 
							<a style="display:<!--plugin_list_uninstall-->" href="?method=uninstall&idx=<!--plugin_list_idx-->" onclick="return confirm('是否确认删除该插件？ 请按确定继续。')">卸载</a>
						</td>
					</tr>
<!--loop:end-->
				</table>
				</center>
			</td>
		</tr>
	</table>
</div>
