<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=rule_add">��Ӳɼ�����</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">���</td>
			<td class="cat">�ɼ���վ</td>
			<td class="cat">����˵��</td>
			<td class="cat" width="120">���ʱ��</td>
			<td class="cat" width="70">���²ɼ�</td>
			<td class="cat" width="110">��ز���</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_no--></td>
			<td class="row"><a href="<!--record_url-->" target="_blank"><!--record_name--></a> ��<!--record_counter-->��</td>
			<td class="row"><!--record_notes--></td>
			<td class="row"><!--record_date--></td>
			<td class="row" align="center">
				<a href="?method=snatch&id=<!--record_id-->">�ɼ�</a>&nbsp;
				<a href="?method=import&idx=<!--record_idx-->">����</a>
			</td>
			<td class="row" align="center">
				<a href="?method=rule_export&id=<!--record_id-->">����</a>&nbsp;
				<a href="?method=rule_edit&id=<!--record_id-->">�༭</a>&nbsp;
				<a href="?method=rule_delete&id=<!--record_id-->" onclick="return confirm('ȷ��ɾ������')">ɾ��</a>&nbsp;
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
