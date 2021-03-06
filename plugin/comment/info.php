<?php
$info_default = array(
	"name" => "新闻评论插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.3",
	"class" => "plugin_comment",
	"intro" => "新闻评论发表",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "新闻评论",
	"cat_desc" => "新闻评论管理",
	"description" => "<b>本插件可使系统支持如下模板标签：</b>
<b>comment: </b>用于在相关文章中显示评论，可控属性包括 news_id, web_id 等
<b>news_comment: </b>用于显示相关评论内容，可控属性包括 web_id, news_id, order, limit, loop, template, count 等",
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