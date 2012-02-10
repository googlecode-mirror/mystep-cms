<?php
$setting_comm = array();
$setting_comm['mode'] = 'Mode';
$setting_comm['host'] = 'Server';
$setting_comm['port'] = 'Port';
$setting_comm['user'] = 'User';
$setting_comm['password'] = 'Password';

$setting_descr = array();
$setting_descr['mode'] = 'Authority mode of SMTP Server';
$setting_descr['host'] = 'Address of SMTP server';
$setting_descr['port'] = 'Port of SMTP server';
$setting_descr['user'] = 'Account of SMTP server';
$setting_descr['password'] = 'Password of SMTP server';

$setting_type = array();
$setting_type['mode'] = array("select", array("PHP mail()"=>"", "Normal SMTP"=>"smtp", "SSL SMTP"=>"ssl", "TLS SMTP"=>"tls", "SSL/TLS Mix"=>"ssl/tls"));
$setting_type['host'] = array("text", false, "30");
$setting_type['port'] = array("text", "digital_", "5");
$setting_type['user'] = array("text", false, "30");
$setting_type['password'] = array("text", false, "40");
?>