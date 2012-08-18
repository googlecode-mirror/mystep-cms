/**************************************************
*																								 *
* Author	: Windy_sk															*
* Create	: 2003-05-03														*
* Modified: 2007-12-9														 *
* Email	 : windy_sk@126.com											*
* HomePage: None (Maybe Soon)										 *
* Notice	: U Can Use & Modify it freely,				 *
*					 BUT PLEASE HOLD THIS ITEM.						*
*																								 *
**************************************************/

function setSlide() {
	var objs = $(".slide");
	if(objs.length==0) return;
	var items = null;
	var temp_num = "";
	for(var i=0; i<objs.length; i++) {
		items = objs[i].getElementsByTagName("DL");
		if(items.length>0) {
			temp_num = "";
			for(var j=0, m=items.length; j<m; j++){
				temp_num += "<li>"+(j+1)+"</li>";
			}
			temp_num = "<ul>"+temp_num+"</ul>";
			$("<div/>").addClass("slide-num").html(temp_num).appendTo(objs[i]);
		}
		$("<div/>").addClass("slide-show").appendTo(objs[i]);
		
		$(".slide li").click(function(){
			var theObj = $(this).parentsUntil(".slide").parent();
			clearTimeout(theObj.data("timeout"));
			theObj = theObj[0];
			theObj.slide(parseInt(this.innerHTML)-1);
		});
		
		objs[i].slide = function(idx) {
			var max = $(this).find("dl").length;
			if(idx>=max) idx = 0;
			$(this).find("DL").hide();
			var item = $(this).find("DL").eq(idx);
			$(this).find(".slide-show").html(item.find("dt").html());
			$(this).find(".slide-num li").removeClass("selected");
			$(this).find(".slide-num li").eq(idx).addClass("selected");
			item.animate({opacity: 'toggle'}, 2000);
			var self = this;
			$(this).data("timeout", setTimeout(function(){self.slide(idx+1)}, 5000));
		}
		objs[i].slide(0);
	}
}

function setSwitch() {
	$(".box > .title > span").mouseover(function(){
		if(this.className=="highlight") return;
		var theParent = $(this).parent().parent();
		var theObjs = theParent.find(".title > span");
		theObjs.removeClass("highlight");
		$(this).addClass("highlight");
		theParent.find(".content").hide();
		for(var i=theObjs.length-1; i>=0; i--) {
			if(theObjs.eq(i).hasClass("highlight")) {
				theParent.find(".content").eq(i).show();
				break;
			}
		}
	});
}

function setList() {
	if($(".catList").length==0) return;
	$(".catList > li:has(ul)").bind('click', function(e){
		if(e.target.tagName.toLowerCase()!="li") return true;
		$(this).children().filter("ul").slideToggle(500);
		if(e && e.preventDefault) {
			e.preventDefault();
		} else {
			window.event.returnValue = false;
		}
		return false;
	});
}

function loadingShow(info) {
	if($("#bar_loading").length==0) {
		var cssText = "top:0px;left:0px;display:none;color:#333333;font-size:24px;font-weight:bold;line-height:48px;position:absolute;border:1px #999999 solid;padding:20px 30px 10px 30px;z-index:999;background-color:#eeeeee;z-index:999;text-align:center;";
		$("<div>").attr("id", "bar_loading").cssText(cssText).append($("<img>").attr("src","/images/loading.gif").css({"width":400,"height":10})).append("<br />").append($("<span>")).appendTo("body");
	}
	if($("#screenLocker").length>0) {
		$("#screenLocker").remove();
		$("#bar_loading").hide();
	} else {
		$("<div id='screenLocker'><!-- --></div>").css({
					position: "absolute",
					background: "#333333",
					left: "0",
					top: "0",
					opacity: "0.8",
					display: "none"
				}).appendTo("body");
		
		$('#screenLocker').height($(window).height() + "px");
		$('#screenLocker').width($(document.body).outerWidth(true) + "px");
		$('#screenLocker').fadeIn();
		
		var theTop = ($(window).height() - $("#bar_loading").height())/2 + $(document.body).scrollTop();
		var theLeft = ($(window).width() - $("#bar_loading").width())/2 + $(document.body).scrollLeft();
		$("#bar_loading").css({"opacity":"0.7", "top":theTop, "left":theLeft});
		if(info==null) info = language.ajax_sending;
		$("#bar_loading > span").html(info);
		$("#bar_loading").show();
	}
	return true;
}

function showSubMenu(theObj) {
	$(theObj).find("a[catid]").each(function(){
		var cur_obj = $(this);
		var cat_id = cur_obj.attr("catid");
		$.post("/ajax.php?func=subcat&return=json", {'id':cat_id}, function(result) {
			if(result!=null) {
				var listObj = $("<ul>").attr("id", "subcat_"+cat_id).addClass("subcat");
				for(var i=0,m=result.length;i<m;i++) {
					listObj.append($('<li><a href="'+result[i].link+'">'+result[i].name+'</a></li>'));
				}
				cur_obj.after(listObj);
				cur_obj.parent().hover(function(){
					var pos = cur_obj.position();
					cur_obj.addClass("highlight");
					$(this).children("ul").css({"top":(pos.top+$(this).height()),"left":pos.left}).show();
				},function(){
					cur_obj.removeClass("highlight");
					$(this).children("ul").hide();
				});
			}
		}, 'json');
		
	});
}

$(function() {
	setSlide();
	setSwitch();
	setList();
	showSubMenu($("#top_nav"));
});