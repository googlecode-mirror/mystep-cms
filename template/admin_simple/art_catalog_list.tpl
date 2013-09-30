<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">添加分类</a></div>
<div align="center">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?method=order" onsubmit="return checkForm(this)">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40">排序</td>
			<td class="cat">所属网站</td>
			<td class="cat">栏目名称</td>
			<td class="cat" width="40">升位</td>
			<td class="cat" width="40">降位</td>
			<td class="cat" width="60">操作</td>
			<td class="cat" width="60">资讯</td>
		</tr>
<!--loop:start key="record"-->
		<tr class="row" align="center">
			<td align="center"><input name="cat_id[]" type="hidden" value="<!--record_cat_id-->" /><input name="cat_order[]" type="text" value="<!--record_cat_order-->" size="2" need="digital" /></td>
			<td align="center"><!--record_web_name--></td>
			<td align="left"><a href="../list.php?cat=<!--record_cat_id-->" title="<!--record_cat_comment-->" target="_blank"><!--record_cat_name--></a></td>
			<td align="center"><a href="?method=up&cat_id=<!--record_cat_id-->">↑</a></td>
			<td align="center"><a href="?method=down&cat_id=<!--record_cat_id-->">↓</a></td>
			<td align="center"><a href="?method=edit&cat_id=<!--record_cat_id-->">修改</a> <a href="?method=delete&cat_id=<!--record_cat_id-->" onclick="return confirm('该操作将删除当前类别及其子栏目的所有信息！\\\\n\\\\n请按确定继续。')">删除</a></td>
			<td align="center"><a href="art_content.php?method=add&cat_id=<!--record_cat_id-->&web_id=<!--record_web_id-->">添加</a></td>
		</tr>
<!--loop:end-->
		<tr class="row">
			<td colspan="8" align="center">
				<input class="btn" type="Submit" value=" 确 认 " />&nbsp;&nbsp;
				<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
			</td>
		</tr>
	</table>
	</form>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
if(parent.showCat!=null) {
	parent.group=<!--group-->;
	parent.group.power_cat = "," + parent.group.power_cat + ",";
	parent.group.power_web = "," + parent.group.power_web + ",";
	parent.group.power_func = "," + parent.group.power_func + ",";
	parent.news_cat = <!--news_cat-->;
	parent.showCat(parent.document.getElementById("cat_tree"), parent.getWebCat(<!--web_id-->), true);
}
//]]> 
</script>
