<?php
$info_default = array(
	"name" => "搜索引擎监控插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.3",
	"class" => "plugin_se_detect",
	"intro" => "搜索引擎监控、统计",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name_1" => "搜索引擎",
	"cat_desc_1" => "搜索引擎监控",
	"cat_name_2" => "索引记录",
	"cat_desc_2" => "搜索引擎每日收录记录",
	"description" => "<b>本插件用于监控搜索引擎爬虫对于网站的索引情况</b>"
);

if(isset($setting['gen']['language'])) {
	if(is_file(realpath(dirname(__FILE__))."/info/".$setting['gen']['language'].".php")) {
		include(realpath(dirname(__FILE__))."/info/".$setting['gen']['language'].".php");
		$info = array_merge($info_default, $info);
	} else {
		$info = $info_default;
	}
} else {
	$info = $info_default;
}
?>