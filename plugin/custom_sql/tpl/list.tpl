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
		<div class="addnew"><a href="?method=add">����û���ѯ</a></div>
		<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="30">���</td>
					<td class="cat">����</td>
					<td class="cat">�ֶ�</td>
					<td class="cat" width="120">����</td>
				</tr>
<!--loop:start key="record" time="20"-->
				<tr>
					<td class="row"><!--record_id--></td>
					<td class="row"><!--record_name--></td>
					<td class="row"><!--record_fields--></td>
					<td class="row" align="center"><a href="?method=view&id=<!--record_id-->" target="_blank">���</a> <a href="?method=export&id=<!--record_id-->">����</a> <a href="?method=edit&id=<!--record_id-->">�޸�</a> <a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�밴ȷ��������')">ɾ��</a></td>
				</tr>
<!--loop:end-->
			</table>
		</div>
	</div>
</div>
</body>
</html>