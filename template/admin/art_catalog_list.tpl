<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">��ӷ���</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center"> 
			<td class="cat" width="60">���</td>
			<td class="cat" width="80">������վ</td>
			<td class="cat">��Ŀ����</td>
			<td class="cat" width="40">��λ</td>
			<td class="cat" width="40">��λ</td>
			<td class="cat" width="60">����</td>
			<td class="cat" width="60">��Ѷ</td>
		</tr>
<!--loop:start key="record"-->
		<tr align="center">
			<td class="row" align="center"><!--record_cat_id--></td>
			<td class="row" align="center"><!--record_web_name--></td>
			<td class="row" align="left"><a href="../list.php?cat=<!--record_cat_idx-->" title="<!--record_cat_comment-->" target="_blank"><!--record_cat_name--></a></td>
			<td class="row" align="center"><a href="?method=up&cat_id=<!--record_cat_id-->">��</a></td>
			<td class="row" align="center"><a href="?method=down&cat_id=<!--record_cat_id-->">��</a></td>
			<td class="row" align="center"><a href="?method=edit&cat_id=<!--record_cat_id-->">�޸�</a> <a href="?method=delete&cat_id=<!--record_cat_id-->" onclick="return confirm('�ò�����ɾ����ǰ���������Ŀ��������Ϣ��\n\n�밴ȷ��������')">ɾ��</a></td>
			<td class="row" align="center"><a href="art_content.php?method=add&cat_id=<!--record_cat_id-->&web_id=<!--record_web_id-->">���</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
