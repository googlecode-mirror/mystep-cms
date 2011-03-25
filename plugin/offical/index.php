<?php
require_once(dirname(__FILE__)."/class.php");

$mystep->regTag("news", "plugin_offical::parse_news");
$mystep->regTag("info", "plugin_offical::parse_info");
$mystep->regTag("link", "plugin_offical::parse_link");
$mystep->regTag("tag", "plugin_offical::parse_tag");
$mystep->regTag("include", "plugin_offical::parse_include");
$mystep->regTag("menu", "plugin_offical::parse_menu");

$mystep->regStart("plugin_offical::page_start");
$mystep->regEnd("plugin_offical::page_end");

$mystep->setAddedContent("start", '<script language="JavaScript" src="script/global.js"></script>');
$mystep->setAddedContent("start", '<script language="JavaScript" src="script/jquery.js"></script>');
$mystep->setAddedContent("end", '<script language="JavaScript" src="script/addon.js"></script>');

$mystep->getLanguage(dirname(__FILE__)."/language/");
?>