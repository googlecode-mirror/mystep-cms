<div class="title"><!--title--></div>
<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	<!--custom_form_name-->
</div>
<div class="nav">
	<a href="?mid=<!--mid-->">��ʾȫ��</a>
 |
	<a href="?method=export&mid=<!--mid-->">��������</a>
 |
	�ؼ��֣�<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?mid=<!--mid-->&keyword='+this.value" /><input type="button" value="����" onclick="location.href='?mid=<!--mid-->&keyword='+this.previousSibling.value" />
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="40"><a href="?mid=<!--mid-->&keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat"><a href="?mid=<!--mid-->&keyword=<!--keyword-->&order=name&order_type=<!--order_type-->"><font color="#000000">����</font></a></td>
			<td class="cat"><a href="?mid=<!--mid-->&keyword=<!--keyword-->&order=company&order_type=<!--order_type-->"><font color="#000000">��˾</font></a></td>
			<td class="cat"><a href="?mid=<!--mid-->&keyword=<!--keyword-->&order=tel&order_type=<!--order_type-->"><font color="#000000">�绰</font></a></td>
			<td class="cat"><a href="?mid=<!--mid-->&keyword=<!--keyword-->&order=add_date&order_type=<!--order_type-->"><font color="#000000">���ʱ��</font></a></td>
			<td class="cat" width="100">��ز���</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row"><!--record_id--></td>
			<td class="row"><a href="mailto:<!--record_email-->" class="mail"><!--record_name--></a></td>
			<td class="row"><a href="?method=edit&mid=<!--mid-->&id=<!--record_id-->&keyword=<!--keyword-->"><!--record_company--></a></td>
			<td class="row"><!--record_tel--></td>
			<td class="row"><!--record_add_date--></td>
			<td class="row" align="center"><a href="?method=edit&mid=<!--mid-->&id=<!--record_id-->&keyword=<!--keyword-->">�༭</a> &nbsp;<a href="?method=delete&mid=<!--mid-->&id=<!--record_id-->" onclick="return confirm('ȷ��ɾ������')">ɾ��</a><!--record_confirm--></td>
		</tr>
<!--loop:end-->
	</table>
</center>
<div class="nav">
	<a href="###" onclick="showPop('import','��������','id','import',420, 150)">��������</a>
 |
	���û���<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13 && this.value.length>=2)location.href='?method=add_data_ok&mid=<!--mid-->&name='+this.value" /><input type="button" value="���" onclick="if(this.previousSibling.value.length>=2)location.href='?method=add_data_ok&mid=<!--mid-->&name='+this.previousSibling.value" />
 |
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>
	<a href="<!--page_prev-->">��ҳ</a>
	<a href="<!--page_next-->">��ҳ</a>
	<a href="<!--page_last-->">ĩҳ</a>
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" /><input type="button" value="GO" onclick="location.href='?mid=<!--mid-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
</div>
		</td>
	</tr>
</table>
</div>

<div id="import" class="popshow">
<form name="upload" method="post" ACTION="?method=import&mid=<!--mid-->" ENCTYPE="multipart/form-data" onsubmit="return false">
	<table border="0" cellspacing="0" width="400">
		<tr id=load>
			<td align="center">
				<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
				�ϴ��ļ���
				<input type="file" name="the_file" size="35" /><br /><br />
				<b>��ȷ���ϴ��ļ�Ϊcsv��ʽ�������뵼����һһ��Ӧ��</b><br />
				����ʾ���ɽ����������Ϊcsv��ʽ��<br /><br />
				<input type="checkbox" name="empty" value="empty" /> �����������<br /><br />
				<input type="button" name="Submit" value=" �� �� " onclick="check()" />
				&nbsp; &nbsp; &nbsp;
				<input type="button" name="Close" value=" �� �� " onclick="if(parent==null){self.close();}else{parent.$.closePopupLayer();}" />
			</td>
		</tr>
		<tr id=wait style="display:none">
			<td align="center">
				�����ϴ������Ժ�......
			</td>
		</tr>
	</table>
</form>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
if(typeof($.setupJMPopups)=="undefined") $.getScript("../../script/jquery.jmpopups.js", function(){
	$.setupJMPopups({
		screenLockerBackground: "#000",
		screenLockerOpacity: "0.4"
	});
});
function check(){
	if ($("#popupLayer_import").find("form").get(0).the_file.value==0){
		alert("�ϴ��ļ�����Ϊ�գ�");
		$("#popupLayer_import").find("form").get(0).the_file.focus();
	}else{
		$id("load").style.display = "none";
		$id("wait").style.display = "";
		$("#popupLayer_import").find("form").get(0).submit();
	}
}
$(function(){
	$("a.mail").each(function(){
		if(this.href.length>10) {
			this.href = this.href+"?subject="+UrlEncode("<!--custom_form_name-->");
		}
	});
});
//]]> 
</script>