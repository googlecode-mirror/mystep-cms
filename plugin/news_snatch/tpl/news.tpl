<div class="title"><!--title--></div>
<div class="nav">
	<a href="?method=news_truncate">�����ץȡ����</a>
 | 
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?method=news&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
&nbsp;|&nbsp;
	�ؼ��֣�<input type="text" size="8" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?method=news&keyword='+this.value" /><input type="button" value="����" onclick="location.href='?method=news&keyword='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center"> 
			<td class="cat" width="30"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=original&order_type=<!--order_type-->"><font color="#000000">��Դ��վ</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=subject&order_type=<!--order_type-->"><font color="#000000">���ű���</font></a></td>
			<td class="cat" width="90"><font color="#000000">��ز���</font></td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><!--record_original--></td>
			<td class="row" align="left"><a href="<!--record_url-->" target="_blank"><!--record_subject--></a></td>
			<td class="row">
		<a href="?method=news_import&id=<!--record_id-->&idx=<!--record_idx-->">����</a>
		<a href="?method=news_edit&id=<!--record_id-->">�޸�</a>
		<a href="?method=news_delete&id=<!--record_id-->" onclick="return confirm('�Ƿ�ȷ��Ҫɾ�������ţ�')">ɾ��</a>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	<a href="?method=news_truncate">�����ץȡ����</a>
 | 
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?method=news&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?method=news&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
&nbsp;|&nbsp;
	�ؼ��֣�<input type="text" size="8" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?method=news&keyword='+this.value" /><input type="button" value="����" onclick="location.href='?method=news&keyword='+this.previousSibling.value" />
</div>