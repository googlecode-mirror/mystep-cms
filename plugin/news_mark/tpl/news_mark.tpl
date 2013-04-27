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
			<select name="web_id" style="text-align:center;" onchange="location.href='?web_id='+this.value">
<!--loop:start key="website"-->
				<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
			</select>
		</div>
		<div class="nav">
			共有 <!--page_total--> 条记录，当前为第 <!--page_cur-->/<!--page_count--> 页，&nbsp;
			<a href="<!--page_first-->">首页</a>&nbsp;
			<a href="<!--page_prev-->">上页</a>&nbsp;
			<a href="<!--page_next-->">下页</a>&nbsp;
			<a href="<!--page_last-->">末页</a>&nbsp;
			跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
		&nbsp;|&nbsp;
			关键字：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value" />
		</div>
		<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="30"><a href="?keyword=<!--keyword-->&order_type=<!--order_type-->"><font color="#000000">编号</font></a></td>
					<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=cat_id&order_type=<!--order_type-->"><font color="#000000">所属栏目</font></a></td>
					<td class="cat"><a href="?keyword=<!--keyword-->&order=subject&order_type=<!--order_type-->"><font color="#000000">新闻标题</font></a></td>
					<td class="cat"><a href="?keyword=<!--keyword-->&order=jump&order_type=<!--order_type-->"><font color="#000000">提升值</font></a></td>
					<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=jump_time&order_type=<!--order_type-->"><font color="#000000">提升时间</font></a></td>
					<td class="cat"><a href="?keyword=<!--keyword-->&order=rank_times&order_type=<!--order_type-->"><font color="#000000">评分次数</font></a></td>
					<td class="cat"><a href="?keyword=<!--keyword-->&order=rank_total&order_type=<!--order_type-->"><font color="#000000">评分总分</font></a></td>
					<td class="cat" width="60"><a href="?keyword=<!--keyword-->&order=rank_time&order_type=<!--order_type-->"><font color="#000000">评分时间</font></a></td>
				</tr>
		<!--loop:start key="record" time="20"-->
				<tr align="center">
					<td class="row"><!--record_news_id--></td>
					<td class="row"><!--record_cat_id--></td>
					<td class="row" align="left"><a href="<!--record_link-->" target="_blank"><!--record_subject--></a></td>
					<td class="row"><!--record_jump--></td>
					<td class="row"><!--record_jump_time--></td>
					<td class="row"><!--record_rank_times--></td>
					<td class="row"><!--record_rank_total--></td>
					<td class="row"><!--record_rank_time--></td>
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
			跳页<input type="text" size="2" value="<!--page_cur-->" style="text-align:center" onkeypress="if(window.event.keyCode==13)location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.value" /><input type="button" value="GO" onclick="location.href='?keyword=<!--keyword-->&order=<!--order-->&order_type=<!--order_type_org-->&page='+this.previousSibling.value" />
		&nbsp;|&nbsp;
			关键字：<input type="text" size="10" value="<!--keyword-->" onkeypress="if(window.event.keyCode==13)location.href='?keyword='+this.value" /><input type="button" value="检索" onclick="location.href='?keyword='+this.previousSibling.value" />
		</div>
	</div>
</div>
</body>
</html>