<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加链接</a></div>
<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40"><a href="?order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=link_name"><font color="#000000">链接名称</font></a></td>
			<td class="cat" width="200"><a href="?order_type=<!--order_type-->&order=image"><font color="#000000">链接图形</font></a></td>
			<td class="cat" width="80"><a href="?order_type=<!--order_type-->&order=level"><font color="#000000">显示级别</font></a></td>
			<td class="cat" width="60">相关操作</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row" align="left"><a href="<!--record_link_url-->" target="_blank"><!--record_link_name--></a></td>
			<td class="row"><!--record_image--></td>
			<td class="row"><!--record_level--></td>
			<td class="row"><a href="?method=edit&id=<!--record_id-->">修改</a> <a href="?method=delete&id=<!--record_id-->" onclick="return confirm('是否确认删除该项目？')">删除</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value">
</div>
