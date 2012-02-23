<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加规则</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="120">编号</td>
			<td class="cat" width="120">相关页面</td>
			<td class="cat">功能描述</td>
			<td class="cat" width="60">操作</td>
		</tr>
<!--loop:start key="record" time="15"-->
		<tr class="row" align="center">
			<td align="center"><!--record_idx--></td>
			<td align="center"><!--record_page--></td>
			<td align="left"><!--record_description--></td>
			<td align="center"><a href="?method=edit&idx=<!--record_idx-->">修改</a> <a href="?method=delete&idx=<!--record_idx-->" onclick="return confirm('请按确定继续。')">删除</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
