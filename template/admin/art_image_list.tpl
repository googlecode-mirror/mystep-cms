<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">���ͼʾ</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat"><a href="?order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat"><a href="?order=name&order_type=<!--order_type-->"><font color="#000000">����</font></a></td>
			<td class="cat"><a href="?order=keyword&order_type=<!--order_type-->"><font color="#000000">�ؼ���</font></a></td>
			<td class="cat"><a href="?order=image&order_type=<!--order_type-->"><font color="#000000">ͼƬ</font></a></td>
			<td class="cat"><font color="#000000">��ز���</font></td>
		</tr>
<!--loop:start key="record" time="15"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><!--record_name--></td>
			<td class="row"><!--record_keyword--></td>
			<td class="row"><img src="<!--record_image-->" height="60" /></td>
			<td class="row" align="center"><a href="?method=edit&id=<!--record_id-->">�༭</a> <a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�ò��������ɻָ����밴ȷ��������')">ɾ��</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
