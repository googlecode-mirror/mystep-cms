<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加图示</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat"><a href="?order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat"><a href="?order=name&order_type=<!--order_type-->"><font color="#000000">名称</font></a></td>
			<td class="cat"><a href="?order=keyword&order_type=<!--order_type-->"><font color="#000000">关键字</font></a></td>
			<td class="cat"><a href="?order=image&order_type=<!--order_type-->"><font color="#000000">图片</font></a></td>
			<td class="cat"><font color="#000000">相关操作</font></td>
		</tr>
<!--loop:start key="record" time="15"-->
		<tr class="row" align="center">
			<td><!--record_id--></td>
			<td><!--record_name--></td>
			<td><!--record_keyword--></td>
			<td><img src="<!--record_image-->" height="60" /></td>
			<td align="center"><a href="?method=edit&web_id=<!--record_web_id-->&id=<!--record_id-->">编辑</a> <a href="?method=delete&web_id=<!--record_web_id-->&id=<!--record_id-->" onclick="return confirm('该操作将不可恢复！请按确定继续。')">删除</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
