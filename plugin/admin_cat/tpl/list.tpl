<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--> - ��̨����</title>
<meta http-equiv="Pragma" contect="no-cache">
<meta http-equiv="Expires" contect="-1">
<meta http-equiv="windows-Target" contect="_top">
<meta http-equiv="Content-Type" content="text/html; charset=<!--charset-->" />
<link rel="stylesheet" type="text/css" media="all" href="../../<!--path_admin-->/style.css" />
<script language="JavaScript" src="../../script/global.js"></script>
<script language="JavaScript" src="../../script/jquery.js"></script>
</head>
<body>
<div id="page_ole">
	<div id="page_main">
		<div class="title"><!--title--></div>
		<div align="center">
			<form method="post" action="?method=pos">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="40">���</td>
					<td class="cat">����</td>
					<td class="cat">������վ</td>
					<td class="cat">����</td>
					<td class="cat">˳��</td>
					<td class="cat">����</td>
				</tr>
		<!--loop:start key="record"-->
				<tr>
					<td class="row"><!--record_id--></td>
					<td class="row"><a href="/<!--admin_path--><!--record_url-->" target="_blank"><!--record_name--></a></td>
					<td class="row"><!--record_web_id--></td>
					<td class="row"><!--record_comment--></td>
					<td class="row"><input name="id[]" type="hidden" value="<!--record_id-->" /><input name="order[]" type="text" size="2" value="<!--record_order-->" /></td>
					<td class="row" align="center"><a href="?method=edit&id=<!--record_id-->">�޸�</a> <a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�밴ȷ��������')">ɾ��</a></td>
				</tr>
		<!--loop:end-->
				<tr>
					<td colspan="8" align="center" class="cat">
						<input class="btn" type="button" value=" �� �� " onClick="location.href='?method=add'" />&nbsp;&nbsp;
						<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
						<input class="btn" type="reset" value=" �� �� " />
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>
</body>
</html>