<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">��ӹ���</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="120">���</td>
			<td class="cat" width="120">���ҳ��</td>
			<td class="cat">��������</td>
			<td class="cat" width="60">����</td>
		</tr>
<!--loop:start key="record" time="15"-->
		<tr class="row" align="center">
			<td align="center"><!--record_idx--></td>
			<td align="center"><!--record_page--></td>
			<td align="left"><!--record_description--></td>
			<td align="center"><a href="?method=edit&idx=<!--record_idx-->">�޸�</a> <a href="?method=delete&idx=<!--record_idx-->" onclick="return confirm('�밴ȷ��������')">ɾ��</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
