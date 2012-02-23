<?php
require(dirname(__FILE__)."/class.php");
$mystep->regTag("search", "plugin_search::tag_search");
$mystep->regTag("keyword", "plugin_search::tag_keyword");
$mystep->regModule("search", dirname(__FILE__)."/show.php");
$mystep->getLanguage(dirname(__FILE__)."/language/");
?>