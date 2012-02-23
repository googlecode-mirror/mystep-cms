<?php
require(dirname(__FILE__)."/class.php");

$mystep->regTag("survey", "plugin_survey::survey");
$mystep->regTag("survey_list", "plugin_survey::survey_list");
$mystep->regAjax("vote", "plugin_survey::ajax_vote");

$mystep->regModule("survey", dirname(__FILE__)."/show.php");

$mystep->addJS('plugin/'.basename(realpath(dirname(__FILE__))).'/survey.js');
$mystep->addCSS('plugin/'.basename(realpath(dirname(__FILE__))).'/style.css');

$mystep->getLanguage(dirname(__FILE__)."/language/");
?>