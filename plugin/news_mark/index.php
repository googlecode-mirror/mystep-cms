<?php
require_once(dirname(__FILE__)."/class.php");

$mystep->regTag("news_rank", "plugin_news_mark::news_rank");
$mystep->regTag("news_jump", "plugin_news_mark::news_jump");
$mystep->regTag("news_mark", "plugin_news_mark::news_mark");

$mystep->regAjax("jump", "plugin_news_mark::ajax_jump");
$mystep->regAjax("rank", "plugin_news_mark::ajax_rank");

$mystep->addCSS('plugin/'.basename(realpath(dirname(__FILE__))).'/style.css');
$mystep->addJS('plugin/'.basename(realpath(dirname(__FILE__))).'/news_mark.js');

$mystep->getLanguage(dirname(__FILE__)."/language/");
?>