<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">����û���</a></div>
<div align="center">
	<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td align="center">
				<center>
				<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
					<tr align="center">
						<td class="cat" width="30">���</td>
						<td class="cat" width="80">��������</td>
<!--loop:start key="user_power"-->
						<td class="cat"><!--user_power_name--></td>
<!--loop:end-->
						<td class="cat" width="60">��ز���</td>
					</tr>
<!--loop:start key="record"-->
					<tr align="center">
						<td class="row"><!--record_type_id--></td>
						<td class="row"><!--record_type_name--></td>
						<!--record_user_power-->
						<td class="row" align="center"><a href="?method=edit&type_id=<!--record_type_id-->">�޸�</a> <a href="?method=delete&type_id=<!--record_type_id-->" onclick="return confirm('�ò�����Ӱ��������������û��� �밴ȷ��������')">ɾ��</a></td>
					</tr>
<!--loop:end-->
				</table>
				</center>
			</td>
		</tr>
	</table>
</div>
