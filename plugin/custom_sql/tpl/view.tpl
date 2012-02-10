<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
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
		<div class="title"><!--title--> - <!--title_2--></div>
		<div class="nav">
	共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，
	<a href="<!--page_first-->">首页</a>&nbsp;
	<a href="<!--page_prev-->">上页</a>&nbsp;
	<a href="<!--page_next-->">下页</a>&nbsp;
	<a href="<!--page_last-->">末页</a>&nbsp;
	跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?method=view&id=<!--id-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?method=view&id=<!--id-->&page='+this.previousSibling.value" />
		</div>
		<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="30">序号</td>
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
			<input class="btn" type="button" value=" 导 出 " onclick="location.href='?method=export&id=<!--id-->'"/>&nbsp;&nbsp;
			<input class="btn" type="button" value=" 关 闭 " onclick="window.close()" />&nbsp;&nbsp;
		</div>
	</div>
</div>
</body>
</html>