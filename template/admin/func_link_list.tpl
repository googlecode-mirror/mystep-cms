<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">�������</a></div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40"><a href="?order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=link_name"><font color="#000000">��������</font></a></td>
			<td class="cat" width="200"><a href="?order_type=<!--order_type-->&order=image"><font color="#000000">����ͼ��</font></a></td>
			<td class="cat" width="80"><a href="?order_type=<!--order_type-->&order=level"><font color="#000000">��ʾ����</font></a></td>
			<td class="cat" width="60">��ز���</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row" align="left"><a href="<!--record_link_url-->" target="_blank"><!--record_link_name--></a></td>
			<td class="row"><!--record_image--></td>
			<td class="row"><!--record_level--></td>
			<td class="row"><a href="?method=edit&id=<!--record_id-->">�޸�</a> <a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�Ƿ�ȷ��ɾ������Ŀ��')">ɾ��</a></td>
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
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value">
</div>
