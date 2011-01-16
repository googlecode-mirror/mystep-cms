<div class="title"><!--title--></div>
<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页， &nbsp;
	<a href="<!--page_first-->">首页</a> &nbsp;
	<a href="<!--page_prev-->">上页</a> &nbsp;
	<a href="<!--page_next-->">下页</a> &nbsp;
	<a href="<!--page_last-->">末页</a> &nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value"> &nbsp;
  （<a href="###" onclick="location.href='?method=clear'">清空日志</a> | <a href="###" onclick="location.href='?method=download'">保存日志</a>）
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center"> 
			<td class="cat" width="30"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
			<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=user&order_type=<!--order_type-->"><font color="#000000">管理员</font></a></td>
			<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=group&order_type=<!--order_type-->"><font color="#000000">级别</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=link&order_type=<!--order_type-->"><font color="#000000">页面</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=comment&order_type=<!--order_type-->"><font color="#000000">维护说明</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=time&order_type=<!--order_type-->"><font color="#000000">时间</font></a></td>
		</tr>
<!--if:start key="empty"-->
		<tr align="center">
			<td class="row" style="padding:5px;font-size:16px;" width="100%" colspan="10"><br /><center>尚无任何相关管理记录，或者记录已被清空！</center><br /></td>
		</tr>
<!--if:end-->
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><!--record_user--></td>
			<td class="row"><!--record_group--></a></td>
			<td class="row" align="left"><!--record_link--></td>
			<td class="row"><!--record_comment--></a></td>
			<td class="row"><!--record_time--></td>
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
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value"> &nbsp;
  （<a href="###" onclick="location.href='?method=clear'">清空日志</a> | <a href="###" onclick="location.href='?method=download'">保存日志</a>）
</div>
