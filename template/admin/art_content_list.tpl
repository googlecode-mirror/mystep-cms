<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add&cat_id=<!--cat_id-->">�������</a></div>
<div class="nav">
	<select onchange="location.href='?cat_id='+this.options[this.selectedIndex].value+''" style="width:80px;">
		<option value="">ȫ������</option>
<!--loop:start key="catalog"-->
		<option value="<!--catalog_cat_id-->" <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
	</select> &nbsp;
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ�� &nbsp;
	<a href="<!--page_first-->">��ҳ</a> &nbsp;
	<a href="<!--page_prev-->">��ҳ</a> &nbsp;
	<a href="<!--page_next-->">��ҳ</a> &nbsp;
	<a href="<!--page_last-->">ĩҳ</a> &nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value">
 &nbsp; | &nbsp;
	�ؼ��֣�<input type="text" size="8" value="<!--keyword-->"><input type="button" value="����" onclick="location.href='?keyword='+this.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center"> 
			<td class="cat" width="30"><a href="?keyword=<!--keyword-->&cat_id=<!--cat_id-->&order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=cat_id&order_type=<!--order_type-->&cat_id=<!--cat_id-->"><font color="#000000">��Ŀ</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=subject&order_type=<!--order_type-->&cat_id=<!--cat_id-->"><font color="#000000">���±���</font></a></td>
			<td class="cat" width="80"><a href="?keyword=<!--keyword-->&order=add_user&order_type=<!--order_type-->&cat_id=<!--cat_id-->"><font color="#000000">¼����</font></a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=add_date&order_type=<!--order_type-->&cat_id=<!--cat_id-->"><font color="#000000">¼������</font></a></td>
			<td class="cat" width="90"><font color="#000000">��ز���</font></td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><a href="?method=edit&news_id=<!--record_news_id-->"><!--record_news_id--></a></td>
			<td class="row"><a href="?cat_id=<!--record_cat_id-->"><!--record_cat_name--></a></td>
			<td class="row" align="left"><a href="<!--record_link-->" target="_blank"><!--record_subject--></a></td>
			<td class="row"><a href="http://bbs.a9vg.com/profile.php?action=show&username=<!--record_add_user-->" target="_blank"><!--record_add_user--></a></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row">
				<a href="?method=unlock&news_id=<!--record_news_id-->">����</a>
				<a href="?method=edit&news_id=<!--record_news_id-->">�޸�</a>
				<a href="?method=delete&news_id=<!--record_news_id-->" onclick="return confirm('�Ƿ�ȷ��Ҫɾ�������£�')">ɾ��</a>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	<select onchange="location.href='?cat_id='+this.options[this.selectedIndex].value+''" style="width:80px;">
		<option>ȫ������</option>
<!--loop:start key="catalog"-->
		<option value="<!--catalog_cat_id-->" <!--catalog_selected-->><!--catalog_cat_name--></option>
<!--loop:end-->
	</select> &nbsp;
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ�� &nbsp;
	<a href="<!--page_first-->">��ҳ</a> &nbsp;
	<a href="<!--page_prev-->">��ҳ</a> &nbsp;
	<a href="<!--page_next-->">��ҳ</a> &nbsp;
	<a href="<!--page_last-->">ĩҳ</a> &nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value">
 &nbsp; | &nbsp;
	�ؼ��֣�<input type="text" size="8" value="<!--keyword-->"><input type="button" value="����" onclick="location.href='?keyword='+this.previousSibling.value">
</div>