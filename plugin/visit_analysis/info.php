<?php
$info_default = array(
	"name" => "网站访问来源分析插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.6",
	"class" => "plugin_visit_analysis",
	"intro" => "网站访问来源统计，关键字分析",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name_1" => "来源统计",
	"cat_desc_1" => "网站访问来源统计",
	"cat_name_2" => "关键字分析",
	"cat_desc_2" => "搜索引擎每关键字分析",
	"description" => "<b>本插件用于统计网站访问来源，以及统计来源搜索引擎的检索关键字</b>"
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