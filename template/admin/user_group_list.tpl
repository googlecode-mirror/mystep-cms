<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加用户组</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">编号</td>
			<td class="cat" width="80">组群名称</td>
			<td class="cat">管理权限</td>
			<td class="cat">网站权限</td>
			<td class="cat">栏目权限</td>
			<td class="cat" width="60">相关操作</td>
		</tr>
<!--loop:start key="record" time="15"-->
		<tr class="row" align="center">
			<td><!--record_group_id--></td>
			<td><!--record_group_name--></td>
			<td><!--record_power_func--></td>
			<td><!--record_power_web--></td>
			<td><!--record_power_cat--></td>
			<td align="center"><a href="?method=edit&group_id=<!--record_group_id-->">修改</a> <a href="?method=delete&group_id=<!--record_group_id-->" onclick="return confirm('该操作将影响所有组用户！ 请按确定继续。')">删除</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
