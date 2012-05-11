<?php
$info_default = array(
	"name" => "专题插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.2",
	"class" => "plugin_topic",
	"intro" => "设置网站专题栏目",
	"cat_name" => "网站专题",
	"cat_desc" => "网站专题栏目管理",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>本插件用于设置网站专题栏目，可使系统支持如下模板标签：</b>
<b>topic_list: </b>用于显示现有专题列表，可控属性包括 order, limit, loop, template, condition, show_date 等
<b>topic: </b>用于显示对应专题的相关链接，可控属性包括 id, cat, order, limit, loop, template, condition, show_date, show_catalog 等",
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