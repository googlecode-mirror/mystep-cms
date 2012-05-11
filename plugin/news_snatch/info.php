<?php
$info_default = array(
	"name" => "文章采集插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.2",
	"class" => "plugin_news_snatch",
	"intro" => "通过用户定义规则抓取网页文章",
	"cat_name_1" => "采集规则",
	"cat_desc_1" => "外网文章抓取及导入脚本",
	"cat_name_2" => "采集文章",
	"cat_desc_2" => "已采集的文章列表",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>本插件可通过用户定义的规则抓取其他网站内容，并导入本网数据库</b>",
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