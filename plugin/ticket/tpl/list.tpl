<div class="title"><!--title--></div>
<div align="center">
<br />
	<select onchange="location.href='?method=list&idx=web&idx='+this.value">
		<option value="">��ѡ��</option>
<!--loop:start key="topic"-->
		<option value="<!--topic_idx-->" <!--topic_selected-->><!--topic_topic-->��<!--topic_total-->��</option>
<!--loop:end-->
	</select>
		</div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ�� &nbsp;
	<a href="<!--page_first-->">��ҳ</a> &nbsp;
	<a href="<!--page_prev-->">��ҳ</a> &nbsp;
	<a href="<!--page_next-->">��ҳ</a> &nbsp;
	<a href="<!--page_last-->">ĩҳ</a> &nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?method=list&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?method=list&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30"><a href="?method=list&order=keyword&order_type=<!--order_type-->"><font color="#000000">ID</font></a></td>
			<td class="cat"><a href="?method=list&order=subject&order_type=<!--order_type-->"><font color="#000000">����</font></a></td>
			<td class="cat" width="60"><a href="?method=list&order=name&order_type=<!--order_type-->"><font color="#000000">�ύ�û�</font></a></td>
			<td class="cat" width="40"><a href="?method=list&order=priority&order_type=<!--order_type-->"><font color="#000000">���ȼ�</font></a></td>
			<td class="cat" width="40"><a href="?method=list&order=stauts&order_type=<!--order_type-->"><font color="#000000">״̬</font></a></td>
			<td class="cat" width="120"><a href="?method=list&order=add_date&order_type=<!--order_type-->"><font color="#000000">�ύ����</font></a></td>
			<td class="cat" width="60">��ز���</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center" class="row" title="<!--record_type-->">
			<td><!--record_id--></td>
			<td><!--record_subject--></td>
			<td><a href="mailto:<!--record_email-->"><!--record_name--></a></td>
			<td><!--record_priority--></td>
			<td><!--record_status--></td>
			<td><!--record_add_date--></td>
			<td class="row" align="center">
				<a href="?method=check&id=<!--record_id-->">�鿴</a>
				<a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�Ƿ�ȷ��ɾ�������⼰�������⣿')">ɾ��</a>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ�� &nbsp;
	<a href="<!--page_first-->">��ҳ</a> &nbsp;
	<a href="<!--page_prev-->">��ҳ</a> &nbsp;
	<a href="<!--page_next-->">��ҳ</a> &nbsp;
	<a href="<!--page_last-->">ĩҳ</a> &nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?method=list&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?method=list&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
</div>
