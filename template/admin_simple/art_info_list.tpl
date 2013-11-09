<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add&web_id=<!--web_id-->">添加内容</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat">展示标题</td>
			<td class="cat">展示内容</td>
			<td class="cat" width="60">操作</td>
		</tr>
<!--loop:start key="record" time="15"-->
		<tr class="row" align="center">
			<td align="left"><!--record_subject--></td>
			<td align="left"><!--record_content--></td>
			<td align="center"><a href="?method=edit&web_id=<!--record_web_id-->&id=<!--record_id-->">修改</a> <a href="?method=delete&web_id=<!--record_web_id-->&id=<!--record_id-->" onclick="return confirm('请按确定继续。')">删除</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
