<?php
$setting_comm = array();
$setting_comm['cms_jquery'] = "Default jQuery";
$setting_comm['cms_jquery_addon'] = "jQuery Addon";
$setting_comm['affix'] = "Affix";
$setting_comm['alert'] = "Alert";
$setting_comm['button'] = "Button";
$setting_comm['carousel'] = "Carouse";
$setting_comm['collapse'] = "Collapse";
$setting_comm['dropdown'] = "Dropdown";
$setting_comm['modal'] = "Modal";
$setting_comm['scrollspy'] = "Scrollspy";
$setting_comm['tab'] = "Tab";
$setting_comm['tooltip'] = "Tooltip";
$setting_comm['popover'] = "Popover";
$setting_comm['typeahead'] = "Typeahead";

$setting_descr = array();
$setting_descr['cms_jquery'] = "Use jQuery.js provided by CMS";
$setting_descr['cms_jquery_addon'] = "Use jQuery_addon.js provided by CMS";
$setting_descr['affix'] = "Use Affix plugin provided by bootstrap";
$setting_descr['alert'] = "Use Alert plugin provided by bootstrap";
$setting_descr['button'] = "Use Button plugin provided by bootstrap";
$setting_descr['carousel'] = "Use Carouse plugin provided by bootstrap";
$setting_descr['collapse'] = "Use Collapse plugin provided by bootstrap";
$setting_descr['dropdown'] = "Use Dropdown plugin provided by bootstrap";
$setting_descr['modal'] = "Use Modal plugin provided by bootstrap";
$setting_descr['scrollspy'] = "Use Scrollspy plugin provided by bootstrap";
$setting_descr['tab'] = "Use Tab plugin provided by bootstrap";
$setting_descr['tooltip'] = "Use Tooltip plugin provided by bootstrap";
$setting_descr['popover'] = "Use Popover plugin provided by bootstrap, Tooltip is needed";
$setting_descr['typeahead'] = "Use Typeahead plugin provided by bootstrap";

$setting_type = array();
$setting_type['cms_jquery'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['cms_jquery_addon'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['affix'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['alert'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['button'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['carousel'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['collapse'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['dropdown'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['modal'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['scrollspy'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['tab'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['tooltip'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['popover'] = array("radio", array("Yes"=>"true", "No"=>"false"));
$setting_type['typeahead'] = array("radio", array("Yes"=>"true", "No"=>"false"));
?>







<?php
$setting_comm = array();
$setting_comm['cache'] = "Explorer Cache";
$setting_comm['counter'] = "Visit Counter";
$setting_comm['ct_news'] = "News Cache";
$setting_comm['ct_info'] = "Info Cache";
$setting_comm['ct_tag'] = "Tag Cache";
$setting_comm['bgsound'] = "BG Music";
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
$setting_descr['bgsound'] = "Background music of the website, every line make effect with corresponding subweb";
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
$setting_type['bgsound'] = array("textarea", false, "4");
$setting_type['para_1'] = array("text", "name", "50");
$setting_type['para_2'] = array("text", "number", "10");
$setting_type['para_3'] = array("checkbox", array("Selection 1"=>1, "Selection 2"=>2, "Selection 3"=>3, "Selection 4"=>4));
$setting_type['para_4'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['para_5'] = array("select", array("Selection 1"=>"select_1", "Selection 2"=>"select_2", "Selection 3"=>"select_3", "Selection 4"=>"select_4"));
$setting_type['para_6'] = array("password", "", "15");
?>