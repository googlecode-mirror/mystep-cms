<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add&web_id=<!--web_id-->">�������</a></div>
<div class="nav">
	<select name="web_id" style="width:120px;text-align:center;" onchange="location.href='?web_id='+this.value">
		<option value="">ȫ��</option>
<!--loop:start key="website"-->
		<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
	</select>
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center"> 
			<td class="cat" width="60">���</td>
			<td class="cat">չʾ����</td>
			<td class="cat">չʾ����</td>
			<td class="cat" width="60">����</td>
		</tr>
<!--loop:start key="record" time="15"-->
		<tr class="row" align="center">
			<td align="center"><!--record_id--></td>
			<td align="left"><!--record_subject--></td>
			<td align="left"><!--record_content--></td>
			<td align="center"><a href="?method=edit&id=<!--record_id-->">�޸�</a> <a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�밴ȷ��������')">ɾ��</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
