<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
		<div class="nav">
			<select name="web_id" style="text-align:center;" onchange="location.href='?web_id='+this.value">
<!--loop:start key="website"-->
				<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
			</select>
		</div>
		<div class="nav">
			<a href="?web_id=<!--web_id-->&method=clean">����ʧЧ����</a>&nbsp; | &nbsp;
			���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��&nbsp;
			<a href="<!--page_first-->">��ҳ</a>&nbsp;
			<a href="<!--page_prev-->">��ҳ</a>&nbsp;
			<a href="<!--page_next-->">��ҳ</a>&nbsp;
			<a href="<!--page_last-->">ĩҳ</a>&nbsp;
			��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?web_id=<!--web_id-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?web_id=<!--web_id-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
		&nbsp;|&nbsp;
			�ؼ��֣�<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?web_id=<!--web_id-->&keyword='+this.value" /><input type="button" value="����" onclick="location.href='?web_id=<!--web_id-->&keyword='+this.previousSibling.value" />
		</div>
		<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="30"><a href="?web_id=<!--web_id-->&keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">���</font></a></td>
					<td class="cat"><a href="?web_id=<!--web_id-->&keyword=<!--keyword-->&order=web_id&order_type=<!--order_type-->"><font color="#000000">������վ</font></a></td>
					<td class="cat"><a href="?web_id=<!--web_id-->&keyword=<!--keyword-->&order=cat_id&order_type=<!--order_type-->"><font color="#000000">������Ŀ</font></a></td>
					<td class="cat"><a href="?web_id=<!--web_id-->&keyword=<!--keyword-->&order=subject&order_type=<!--order_type-->"><font color="#000000">���ű���</font></a></td>
					<td class="cat" width="60"><a href="?web_id=<!--web_id-->&keyword=<!--keyword-->&order=views&order_type=<!--order_type-->"><font color="#000000">�������</font></a></td>
					<td class="cat" width="60"><a href="?web_id=<!--web_id-->&keyword=<!--keyword-->&order=day_start&order_type=<!--order_type-->"><font color="#000000">������</font></a></td>
					<td class="cat" width="40"><a href="?web_id=<!--web_id-->&keyword=<!--keyword-->&order=day_max_count&order_type=<!--order_type-->"><font color="#000000">����շ���</font></a></td>
					<td class="cat" width="40"><a href="?web_id=<!--web_id-->&keyword=<!--keyword-->&order=week_max_count&order_type=<!--order_type-->"><font color="#000000">����ܷ���</font></a></td>
					<td class="cat" width="40"><a href="?web_id=<!--web_id-->&keyword=<!--keyword-->&order=month_max_count&order_type=<!--order_type-->"><font color="#000000">����·���</font></a></td>
					<td class="cat" width="40"><a href="?web_id=<!--web_id-->&keyword=<!--keyword-->&order=year_max_count&order_type=<!--order_type-->"><font color="#000000">��������</font></a></td>
				</tr>
		<!--loop:start key="record" time="20"-->
				<tr align="center">
					<td class="row"><!--record_news_id--></td>
					<td class="row"><!--record_web_id--></td>
					<td class="row"><!--record_cat_id--></td>
					<td class="row" align="left"><a href="<!--record_link-->" target="_blank"><!--record_subject--></a></td>
					<td class="row"><!--record_views--></td>
					<td class="row"><!--record_day_start--></td>
					<td class="row"><!--record_day_max_count--></td>
					<td class="row"><!--record_week_max_count--></td>
					<td class="row"><!--record_month_max_count--></td>
					<td class="row"><!--record_year_max_count--></td>
				</tr>
		<!--loop:end-->
			</table>
		</div>
		<div class="nav">
			���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��&nbsp;
			<a href="<!--page_first-->">��ҳ</a>&nbsp;
			<a href="<!--page_prev-->">��ҳ</a>&nbsp;
			<a href="<!--page_next-->">��ҳ</a>&nbsp;
			<a href="<!--page_last-->">ĩҳ</a>&nbsp;
			��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?web_id=<!--web_id-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?web_id=<!--web_id-->&keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
		&nbsp;|&nbsp;
			�ؼ��֣�<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?web_id=<!--web_id-->&keyword='+this.value" /><input type="button" value="����" onclick="location.href='?web_id=<!--web_id-->&keyword='+this.previousSibling.value" />
		</div>
	</div>
</div>
</body>
</html>