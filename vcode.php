<?php
$ms_sign = 1;
require("inc.php");
$str = RndKey(4, 3);
$req->setCookie("vcode", $str, 1000);
vertify_img($str, ROOT_PATH."/images/font.ttc", 24);
$mystep->pageEnd(false);
?>