<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add&idx=<!--tpl_idx-->">添加模板</a></div>
<div class="nav">
	<select name="tpl" style="width:120px;text-align:center;" onchange="location.href='?idx='+this.value">
<!--loop:start key="tpl_list"-->
		<option value="<!--tpl_list_idx-->" <!--tpl_list_selected-->><!--tpl_list_idx--></option>
<!--loop:end-->
	</select>
</div>
<div align="center">
	<table id="list_area" cellspacing="0" cellpadding="0">
		<tr align="center">
			<td class="cat">模板文件</td>
			<td class="cat" width="80">文件大小</td>
			<td class="cat" width="80">文件属性</td>
			<td class="cat" width="120">修改时间</td>
			<td class="cat" width="80">操作</td>
		</tr>
<!--loop:start key="file"-->
		<tr class="row">
			<td><!--file_name--></td>
			<td><!--file_size--></td>
			<td><!--file_attr--></td>
			<td><!--file_time--></td>
			<td align="center">
				<a href="?method=edit&idx=<!--tpl_idx-->&file=<!--file_name-->">修改</a> &nbsp;
				<a href="?method=delete&idx=<!--tpl_idx-->&file=<!--file_name-->" onclick="return confirm('是否确定删除当前模板文件？')">删除</a></td>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
