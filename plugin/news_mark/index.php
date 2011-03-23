<?php
require_once(dirname(__FILE__)."/class.php");

$mystep->regTag("news_rank", "plugin_news_mark::news_rank");
$mystep->regTag("news_jump", "plugin_news_mark::news_jump");

$mystep->regAjax("jump", "plugin_news_mark::ajax_jump");
$mystep->regAjax("rank", "plugin_news_mark::ajax_rank");

$mystep->setAddedContent("start", '<link rel="stylesheet" type="text/css" media="all" href="plugin/'.basename(realpath(dirname(__FILE__))).'/style.css" /> ');
$mystep->setAddedContent("end", '<script language="JavaScript" src="plugin/'.basename(realpath(dirname(__FILE__))).'/news_mark.js"></script>  ');

$mystep->getLanguage(dirname(__FILE__)."/language/");
?>