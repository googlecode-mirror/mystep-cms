<div class="title"><!--title--></div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ�� &nbsp;
	<a href="<!--page_first-->">��ҳ</a> &nbsp;
	<a href="<!--page_prev-->">��ҳ</a> &nbsp;
	<a href="<!--page_next-->">��ҳ</a> &nbsp;
	<a href="<!--page_last-->">ĩҳ</a> &nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value"> &nbsp;
  ��<a href="###" onclick="location.href='?method=clear'">�����־</a> | <a href="###" onclick="location.href='?method=download'">������־</a>��
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center"> 
			<td class="cat" width="30"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=user&order_type=<!--order_type-->"><font color="#000000">����Ա</font></a></td>
			<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=group&order_type=<!--order_type-->"><font color="#000000">����</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=link&order_type=<!--order_type-->"><font color="#000000">ҳ��</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=comment&order_type=<!--order_type-->"><font color="#000000">ά��˵��</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=time&order_type=<!--order_type-->"><font color="#000000">ʱ��</font></a></td>
		</tr>
<!--if:start key="empty"-->
		<tr align="center">
			<td class="row" style="padding:5px;font-size:16px;" width="100%" colspan="10"><br /><center>�����κ���ع����¼�����߼�¼�ѱ���գ�</center><br /></td>
		</tr>
<!--if:end-->
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><!--record_user--></td>
			<td class="row"><!--record_group--></a></td>
			<td class="row" align="left"><!--record_link--></td>
			<td class="row"><!--record_comment--></a></td>
			<td class="row"><!--record_time--></td>
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
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value"> &nbsp;
  ��<a href="###" onclick="location.href='?method=clear'">�����־</a> | <a href="###" onclick="location.href='?method=download'">������־</a>��
</div>
