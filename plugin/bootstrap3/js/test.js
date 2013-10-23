// For Windows Phone 8 and Internet Explorer 10
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
	var msViewportStyle = document.createElement("style")
	msViewportStyle.appendChild(
		document.createTextNode(
			"@-ms-viewport{width:auto!important}"
		)
	)
	document.getElementsByTagName("head")[0].appendChild(msViewportStyle)
}

// tooltip demo
$('#tooltips_input').tooltip({
	container: "body",
	animation: true,
	html: true,
	placement: "right",
	trigger: "focus",
	delay: {show:500, hide:100}
});

$('.example').tooltip({
	title: "按住CTRL键单击，以显示 HTML 代码",
	container: "body",
	animation: true,
	html: true,
	placement: "top",
	trigger: "hover",
	delay: {show:500, hide:200}
});

// carousel demo
$('#myCarousel').carousel({
	interval: 5000,
	pause: 'hover'
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
		var progress_bar = $("#progress_test > div");
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

// magic input
function magicInput(obj, the_width) {
	obj = $(obj);
	if(obj.length<1) return false;
	if(the_width==null) the_width = 200;
	var default_width = obj.outerWidth(true);
	obj.css("color", "#999");
	obj.focus(function(){
		$(this).animate({'width':the_width}, 500);
		$(this).val("");
		$(this).css("color", "#000");
	}).blur(function(){
		$(this).animate({'width':default_width}, 500);
		$(this).val($(this).get(0).defaultValue);
		$(this).css("color", "#999");
	});
	return true;
}
magicInput("#search_input");

// set popover
function setPop(theObj, options) {
	if($(theObj).length) {
		theObj = $(theObj);
		theObj.popover('destroy');
		for(var x in options) {
			theObj.attr("data-"+x, options[x]);
			theObj.data(x, options[x]);
		}
		theObj.popover('toggle');
	}
	return;
}

// set affix
function setAffix(pos) {
	pos = pos || $('#affix_bar').attr("pos") || "right";
	if(pos=="left") {
		$("#nav").removeClass("col-md-push-10");
		$("#main").removeClass("col-md-pull-2");
		$('#affix_bar').css("left", "auto");
		$('#affix_bar .glyphicon').css({"float":"right","margin-right":"0px"});
		$('#affix_bar .glyphicon').removeClass("glyphicon-chevron-left").addClass("glyphicon-chevron-right");
		pos = "right";
	} else {
		$("#nav").addClass("col-md-push-10");
		$("#main").addClass("col-md-pull-2");
		$('#affix_bar').css("left", $("#nav").position().left+20);
		$('#affix_bar .glyphicon').css({"float":"left","margin-right":"10px"});
		$('#affix_bar .glyphicon').removeClass("glyphicon-chevron-right").addClass("glyphicon-chevron-left");
		pos = "left";
	}
	$('#affix_bar').attr("pos", pos);
}
$(function(){
	$("section[title]").each(function(i){
		$('<div class="affix_show" style="\
					border:1px solid #e5e5e5;\
					background-color:#f7f5fa;\
					padding:5px 10px;\
					display:block;\
					text-align:center;\
					z-index:-1;\
					margin-top:-50px;\
		">' + this.title + '</div>')
		.appendTo($(this)).affix({
			offset:{
				top:100,
				left:function(){
					return (this.left = $("#page_container").offset().left + $("#page_container").width() + 20);
				}
			},
			relative: true
		});
		//alert(this.innerHTML);
	});
});

// set class
function setClass(theObj, theClass) {
	if($(theObj).length) {
		$(theObj).toggleClass(theClass);
	}
	return;
}
function chgClass(theObj, theClass) {
	if($(theObj).length) {
		var items = $(event.target || event.srcElement).parent().find("label");
		for(var i=0,m=items.length;i<m;i++) {
			$(theObj).removeClass(items.get(i).innerText.replace(".", ""));
		}
		$(theObj).addClass(theClass);
	}
	return;
}

// other
$('#tabs').on('show.bs.tab', function (e) {
	//alert("show");
}).on('shown.bs.tab', function (e) {
	alert("From: " + e.relatedTarget.innerHTML + "\nTo: " + e.target.innerHTML);
})

// Show source code
$(".example").click(function(e){
	if(!e.ctrlKey) return;
	var code = $(this).html();
	var code_obj = $("#show_code").find("code");
	code = code.replace(/\r/, "");
	code = code.replace(/[\n\s]+$/, "");
	code = code.replace(/^[\n]+(\s+)/, "");
	code = code.replace((new RegExp("\n"+RegExp.$1, "g")), "\n");
	code = code.replace(/\t/g, "  ");
	code_obj.text(code);
	
	$("#show_code").show();
	var base_width = code_obj.attr("data-width");
	if(base_width==null) {
		base_width = code_obj.width();
		code_obj.attr("data-width", base_width);
	}
	code_obj.width(2000);
	var cur_width = 2000;
	var cur_height = code_obj.height();
	for(var i=1900;i>base_width;i-=100) {
		code_obj.width(i);
		if(cur_height < code_obj.height()) {
			code_obj.width(i+100);
			break;
		}
		cur_height = code_obj.height();
	}
	
	hljs.highlightBlock(code_obj.get(0));
	
	$("#show_code").modal({
		keyboard: true,
		backdrop: true,
		show: true
	}).on('show.bs.modal', function () {
		code_obj.parent().scrollTop(0);
		code_obj.parent().scrollLeft(0);
	});
});

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