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
		<tr class="row" align="center">
			<td><!--record_id--></td>
			<td><!--record_name--></td>
			<td><!--record_keyword--></td>
			<td><img src="<!--record_image-->" height="60" /></td>
			<td align="center"><a href="?method=edit&web_id=<!--record_web_id-->&id=<!--record_id-->">�༭</a> <a href="?method=delete&web_id=<!--record_web_id-->&id=<!--record_id-->" onclick="return confirm('�ò��������ɻָ����밴ȷ��������')">ɾ��</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
