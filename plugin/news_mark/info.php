<?php
$info_default = array(
	"name" => "新闻评价插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_news_mark",
	"intro" => "新闻评分、提升",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "新闻评分",
	"cat_desc" => "新闻评分、提升",
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