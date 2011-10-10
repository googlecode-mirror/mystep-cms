	<div class="page_bar after">
		<div class="fl page_l">
<!--menu web_id='$web_id' deep="2" class="catList"-->
		</div>

		<div class="fr page_r" style="margin-top:0px;">
			<div class="pic_ole fl">
				<div id="news_image">
<!--news limit="3" template="mix" show_image="1" show_date="Y-m-d H:i:s" setop="img"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title">会员登录</div>
				<div class="content">
<!--login id="login"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_s1">
				<div class="title">
					<span class="highlight">栏目一</span>
					<span>栏目二</span>
					<span>栏目三</span>
					<div class="more"><a href="list.php"><img src="images/classic/more.png" /></a></div>
				</div>
				<div class="content">
<!--news cat_id="2" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="3" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="4" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title">栏目四</div>
				<div class="content">
<!--news cat_id="5" limit="6" loop="6"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_m">
				<div class="title">
					栏目五
					<div class="more"><a href="list.php"><img src="images/classic/more.png" /></a></div>
				</div>
				<div class="content">
<!--news cat_id="6" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="list.php">栏目六</a></div>
				<div class="content">
<!--news cat_id="7" limit="6" loop="6"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_m">
				<div class="title">
					栏目七
					<div class="more"><a href="list.php"><img src="images/classic/more.png" /></a></div>
				</div>
				<div class="content">
<!--news cat_id="8" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="list.php">栏目八</a></div>
				<div class="content">
<!--news cat_id="9" limit="6" loop="6"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_m">
				<div class="title">
					栏目九
					<div class="more"><a href="list.php"><img src="images/classic/more.png" /></a></div>
				</div>
				<div class="content">
<!--news cat_id="10" limit="6" loop="6" show_date="Y-m-d"-->
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
});
</script> 
