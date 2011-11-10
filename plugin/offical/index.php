<?php
require_once(dirname(__FILE__)."/class.php");

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

//$mystep->setAddedContent("start", '<script language="JavaScript" src="/script/jquery.js"></script>');
//$mystep->setAddedContent("start", '<script language="JavaScript" src="/script/global.js"></script>');
//$mystep->setAddedContent("end", '<script language="JavaScript" src="/script/addon.js"></script>');
//$mystep->setAddedContent("start", '<link rel="stylesheet" type="text/css" media="all" href="images/a.css" /> ');

$mystep->addJS("script/jquery.js");
$mystep->addJS("script/jquery.addon.js");
$mystep->addJS("script/global.js");
$mystep->addJS("script/addon.js");
$mystep->setAddedContent("start", '<script language="JavaScript" src="/source/merge.php?js"></script>');
$mystep->addCSS("images/style.css");
$mystep->setAddedContent("start", '<link rel="stylesheet" type="text/css" media="all" href="/source/merge.php?css" />');

$mystep->regModule("offical", dirname(__FILE__)."/show.php");
$mystep->getLanguage(dirname(__FILE__)."/language/");
?>