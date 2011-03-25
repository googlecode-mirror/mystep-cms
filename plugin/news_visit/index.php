<?php
require_once(dirname(__FILE__)."/class.php");

$mystep->regTag("news_day", "plugin_news_visit::parse_news_day");
$mystep->regTag("news_week", "plugin_news_visit::parse_news_week");
$mystep->regTag("news_month", "plugin_news_visit::parse_news_month");
$mystep->regTag("news_year", "plugin_news_visit::parse_news_year");

$mystep->regEnd("plugin_news_visit::page_end");

?>