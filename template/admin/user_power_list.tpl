<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">����û�Ȩ��</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">���</td>
			<td class="cat">Ȩ������</td>
			<td class="cat">Ȩ������</td>
			<td class="cat">Ĭ��ֵ</td>
			<td class="cat">Ҫ���ʽ</td>
			<td class="cat">Ȩ������</td>
			<td class="cat" width="60">��ز���</td>
		</tr>
<!--loop:start key="record"-->
		<tr class="row" align="center">
			<td><!--record_power_id--></td>
			<td><!--record_idx--></td>
			<td><!--record_name--></td>
			<td><!--record_value--></td>
			<td><!--record_format--></td>
			<td><!--record_comment--></td>
			<td align="center"><a href="?method=edit&power_id=<!--record_power_id-->">�޸�</a> <a href="?method=delete&power_id=<!--record_power_id-->" onclick="return confirm('�밴ȷ��������')">ɾ��</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
