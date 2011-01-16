<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--> - 后台管理</title>
<meta http-equiv="Pragma" contect="no-cache">
<meta http-equiv="Expires" contect="-1">
<meta http-equiv="windows-Target" contect="_top">
<meta http-equiv="Content-Type" content="text/html; charset=<!--charset-->" />
<meta http-equiv="Pragma" content="no-cache" />
<link rel="stylesheet" type="text/css" media="all" href="style.css" />
<script language="JavaScript" src="../script/global.js"></script>
<script language="JavaScript" src="../script/jquery.js"></script>
<base target="main">
</head>
<body style="overflow:hidden;">
<div id="page_ole">
	<div id="page_top">
		<div class="l">
			<a href="/" target="_blank"><img src="images/logo.png" height="60" /></a>
		</div>
		<div class="r">
			<div class="info">
				登录用户：<!--username-->（<!--usergroup-->） [<a href="login.php?logout" target="_top">退出</a>]
			</div>
			<div id="menu_nav">
				<ul></ul>
			</div>
		</div>
	</div>
	<div id="page_main">
		<table><tr>
			<td class="list" valign="top">
			内容管理
			</td>
			<td class="content" valign="top">
				<iframe id="main" name="main" frameborder="0" scrolling="yes" src="info.php"></iframe>
			</td>
		</tr></table>
	</div>
	<div id="page_bottom">
		Powered by 『 MyStep Content Managerment System 1.0 』&nbsp; Copyright&copy; 2010-2011 <a href="mailto:windy2006@gmail.com">Windy2000</a>
	</div>
</div>
</body>
<script language="JavaScript">
var admin_cat = <!--admin_cat-->;
var website = <!--website-->;
function setPos() {
	var theWidth = $(window).width() - 200;
	var theHeight = $(window).height() - 120;
	$("#main").width(theWidth);
	$("#main").height(theHeight);
}
$(function(){
	setPos();
	$(window).bind("resize", setPos);
	var listOLE = $("#menu_nav ul:first");
	var newItem = null;
	var newSubItem = null;
	for(var i=0; i<admin_cat.length; i++) {
		newItem = $("<li/>");
		newItem.append("<a href=\""+admin_cat[i].url+"\" class=\"nav\">"+admin_cat[i].name+"</a>");
		if(admin_cat[i].sub!=null  && admin_cat[i].sub.length>0) {
			newSubItem = $("<ul/>");
			for(var j=0; j<admin_cat[i].sub.length; j++) {
				newSubItem.append("<li><a href=\""+admin_cat[i].sub[j].url+"\">"+admin_cat[i].sub[j].name+"</a></li>");
			}
			newItem.append(newSubItem);
		}
		listOLE.append(newItem);
	}
	newItem = $("<li/>");
	newItem.append("<a href=\"###\" class=\"nav\">网站</a>");
	newSubItem = $("<ul/>");
	for(i=0; i<website.length; i++) {
		newSubItem.append("<li><a href=\"http://"+website[i].host+"\" target=\"_blank\">"+website[i].name+"</a></li>");
	}
	newItem.append(newSubItem);
	listOLE.append(newItem);
	
	
	$("#menu_nav li:has(ul)").hover(function(){
			$(this).children("ul").stop(true,true).show(400);
		},function(){
			$(this).children("ul").stop(true,true).hide();
	});
	
	$("a[href='###']").bind('click', function() {
	  return false;
	});
});
if(top != window) history.go(-1);
</script>
</html>