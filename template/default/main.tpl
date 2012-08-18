<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><!--web_title--></title>
<meta http-equiv="windows-Target" content="_top" />
<meta http-equiv="Content-Type" content="text/html; charset=<!--charset-->" />
<meta name="keywords" content="<!--page_keywords-->" />
<meta name="description" content="<!--page_description-->" />
<base href="<!--web_url-->" />
<link rel="Shortcut Icon" href="favicon.ico" />
<!--page_start-->
<link rel="stylesheet" media="screen" type="text/css" href="/images/<!--template-->/style.css" />
<link rel="alternate" title="<!--web_title-->" href="<!--rss_link-->" type="application/rss+xml" />
</head>
<body>
<div id="page_ole">
	<div id="page_top" class="after">
		<div style="position:relative;top:10px;left:880px;width:100px;"">
			<select onchange="$.cookie('template', this.value, {expires:1});window.location.reload();">
				<option value="<!--template-->">ÍøÕ¾ÑùÊ½</option>
				<option value="default">default</option>
				<option value="classic">classic</option>
			</select>
		</div>
		<div class="l fl">
			<img src="/images/default/logo.png" width="280" /><a name="top"></a>
		</div>
		<div class="r fr">
			<img src="/images/default/title_text_1.png" />
			<img src="/images/default/title_text_2.png" />
		</div>
	</div>
	<div id="topbar" class="after">
		<div class="l fl"></div>
		<div class="m fl tc">
			<ul id="top_nav">
				<li class="first"><a href="<!--web_url-->"><!--lang_page_main--></a></li>
<!--loop:start key="news_cat"-->
				<li><a href="<!--news_cat_cat_link-->" catid="<!--news_cat_cat_id-->"><!--news_cat_cat_name--></a></li>
<!--loop:end-->
			</ul>
		</div>
		<div class="r fr"></div>
	</div>
<!--main-->
	<div id="page_bottom" class="after">
		<!--info title="copyright"-->
	</div>
	<div align="center"><!--lang_page_update_time--> : <!--last_modify--><a name="bottom"></a></div>
</div>
<!--page_end-->
</body>
</html>