<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">���ר��</a></div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value">
 |
	<input type="text" size="8" value="<!--keyword-->"><input type="button" value="����" onclick="location.href='?keyword='+this.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=topic_name&order_type=<!--order_type-->"><font color="#000000">ר������</font</a></td>
			<td class="cat"><font color="#000000">ר�����</font></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=add_date&order_type=<!--order_type-->"><font color="#000000">¼������</font></a></td>
			<td class="cat" width="60">��ز���</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_topic_id--></td>
			<td class="row" align="left"><a href="<!--record_topic_link-->" target="_blank"><!--record_topic_name--></a></td>
			<td class="row" align="left"><!--record_topic_intro--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row"><a href="?method=edit&topic_id=<!--record_topic_id-->">�޸�</a> <a href="?method=delete&topic_id=<!--record_topic_id-->" onclick="return confirm('�Ƿ�ȷ��ɾ������Ŀ��')">ɾ��</a></td>
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
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value">
 |
	<input type="text" size="8" value="<!--keyword-->"><input type="button" value="����" onclick="location.href='?keyword='+this.previousSibling.value">
</div>