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
<script language="JavaScript" src="../../script/language.js.php"></script>
</head>
<body>
<div id="page_ole">
	<div id="page_main">
<div class="title"><!--title--></div>
<div align="center">
	<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">名称：</td>
				<td class="row">
					<input name="name" type="text" value="<!--name-->" maxlength="40" need="" />
					<input type="hidden" name="id" value="<!--id-->" />
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">字段：</td>
				<td class="row">
					<input name="fields" type="text" value="<!--fields-->" maxlength="200" need="" />
					<span class="comment">（请用半角逗号间隔）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">查询语句：</td>
				<td class="row">
					<textarea name="sql" rows="5" cols="100"><!--sql--></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" class="row">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
	</div>
</div>
</body>
</html>