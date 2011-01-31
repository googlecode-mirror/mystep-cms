<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加分类</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center"> 
			<td class="cat" width="60">编号</td>
			<td class="cat" width="80">所属网站</td>
			<td class="cat">栏目名称</td>
			<td class="cat" width="40">升位</td>
			<td class="cat" width="40">降位</td>
			<td class="cat" width="60">操作</td>
			<td class="cat" width="60">资讯</td>
		</tr>
<!--loop:start key="record"-->
		<tr align="center">
			<td class="row" align="center"><!--record_cat_id--></td>
			<td class="row" align="center"><!--record_web_name--></td>
			<td class="row" align="left"><a href="../list.php?cat=<!--record_cat_idx-->" title="<!--record_cat_comment-->" target="_blank"><!--record_cat_name--></a></td>
			<td class="row" align="center"><a href="?method=up&cat_id=<!--record_cat_id-->">↑</a></td>
			<td class="row" align="center"><a href="?method=down&cat_id=<!--record_cat_id-->">↓</a></td>
			<td class="row" align="center"><a href="?method=edit&cat_id=<!--record_cat_id-->">修改</a> <a href="?method=delete&cat_id=<!--record_cat_id-->" onclick="return confirm('该操作将删除当前类别及其子栏目的所有信息！\n\n请按确定继续。')">删除</a></td>
			<td class="row" align="center"><a href="art_content.php?method=add&cat_id=<!--record_cat_id-->&web_id=<!--record_web_id-->">添加</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
