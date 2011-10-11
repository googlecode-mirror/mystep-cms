<div class="title"><!--title--></div>
<div align="center">
	<div id="info_show" style="margin:auto; text-align:left; width:800px; padding:20px 10px 20px 10px; font-size:14px; line-height:20px;"></div>
</div>
<div>
	<iframe scrolling="no" id="snatch" name="snatch" src="about:blank" MARGINHEIGHT="0" MARGINWIDTH="0" style="display:none;"></iframe>
</div>
<script type="text/javascript" language="javascript">
$(function(){
	var id = "<!--id-->";
	var show = "<!--show-->";
	var refresh = parseInt("<!--refresh-->");
	var info_file = "<!--info_file-->";
	if(show.length>0) {
		$("#info_show").css({"font-size":"18px", "font-weight":"bold", "text-align":"center"});
		$("#info_show").html(show);
	} else {
		$("#snatch").attr("src", "news_snatch.php?method=news_snatch&id="+id);
		$("#info_show").html("开始抓取文章，请稍候。。。");
		setInterval(function() {
			$.get(info_file, {rand:Math.random()}, function(data){
			  if(data.length>0) {
			  	$("#info_show").html(data);
			  	window.scrollTo(0,document.body.scrollHeight);
			  }
			});
		}, 10000);
	}
	if(!isNaN(refresh)) setTimeout("window.location.reload(true)", (refresh+1200)*1000);
});
</script>
