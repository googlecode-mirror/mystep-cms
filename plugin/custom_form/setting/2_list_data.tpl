<div class="title"><!--title--></div>
<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	<!--custom_form_name-->
</div>
<div class="nav">
	<a href="?method=export&mid=<!--mid-->">��������</a>
 |
	���û���<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?method=add_data_ok&mid=<!--mid-->&name='+this.value" /><input type="button" value="���" onclick="location.href='?method=add_data_ok&mid=<!--mid-->&name='+this.previousSibling.value" />
 |
	�ؼ��֣�<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?mid=<!--mid-->&keyword='+this.value" /><input type="button" value="����" onclick="location.href='?mid=<!--mid-->&keyword='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=name&order_type=<!--order_type-->"><font color="#000000">����</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=company&order_type=<!--order_type-->"><font color="#000000">��˾</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=tel&order_type=<!--order_type-->"><font color="#000000">�绰</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=add_date&order_type=<!--order_type-->"><font color="#000000">���ʱ��</font></a></td>
			<td class="cat" width="100">��ز���</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><a href="mailto:<!--record_email-->?subject=China+Garlic+2011"><!--record_name--></a></td>
			<td class="row"><a href="?method=edit&mid=<!--mid-->&id=<!--record_id-->"><!--record_company--></a></td>
			<td class="row"><!--record_tel--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row" align="center"><a href="?method=edit&mid=<!--mid-->&id=<!--record_id-->">�༭</a> &nbsp;<a href="?method=delete&mid=<!--mid-->&id=<!--record_id-->" onclick="return confirm('ȷ��ɾ������')">ɾ��</a><!--record_confirm--></td>
		</tr>
<!--loop:end-->
	</table>
</center>
<div class="nav">
	���� <!--page_count--> ҳ����ǰΪ�� <!--page_cur--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>
	<a href="<!--page_prev-->">��ҳ</a>
	<a href="<!--page_next-->">��ҳ</a>
	<a href="<!--page_last-->">ĩҳ</a>
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" /><input type="button" value="GO" onclick="location.href='?mid=<!--mid-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
</div>
		</td>
	</tr>
</table>
</div>