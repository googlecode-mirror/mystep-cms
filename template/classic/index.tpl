	<div class="page_bar after">
		<div class="fl page_l">
<!--menu web_id='$web_id' deep="2" class="catList"-->
		</div>

		<div class="fr page_r" style="margin-top:0px;">
			<div class="pic_ole fl">
				<div id="news_image">
<!--news limit="5" template="mix" show_image="1" show_date="Y-m-d H:i:s" setop1="img"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title">会员登录</div>
				<div class="content" style="height:150px;">
<!--login id="login"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_s1">
				<div class="title">
					<span class="highlight">最新消息</span>
					<span>科学探索</span>
					<span>视点观察</span>
					<div class="more"><a href="list.php"><img src="images/classic/more.png" /></a></div>
				</div>
				<div class="content">
<!--news cat_id="9" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="15" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="7" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="list.php?cat=83">危机警告</a></div>
				<div class="content">
<!--news cat_id="83" limit="6" loop="6"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_s1">
				<div class="title">
					<span class="highlight">Apple</span>
					<span>iPhone</span>
					<span>iPad</span>
					<div class="more"><a href="list.php"><img src="images/classic/more.png" /></a></div>
				</div>
				<div class="content">
<!--news cat_id="53" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="16" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="86" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="list.php?cat=89">软件新闻</a></div>
				<div class="content">
<!--news cat_id="89" limit="6" loop="6"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_s1">
				<div class="title">
					<span class="highlight">Google</span>
					<span>Android</span>
					<span>Gmail</span>
					<div class="more"><a href="list.php"><img src="images/classic/more.png" /></a></div>
				</div>
				<div class="content">
<!--news cat_id="10" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="36" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="52" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="list.php?cat=5">硬件新闻</a></div>
				<div class="content">
<!--news cat_id="5" limit="6" loop="6"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_s1">
				<div class="title">
					<span class="highlight">游戏娱乐</span>
					<span>智能手机</span>
					<span>通信运营商</span>
					<div class="more"><a href="list.php"><img src="images/classic/more.png" /></a></div>
				</div>
				<div class="content">
<!--news cat_id="26" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="42" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="28" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="read.html">联系办法</a></div>
				<div class="content" style="height:144px; overflow:hidden;">
<!--info title="contact"-->
				</div>
			</div>
		</div>
	</div>

	<div class="page_bar after">
		<div id="pic_show">
			<div class="fl l">&lt;</div>
			<div class="fl m">
				<div class="marquee">
<!--link type="image" idx="show"-->
				</div>
			</div>
			<div class="fr r">&gt;</div>
		</div>
	</div>
		
	<div class="page_bar after">
		<div class="box box_s2">
			<div class="title">
				<span class="highlight">友情链接</span>
				<span>推荐网站</span>
			</div>
			<div class="content">
<!--link type="text" idx="friend"-->
			</div>
			<div class="content" style="display:none;">
<!--link type="text" idx="recommend"-->
			</div>
		</div>
	</div>

<script language="JavaScript">
$(function(){
	//Menu List
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
	//News Picture
	$("#news_image").parent().css({'height':'200px','overflow':'hidden','margin-top':'0px'});
	if($.browser.msie) {
		$("#news_image").css({'height':'190px','overflow':'hidden'});
		var item_cnt = $("#news_image").children();
		var cur_idx = 0;
		setInterval(function(){
			cur_idx++;
			if(cur_idx>=item_cnt.length) cur_idx = 0;
			$(item_cnt).hide();
			$(item_cnt[cur_idx]).css({'opacity':0});
			$(item_cnt[cur_idx]).show();
			$(item_cnt[cur_idx]).fadeTo(2000, 1);
		}, 5000);
	} else {
		var content = $("#news_image").html();
		$("#news_image").html(content + content);
		setInterval(function(){
			var theStep = 190;
			var theTop = parseInt($("#news_image").css('top'));
			if(Math.abs(theTop/theStep)>=$("#news_image").children().length/2) {
				$("#news_image").css('top', '0px');
				theTop = 0;
			}
			$("#news_image").animate({'top':theTop-theStep},1000);
		}, 5000);
	}
	//Picture Show
	var theObj = $("#pic_show .marquee");
	if(theObj.children().length>5) {
		var content = theObj.html();
		theObj.html(content + content + content);
		setInterval(function(){
			var theObj = $("#pic_show .marquee");
			var theStep = 187*5;
			var theLeft = parseInt(theObj.css('left'));
			var theLength = 187*theObj.children().length/3;
			if(Math.abs(theLeft)>=theLength) {
				theLeft += theLength;
				theObj.css('left', theLeft);
			}
			theObj.animate({'left':theLeft-theStep},1000);
		}, 5000);
	}
	//Switch Tag
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
	//login
	$.get("ajax.php?func=login&return=json", function(data){
		if(data.usertype==1) return;
		$("#login").find("div").css({"padding":"2px 2px 10px 2px", "text-align":"left", "font-weight":"normal"});
		$("#login").find("div").eq(0).html('您好，<b>' + data.username + "</b>");
		$("#login").find("div").eq(1).html("您的用户级别是：<b>" + data.type_name + "</b>");
		$("#login").find("div").eq(2).html("您的管理级别是：<b>" + data.group_name + "</b>");
		$("#login").find("div").eq(3).html('<a href="module.php?m=offical&f=password" target="_blank">密码</a> | <a href="module.php?m=offical&f=logout">注销</a>').css("text-align", "center");
		$("#login").find("div").eq(4).remove();
		$("#login").find("div").eq(5).remove();
		if(data.usergroup>0) {
			$("#login").find("div").eq(3).html('<a href="admin/" target="_blank">管理</a> | ' + $("#login").find("div").eq(3).html());
		}
	}, "json");
});
</script> 
