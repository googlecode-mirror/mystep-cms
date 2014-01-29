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
<div align="left">
	<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">所属子站：</td>
				<td class="row">
					<select name="web_id" id="webList">
						<option value="0">仅管理面板</option>
						<option value="255">全部子站</option>
<!--loop:start key="website"-->
						<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">目录标题：</td>
				<td class="row">
					<input name="name" type="text" value="<!--name-->" maxlength="40" need="" />
					<input type="hidden" name="id" value="<!--id-->" />
				</td>
			</tr>
			<tr>
				<td class="cat">所属目录：</td>
				<td class="row">
					<select name="pid">
						<option value="0">主目录</option>
<!--loop:start key="cat"-->
						<option value="<!--cat_id-->" <!--cat_selected-->><!--cat_name--></option>
<!--loop:end-->
					</select>
				</td>
			</tr>
			<tr>
				<td class="cat">脚本文件：</td>
				<td class="row">
					<input name="file" type="text" value="<!--file-->" maxlength="30" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat">脚本路径：</td>
				<td class="row">
					<input name="path" type="text" value="<!--path-->" maxlength="100" />
				</td>
			</tr>
			<tr>
				<td class="cat">目录说明：</td>
				<td class="row">
					<input name="comment" type="text" value="<!--comment-->" maxlength="150" need="" />
				</td>
			</tr>
			<tr>
				<td class="cat">显示次序：</td>
				<td class="row">
					<input name="order" type="text" value="<!--order-->" maxlength="2" need="digital" />
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" 提 交 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script Language="JavaScript">
for(var i=0; i<$id("webList").options.length; i++) {
	if($id("webList").options[i].value=="<!--web_id-->") {
		$id("webList").selectedIndex = i;
		break;
	}
}
</script>
	</div>
</div>
</body>
</html>