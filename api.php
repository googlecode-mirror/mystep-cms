<?php
include("inc.php");
$api = $mystep->getInstance("MyApi");
$para = explode("|", $req->getServer("QUERY_STRING"));
$func = array_shift($para);
echo $api->run($func, $para);
$mystep->pageEnd(false);
?>