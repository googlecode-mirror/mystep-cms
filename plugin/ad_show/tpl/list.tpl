<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加广告</a></div>
<div class="nav">
	共有 <!--page_count--> 页，当前为第 <!--page_cur--> 页，
	<a href="<!--page_first-->">首页</a>
	<a href="<!--page_prev-->">上页</a>
	<a href="<!--page_next-->">下页</a>
	<a href="<!--page_last-->">末页</a>
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"> <input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30"><a href="?order_type=<!--order_type-->&expire=<!--expire-->"><font color="#000000">编号</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=ad_client&expire=<!--expire-->"><font color="#000000">客户名称</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=ad_text&expire=<!--expire-->"><font color="#000000">显示文字</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=ad_mode&expire=<!--expire-->"><font color="#000000">广告类型</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=view&expire=<!--expire-->"><font color="#000000">显示次数</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=click&expire=<!--expire-->"><font color="#000000">点击次数</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=add_date&expire=<!--expire-->"><font color="#000000">发布日期</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=exp_date&expire=<!--expire-->"><font color="#000000">过期时间</font></a></td>
			<td class="cat" width="60">相关操作</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><a href="<!--record_ad_url-->" title="<!--record_ad_text-->" target="_blank"><!--record_ad_client--></a> [<a href="<!--record_ad_file-->" target="_blank">查看</a>]</td>
			<td class="row"><!--record_ad_text--></td>
			<td class="row"><!--record_ad_mode--></td>
			<td class="row"><!--record_view--></td>
			<td class="row"><!--record_click--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row"><!--record_exp_date--></td>
			<td class="row">
				<a href="?method=export&id=<!--record_id-->">查看</a>
				<a href="?method=edit&id=<!--record_id-->">修改</a>
				<a href="?method=delete&id=<!--record_id-->" onclick="return confirm('是否确认删除该项目？')">删除</a>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	共有 <!--page_count--> 页，当前为第 <!--page_cur--> 页，
	<a href="<!--page_first-->">首页</a>
	<a href="<!--page_prev-->">上页</a>
	<a href="<!--page_next-->">下页</a>
	<a href="<!--page_last-->">末页</a>
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"> <input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.previousSibling.value">
</div>
