<?php
if(empty($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME'])!==7) die("NULL");
require("inc.php");
$ajax = $mystep->getInstance("MyAjax");
$func = $req->getGet("func");
$return = $req->getGet("return");
echo $ajax->run($func, $_POST, $return, $setting['gen']['charset']);
$mystep->pageEnd(false);
?>