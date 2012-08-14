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
<script language="JavaScript" src="../../script/addon.js"></script>
</head>
<body>
<div id="page_ole">
	<div id="page_main">
		<div class="title"><!--title--></div>
		<div class="addnew"><a href="?method=add">新建计划任务</a></div>
		<div class="nav">运行状态：<!--status_info--> （<a href="<!--status_link-->">点击<!--status_txt--></a>） <a href="log.txt" target="_blank">查看运行状态</a></div>
		<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="30">编号</td>
					<td class="cat">名称</td>
					<td class="cat">描述</td>
					<td class="cat" width="30">次数</td>
					<td class="cat" width="120">上次时间</td>
					<td class="cat" width="120">下次时间</td>
					<td class="cat" width="60">过期日期</td>
					<td class="cat" width="60">操作</td>
				</tr>
		<!--loop:start key="record" time="20"-->
				<tr>
					<td class="row"><!--record_id--></td>
					<td class="row"><!--record_name--></td>
					<td class="row"><!--record_describe--></td>
					<td class="row"><!--record_exe_count--></td>
					<td class="row"><!--record_exe_date--></td>
					<td class="row"><!--record_next_date--></td>
					<td class="row"><!--record_expire--></td>
					<td class="row" align="center"><a href="?method=edit&id=<!--record_id-->">修改</a> <a href="?method=delete&id=<!--record_id-->" onclick="return confirm('请按确定继续。')">删除</a></td>
				</tr>
		<!--loop:end-->
			</table>
			<iframe scrolling="no" name="start" src="about:blank" MARGINHEIGHT="0" MARGINWIDTH="0" style="display:none;"></iframe>
		</div>
	</div>
</div>
</body>
<script language="JavaScript">
function crontab_start() {
	$("iframe[name=start]").attr("src", "run.php");
	setTimeout("location.reload()",2000)
}
</script>
</html>