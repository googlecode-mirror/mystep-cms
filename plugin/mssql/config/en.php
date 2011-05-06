<?php
$setting_comm = array();
$setting_comm['host'] = "Host";
$setting_comm['name'] = "Database";
$setting_comm['user'] = "User";
$setting_comm['pass'] = "Password";
$setting_comm['pconn'] = "Persistent";

$setting_descr = array();
$setting_descr['host'] = "Address ofSQL Server";
$setting_descr['name'] = "Name SQL Server Database";
$setting_descr['user'] = "User of SQL Server";
$setting_descr['pass'] = "Password of SQL Server";
$setting_descr['pconn'] = "Persistent Connection";

$setting_type = array();
$setting_type['host'] = array("text", "", "50");
$setting_type['name'] = array("text", "word", "50");
$setting_type['user'] = array("text", "word", "50");
$setting_type['pass'] = array("text", "", "50");
$setting_type['pconn'] = array("radio", array("Open"=>"true", "Close"=>"false"));

?>