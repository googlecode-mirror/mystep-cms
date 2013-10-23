<?php
$setting_comm = array();
$setting_comm['cms_jquery'] = "系统jQuery";
$setting_comm['cms_jquery_addon'] = "jQuery扩展";
$setting_comm['cms_css'] = "系统样式";

$setting_descr = array();
$setting_descr['cms_jquery'] = "是否使用系统jQuery";
$setting_descr['cms_jquery_addon'] = "是否使用系统提供的jQuery扩展";
$setting_descr['cms_css'] = "是否使用系统提供的样式（某些JS扩展需要）";

$setting_type = array();
$setting_type['cms_jquery'] = array("radio", array("是"=>"true", "否"=>"false"));
$setting_type['cms_jquery_addon'] = array("radio", array("是"=>"true", "否"=>"false"));
$setting_type['cms_css'] = array("radio", array("是"=>"true", "否"=>"false"));
?>