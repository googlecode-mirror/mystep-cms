<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加用户权限</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">编号</td>
			<td class="cat">权限索引</td>
			<td class="cat">权限名称</td>
			<td class="cat">默认值</td>
			<td class="cat">要求格式</td>
			<td class="cat">权限描述</td>
			<td class="cat" width="60">相关操作</td>
		</tr>
<!--loop:start key="record"-->
		<tr class="row" align="center">
			<td><!--record_power_id--></td>
			<td><!--record_idx--></td>
			<td><!--record_name--></td>
			<td><!--record_value--></td>
			<td><!--record_format--></td>
			<td><!--record_comment--></td>
			<td align="center"><a href="?method=edit&power_id=<!--record_power_id-->">修改</a> <a href="?method=delete&power_id=<!--record_power_id-->" onclick="return confirm('请按确定继续。')">删除</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
