<?php
$setting_comm = array();
$setting_comm['interval'] = "Check Interval";
$setting_comm['s_pass'] = "SA Password";

$setting_descr = array();
$setting_descr['interval'] = "The time interval between two scheduled task check(in seconds)";
$setting_descr['s_pass'] = "Password of the super user(Need for resume mode above, with authority mode)";

$setting_type = array();
$setting_type['interval'] = array("text", "number", "4");
$setting_type['s_pass'] = array("password", false, "40");
?>