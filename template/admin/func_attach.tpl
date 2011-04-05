<div class="title"><!--title--></div>
<div class="nav">
	<a href="?method=clear" onclick="return confirm('是否确认清除 3 天以前引用次数小于 5 次的未关联附件')">清除未关联附件</a>
	&nbsp;|&nbsp;
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，&nbsp;
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
	&nbsp;|&nbsp;
	关键字：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value" />
</div>
<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center"> 
					<td class="cat" width="40"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
					<td class="cat" width="55"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=news_id"><font color="#000000">新闻索引</font></a></td>
					<td class="cat"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_name"><font color="#000000">附件名称</font></a></td>
					<td class="cat" width="100"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_type"><font color="#000000">附件类型</font></a></td>
					<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_size"><font color="#000000">附件大小</font></a></td>
					<td class="cat" width="80"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_time"><font color="#000000">上传时间</font></a></td>
					<td class="cat" width="55"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_count"><font color="#000000">下载次数</font></a></td>
					<td class="cat" width="55">相关操作</td>
				</tr>
<!--loop:start key="record" time="20"-->
				<tr align="center">
					<td class="row"><!--record_id--></td>
					<td class="row"><!--record_news_id--></td>
					<td class="row" align="left"><a href="<!--record_web_url-->/files?<!--record_id-->" target="_blank"><!--record_file_name--></a></td>
					<td class="row"><!--record_file_type--></td>
					<td class="row"><!--record_file_size--></td>
					<td class="row"><!--record_file_time--></td>
					<td class="row"><!--record_file_count--></td>
					<td class="row"><a href="?method=delete&id=<!--record_id-->" onclick="return confirm('是否确认删除该附件？')">删除</a></td>
				</tr>
<!--loop:end-->
			</table>
</div>
<div class="nav">
	<a href="?method=clear" onclick="return confirm('是否确认清除 3 天以前引用次数小于 5 次的未关联附件')">清除未关联附件</a>
	&nbsp;|&nbsp;
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，&nbsp;
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
	&nbsp;|&nbsp;
	关键字：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value" />
</div>
