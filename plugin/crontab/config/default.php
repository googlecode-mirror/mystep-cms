<?php
$setting_comm = array();
$setting_comm['interval'] = "刷新频率";
$setting_comm['interval_resume'] = "恢复频率";
$setting_comm['s_pass'] = "创始人密码";

$setting_descr = array();
$setting_descr['interval'] = "每次检查计划任务时间（秒）";
$setting_descr['interval_resume'] = "解决windows系统下FastCGI执行超时的问题（每执行多少次任务检查）";
$setting_descr['s_pass'] = "超级用户密码（用于以上的恢复模式，需配合 authority 模式）";

$setting_type = array();
$setting_type['interval'] = array("text", "number", "4");
$setting_type['interval_resume'] = array("text", "number", "3");
$setting_type['s_pass'] = array("password", false, "40");
?>