<?php
include("inc.php");
$module = $req->getGet("m");
$mystep->module($module);
$mystep->pageEnd(false);
?>