<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=rule_add">添加采集规则</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">编号</td>
			<td class="cat">采集网站</td>
			<td class="cat">内容说明</td>
			<td class="cat" width="120">添加时间</td>
			<td class="cat" width="70">文章采集</td>
			<td class="cat" width="110">相关操作</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_no--></td>
			<td class="row"><a href="<!--record_url-->" target="_blank"><!--record_name--></a> （<!--record_counter-->）</td>
			<td class="row"><!--record_notes--></td>
			<td class="row"><!--record_date--></td>
			<td class="row" align="center">
				<a href="?method=snatch&id=<!--record_id-->">采集</a>&nbsp;
				<a href="?method=import&idx=<!--record_idx-->">导入</a>
			</td>
			<td class="row" align="center">
				<a href="?method=rule_export&id=<!--record_id-->">导出</a>&nbsp;
				<a href="?method=rule_edit&id=<!--record_id-->">编辑</a>&nbsp;
				<a href="?method=rule_delete&id=<!--record_id-->" onclick="return confirm('确认删除？？')">删除</a>&nbsp;
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
