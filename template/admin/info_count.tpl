<div class="title"><!--title--></div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��&nbsp;
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat"><a href="?order=date&order_type=<!--order_type-->"><font color="#000000">ͳ������</font></a></td>
			<td class="cat"><a href="?order=pv&order_type=<!--order_type-->"><font color="#000000">����ҳ��</font></a></td>
			<td class="cat"><a href="?order=iv&order_type=<!--order_type-->"><font color="#000000">��������</font></a></td>
			<td class="cat"><a href="?order=online&order_type=<!--order_type-->"><font color="#000000">�����������</font></a></td>
		</tr>
<!--if:start key="empty"-->
		<tr align="center">
			<td class="row" style="padding:5px;font-size:16px;" width="100%" colspan="4"><br /><center>�����κ���ع����¼�����߼�¼�ѱ���գ�</center><br /></td>
		</tr>
<!--if:end-->
<!--loop:start key="record" time="20"-->
		<tr class="row" align="center">
			<td><!--record_date--></td>
			<td><!--record_pv--></a></td>
			<td><!--record_iv--></td>
			<td><!--record_online--></td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��&nbsp;
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value">
</div>
