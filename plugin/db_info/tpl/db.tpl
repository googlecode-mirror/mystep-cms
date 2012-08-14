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
		<div class="nav">
			<select name="db" style="text-align:center;" onchange="location.href='?db='+this.value">
<!--loop:start key="db"-->
				<option value="<!--db_name-->" <!--db_selected-->><!--db_name--></option>
<!--loop:end-->
			</select>
		</div>
		<div align="center">
			<form method="post" action="?method=pos">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="30">编号</td>
					<td class="cat">表名</td>
					<td class="cat" width="40">类型</td>
					<td class="cat" width="30">行数</td>
					<td class="cat" width="60">大小</td>
					<td class="cat">创建时间</td>
					<td class="cat">字符集</td>
					<td class="cat">说明</td>
					<td class="cat" width="30">查看</td>
				</tr>
<!--loop:start key="record"-->
				<tr>
					<td class="row"><!--record_no--></td>
					<td class="row"><!--record_Name--></td>
					<td class="row"><!--record_Engine--></td>
					<td class="row"><!--record_Rows--></td>
					<td class="row"><!--record_Data_length--></td>
					<td class="row"><!--record_Create_time--></td>
					<td class="row"><!--record_Collation--></td>
					<td class="row"><!--record_Comment--></td>
					<td class="row" align="center"><a href="?db=<!--db-->&tbl=<!--record_Name-->">查看</a></td>
				</tr>
<!--loop:end-->
			</table>
			</form>
		</div>
	</div>
</div>
</body>
</html>