<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">���ͶƱ</a></div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30"><a href="?order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=subject"><font color="#000000">��������</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=`describe`"><font color="#000000">��������</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=max_select"><font color="#000000">ͶƱģʽ</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=add_date"><font color="#000000">�������</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=expire"><font color="#000000">��Чʱ��</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=user_lvl"><font color="#000000">ͶƱ����</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=times"><font color="#000000">��������</font></a></td>
			<td class="cat" width="120">��ز���</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row" align="left"><a href="<!--record_link-->" target="_blank"><!--record_subject--></a></td>
			<td class="row" align="left"><!--record_describe--></td>
			<td class="row"><!--record_max_select--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row"><!--record_expire--></td>
			<td class="row"><!--record_user_lvl--></td>
			<td class="row"><!--record_times--></td>
			<td class="row">
				<a href="?method=export&id=<!--record_id-->">����</a> 
				<a href="?method=edit&id=<!--record_id-->">�޸�</a> 
				<a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�Ƿ�ȷ��ɾ����ͶƱ��Ŀ��')">ɾ��</a>
				<a href="/module.php?m=survey&id=<!--record_id-->" target="_blank">ǰ̨</a>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value" />
</div>
</div>