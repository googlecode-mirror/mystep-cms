<div class="title"><!--title--></div>
<div class="nav">
	<a href="?method=clear" onclick="return confirm('�Ƿ�ȷ����� 3 ����ǰ���ô���С�� 5 �ε�δ��������')">���δ��������</a>
	&nbsp;|&nbsp;
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��&nbsp;
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
	&nbsp;|&nbsp;
	�ؼ��֣�<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?keyword='+this.value" /><input type="button" value="����" onclick="location.href='?keyword='+this.previousSibling.value" />
</div>
<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center"> 
					<td class="cat" width="40"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
					<td class="cat" width="55"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=news_id"><font color="#000000">��������</font></a></td>
					<td class="cat"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_name"><font color="#000000">��������</font></a></td>
					<td class="cat" width="100"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_type"><font color="#000000">��������</font></a></td>
					<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_size"><font color="#000000">������С</font></a></td>
					<td class="cat" width="80"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_time"><font color="#000000">�ϴ�ʱ��</font></a></td>
					<td class="cat" width="55"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->&order=file_count"><font color="#000000">���ش���</font></a></td>
					<td class="cat" width="55">��ز���</td>
				</tr>
<!--loop:start key="record" time="20"-->
				<tr align="center">
					<td class="row"><!--record_id--></td>
					<td class="row"><!--record_news_id--></td>
					<td class="row" align="left"><a href="<!--record_web_url-->/files?<!--record_id-->" target="_blank"><!--record_file_name--></a></td>
					<td class="row"><!--record_file_type--></td>
					<td class="row"><!--record_file_size--></td>
					<td class="row"><!--record_file_time--></td>
					<td class="row"><!--record_file_count--></td>
					<td class="row"><a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�Ƿ�ȷ��ɾ���ø�����')">ɾ��</a></td>
				</tr>
<!--loop:end-->
			</table>
</div>
<div class="nav">
	<a href="?method=clear" onclick="return confirm('�Ƿ�ȷ����� 3 ����ǰ���ô���С�� 5 �ε�δ��������')">���δ��������</a>
	&nbsp;|&nbsp;
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��&nbsp;
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
	&nbsp;|&nbsp;
	�ؼ��֣�<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?keyword='+this.value" /><input type="button" value="����" onclick="location.href='?keyword='+this.previousSibling.value" />
</div>
