<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add&idx=<!--tpl_idx-->">���ģ��</a></div>
<div class="nav">
	<select name="tpl" style="width:120px;text-align:center;" onchange="location.href='?idx='+this.value">
<!--loop:start key="tpl_list"-->
		<option value="<!--tpl_list_idx-->" <!--tpl_list_selected-->><!--tpl_list_idx--></option>
<!--loop:end-->
	</select>
</div>
<div align="center">
	<table id="list_area" cellspacing="0" cellpadding="0">
		<tr align="center">
			<td class="cat">ģ���ļ�</td>
			<td class="cat" width="80">�ļ���С</td>
			<td class="cat" width="80">�ļ�����</td>
			<td class="cat" width="120">�޸�ʱ��</td>
			<td class="cat" width="80">����</td>
		</tr>
<!--loop:start key="file"-->
		<tr class="row">
			<td><!--file_name--></td>
			<td><!--file_size--></td>
			<td><!--file_attr--></td>
			<td><!--file_time--></td>
			<td align="center">
				<a href="?method=edit&idx=<!--tpl_idx-->&file=<!--file_name-->">�޸�</a> &nbsp;
				<a href="?method=delete&idx=<!--tpl_idx-->&file=<!--file_name-->" onclick="return confirm('�Ƿ�ȷ��ɾ����ǰģ���ļ���')">ɾ��</a></td>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
