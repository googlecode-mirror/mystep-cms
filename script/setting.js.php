<?php
define(ROOT_PATH, str_replace("\\", "/", realpath(dirname(__file__)."/../")));
include(ROOT_PATH."/include/config.php");
require(ROOT_PATH."/source/function/global.php");
echo "var ms_setting = ".toJson($setting['js'], $setting['gen']['charset']).";";
?>