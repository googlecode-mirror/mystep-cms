<?php
$setting_comm = array();
$setting_comm['cache'] = "浏览器缓存";
$setting_comm['counter'] = "访问量统计";
$setting_comm['ct_news'] = "新闻缓存";
$setting_comm['ct_info'] = "信息缓存";
$setting_comm['ct_tag'] = "标签缓存";
$setting_comm['timezone'] = "时区矫正";
$setting_comm['para_1'] = "文本测试";
$setting_comm['para_2'] = "数字测试";
$setting_comm['para_3'] = "复选测试";
$setting_comm['para_4'] = "单选测试";
$setting_comm['para_5'] = "选单测试";
$setting_comm['para_6'] = "密码测试";

$setting_descr = array();
$setting_descr['cache'] = "避免反复调用服务器页面，但会影响流量统计";
$setting_descr['counter'] = "简单访问统计，会有三次简单查询";
$setting_descr['ct_news'] = "新闻列表缓存时间";
$setting_descr['ct_info'] = "页面信息缓存时间";
$setting_descr['ct_tag'] = "标签列表缓存时间";
$setting_descr['timezone'] = "设定网站显示时区";
$setting_descr['para_1'] = "不可为特殊符号，限长50字";
$setting_descr['para_2'] = "只可为合法实数，限长10位";
$setting_descr['para_3'] = "可多选";
$setting_descr['para_4'] = "单选";
$setting_descr['para_5'] = "下拉列表";
$setting_descr['para_6'] = "请输入两次密码，限长15位";

$setting_type = array();
$setting_type['cache'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['counter'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['ct_news'] = array("text", "number", "6");
$setting_type['ct_info'] = array("text", "number", "6");
$setting_type['ct_tag'] = array("text", "number", "6");
$setting_type['timezone'] = array("select", array("GMT-12"=>"Etc/GMT+12", "GMT-11"=>"Etc/GMT+11", "GMT-10"=>"Etc/GMT+10", "GMT-9"=>"Etc/GMT+9", "GMT-8"=>"Etc/GMT+8", "GMT-7"=>"Etc/GMT+7", "GMT-6"=>"Etc/GMT+6", "GMT-5"=>"Etc/GMT+5", "GMT-4"=>"Etc/GMT+4", "GMT-3"=>"Etc/GMT+3", "GMT-2"=>"Etc/GMT+2", "GMT-1"=>"Etc/GMT+1", "GMT"=>"Etc/GMT", "GMT+1"=>"Etc/GMT-1", "GMT+2"=>"Etc/GMT-2", "GMT+3"=>"Etc/GMT-3", "GMT+4"=>"Etc/GMT-4", "GMT+5"=>"Etc/GMT-5", "GMT+6"=>"Etc/GMT-6", "GMT+7"=>"Etc/GMT-7", "GMT+8"=>"Etc/GMT-8", "GMT+9"=>"Etc/GMT-9", "GMT+10"=>"Etc/GMT-10", "GMT+11"=>"Etc/GMT-11", "GMT+12"=>"Etc/GMT-12"));
$setting_type['para_1'] = array("text", "name", "50");
$setting_type['para_2'] = array("text", "number", "10");
$setting_type['para_3'] = array("checkbox", array("选项 1"=>1, "选项 2"=>2, "选项 3"=>3, "选项 4"=>4));
$setting_type['para_4'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['para_5'] = array("select", array("选项 1"=>"select_1", "选项 2"=>"select_2", "选项 3"=>"select_3", "选项 4"=>"select_4"));
$setting_type['para_6'] = array("password", "", "15");
?>