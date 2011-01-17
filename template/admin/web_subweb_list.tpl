<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加网站</a></div>
<div align="center">
	<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td align="center">
				<center>
				<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
					<tr align="center">
						<td class="cat" width="30">编号</td>
						<td class="cat" width="80">网站名称</td>
						<td class="cat">网站索引</td>
						<td class="cat">网站域名</td>
						<td class="cat" width="60">相关操作</td>
					</tr>
<!--loop:start key="record" time="15"-->
					<tr align="center">
						<td class="row"><!--record_web_id--></td>
						<td class="row"><!--record_name--></td>
						<td class="row"><!--record_idx--></td>
						<td class="row"><!--record_host--></td>
						<td class="row" align="center"><a href="?method=edit&web_id=<!--record_web_id-->">修改</a> <a href="?method=delete&web_id=<!--record_web_id-->" onclick="return confirm('该操作将所有网站相关信息！ 请按确定继续。')">删除</a></td>
					</tr>
<!--loop:end-->
				</table>
				</center>
			</td>
		</tr>
	</table>
</div>