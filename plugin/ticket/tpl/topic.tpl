<div class="title"><!--title--></div>
<div class="addnew"><a href="?method=add">�����Ŀ</a></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="50">����</td>
			<td class="cat">����</td>
			<td class="cat" width="50">����</td>
			<td class="cat" width="50">δ����</td>
			<td class="cat" width="50">������</td>
			<td class="cat" width="50">�����</td>
			<td class="cat" width="120">�������</td>
			<td class="cat" width="120">��ز���</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center" class="row">
			<td><!--record_idx--></td>
			<td><a href="?method=list&idx=<!--record_idx-->" target="_blank"><!--record_topic--></a></td>
			<td><!--record_total--></td>
			<td><!--record_untreated--></td>
			<td><!--record_processing--></td>
			<td><!--record_done--></td>
			<td><!--record_lastpost--></td>
			<td align="center">
				<a href="?method=list&idx=<!--record_idx-->" target="_blank">�鿴</a>
				<a href="?method=edit&idx=<!--record_idx-->">�޸�</a>
				<a href="?method=delete_topic&idx=<!--record_idx-->" onclick="return confirm('�Ƿ�ȷ��ɾ�������⼰�������⣿')">ɾ��</a>
				<a href="/module.php?m=ticket&idx=<!--record_idx-->" target="_blank">ǰ̨</a>
			</td>
		</tr>
<!--loop:end-->
	</table>
</div>
