<?php
$setting_comm = array();
$setting_comm['mode'] = '发送模式';
$setting_comm['host'] = '服务器地址';
$setting_comm['port'] = '服务器端口';
$setting_comm['user'] = '服务器账户';
$setting_comm['password'] = '服务器密码';

$setting_descr = array();
$setting_descr['mode'] = '选择发送邮件及服务器认证的方式';
$setting_descr['host'] = '发送邮件所用SMTP服务器';
$setting_descr['port'] = 'SMTP服务器端口';
$setting_descr['user'] = '服务器所分配的邮件账户';
$setting_descr['password'] = '对应邮件账户的密码';

$setting_type = array();
$setting_type['mode'] = array("select", array("内置函数"=>"", "普通验证"=>"smtp", "SSL 验证"=>"ssl", "TLS 验证"=>"tls", "SSL/TLS 混合验证"=>"ssl/tls"));
$setting_type['host'] = array("text", false, "30");
$setting_type['port'] = array("text", "digital_", "5");
$setting_type['user'] = array("text", false, "30");
$setting_type['password'] = array("text", false, "40");
?>