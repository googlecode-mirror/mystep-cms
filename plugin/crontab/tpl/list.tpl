<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--> - ��̨����</title>
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
		<div class="addnew"><a href="?method=add">�½��ƻ�����</a></div>
		<div class="nav">����״̬��<!--status_info--> ��<a href="<!--status_link-->">���<!--status_txt--></a>�� <a href="log.txt" target="_blank">�鿴����״̬</a></div>
		<div align="center">
			<table id="list_area" cellSpacing="0" cellPadding="0" align="center">
				<tr align="center">
					<td class="cat" width="30">���</td>
					<td class="cat">����</td>
					<td class="cat">����</td>
					<td class="cat" width="30">����</td>
					<td class="cat" width="120">�ϴ�ʱ��</td>
					<td class="cat" width="120">�´�ʱ��</td>
					<td class="cat" width="60">��������</td>
					<td class="cat" width="60">����</td>
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
					<td class="row" align="center"><a href="?method=edit&id=<!--record_id-->">�޸�</a> <a href="?method=delete&id=<!--record_id-->" onclick="return confirm('�밴ȷ��������')">ɾ��</a></td>
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