<div class="title"><!--title--></div>
<div class="addnew"><a href="###" onclick="showPop('upload','������','url','web_plugin.php?method=upload',420, 100)">������</a></div>
<div align="center"><h1>�Ѱ�װ���</h1></div>
<div align="center">
<form method="post" action="?method=order">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">����</td>
			<td class="cat" width="150">�������</td>
			<td class="cat" width="80">����汾</td>
			<td class="cat">�������</td>
			<td class="cat" width="120">��ز���</td>
		</tr>
<!--loop:start key="plugin_list_1"-->
		<tr class="row" align="center">
			<td>
				<input type="hidden" name="idx[]" value="<!--plugin_list_1_idx-->" size="2" />
				<input type="text" name="order[]" value="<!--plugin_list_1_order-->" size="2" />
			</td>
			<td><!--plugin_list_1_name--></td>
			<td><!--plugin_list_1_ver--><span style="display:<!--plugin_list_1_update-->">��<a href="###" onclick="update('<!--plugin_list_1_idx-->', '<!--plugin_list_1_name-->')" title="�������� <!--plugin_list_1_ver_new-->">����</a>��</span></td>
			<td><!--plugin_list_1_intro--></td>
			<td align="center">
				<a href="?method=uninstall&idx=<!--plugin_list_1_idx-->" onclick="return confirm('�Ƿ�ȷ��ɾ���ò���� �밴ȷ��������')">ж��</a>
				<a href="?method=active&idx=<!--plugin_list_1_idx-->"><!--plugin_list_1_active--></a>
				<a href="?method=setting&idx=<!--plugin_list_1_idx-->">����</a>
				<a href="?method=pack&idx=<!--plugin_list_1_idx-->">���</a>
			</td>
		</tr>
<!--loop:end-->
		<tr>
			<td class="row" colspan="5" align="center">
				<input class="btn" type="Submit" value=" �� �� " />&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="btn" type="reset" value=" �� �� " />
			</td>
		</tr>
	</table>
	</form>
</div>

<div align="center"><h1>δ��װ���</h1></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="200">�������</td>
			<td class="cat" width="80">����汾</td>
			<td class="cat">�������</td>
			<td class="cat" width="120">��ز���</td>
		</tr>
<!--loop:start key="plugin_list_2"-->
		<tr class="row" align="center">
			<td><!--plugin_list_2_name--></td>
			<td><!--plugin_list_2_ver--><span style="display:<!--plugin_list_2_update-->">��<a href="###" onclick="update('<!--plugin_list_2_idx-->', '<!--plugin_list_2_name-->')" title="�������� <!--plugin_list_2_ver_new-->">����</a>��</span></td>
			<td><!--plugin_list_2_intro--></td>
			<td align="center">
				<a href="?method=view&idx=<!--plugin_list_2_idx-->">��װ</a>
				<a href="?method=uninstall&idx=<!--plugin_list_2_idx-->" onclick="return confirm('��������Ҫ���������װδ�ɹ��Ĳ�����������ܻ����һЩ�����¼�� �밴ȷ��������')">���</a>
				<a href="?method=delete&idx=<!--plugin_list_2_idx-->" onclick="return confirm('�Ƿ�ȷ��ɾ����ǰ�����')">ɾ��</a>
				<a href="?method=pack&idx=<!--plugin_list_2_idx-->">���</a>
			</td>
		</tr>
<!--loop:end-->
<!--if:start condition="judge" key="empty_2"-->
		<tr align="center">
			<td class="row" colspan="4" style="padding:10px;font-size:16px;text-align:center;">���б��ز�����Ѱ�װ</td>
		</tr>
<!--if:end-->
		</tr>
	</table>
</div>

<div align="center"><h1>�����ز��</h1></div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="200">�������</td>
			<td class="cat" width="80">����汾</td>
			<td class="cat">�������</td>
			<td class="cat" width="120">��ز���</td>
		</tr>
<!--loop:start key="plugin_list_3"-->
		<tr class="row" align="center">
			<td><!--plugin_list_3_name--></td>
			<td><!--plugin_list_3_ver--></td>
			<td><!--plugin_list_3_intro--></td>
			<td align="center">
				<a href="###" onclick="update('<!--plugin_list_3_idx-->', '<!--plugin_list_3_name-->')">����</a>
			</td>
		</tr>
<!--loop:end-->
<!--if:start condition="judge" key="empty_3"-->
		<tr align="center">
			<td class="row" colspan="4" style="padding:10px;font-size:16px;text-align:center;">���·������޿����ز��</td>
		</tr>
<!--if:end-->
		</tr>
	</table>
</div>

<script language="JavaScript" type="text/javascript">
//<![CDATA[
var dp_list = "<!--dp_list-->";
if(dp_list.length>1) {
	alert("�������²���ļ����ڹ����ļ����ظ����⽫Ӱ����վȨ�޵ķ��䣬��ȷ�ϲ�������\n\n" + dp_list);
}
function update(idx, name) {
	loadingShow("��"+name+"�����ڸ��£���ȴ���");
	$.get("<!--self-->?method=update&idx="+idx, function(info){
		loadingShow();
		try {
			alert(info.info);
			if(info.link.length>2) {
				window.open(info.link);
			}
			window.location.reload();
		} catch(e) {
			alert("���»�ȡʧ�ܣ�����������ã�");
		}
	}, "json");
}
//]]> 
</script>
