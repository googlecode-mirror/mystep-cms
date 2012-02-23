<?php
require(dirname(__FILE__)."/class.php");

$mystep->regTag("regist", "plugin_meeting::tag_reg");
$mystep->regModule("regist", dirname(__FILE__)."/regist.php");
$mystep->regModule("reglist", dirname(__FILE__)."/regist.php");
$mystep->addCSS('plugin/'.basename(realpath(dirname(__FILE__))).'/style.css');
$mystep->getLanguage(dirname(__FILE__)."/language/");
?>