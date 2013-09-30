// tooltip demo
$('body').tooltip({
	selector: "a[data-toggle=tooltip]",
	animation: true,
	placement: "bottom",
	title: "No Title",
	trigger: "hover",
	delay: 1
});
$('#tooltips_input').tooltip({
	container: "body",
	animation: true,
	html: true,
	placement: "right",
	trigger: "focus",
	delay: {show:500, hide:100}
});

// popover demo
$("#popover_test").popover({
		animation: true,
		placement: "top",
		title: "No Title",
		trigger: "hover",
		delay: {show: 500, hide: 100}
});

// carousel demo
$('#myCarousel').carousel({
	interval: 5000,
	pause: 'hover'
}).bind("slide", function(){
	$("#alert_carousel").alert('close');
}).bind("slid", function(){
	var cur_item = $(this).find('.active');
	$("#alert_carousel").find("span").text("当前图片："+cur_item.find('img').attr('src'));
	$("#alert_carousel").alert('show');
});

// button demo
$('#button_test').click(function () {
		var btn = $(this);
		btn.button('loading');
		setTimeout(function () {
			btn.button('complete');
			//btn.button('reset');
		}, 3000);
});
	
// process demo
$('#progress_go').click(function () {
		var btn = $(this);
		var progress_bar = $("#progress_test > .bar");
		var cur_percent = 0;
		progress_bar.css("width","0");
		progress_bar.text("");
		btn.button('loading');
		var doit = function() {
			cur_percent++;
			if(cur_percent>100) {
				btn.button('complete');
				alert("Done!");
				btn.button('reset');
			} else {
				progress_bar.css("width",cur_percent+"%");
				progress_bar.text(cur_percent+"%");
				setTimeout(doit, 100);
			}
		};
		doit();
});

// tab demo
function setTab(obj, mode) {
	var the_height = 0;
	obj = $(obj).children().first();
	var tagName = obj[0].tagName.toLowerCase();
	if((mode=="below" && tagName=="ul") || (mode!="below" && tagName=="div")) {
		obj.before(obj.next());
	}
	obj = obj.parent().find("div").first();
	obj.css("border", "1px solid #ddd");
	switch(mode) {
		case "up":
			obj.css("border-top-width", "0");
			obj.css("margin", "0");
			obj.parent().find("ul").first().css("height", "auto");
			break;
		case "below":
			obj.css("border-bottom-width", "0");
			obj.css("margin", "0");
			obj.parent().find("ul").first().css("height", "auto");
			break;
		case "left":
			obj.css("border-left-width", "0");
			obj.css("margin-left", "-20px");
			obj.css("margin-right", "20px");
			the_height = obj.parent().height();
			obj.parent().find("ul").first().height(the_height);
			break;
		case "right":
			obj.css("border-right-width", "0");
			obj.css("margin-left", "20px");
			obj.css("margin-right", "-20px");
			the_height = obj.parent().height();
			obj.parent().find("ul").first().height(the_height);
			break;
		default:
			break;
	}
}

//collapse nav
$("#collapse_nav").find("li:has(ul)").hover(
	function () {
		$($(this).attr("data-target")).collapse('show');
	},
	function () {
		$($(this).attr("data-target")).collapse('hide');
	}
);

// Anchor
$("a[href^=#]").each(function(){
	var the_name = this.href.replace(/^.*?#+/, "");
	$(this).click(function(e) {
		if(the_name!="" && $("a[name="+the_name+"]").length>0) {
			var the_top = $("a[name="+the_name+"]").offset().top-80;
			//$(window).scrollTop(the_top);
			$('html, body').animate({scrollTop: the_top}, 300);
		}
		e.preventDefault();
	});
})

// set class
function setClass(theObj, theClass) {
	if($(theObj).length) {
		$(theObj).toggleClass(theClass);
	}
	return;
}
function chgClass(theObj, theClass) {
	if($(theObj).length) {
		var items = $(event.target || event.srcElement).parent().find("button");
		for(var i=0,m=items.length;i<m;i++) {
			$(theObj).removeClass(items.get(i).innerHTML.replace(".", ""));
		}
		$(theObj).addClass(theClass);
	}
	return;
}

// other
$('#tabs').bind('show', function (e) {
	//alert("show");
}).bind('shown', function (e) {
	alert("From: " + e.relatedTarget.innerHTML + "\nCurrent: " + e.target.innerHTML);
})

$('#alert_test2').bind('closed', function () {
	alert("closed");
}).bind('close', function () {
	alert("close");
}).bind('show', function () {
	alert("show");
}).bind('shown', function () {
	alert("shown");
})

$('#collapse_test').bind('hide', function () {
	alert("hide");
}).bind('hidden', function () {
	alert("hidden");
}).bind('show', function () {
	alert("show");
}).bind('shown', function () {
	alert("shown");
})

function setSideNav() {
	var width_window = $(window).width();
	if(width_window<980) {
		var width_container = $(".container-fluid").width();
		var width_main = $("#main").width();
		$(".sidenav").width(width_container-width_main-20);
	} else {
		$(".sidenav").width(140);
	}
}
setSideNav();
$(window).on('resize', setSideNav);