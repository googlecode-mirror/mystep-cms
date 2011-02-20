<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/parameter.php");
include(ROOT_PATH."/source/function/global.php");
include(ROOT_PATH."/source/function/web.php");

$req = new MyReq;
$req->init($setting['cookie'], $setting['session']);
$str = RndKey(4, 3);
$req->setCookie("vcode", $str, 300);
vertify_img($str, ROOT_PATH."/images/font.ttc", 24);
?>