<div class="title"><!--title--></div>
<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页， &nbsp;
	<a href="<!--page_first-->">首页</a> &nbsp;
	<a href="<!--page_prev-->">上页</a> &nbsp;
	<a href="<!--page_next-->">下页</a> &nbsp;
	<a href="<!--page_last-->">末页</a> &nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40"><a href="?order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat"><a href="?order=host&order_type=<!--order_type-->"><font color="#000000">来访主机</font></a></td>
			<td class="cat" width="80"><a href="?order=count_month&order_type=<!--order_type-->"><font color="#000000">本月出现次数</font></a></td>
			<td class="cat" width="80"><a href="?order=count_year&order_type=<!--order_type-->"><font color="#000000">本年出现次数</font></a></td>
			<td class="cat" width="80"><a href="?order=count&order_type=<!--order_type-->"><font color="#000000">总出现次数</font></a></td>
			<td class="cat" width="120"><a href="?order=add_date&order_type=<!--order_type-->"><font color="#000000">添加时间</font></a></td>
			<td class="cat" width="120"><a href="?order=chg_date&order_type=<!--order_type-->"><font color="#000000">更新时间</font></a></td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr class="row">
			<td align="center"><!--record_id--></td>
			<td><!--record_host--></td>
			<td><!--record_count_month--></td>
			<td><!--record_count_year--></td>
			<td><!--record_count--></td>
			<td><!--record_add_date--></td>
			<td><!--record_chg_date--></td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页， &nbsp;
	<a href="<!--page_first-->">首页</a> &nbsp;
	<a href="<!--page_prev-->">上页</a> &nbsp;
	<a href="<!--page_next-->">下页</a> &nbsp;
	<a href="<!--page_last-->">末页</a> &nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
</div>
