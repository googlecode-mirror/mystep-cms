<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">�����վ</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">���</td>
			<td class="cat" width="80">��վ����</td>
			<td class="cat">��վ����</td>
			<td class="cat">��վ����</td>
			<td class="cat" width="60">��ز���</td>
		</tr>
<!--loop:start key="record" time="15"-->
		<tr class="row" align="center">
			<td><!--record_web_id--></td>
			<td><!--record_name--></td>
			<td><!--record_idx--></td>
			<td><!--record_host--></td>
			<td align="center"><a href="?method=edit&web_id=<!--record_web_id-->">�޸�</a> <a href="?method=delete&web_id=<!--record_web_id-->" onclick="return confirm('�ò�����������վ�����Ϣ�� �밴ȷ��������')">ɾ��</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
<script language="JavaScript">
parent.website = <!--website-->;
parent.admin_cat = <!--admin_cat-->;
parent.setNav();
</script>

