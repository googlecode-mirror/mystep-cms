<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--> - ��̨����</title>
<meta http-equiv="Pragma" contect="no-cache">
<meta http-equiv="Expires" contect="-1">
<meta http-equiv="windows-Target" contect="_top">
<meta http-equiv="Content-Type" content="text/html; charset=<!--charset-->" />
<link rel="stylesheet" type="text/css" media="all" href="../../<!--path_admin-->/style.css" />
<script language="JavaScript" src="../../script/jquery.js"></script>
<script language="JavaScript" src="../../script/jquery.addon.js"></script>
<script language="JavaScript" src="../../script/global.js"></script>
<script language="JavaScript" src="../../script/admin.js"></script>
</head>
<body>
<div id="page_ole">
	<div id="page_main">

<div class="title"><!--title--></div>
<div align="left">
������վ��
<select name="web_id" onchange="location.href='?keyword=<!--keyword-->&web_id='+this.value">
<!--loop:start key="website"-->
	<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
</select>
</div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value">
 |
	<input type="text" size="8" value="<!--keyword-->"><input type="button" value="����" onclick="location.href='?keyword='+this.previousSibling.value">
</div>
<div align="center">
	<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
		<tr align="center">
			<td class="cat" width="30"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
			<td class="cat"><a href="?keyword=<!--keyword-->&order=news_id&order_type=<!--order_type-->"><font color="#000000">��������</font</a></td>
			<td class="cat" width="80"><a href="?keyword=<!--keyword-->&order=user_name&order_type=<!--order_type-->"><font color="#000000">�����û�</font</a></td>
			<td class="cat" width="30"><a href="?keyword=<!--keyword-->&order=agree&order_type=<!--order_type-->"><font color="#000000">��ͬ</font</a></td>
			<td class="cat" width="30"><a href="?keyword=<!--keyword-->&order=oppose&order_type=<!--order_type-->"><font color="#000000">����</font</a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=rpt_date&order_type=<!--order_type-->"><font color="#000000">�ٱ�</font</a></td>
			<td class="cat" width="120"><a href="?keyword=<!--keyword-->&order=add_date&order_type=<!--order_type-->"><font color="#000000">��������</font></a></td>
			<td class="cat" width="30">����</td>
		</tr>
<!--loop:start key="record" time="20"-->
		<tr align="center">
			<td class="row" rowspan="2" valign="middle"><!--record_id--></td>
			<td class="row" align="left"><a href="<!--record_link-->" target="_blank"><!--record_subject--></a></td>
			<td class="row" align="center"><!--record_user_name--><br/>(<!--record_ip-->)</td>
			<td class="row"><!--record_agree--></td>
			<td class="row"><!--record_oppose--></td>
			<td class="row"><!--record_rpt_date--><br/>( <!--record_report--> )</td>
			<td class="row"><!--record_add_date--></td>
			<td class="row" rowspan="2" valign="middle"><a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�Ƿ�ȷ��ɾ������Ŀ��')">ɾ��</a></td>
		</tr>
		<tr>
			<td class="row" colspan="6"><!--record_comment--></td>
		</tr>
<!--loop:end-->
	</table>
</div>
<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order_type=<!--order_type_org-->&order=<!--order-->&page='+this.previousSibling.value">
 |
	<input type="text" size="8" value="<!--keyword-->"><input type="button" value="����" onclick="location.href='?keyword='+this.previousSibling.value">
</div>

	</div>
</div>
</body>
</html>