<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加用户权限</a></div>
<div align="center">
	<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td align="center">
				<center>
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
					<tr align="center">
						<td class="row"><!--record_power_id--></td>
						<td class="row"><!--record_idx--></td>
						<td class="row"><!--record_name--></td>
						<td class="row"><!--record_value--></td>
						<td class="row"><!--record_format--></td>
						<td class="row"><!--record_comment--></td>
						<td class="row" align="center"><a href="?method=edit&power_id=<!--record_power_id-->">修改</a> <a href="?method=delete&power_id=<!--record_power_id-->" onclick="return confirm('请按确定继续。')">删除</a></td>
					</tr>
<!--loop:end-->
				</table>
				</center>
			</td>
		</tr>
	</table>
</div>
