<?php
$info_default = array(
	"name" => "新闻评价插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_news_mark",
	"intro" => "新闻评分、提升",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "新闻评分",
	"cat_desc" => "新闻评分、提升",
	"description" => "<b>本插件可使系统支持如下模板标签：</b>
<b>news_rank: </b>用于对相关文章进行评分，可控属性包括 news_id, web_id, cat_id 等
<b>news_jump: </b>用于对相关文章进行提升和下压操作，可控属性包括 news_id, web_id, cat_id 等"
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