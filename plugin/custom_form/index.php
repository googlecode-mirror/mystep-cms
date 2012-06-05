<?php
require(dirname(__FILE__)."/class.php");
$mystep->regTag("cf_list", "plugin_custom_form::tag_list");
$mystep->regModule("cf_submit", dirname(__FILE__)."/show.php");
$mystep->regModule("cf_list", dirname(__FILE__)."/show.php");
$mystep->regUrl("cf_submit", "plugin_custom_form::getUrl_submit");
$mystep->regUrl("cf_list", "plugin_custom_form::getUrl_list");
$mystep->addCSS('plugin/'.basename(realpath(dirname(__FILE__))).'/style.css');
$mystep->getLanguage(dirname(__FILE__)."/language/");
?>