<?php
$info_default = array(
	"name" => "新闻访问统计插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.4",
	"class" => "plugin_news_visit",
	"intro" => "高级新闻访问统计及显示",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "文章访问",
	"cat_desc" => "文章访问统计",
	"description" => "<b>本插件可使系统支持如下模板标签：</b>
<b>parse_news_day: </b>按日访问量显示文章列表，可控属性包括 web_id, cat_id, css1, css2, limit, loop, template 等
<b>parse_news_week: </b>按周访问量显示文章列表，可控属性包括 web_id, cat_id, css1, css2, limit, loop, template 等
<b>parse_news_month: </b>按月访问量显示文章列表，可控属性包括 web_id, cat_id, css1, css2, limit, loop, template 等
<b>parse_news_year: </b>按年访问量显示文章列表，可控属性包括 web_id, cat_id, css1, css2, limit, loop, template 等"
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