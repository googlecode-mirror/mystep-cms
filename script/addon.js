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

$(function() {
	$("img").error(function(){
		this.src="images/dummy.png";
		this.onerror=null;
	})
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