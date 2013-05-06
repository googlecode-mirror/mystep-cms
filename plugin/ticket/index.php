<?php
require(dirname(__FILE__)."/class.php");
$mystep->regModule("ticket", dirname(__FILE__)."/show.php");
$mystep->getLanguage(dirname(__FILE__)."/language/");
$mystep->addCSS('plugin/'.basename(realpath(dirname(__FILE__))).'/style.css');
?>