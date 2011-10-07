<div class="title"><!--title--></div>
<div class="nav">
	<a href="?method=news_truncate">清空已抓取文章</a>
 | 
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?method=news&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
&nbsp;|&nbsp;
	关键字：<input type="text" size="8" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?method=news&keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?method=news&keyword='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center"> 
			<td class="cat" width="30"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=original&order_type=<!--order_type-->"><font color="#000000">来源网站</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=subject&order_type=<!--order_type-->"><font color="#000000">新闻标题</font></a></td>
			<td class="cat" width="90"><font color="#000000">相关操作</font></td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><!--record_original--></td>
			<td class="row" align="left"><a href="<!--record_url-->" target="_blank"><!--record_subject--></a></td>
			<td class="row">
		<a href="?method=news_import&id=<!--record_id-->&idx=<!--record_idx-->">导入</a>
		<a href="?method=news_edit&id=<!--record_id-->">修改</a>
		<a href="?method=news_delete&id=<!--record_id-->" onclick="return confirm('是否确定要删除该新闻？')">删除</a>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	<a href="?method=news_truncate">清空已抓取文章</a>
 | 
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?method=news&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?method=news&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
&nbsp;|&nbsp;
	关键字：<input type="text" size="8" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?method=news&keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?method=news&keyword='+this.previousSibling.value" />
</div>