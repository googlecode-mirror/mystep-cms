<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">��ӹ��</a></div>
<div class="nav">
	���� <!--page_count--> ҳ����ǰΪ�� <!--page_cur--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>
	<a href="<!--page_prev-->">��ҳ</a>
	<a href="<!--page_next-->">��ҳ</a>
	<a href="<!--page_last-->">ĩҳ</a>
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"> <input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30"><a href="?order_type=<!--order_type-->&expire=<!--expire-->"><font color="#000000">���</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=ad_client&expire=<!--expire-->"><font color="#000000">�ͻ�����</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=ad_text&expire=<!--expire-->"><font color="#000000">��ʾ����</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=ad_mode&expire=<!--expire-->"><font color="#000000">�������</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=view&expire=<!--expire-->"><font color="#000000">��ʾ����</font></a></td>
			<td class="cat" width="60"><a href="?order_type=<!--order_type-->&order=click&expire=<!--expire-->"><font color="#000000">�������</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=add_date&expire=<!--expire-->"><font color="#000000">��������</font></a></td>
			<td class="cat"><a href="?order_type=<!--order_type-->&order=exp_date&expire=<!--expire-->"><font color="#000000">����ʱ��</font></a></td>
			<td class="cat" width="60">��ز���</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><a href="<!--record_ad_url-->" title="<!--record_ad_text-->" target="_blank"><!--record_ad_client--></a> [<a href="<!--record_ad_file-->" target="_blank">�鿴</a>]</td>
			<td class="row"><!--record_ad_text--></td>
			<td class="row"><!--record_ad_mode--></td>
			<td class="row"><!--record_view--></td>
			<td class="row"><!--record_click--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row"><!--record_exp_date--></td>
			<td class="row">
				<a href="?method=export&id=<!--record_id-->">�鿴</a>
				<a href="?method=edit&id=<!--record_id-->">�޸�</a>
				<a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�Ƿ�ȷ��ɾ������Ŀ��')">ɾ��</a>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	���� <!--page_count--> ҳ����ǰΪ�� <!--page_cur--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>
	<a href="<!--page_prev-->">��ҳ</a>
	<a href="<!--page_next-->">��ҳ</a>
	<a href="<!--page_last-->">ĩҳ</a>
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"> <input type="button" value="GO" onclick="location.href='?order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.previousSibling.value">
</div>
