<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--> - 后台管理</title>
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
		<div align="center">
			<form method="post" action="?method=pos">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="30">编号</td>
					<td class="cat">字段</td>
					<td class="cat">类型</td>
					<td class="cat">空值</td>
					<td class="cat">索引</td>
					<td class="cat">默认</td>
					<td class="cat">其他</td>
					<td class="cat">备注</td>
				</tr>
<!--loop:start key="record"-->
				<tr>
					<td class="row"><!--record_no--></td>
					<td class="row"><!--record_Field--></td>
					<td class="row"><!--record_Type--></td>
					<td class="row"><!--record_Null--></td>
					<td class="row"><!--record_Key--></td>
					<td class="row"><!--record_Default--></td>
					<td class="row"><!--record_Extra--></td>
					<td class="row"><!--record_comment--></td>
				</tr>
<!--loop:end-->
				<tr align="center">
					<td class="row" colspan="8">
						<input type="button" value=" 返 回 " onclick="history.go(-1)" />
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>
</body>
</html>