<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加用户</a></div>
<div class="nav">
	<select onchange="location.href='?type_id=<!--type_id-->&group_id='+this.options[this.selectedIndex].value" style="width:120px;">
		<option value="">组群选择</option>
<!--loop:start key="user_group"-->
		<option value="<!--user_group_group_id-->" <!--user_group_selected-->><!--user_group_group_name--></option>
<!--loop:end-->
	</select>&nbsp;
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
&nbsp;|&nbsp;
	关键字：<input type="text" size="8" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat"><a href="?keyword=<!--keyword-->&group_id=<!--group_id-->&type_id=<!--type_id-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&group_id=<!--group_id-->&type_id=<!--type_id-->&order=username&order_type=<!--order_type-->"><font color="#000000">用户名称</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&group_id=<!--group_id-->&type_id=<!--type_id-->&order=group_id&order_type=<!--order_type-->"><font color="#000000">用户组</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&group_id=<!--group_id-->&type_id=<!--type_id-->&order=email&order_type=<!--order_type-->"><font color="#000000">电子邮件</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&group_id=<!--group_id-->&type_id=<!--type_id-->&order=regdate&order_type=<!--order_type-->"><font color="#000000">注册日期</font></a></td>
			<td class="cat"><font color="#000000">相关操作</font></td>
		</tr>
<!--loop:start key="record" time="15"-->
		<tr class="row" align="center">
			<td><!--record_user_id--></td>
			<td><!--record_username--></td>
			<td><!--record_group_name--></td>
			<td><a href="mailto:<!--record_email-->" /><!--record_email--></a></td>
			<td><!--record_regdate--></td>
			<td align="center"><a href="?method=edit&user_id=<!--record_user_id-->">编辑</a> <a href="?method=delete&user_id=<!--record_user_id-->" onclick="return confirm('该操作将不可恢复！请按确定继续。')">删除</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	<select onchange="location.href='?group_id=<!--group_id-->&type_id='+this.options[this.selectedIndex].value" style="width:120px;">
		<option value="">类型选择</option>
<!--loop:start key="user_type"-->
		<option value="<!--user_type_type_id-->" <!--user_type_selected-->><!--user_type_type_name--></option>
<!--loop:end-->
	</select>&nbsp;
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
&nbsp;|&nbsp;
	关键字：<input type="text" size="8" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value">
</div>
