<div class="title"><!--title--></div>
<div align="center">
<form method="post" action="?method=order">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30">����</td>
			<td class="cat" width="30">���</td>
			<td class="cat" width="100">�������</td>
			<td class="cat" width="60">����汾</td>
			<td class="cat">�������</td>
			<td class="cat">��Ȩ��Ϣ</td>
			<td class="cat" width="90">��ز���</td>
		</tr>
<!--loop:start key="plugin_list"-->
		<tr class="row" align="center">
			<td>
				<input type="hidden" name="idx[]" value="<!--plugin_list_idx-->" size="2" />
				<input type="text" name="order[]" value="<!--plugin_list_order-->" size="2" />
			</td>
			<td><!--plugin_list_id--></td>
			<td><!--plugin_list_name--></td>
			<td><!--plugin_list_ver--></td>
			<td><!--plugin_list_intro--></td>
			<td><!--plugin_list_copyright--></td>
			<td align="center">
				<a style="display:<!--plugin_list_install-->" href="?method=view&idx=<!--plugin_list_idx-->">��װ</a> 
				<a style="display:<!--plugin_list_install-->" href="?method=uninstall&idx=<!--plugin_list_idx-->" onclick="return confirm('��������Ҫ���������װδ�ɹ��Ĳ�����������ܻ����һЩ�����¼�� �밴ȷ��������')">���</a> 
				<a style="display:<!--plugin_list_uninstall-->" href="?method=uninstall&idx=<!--plugin_list_idx-->" onclick="return confirm('�Ƿ�ȷ��ɾ���ò���� �밴ȷ��������')">ж��</a>
				<a style="display:<!--plugin_list_uninstall-->" href="?method=active&idx=<!--plugin_list_idx-->"><!--plugin_list_active--></a>
				<a style="display:<!--plugin_list_uninstall-->" href="?method=setting&idx=<!--plugin_list_idx-->">����</a> 
				<a style="display:<!--plugin_list_install-->" href="?method=delete&idx=<!--plugin_list_idx-->" onclick="return confirm('�Ƿ�ȷ��ɾ����ǰ�����')">ɾ��</a> 
			</td>
		</tr>
<!--loop:end-->
		<tr>
			<td colspan="8" align="center" class="cat">
				<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
				<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
				<input class="btn" type="button" value=" �� �� " onclick="showPop('upload','������','url','web_plugin.php?method=upload',420, 100)" />
			</td>
		</tr>
	</table>
	</form>
</div>
<script language="JavaScript">
if(typeof($.setupJMPopups)=="undefined") $.getScript("../../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});
var dp_list = "<!--dp_list-->";
if(dp_list.length>1) {
	alert("�������²���ļ����ڹ����ļ����ظ����⽫Ӱ����վȨ�޵ķ��䣬��ȷ�ϲ�������\n\n" + dp_list);
}
</script>
