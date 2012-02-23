<?php
require(dirname(__FILE__)."/class.php");
$mystep->regTag("ad_show", "plugin_ad_show::ad_show");
$mystep->regModule("ad_link", dirname(__FILE__)."/go.php");
?>