<div class="title"><!--title--></div>
<div class="nav">
	<a href="?method=rebuild">重新整理</a>
	&nbsp;|&nbsp;
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页， &nbsp;
	<a href="<!--page_first-->">首页</a> &nbsp;
	<a href="<!--page_prev-->">上页</a> &nbsp;
	<a href="<!--page_next-->">下页</a> &nbsp;
	<a href="<!--page_last-->">末页</a> &nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
	&nbsp;|&nbsp;
	关键字：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=tag&order_type=<!--order_type-->"><font color="#000000">关键字</font></a></td>
			<td class="cat" width="80"><a href="?keyword=<!--keyword-->&order=count&order_type=<!--order_type-->"><font color="#000000">出现次数</font></a></td>
			<td class="cat" width="80"><a href="?keyword=<!--keyword-->&order=click&order_type=<!--order_type-->"><font color="#000000">点击次数</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=add_date&order_type=<!--order_type-->"><font color="#000000">发表时间</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=update_date&order_type=<!--order_type-->"><font color="#000000">更新时间</font></a></td>
			<td class="cat" width="80">相关操作</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><a href="<!--record_link-->" target="_blank"><!--record_tag--> </a></td>
			<td class="row"><!--record_count--></td>
			<td class="row"><!--record_click--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row"><!--record_update_date--></td>
			<td class="row" align="center"><a href="?method=delete&id=<!--record_id-->&web_id=<!--web_id-->">删除</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	<a href="?method=rebuild">重新整理</a>
	&nbsp;|&nbsp;
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页， &nbsp;
	<a href="<!--page_first-->">首页</a> &nbsp;
	<a href="<!--page_prev-->">上页</a> &nbsp;
	<a href="<!--page_next-->">下页</a> &nbsp;
	<a href="<!--page_last-->">末页</a> &nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
	&nbsp;|&nbsp;
	关键字：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value" />
</div>
