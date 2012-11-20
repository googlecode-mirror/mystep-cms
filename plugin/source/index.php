<?php
$mystep->regModule("source", dirname(__FILE__)."/show.php");
$mystep->setAddedContent("end", '
<div style="position:fixed;bottom:5px;right:5px;border:1px #cccccc dashed;background-color:#efefef;padding:5px 10px;font-weight:bold;"><a href="/module.php?m=source" target="_blank">Source Code</a></div>
');
?>