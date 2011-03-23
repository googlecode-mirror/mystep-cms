<?php
include("inc.php");
$ajax = $mystep->getInstance("MyAjax");
$func = $req->getGet("func");
echo $ajax->run($func, $_POST);
$mystep->pageEnd(false);
?>