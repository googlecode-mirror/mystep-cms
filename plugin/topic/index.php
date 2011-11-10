<?php
require_once(dirname(__FILE__)."/class.php");

$mystep->regTag("topic", "plugin_topic::topic");
$mystep->regModule("topic", dirname(__FILE__)."/show.php");
?>