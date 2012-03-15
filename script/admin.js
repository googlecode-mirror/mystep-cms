/**************************************************
*                                                 *
* Author  : Windy_sk                              *
* Create  : 2012-02-03                            *
* Email   : windy_sk@126.com                      *
* HomePage: None (Maybe Soon)                     *
* Notice  : U Can Use & Modify it freely,         *
*           BUT PLEASE HOLD THIS ITEM.            *
*                                                 *
**************************************************/

$(function(){
	var obj_title = $(".title");
	if(obj_title.length) {
		var new_title = obj_title.clone().css({"position":"fixed","top":"0px","left":"0px","width":"100%","z-index":"99"}).prependTo("#page_main");
		if($.browser.msie) {
			new_title.css("position","absolute");
			$(window).scroll(function() {
				new_title.css("top", $(document.body).scrollTop());
			});
			$(window).resize(function() {
				new_title.css("top", $(document.body).scrollTop());
			});
		}
	}
	var obj_addnew = $(".addnew");
	if(obj_addnew.length) {
		var top = 3;
		obj_addnew.css({"top":top, "z-index":999});
		if($.browser.msie) {
			$(window).scroll(function() {
				obj_addnew.css("top", $(document.body).scrollTop()+top);
			});
			$(window).resize(function() {
			obj_addnew.css({"top":top, "z-index":999});
				obj_addnew.css("top", $(document.body).scrollTop()+top);
			});
		} else {
			obj_addnew.css("position","fixed");
		}
	}
});