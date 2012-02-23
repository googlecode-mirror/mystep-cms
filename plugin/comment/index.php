<?php
require(dirname(__FILE__)."/class.php");
$mystep->regTag("comment", "plugin_comment::comment");
$mystep->regTag("news_comment", "plugin_comment::news_comment");
$mystep->regAjax("comment_post", "plugin_comment::ajax_post");
$mystep->regAjax("comment_report", "plugin_comment::ajax_report");
$mystep->addCSS('plugin/'.basename(realpath(dirname(__FILE__))).'/style.css');
$mystep->getLanguage(dirname(__FILE__)."/language/");
?>