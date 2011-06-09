<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--> - 后台管理</title>
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
		<div class="addnew"><a href="?method=add">添加用户查询</a></div>
		<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat">名称</td>
					<td class="cat">字段</td>
					<td class="cat" width="90">操作</td>
				</tr>
		<!--loop:start key="record" time="20"-->
				<tr>
					<td class="row"><!--record_name--></td>
					<td class="row"><!--record_fields--></td>
					<td class="row" align="center"><a href="?method=export&id=<!--record_id-->">导出</a> <a href="?method=edit&id=<!--record_id-->">修改</a> <a href="?method=delete&id=<!--record_id-->" onclick="return confirm('请按确定继续。')">删除</a></td>
				</tr>
		<!--loop:end-->
			</table>
		</div>
	</div>
</div>
</body>
</html>