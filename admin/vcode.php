<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
require_once(ROOT_PATH."/include/config.php");
require_once(ROOT_PATH."/include/parameter.php");
require_once(ROOT_PATH."/source/function/global.php");
require_once(ROOT_PATH."/source/function/web.php");

$req = new MyReq;
$req->init($setting['cookie'], $setting['session']);
$str = RndKey(4, 3);
$req->setCookie("vcode", $str, 300);
vertify_img($str, ROOT_PATH."/images/simsun.ttc", 24);
?>