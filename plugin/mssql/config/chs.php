<?php
$setting_comm = array();
$setting_comm['host'] = "服务器地址";
$setting_comm['name'] = "数据库名称";
$setting_comm['user'] = "数据库用户";
$setting_comm['pass'] = "数据库密码";
$setting_comm['pconn'] = "持久连接";

$setting_descr = array();
$setting_descr['host'] = "SQL Server 服务器";
$setting_descr['name'] = "SQL Server 数据库名称";
$setting_descr['user'] = "SQL Server 服务器用户";
$setting_descr['pass'] = "SQL Server 服务器密码";
$setting_descr['pconn'] = "SQL Server 持续链接";

$setting_type = array();
$setting_type['host'] = array("text", "", "50");
$setting_type['name'] = array("text", "word", "50");
$setting_type['user'] = array("text", "word", "50");
$setting_type['pass'] = array("text", "", "50");
$setting_type['pconn'] = array("radio", array("开启"=>"true", "关闭"=>"false"));

?>