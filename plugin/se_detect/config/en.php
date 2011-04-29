<?php
$setting_comm = array();
$setting_comm['ban'] = "Ban List";
$setting_comm['counter'] = "Count Visit";

$setting_descr = array();
$setting_descr['ban'] = "Forbid Visit of Specified SE, separate with comma.";
$setting_descr['counter'] = "Count visit of each IP;

$setting_type = array();
$setting_type['ban'] = array("text", "", "200");
$setting_type['counter'] = array("radio", array("Yes"=>"true", "No"=>"false"));
?>