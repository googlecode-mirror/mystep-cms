<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">��ӱ�</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40">���</td>
			<td class="cat">������վ</td>
			<td class="cat">��������</td>
			<td class="cat">���ʱ��</td>
			<td class="cat" width="100">��ز���</td>
			<td class="cat" width="60">�������</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_mid--></td>
			<td class="row"><!--record_web_id--></td>
			<td class="row"><a href="custom_form.php?mid=<!--record_mid-->"><!--record_name--></a></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row" align="center"><a href="?method=edit&mid=<!--record_mid-->">�༭</a> &nbsp;<a href="?method=delete&mid=<!--record_mid-->" onclick="return confirm('ȷ��ɾ������')">ɾ��</a> &nbsp;<a href="?method=add&mid=<!--record_mid-->">�½�</a></td>
			<td class="row" align="center"><a href="<!--record_link_submit-->" target="_blank">���</a> &nbsp;<a href="<!--record_link_list-->" target="_blank">�б�</a></td>
		</tr>
<!--loop:end-->
	</table>
</div>
<script language="javascript">
if(parent.setNav!=null) {
	parent.admin_cat = <!--admin_cat-->;
	parent.setNav();
}
</script>