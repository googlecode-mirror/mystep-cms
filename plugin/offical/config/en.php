<?php
$setting_comm = array();
$setting_comm['cache'] = "Explorer Cache";
$setting_comm['counter'] = "Visit Counter";
$setting_comm['ct_news'] = "News Cache";
$setting_comm['ct_info'] = "Info Cache";
$setting_comm['ct_tag'] = "Tag Cache";
$setting_comm['timezone'] = "Timezone";
$setting_comm['para_1'] = "Text test";
$setting_comm['para_2'] = "Number test";
$setting_comm['para_3'] = "Checkbox test";
$setting_comm['para_4'] = "Radio test";
$setting_comm['para_5'] = "Select test";
$setting_comm['para_6'] = "Password test";

$setting_descr = array();
$setting_descr['cache'] = "Make the explorer side cache, but it will affect the website visit count";
$setting_descr['counter'] = "Simple visit counter, query database 3 times";
$setting_descr['ct_news'] = "Cache expire time of News List";
$setting_descr['ct_info'] = "Cache expire time of Info Show";
$setting_descr['ct_tag'] = "Cache expire time of Tag List";
$setting_descr['timezone'] = "Set the timezone of the website";
$setting_descr['para_1'] = "Alphabets only, 50 charactors as max";
$setting_descr['para_2'] = "Numbers only, 10 digitals as max";
$setting_descr['para_3'] = "Multiselect";
$setting_descr['para_4'] = "Check one";
$setting_descr['para_5'] = "drop down select";
$setting_descr['para_6'] = "Input the same password twice, 15 charactors as max";

$setting_type = array();
$setting_type['cache'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['counter'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['ct_news'] = array("text", "number", "6");
$setting_type['ct_info'] = array("text", "number", "6");
$setting_type['ct_tag'] = array("text", "number", "6");
$setting_type['timezone'] = array("select", array("GMT-12"=>"Etc/GMT+12", "GMT-11"=>"Etc/GMT+11", "GMT-10"=>"Etc/GMT+10", "GMT-9"=>"Etc/GMT+9", "GMT-8"=>"Etc/GMT+8", "GMT-7"=>"Etc/GMT+7", "GMT-6"=>"Etc/GMT+6", "GMT-5"=>"Etc/GMT+5", "GMT-4"=>"Etc/GMT+4", "GMT-3"=>"Etc/GMT+3", "GMT-2"=>"Etc/GMT+2", "GMT-1"=>"Etc/GMT+1", "GMT"=>"Etc/GMT", "GMT+1"=>"Etc/GMT-1", "GMT+2"=>"Etc/GMT-2", "GMT+3"=>"Etc/GMT-3", "GMT+4"=>"Etc/GMT-4", "GMT+5"=>"Etc/GMT-5", "GMT+6"=>"Etc/GMT-6", "GMT+7"=>"Etc/GMT-7", "GMT+8"=>"Etc/GMT-8", "GMT+9"=>"Etc/GMT-9", "GMT+10"=>"Etc/GMT-10", "GMT+11"=>"Etc/GMT-11", "GMT+12"=>"Etc/GMT-12"));
$setting_type['para_1'] = array("text", "name", "50");
$setting_type['para_2'] = array("text", "number", "10");
$setting_type['para_3'] = array("checkbox", array("Selection 1"=>1, "Selection 2"=>2, "Selection 3"=>3, "Selection 4"=>4));
$setting_type['para_4'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['para_5'] = array("select", array("Selection 1"=>"select_1", "Selection 2"=>"select_2", "Selection 3"=>"select_3", "Selection 4"=>"select_4"));
$setting_type['para_6'] = array("password", "", "15");
?>