<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--> - ��̨����</title>
<meta http-equiv="Pragma" contect="no-cache">
<meta http-equiv="Expires" contect="-1">
<meta http-equiv="windows-Target" contect="_top">
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Content-Type" content="text/html; charset=<!--charset-->" />
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
				��¼�û���<!--username-->��<!--usergroup-->�� [<a href="login.php?logout" target="_top">�˳�</a>]
			</div>
			<div id="menu_nav">
				<ul></ul>
			</div>
		</div>
	</div>
	<div id="page_main">
		<table><tr>
			<td class="list" valign="top">
				<div>
					<select id="website" onchange="showCat($id('cat_tree'), getWebCat(this.value), true)" style="width:180px;">
						<option value="">ȫ��Ĭ����վ</option>
						<option value="0">����վ��Ŀ</option>
					</select>
				</div>
				<div id="cat_tree"></div>
			</td>
			<td class="content" valign="top">
				<iframe id="main" name="main" frameborder="0" scrolling="yes" src="info.php"></iframe>
			</td>
		</tr></table>
	</div>
	<div id="page_bottom">
		Powered by �� MyStep Content Managerment System 1.0 ��&nbsp;Copyright&copy; 2010-2011 <a href="mailto:windy2006@gmail.com">Windy2000</a>
	</div>
</div>
</body>
<script language="JavaScript">
function getSubCat(cat_id) {
	var catList = new Array();
	for(var i=0; i<news_cat.length; i++) {
		if(news_cat[i].cat_main==cat_id) catList.append(news_cat[i]);
	}
	return catList;
}
function getWebCat(web_id) {
	var catList = new Array();
	for(var i=0; i<news_cat.length; i++) {
		if((web_id=="" || web_id==null || news_cat[i].web_id==web_id) && news_cat[i].cat_layer==1) catList.append(news_cat[i]);
	}
	return catList;
}
function showCat(theOle, theObjs, renew) {
	if(renew==true) $(theOle).children().remove();
	if($(theOle).children().length==0) {
		var newItem = $("<ul/>");
		var newSubItem = null;
		var subObjs = null;
		for(var i=0; i<theObjs.length; i++) {
			if(group.power_cat!=",all," && group.power_cat.indexOf(","+theObjs[i].cat_id+",")==-1) continue;
			newSubItem = $("<li/>");
			newSubItem.append('<a href="art_content.php?cat_id='+theObjs[i].cat_id+'" title="'+theObjs[i].cat_comment+'">'+theObjs[i].cat_name+'</a>');
			newItem.append(newSubItem);
			newSubItem.bind('click', function(e){
				if(e.target.tagName.toLowerCase()!="li") return true;
				$(this).children().filter("ul").toggle(500, function() {
					$(this).parent().css("background-image", "url('"+(this.style.display=="none"?"images/tree_icon/plus_noLine.gif":"images/tree_icon/minus_noLine.gif")+"')");
				});
				if(e && e.preventDefault) {
					e.preventDefault();
				} else {
					window.event.returnValue = false; 
				}
				return false;
			});
			subObjs = getSubCat(theObjs[i].cat_id);
			if(subObjs.length>0) {
				var newOle = $("<ul/>");
				newSubItem.append(newOle);
				showCat(newOle, subObjs);
				newSubItem.css("background-image", "url('images/tree_icon/minus_noLine.gif')");
			}
		}
		$(theOle).append(newItem);
	}
	return;
}
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
	group.power_cat = "," + group.power_cat + ",";
	group.power_web = "," + group.power_web + ",";
	group.power_func = "," + group.power_func + ",";
	for(var i=0; i<admin_cat.length; i++) {
		if(group.power_func!=",all," && group.power_func.indexOf(","+admin_cat[i].id+",")==-1) continue;
		newItem = $("<li/>");
		newItem.append("<a href=\""+admin_cat[i].url+"\" class=\"nav\">"+admin_cat[i].name+"</a>");
		if(admin_cat[i].sub!=null && admin_cat[i].sub.length>0) {
			newSubItem = $("<ul/>");
			for(var j=0; j<admin_cat[i].sub.length; j++) {
				if(group.power_func!=",all," && group.power_func.indexOf(","+admin_cat[i].sub[j].id+",")==-1) continue;
				newSubItem.append("<li><a href=\""+admin_cat[i].sub[j].url+"\">"+admin_cat[i].sub[j].name+"</a></li>");
			}
			newItem.append(newSubItem);
		}
		listOLE.append(newItem);
	}
	newItem = $("<li/>");
	newItem.append("<a href=\"###\" class=\"nav\">��վ</a>");
	newSubItem = $("<ul/>");
	for(i=0; i<website.length; i++) {
		newSubItem.append("<li><a href=\"http://"+website[i].host+"\" target=\"_blank\">"+website[i].name+"</a></li>");
		if(group.power_web==",all," || group.power_web.indexOf(","+website[i].web_id+",")!=-1)	$($id("website")).append("<option value=\""+website[i].web_id+"\">"+website[i].name+"</option>");
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
	
	showCat($id("cat_tree"), getWebCat());
});
if(top != window) history.go(-1);

var group=<!--group-->;
var admin_cat = <!--admin_cat-->;
var website = <!--website-->;
var news_cat = <!--news_cat-->;
</script>
</html>