<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add&cat_id=<!--cat_id-->&web_id=<!--web_id-->">添加文章</a></div>
<div class="nav">
	<select onchange="location.href='?web_id=<!--web_id-->&cat_id='+this.options[this.selectedIndex].value+''">
		<option value="">全部文章</option>
<!--loop:start key="catalog"-->
		<option value="<!--catalog_cat_id-->" <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
	</select>
&nbsp;|&nbsp;
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?web_id=<!--web_id-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?web_id=<!--web_id-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
&nbsp;|&nbsp;
	关键字：<input type="text" size="8" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?web_id=<!--web_id-->&keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?web_id=<!--web_id-->&keyword='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center"> 
			<td class="cat" width="30"><a href="?keyword=<!--keyword-->&cat_id=<!--cat_id-->&web_id=<!--web_id-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=cat_id&order_type=<!--order_type-->&cat_id=<!--cat_id-->&web_id=<!--web_id-->"><font color="#000000">栏目</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=subject&order_type=<!--order_type-->&cat_id=<!--cat_id-->&web_id=<!--web_id-->"><font color="#000000">文章标题</font></a></td>
			<td class="cat" width="80"><a href="?keyword=<!--keyword-->&order=add_user&order_type=<!--order_type-->&cat_id=<!--cat_id-->&web_id=<!--web_id-->"><font color="#000000">录入人</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=add_date&order_type=<!--order_type-->&cat_id=<!--cat_id-->&web_id=<!--web_id-->"><font color="#000000">录入日期</font></a></td>
			<td class="cat" width="90"><font color="#000000">相关操作</font></td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_news_id--></td>
			<td class="row"><a href="?cat_id=<!--record_cat_id-->&web_id=<!--record_web_id-->" /><!--record_cat_name--></a></td>
			<td class="row" align="left"><a href="<!--record_link-->" target="_blank"><!--record_subject--></a></td>
			<td class="row"><!--record_add_user--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row">
				<a href="?method=unlock&web_id=<!--record_web_id-->&news_id=<!--record_news_id-->">解锁</a>
				<a href="?method=edit&web_id=<!--record_web_id-->&news_id=<!--record_news_id-->">修改</a>
				<a href="?method=delete&web_id=<!--record_web_id-->&news_id=<!--record_news_id-->" onclick="return confirm('是否确定要删除该文章？')">删除</a>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	<select onchange="location.href='?web_id=<!--web_id-->&cat_id='+this.options[this.selectedIndex].value+''">
		<option value="">全部文章</option>
<!--loop:start key="catalog"-->
		<option value="<!--catalog_cat_id-->" <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
	</select>
&nbsp;|&nbsp;
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?web_id=<!--web_id-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?web_id=<!--web_id-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
&nbsp;|&nbsp;
	关键字：<input type="text" size="8" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?web_id=<!--web_id-->&keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?web_id=<!--web_id-->&keyword='+this.previousSibling.value" />
</div>
