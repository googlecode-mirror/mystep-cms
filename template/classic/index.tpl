	<div class="page_bar after">
		<div class="fl page_l">
<!--menu web_id='$web_id' deep="2" class="catList"-->
		</div>

		<div class="fr page_r" style="margin-top:0px;">
			<div class="pic_ole fl" style="height:200px;overflow-y:hidden;">
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
					<span class="highlight">新闻栏目一</span>
					<span>新闻栏目二</span>
					<span>新闻栏目三</span>
					<div class="more"><a href="list.php"><img src="images/classic/more.png" alt="More"/></a></div>
				</div>
				<div class="content">
<!--news cat_id="1" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="2" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="3" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="list.php?cat=83">右侧栏目一</a></div>
				<div class="content">
<!--news cat_id="4" limit="6" loop="6"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_s1">
				<div class="title">
					<span class="highlight">新闻栏目一</span>
					<span>新闻栏目二</span>
					<div class="more"><a href="list.php"><img src="images/classic/more.png" alt="More"/></a></div>
				</div>
				<div class="content">
<!--news cat_id="1" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="2" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="list.php?cat=5">右侧栏目二</a></div>
				<div class="content">
<!--news cat_id="5" limit="6" loop="6"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
      <div class="box box_m">
        <div class="title">新闻栏目三
          <div class="more"><a href="list.php?cat=3"><img src="images/classic/more.png" alt="More"/></a></div>
        </div>
        <div class="content">
<!--news cat_id="3" limit="6" loop="6" show_date="Y-m-d"-->
        </div>
      </div>
			<div class="box box_r">
				<div class="title">联系办法</div>
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

<script language="JavaScript" type="text/javascript">
$(function(){
	//News Picture
	var stop_news_image = false;
	$("#news_image").parent().css({'height':'200px','overflow':'hidden','margin-top':'0px','position':'absolute'});
	$("#news_image").hover(
		function() {stop_news_image = true;},
		function() {stop_news_image = false;}
	);
	var content = $("#news_image").html();
	$("#news_image").html(content + content);
	setInterval(function(){
		if(!stop_news_image) {
			var theStep = 190;
			var theTop = parseInt($("#news_image").css('top'));
			if(Math.abs(theTop/theStep)>=$("#news_image").children().length/2) {
				$("#news_image").css('top', '0px');
				theTop = 0;
			}
			$("#news_image").animate({'top':theTop-theStep},1000);
		}
	}, 5000);
	//Picture Show
	var stop_pic_show = false;
	var theObj = $("#pic_show .marquee");
	$("#pic_show").css('position', 'absolute');
	$("#pic_show").parent().next().css('margin-top', $("#pic_show").height()+10);
	theObj.parent().hover(
		function() {stop_pic_show = true;},
		function() {stop_pic_show = false;}
	);
	var img_cnt = theObj.children().length;
	if(img_cnt>1) {
		var unit_width = 187; //width + margin + border*2
		var content = theObj.html();
		var times = Math.ceil(theObj.width()/(img_cnt*unit_width))*2;
		theObj.html((new Array(times+1)).join(content));
		setInterval(function(){
			if(!stop_pic_show) {
				var theObj = $("#pic_show .marquee");
				var theStep = unit_width * Math.floor(theObj.width()/unit_width);
				var theLeft = parseInt(theObj.css('left'));
				var theLength = unit_width * img_cnt;
				if(Math.abs(theLeft)>=theLength) {
					theLeft += theLength;
					if(Math.abs(theLeft)>=theLength) theLeft += theLength;
					theObj.css('left', theLeft);
				}
				theObj.animate({'left':theLeft-theStep},1000);
			}
		}, 5000);
	}
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
