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
				<div class="title">��Ա��¼</div>
				<div class="content" style="height:150px;">
<!--login id="login"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_s1">
				<div class="title">
					<span class="highlight">������Ϣ</span>
					<span>��ѧ̽��</span>
					<span>�ӵ�۲�</span>
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
				<div class="title"><a href="list.php?cat=83">Σ������</a></div>
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
					<span>iTune</span>
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
				<div class="content" style="display:none;">
<!--news cat_id="107" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="list.php?cat=89">�������</a></div>
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
					<span>Chrome</span>
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
				<div class="content" style="display:none;">
<!--news cat_id="118" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="list.php?cat=5">Ӳ������</a></div>
				<div class="content">
<!--news cat_id="5" limit="6" loop="6"-->
				</div>
			</div>
		</div>

		<div class="fr page_r">
			<div class="box box_s1">
				<div class="title">
					<span class="highlight">���繫˾</span>
					<span>�Ƽ���ҵ</span>
					<span>Ӳ������</span>
					<div class="more"><a href="list.php"><img src="images/classic/more.png" /></a></div>
				</div>
				<div class="content">
<!--news cat_id="94" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="39" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
				<div class="content" style="display:none;">
<!--news cat_id="111" limit="6" loop="6" show_date="Y-m-d"-->
				</div>
			</div>
			<div class="box box_r">
				<div class="title"><a href="read.html">��ϵ�취</a></div>
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
				<span class="highlight">��������</span>
				<span>�Ƽ���վ</span>
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
	//News Picture
	var stop_news_image = false;
	$("#news_image").parent().css({'height':'200px','overflow':'hidden','margin-top':'0px'});
	$("#news_image").hover(
		function() {stop_news_image = true;},
		function() {stop_news_image = false;}
	);
	if($.browser.msie) {
		$("#news_image").css({'height':'190px','overflow':'hidden'});
		var item_cnt = $("#news_image").children();
		var cur_idx = 0;
		setInterval(function(){
			if(!stop_news_image) {
				cur_idx++;
				if(cur_idx>=item_cnt.length) cur_idx = 0;
				$(item_cnt).hide();
				$(item_cnt[cur_idx]).css({'opacity':0});
				$(item_cnt[cur_idx]).show();
				$(item_cnt[cur_idx]).fadeTo(2000, 1);
			}
		}, 5000);
	} else {
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
	}
	//Picture Show
	var stop_pic_show = false;
	var theObj = $("#pic_show .marquee");
	theObj.parent().hover(
		function() {stop_pic_show = true;},
		function() {stop_pic_show = false;}
	);
	if(theObj.children().length>5) {
		var content = theObj.html();
		theObj.html(content + content + content);
		setInterval(function(){
			if(!stop_pic_show) {
				var theObj = $("#pic_show .marquee");
				var theStep = 187*5;
				var theLeft = parseInt(theObj.css('left'));
				var theLength = 187*theObj.children().length/3;
				if(Math.abs(theLeft)>=theLength) {
					theLeft += theLength;
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
		$("#login").find("div").eq(0).html('���ã�<b>' + data.username + "</b>");
		$("#login").find("div").eq(1).html("�����û������ǣ�<b>" + data.type_name + "</b>");
		$("#login").find("div").eq(2).html("���Ĺ������ǣ�<b>" + data.group_name + "</b>");
		$("#login").find("div").eq(3).html('<a href="module.php?m=offical&f=password" target="_blank">����</a> | <a href="module.php?m=offical&f=logout">ע��</a>').css("text-align", "center");
		$("#login").find("div").eq(4).remove();
		$("#login").find("div").eq(5).remove();
		if(data.usergroup>0) {
			$("#login").find("div").eq(3).html('<a href="admin/" target="_blank">����</a> | ' + $("#login").find("div").eq(3).html());
		}
	}, "json");
	//Misc
	setSwitch();
	setList()
});
</script> 
