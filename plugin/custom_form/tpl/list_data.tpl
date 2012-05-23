<div class="title"><!--title--></div>
<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	<!--custom_form_name-->
</div>
<div class="nav">
	<a href="?method=export&mid=<!--mid-->">导出数据</a>
 |
	新用户：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?method=add_data_ok&mid=<!--mid-->&name='+this.value" /><input type="button" value="添加" onclick="location.href='?method=add_data_ok&mid=<!--mid-->&name='+this.previousSibling.value" />
 |
	关键字：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?mid=<!--mid-->&keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?mid=<!--mid-->&keyword='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=name&order_type=<!--order_type-->"><font color="#000000">姓名</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=company&order_type=<!--order_type-->"><font color="#000000">公司</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=tel&order_type=<!--order_type-->"><font color="#000000">电话</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=add_date&order_type=<!--order_type-->"><font color="#000000">填表时间</font></a></td>
			<td class="cat" width="100">相关操作</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><a href="mailto:<!--record_email-->?subject=China+Garlic+2011"><!--record_name--></a></td>
			<td class="row"><a href="?method=edit&mid=<!--mid-->&id=<!--record_id-->"><!--record_company--></a></td>
			<td class="row"><!--record_tel--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row" align="center"><a href="?method=edit&mid=<!--mid-->&id=<!--record_id-->">编辑</a> &nbsp;<a href="?method=delete&mid=<!--mid-->&id=<!--record_id-->" onclick="return confirm('确认删除？？')">删除</a><!--record_confirm--></td>
		</tr>
<!--loop:end-->
	</table>
</center>
<div class="nav">
	共有 <!--page_count--> 页，当前为第 <!--page_cur--> 页，
	<a href="<!--page_first-->">首页</a>
	<a href="<!--page_prev-->">上页</a>
	<a href="<!--page_next-->">下页</a>
	<a href="<!--page_last-->">末页</a>
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" /><input type="button" value="GO" onclick="location.href='?mid=<!--mid-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
</div>
		</td>
	</tr>
</table>
</div>