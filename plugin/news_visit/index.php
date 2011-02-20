<?php
require_once(dirname(__FILE__)."/class.php");

$mystep->regTag(array("news_day", "plugin_news_visit::news_day"));
$mystep->regTag(array("news_week", "plugin_news_visit::news_week"));
$mystep->regTag(array("news_month", "plugin_news_visit::news_month"));
$mystep->regTag(array("news_year", "plugin_news_visit::news_year"));

$mystep->regEnd("plugin_news_visit::page_end");

?>