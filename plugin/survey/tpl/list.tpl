<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加投票</a></div>
<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30"><a href="?order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=subject"><font color="#000000">调查主题</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=`describe`"><font color="#000000">调查描述</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=max_select"><font color="#000000">投票模式</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=add_date"><font color="#000000">添加日期</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=expire"><font color="#000000">有效时间</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=user_lvl"><font color="#000000">投票级别</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=times"><font color="#000000">参与人数</font></a></td>
			<td class="cat" width="120">相关操作</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row" align="left"><a href="<!--record_link-->" target="_blank"><!--record_subject--></a></td>
			<td class="row" align="left"><!--record_describe--></td>
			<td class="row"><!--record_max_select--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row"><!--record_expire--></td>
			<td class="row"><!--record_user_lvl--></td>
			<td class="row"><!--record_times--></td>
			<td class="row">
				<a href="?method=export&id=<!--record_id-->">导出</a> 
				<a href="?method=edit&id=<!--record_id-->">修改</a> 
				<a href="?method=delete&id=<!--record_id-->" onclick="return confirm('是否确认删除该投票项目？')">删除</a>
				<a href="/module.php?m=survey&id=<!--record_id-->" target="_blank">前台</a>
			</td>
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
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value" />
</div>
</div>