<?php
$setting_comm = array();
$setting_comm['cms_jquery'] = "Default jQuery";
$setting_comm['cms_jquery_addon'] = "jQuery Addon";
$setting_comm['cms_css'] = "Default Style";

$setting_descr = array();
$setting_descr['cms_jquery'] = "Use jQuery.js provided by CMS";
$setting_descr['cms_jquery_addon'] = "Use jQuery_addon.js provided by CMS";
$setting_descr['cms_css'] = "Use style.css provided by CMS(Some JS function need it)";

$setting_type = array();
$setting_type['cms_jquery'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['cms_jquery_addon'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['cms_css'] = array("radio", array("Yes"=>"true", "No"=>"false"));
?>