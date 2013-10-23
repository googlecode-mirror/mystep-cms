<?php
$ms_sign = 1;
require("inc.php");
$api = $mystep->getInstance("MyApi");
$para = explode("|", $req->getServer("QUERY_STRING"));
for($i=0;$i<3;$i++) {
	if(!isset($para[$i])) $para[$i] = "";
}
$para[2] = strtolower($para[2]);
echo $api->run($para[0], explode(",", $para[1]), $para[2], $setting['gen']['charset']);
$mystep->pageEnd(false);
?>