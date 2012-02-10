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
		var new_title = obj_title.clone().css({"position":"fixed","top":"0px","left":"0px","width":"100%","z-index":"9999"}).prependTo("#page_main");
		if($.browser.msie) {
			new_title.css("position","absolute");
			$(window).scroll(function() {
				new_title.css("top", $(document.body).scrollTop());
			});
		}
	}
});