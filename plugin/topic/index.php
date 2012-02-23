<?php
require(dirname(__FILE__)."/class.php");

$mystep->regTag("topic", "plugin_topic::topic");
$mystep->regTag("topic_list", "plugin_topic::topic_list");
$mystep->regModule("topic", dirname(__FILE__)."/show.php");
?>