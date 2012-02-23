<div class="title"><!--title--></div>
<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，&nbsp;
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat"><a href="?order=date&order_type=<!--order_type-->"><font color="#000000">统计日期</font></a></td>
			<td class="cat"><a href="?order=pv&order_type=<!--order_type-->"><font color="#000000">访问页数</font></a></td>
			<td class="cat"><a href="?order=iv&order_type=<!--order_type-->"><font color="#000000">访问人数</font></a></td>
			<td class="cat"><a href="?order=online&order_type=<!--order_type-->"><font color="#000000">最大在线人数</font></a></td>
		</tr>
<!--if:start key="empty"-->
		<tr align="center">
			<td class="row" style="padding:5px;font-size:16px;" width="100%" colspan="4"><br /><center>尚无任何相关管理记录，或者记录已被清空！</center><br /></td>
		</tr>
<!--if:end-->
<!--loop:start key="record" time="20"-->
		<tr class="row" align="center">
			<td><!--record_date--></td>
			<td><!--record_pv--></a></td>
			<td><!--record_iv--></td>
			<td><!--record_online--></td>
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
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value">
</div>
