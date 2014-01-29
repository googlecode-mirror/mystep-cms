<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加项目</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="50">索引</td>
			<td class="cat">主题</td>
			<td class="cat" width="50">总数</td>
			<td class="cat" width="50">未处理</td>
			<td class="cat" width="50">处理中</td>
			<td class="cat" width="50">已完结</td>
			<td class="cat" width="120">最后提问</td>
			<td class="cat" width="120">相关操作</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center" class="row">
			<td><!--record_idx--></td>
			<td><a href="?method=list&idx=<!--record_idx-->" target="_blank"><!--record_topic--></a></td>
			<td><!--record_total--></td>
			<td><!--record_untreated--></td>
			<td><!--record_processing--></td>
			<td><!--record_done--></td>
			<td><!--record_lastpost--></td>
			<td align="center">
				<a href="?method=list&idx=<!--record_idx-->" target="_blank">查看</a>
				<a href="?method=edit&idx=<!--record_idx-->">修改</a>
				<a href="?method=delete_topic&idx=<!--record_idx-->" onclick="return confirm('是否确认删除该主题及所有问题？')">删除</a>
				<a href="/module.php?m=ticket&idx=<!--record_idx-->" target="_blank">前台</a>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
