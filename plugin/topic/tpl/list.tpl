<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加专题</a></div>
<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value">
 |
	<input type="text" size="8" value="<!--keyword-->"><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=topic_name&order_type=<!--order_type-->"><font color="#000000">专题名称</font</a></td>
			<td class="cat"><font color="#000000">专题介绍</font></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=add_date&order_type=<!--order_type-->"><font color="#000000">录入日期</font></a></td>
			<td class="cat" width="60">相关操作</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_topic_id--></td>
			<td class="row" align="left"><a href="<!--record_topic_link-->" target="_blank"><!--record_topic_name--></a></td>
			<td class="row" align="left"><!--record_topic_intro--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row"><a href="?method=edit&topic_id=<!--record_topic_id-->">修改</a> <a href="?method=delete&topic_id=<!--record_topic_id-->" onclick="return confirm('是否确认删除该项目？')">删除</a></td>
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
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value">
 |
	<input type="text" size="8" value="<!--keyword-->"><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value">
</div>