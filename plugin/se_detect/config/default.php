<?php
$setting_comm = array();
$setting_comm['ban'] = "阻止访问";
$setting_comm['counter'] = "访问统计";

$setting_descr = array();
$setting_descr['ban'] = "阻止对应搜索引擎对网站的访问，多个请用逗号间隔";
$setting_descr['counter'] = "是否统计每个IP的访问次数";

$setting_type = array();
$setting_type['ban'] = array("text", "", "200");
$setting_type['counter'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
?>