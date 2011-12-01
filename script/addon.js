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
	$(".box .title span").mouseover(function(){
		if(this.className=="highlight") return;
		var theParent = $(this).parent().parent();
		var theObjs = theParent.find(".title span");
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
	$(".catList li:has(ul)").bind('click', function(e){
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

function loadingShow() {
	var theTop = ($(window).height() - $("#bar_loading").height())/2 + $(document.body).scrollTop();
	var theLeft = ($(window).width() - $("#bar_loading").width())/2 + $(document.body).scrollLeft();
	$("#bar_loading").css({"opacity":"0.7", "top":theTop, "left":theLeft});
	$("#bar_loading").toggle();
	return true;
}

$(function() {
	var err_pic = "images/dummy.png";
	var img_lst = $tag("img");
	for(var i=0, m=img_lst.length; i<m; i++) {
		if(img_lst[i].onerror==null) {
			img_lst[i].onerror = new Function("this.src='"+err_pic+"';this.width='0';this.height='0';this.onerror=null;");
			img_lst[i].src = img_lst[i].src;
		}
	}
	$("#content img").each(function(i){
		if($(this).width()>600) $(this).width(600);
		if(this.title=="" && this.alt!="") this.title = this.alt;
		if(this.title!="") this.title += "\n";
		this.title += "按住 ALT，使用鼠标滚轮控制图片缩放！";
		$(this).mousewheel(function(objEvent, intDelta){
			if(objEvent.altKey) {
				var zoom = parseInt(this.style.zoom, 10) || 100;
				zoom += intDelta * 10;
				if(zoom > 0) {
					this.style.zoom = zoom + '%';
				}
				if(objEvent.preventDefault){
					objEvent.preventDefault();
				} else {
					objEvent.returnValue = false;
				}
				return false;
			} else {
				return true;
			}
		});
	});
	setSlide();
});