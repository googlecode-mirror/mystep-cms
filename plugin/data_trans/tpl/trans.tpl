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
</head>
<body>
<div id="page_ole">
	<div id="page_main">
<div class="title"><!--title--></div>
<div align="left">
	<script src="../../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=trans">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tr>
				<td class="cat" width="80">ԭʼ��վ��</td>
				<td class="row">
					<select name="web_id_org" id="web_id_org" onchange="changeWeb(this.selectedIndex)">
<!--loop:start key="website"-->
						<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
					<span class="comment">����ѡ����Ҫ�ƶ���Ŀ���ڵ���վ��</span>
				</td>
			</tr>
			<tr>
				<td class="cat">ת����Ŀ��</td>
				<td class="row">
					<select name="cat_id" id="cat_id">
						<option value="0" web_id="0">������Ŀ</option>
<!--loop:start key="cat"-->
						<option value="<!--cat_cat_id-->" web_id="<!--cat_web_id-->"><!--cat_cat_name--></option>
<!--loop:end-->
					</select>
					<span class="comment">����ѡ�������ƶ�����Ŀ������ѡ��������ĿҲ��һͬ���ƶ���</span>
				</td>
			</tr>
			<tr>
				<td class="cat" width="80">Ŀ����վ��</td>
				<td class="row">
					<select name="web_id_dst" id="web_id_dst">
<!--loop:start key="website"-->
						<option value="<!--website_web_id-->" <!--website_selected-->><!--website_name--></option>
<!--loop:end-->
					</select>
					<span class="comment">������ѡԭʼ��վ����Ŀ�ƶ����ĸ���վ��</span>
				</td>
			</tr>
			<tr class="row">
				<td colspan="2" align="center">
					<input class="btn" type="Submit" value=" ȷ �� " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" �� �� " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" �� �� " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script Language="JavaScript">
function changeWeb(idx){
	$("#web_id_dst").find("option").show();
	$("#web_id_dst").find("option").get(idx).style.display="none";
	$id("web_id_dst").selectedIndex = -1;
	for(var i=0,m=$id("web_id_dst").options.length;i<m;i++) {
		if(i!=idx) {
			$id("web_id_dst").selectedIndex = i;
			break;
		}
	}
	$("#cat_id").find("option").hide();
	$("#cat_id").find("option[web_id=0]").show();
	$("#cat_id").find("option[web_id="+$("#web_id_org").val()+"]").show();
	$id("cat_id").selectedIndex = 0;
}
$(function(){
	changeWeb(0);
});
</script>
	</div>
</div>
</body>
</html>