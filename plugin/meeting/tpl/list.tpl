<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加会议</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
	  <tr align="center">
	    <td class="cat" width="40">编号</td>
	    <td class="cat">所属网站</td>
	    <td class="cat">中文名称</td>
	    <td class="cat">备注信息</td>
	    <td class="cat">添加时间</td>
	    <td class="cat" width="100">相关操作</td>
	  </tr>
<!--loop:start key="record" time="20"-->
	  <tr align="center">
	    <td class="row"><!--record_mid--></td>
	    <td class="row"><!--record_web_id--></td>
	    <td class="row"><a href="manager.php?mid=<!--record_mid-->"><!--record_name--></a></td>
	    <td class="row"><!--record_notes--></td>
	    <td class="row"><!--record_add_date--></td>
	    <td class="row" align="center"><a href="?method=edit&mid=<!--record_mid-->">编辑</a> &nbsp;<a href="?method=delete&mid=<!--record_mid-->" onclick="return confirm('确认删除？？')">删除</a></td>
	  </tr>
<!--loop:end-->
	</table>
</center>
    </td>
  </tr>
</table>
</div>