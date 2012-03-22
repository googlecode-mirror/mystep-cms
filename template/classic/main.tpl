<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><!--web_title--></title>
<meta http-equiv="windows-Target" contect="_top" />
<meta http-equiv="Content-Type" content="text/html; charset=<!--charset-->" />
<meta name="keywords" content="<!--page_keywords-->" />
<meta name="description" content="<!--page_description-->" />
<link rel="Shortcut Icon" href="favicon.ico" />
<!--page_start-->
<link rel="stylesheet" type="text/css" href="images/<!--template-->/style.css" />
<link rel="alternate" title="<!--web_title-->" href="<!--rss_link-->" type="application/rss+xml" />
</head>
<body>
<div id="bar_loading"><img src="images/loading.gif" alt="<!--lang_ajax_sending-->"><br / ><span><!--lang_ajax_sending--></span></div>
<div id="page_ole">
	<div id="page_top_nav" class="after">
		<div class="fl">
			<script language="JavaScript" src="script/date.js"></script><a name="top"></a>
		</div>
		<div class="fr">
			<script language="JavaScript" src="script/chs2cht.js"></script> |
			<a href="#" onClick="setHomepage()">设为首页</a> |
			<a href="#" onClick="addBookmark(this)">加入收藏</a>
		</div>
	</div>
	<div id="page_top" class="after">
		<img src="images/classic/top_text.png" />
	</div>
	<div id="topbar" class="after">
		<div class="l fl"></div>
		<div class="m fl">
			<ul>
				<li class="first"><a href="<!--web_url-->"><!--lang_page_main--></a></li>
<!--loop:start key="news_cat"-->
				<li><a href="<!--news_cat_cat_link-->"><!--news_cat_cat_name--></a></li>
<!--loop:end-->
			</ul>
		</div>
		<div class="r fr"></div>
	</div>
	<div id="marquee" class="after">
		<div class="l fl">
<!--search id="search_form" keyword='$keyword'-->
		</div>
		<div class="r fr">
			<marquee behavior="scroll" scrollamount="5" onmouseover="this.stop()" onmouseout="this.start()">
<!--news limit="5" template="plat" setop1="txt" order="rand()" condition="DATEDIFF(add_date, NOW())<5"-->
			</marquee>
		</div>
	</div>

<!--main-->

	<div id="page_bottom" class="after">
		<!--info title="copyright"-->
	</div>

	<div align="center"><!--lang_page_update_time--> : <!--last_modify--><a name="bottom"></a></div>
	<div id="validBar">
		<a id="validXhtml" target="_blank" href="http://validator.w3.org/check?uri=referer">Valid XHTML</a>
		<a id="validCss" target="_blank" href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">Valid CSS</a>
	</div>
<!--page_end-->
</div>
</body>
</html>