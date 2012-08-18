<?php
require(dirname(__FILE__)."/class.php");

$mystep->regTag("news", "plugin_offical::parse_news");
$mystep->regTag("info", "plugin_offical::parse_info");
$mystep->regTag("link", "plugin_offical::parse_link");
$mystep->regTag("tag", "plugin_offical::parse_tag");
$mystep->regTag("include", "plugin_offical::parse_include");
$mystep->regTag("menu", "plugin_offical::parse_menu");
$mystep->regTag("login", "plugin_offical::parse_login");

$mystep->regLog("plugin_offical::login", "plugin_offical::logout");

$mystep->regStart("plugin_offical::page_start");
$mystep->regEnd("plugin_offical::page_end");

$mystep->regApi("rss", "plugin_offical::api_rss");
$mystep->regApi("news", "plugin_offical::api_news");
$mystep->regApi("newslist", "plugin_offical::api_newslist");

$mystep->regAjax("login", "plugin_offical::ajax_login");
$mystep->regAjax("autocomplete", "plugin_offical::ajax_autocomplete");
$mystep->regAjax("subcat", "plugin_offical::ajax_subcat");

$mystep->addJS("script/jquery.js");
$mystep->addJS("script/jquery.addon.js");
$mystep->addJS("script/global.js");
$mystep->addJS("script/addon.js");
$mystep->setAddedContent("start", '<script language="JavaScript" type="text/javascript" src="/source/merge.php?js"></script>');
$mystep->addCSS("images/style.css");
$mystep->setAddedContent("start", '<link rel="stylesheet" type="text/css" media="all" href="/source/merge.php?css" />');

$mystep->regModule("offical", dirname(__FILE__)."/show.php");
$mystep->getLanguage(dirname(__FILE__)."/language/");

$mystep->setAddedContent("start", '
<meta name="robots" content="index, follow" />
<meta name="revisit-after" content="1 days" />
<meta name="rating" content="general" />
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta name="author" content="windy2000" />
<meta name="generator" content="MyStep" />
<meta name="copyright" content="Copyright (c) 2011 windy2000. All Rights Reserved." />
');
$mystep->setAddedContent("end", '
<div style="text-align:center;padding:10px;float:none;clear:both;">Powered By <a href="http://www.mysteps.cn" target="_blank">MystepCMS</a></div>
');

$bg_sound = explode("\n", $plugin_setting['offical']['bgsound']);
$bg_sound = $bg_sound[$setting['info']['web']['web_id']-1];
if(strlen($bg_sound)>4 && $setting['info']['self']=="index.php") {
	$mystep->setAddedContent("end", '
<div style="width:0px;height:0px;overflow:hidden;">
	<audio autoplay="1" loop="loop">
		<source src="'.$bg_sound.'" type="audio/mp3" />
		<embed src="'.$bg_sound.'" loop="true" type="audio/mp3" autostart="true" hidden="true" />
	</audio>
</div>
	');
}
?>