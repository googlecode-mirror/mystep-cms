<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">����û�</a></div>
<div class="nav">
	<select onchange="location.href='?group_id='+this.options[this.selectedIndex].value" style="width:120px;">
		<option value="">��Ⱥѡ��</option>
<!--loop:start key="user_group"-->
		<option value="<!--user_group_group_id-->" <!--user_group_selected-->><!--user_group_group_name--></option>
<!--loop:end-->
	</select>&nbsp;
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value">
&nbsp;|&nbsp;
	�ؼ��֣�<input type="text" size="8" value="<!--keyword-->"><input type="button" value="����" onclick="location.href='?keyword='+this.previousSibling.value+'&group_id=<!--group_id-->'">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat"><a href="?keyword=<!--keyword-->&group_id=<!--group_id-->&order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&group_id=<!--group_id-->&order=username&order_type=<!--order_type-->"><font color="#000000">�û�����</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&group_id=<!--group_id-->&order=group_id&order_type=<!--order_type-->"><font color="#000000">�û���</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&group_id=<!--group_id-->&order=email&order_type=<!--order_type-->"><font color="#000000">�����ʼ�</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&group_id=<!--group_id-->&order=regdate&order_type=<!--order_type-->"><font color="#000000">ע������</font></a></td>
			<td class="cat"><font color="#000000">��ز���</font></td>
		</tr>
<!--loop:start key="record" time="15"-->
		<tr align="center">
			<td class="row"><!--record_user_id--></td>
			<td class="row"><!--record_username--></td>
			<td class="row"><!--record_group_name--></td>
			<td class="row"><a href="mailto:<!--record_email-->"><!--record_email--></a></td>
			<td class="row"><!--record_regdate--></td>
			<td class="row" align="center"><a href="?method=edit&user_id=<!--record_user_id-->">�༭</a> <a href="?method=delete&user_id=<!--record_user_id-->" onclick="return confirm('�ò��������ɻָ����밴ȷ��������')">ɾ��</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	<select onchange="location.href='?group_id='+this.options[this.selectedIndex].value" style="width:120px;">
		<option value="">��Ⱥѡ��</option>
<!--loop:start key="user_group"-->
		<option value="<!--user_group_group_id-->" <!--user_group_selected-->><!--user_group_group_name--></option>
<!--loop:end-->
	</select>&nbsp;
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value">
&nbsp;|&nbsp;
	�ؼ��֣�<input type="text" size="8" value="<!--keyword-->"><input type="button" value="����" onclick="location.href='?keyword='+this.previousSibling.value+'&group_id=<!--group_id-->'">
</div>
