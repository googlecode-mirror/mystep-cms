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
		<div class="title"><!--title--> - <!--title_2--></div>
		<div class="nav">
	���� <!--page_total--> ����¼����ǰΪ�� <!--page_cur-->/<!--page_count--> ҳ��
	<a href="<!--page_first-->">��ҳ</a>&nbsp;
	<a href="<!--page_prev-->">��ҳ</a>&nbsp;
	<a href="<!--page_next-->">��ҳ</a>&nbsp;
	<a href="<!--page_last-->">ĩҳ</a>&nbsp;
	��ҳ<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?method=view&id=<!--id-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?method=view&id=<!--id-->&page='+this.previousSibling.value" />
		</div>
		<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="30">���</td>
<!--loop:start key="fields"-->
					<td class="cat"><!--fields_name--></td>
<!--loop:end-->
				</tr>
<!--loop:start key="record"-->
				<tr>
					<td class="cat" align="center"><!--record_no--></td>
					<!--record_data-->
				</tr>
<!--loop:end-->
			</table>
		</div>
		<div align="center" style="margin:20px 20px 20px 20px;">
			<input class="btn" type="button" value=" �� �� " onclick="location.href='?method=export&id=<!--id-->'"/>&nbsp;&nbsp;
			<input class="btn" type="button" value=" �� �� " onclick="window.close()" />&nbsp;&nbsp;
		</div>
	</div>
</div>
</body>
</html>