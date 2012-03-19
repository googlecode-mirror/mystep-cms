<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加新类型</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">编号</td>
			<td class="cat" width="80">类型名称</td>
<!--loop:start key="user_power"-->
			<td class="cat"><!--user_power_name--></td>
<!--loop:end-->
			<td class="cat" width="60">相关操作</td>
		</tr>
<!--loop:start key="record"-->
		<tr class="row" align="center">
			<td><!--record_type_id--></td>
			<td><!--record_type_name--></td>
			<!--record_user_power-->
			<td align="center"><a href="?method=edit&type_id=<!--record_type_id-->">修改</a> <a href="?method=delete&type_id=<!--record_type_id-->" onclick="return confirm('该操作将影响所有相关类型用户！ 请按确定继续。')">删除</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
