<div class="title"><!--title--></div>
<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，&nbsp;
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value">
&nbsp;|&nbsp;
	关键字：<input type="text" size="10" value="<!--keyword-->"><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0">
		<tr align="center">
			<td class="cat" width="100"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">IP</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=username&order_type=<!--order_type-->"><font color="#000000">用户名称</font></a></td>
			<td class="cat" width="80"><a href="?keyword=<!--keyword-->&order=usertype&order_type=<!--order_type-->"><font color="#000000">所属群组</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=reflash&order_type=<!--order_type-->"><font color="#000000">刷新时间</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=url&order_type=<!--order_type-->"><font color="#000000">当前页面</font></a></td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_ip--></td>
			<td class="row"><!--record_username-->(<!--record_sid-->)</td>
			<td class="row"><!--record_usertype--></td>
			<td class="row"><!--record_reflash--></td>
			<td class="row" align="left"><a href="<!--record_url-->" target="_blank"><!--record_url--></a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，&nbsp;
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value">
&nbsp;|&nbsp;
	关键字：<input type="text" size="10" value="<!--keyword-->"><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value">
</div>
