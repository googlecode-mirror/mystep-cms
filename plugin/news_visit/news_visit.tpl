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
		<div class="nav">
			共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，&nbsp;
			<a href="<!--page_first-->">首页</a>&nbsp;
			<a href="<!--page_prev-->">上页</a>&nbsp;
			<a href="<!--page_next-->">下页</a>&nbsp;
			<a href="<!--page_last-->">末页</a>&nbsp;
			跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value">
		&nbsp;|&nbsp;
			关键字：<input type="text" size="10" value="<!--keyword-->" /><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value" />
		</div>
		<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="40"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
					<td class="cat" width="200"><a href="?keyword=<!--keyword-->&order=subject&order_type=<!--order_type-->"><font color="#000000">所属新闻</font></a></td>
					<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=views&order_type=<!--order_type-->"><font color="#000000">总浏览量</font></a></td>
					<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=day_start&order_type=<!--order_type-->"><font color="#000000">最后访问</font></a></td>
					<td class="cat" width="70"><a href="?keyword=<!--keyword-->&order=day_max_count&order_type=<!--order_type-->"><font color="#000000">最大日访问</font></a></td>
					<td class="cat" width="70"><a href="?keyword=<!--keyword-->&order=week_max_count&order_type=<!--order_type-->"><font color="#000000">最大周访问</font></a></td>
					<td class="cat" width="70"><a href="?keyword=<!--keyword-->&order=month_max_count&order_type=<!--order_type-->"><font color="#000000">最大月访问</font></a></td>
					<td class="cat" width="70"><a href="?keyword=<!--keyword-->&order=year_max_count&order_type=<!--order_type-->"><font color="#000000">最大年访问</font></a></td>
				</tr>
		<!--loop:start key="record" time="20"-->
				<tr align="center">
					<td class="row"><!--record_news_id--></td>
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
			共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，&nbsp;
			<a href="<!--page_first-->">首页</a>&nbsp;
			<a href="<!--page_prev-->">上页</a>&nbsp;
			<a href="<!--page_next-->">下页</a>&nbsp;
			<a href="<!--page_last-->">末页</a>&nbsp;
			跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center"><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.previousSibling.value">
		&nbsp;|&nbsp;
			关键字：<input type="text" size="10" value="<!--keyword-->" /><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value" />
		</div>
	</div>
</div>
</body>
</html>