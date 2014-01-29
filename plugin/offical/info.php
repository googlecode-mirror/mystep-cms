<?php
$info_default = array(
	"name" => "官方插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.9",
	"class" => "plugin_offical",
	"intro" => "官方插件，同时也包含使用样例。",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>本插件可使系统支持如下模板标签：</b>
<b>News: </b>用于展示网站文章，对应数据库中的 news_show 表，可控属性包括 web_id, cat_id, order, setop, show_image, css1, css2, limit, loop, show_catalog, show_date, tag, template 等
<b>Info: </b>用于显示自定义超文本内容，对应数据库中的 info_show 表，可控属性包括 id, title 等
<b>Link: </b>用于显示网站链接，对应数据库中的 link 表，可控属性包括 type, limit, idx 等
<b>Tag: </b>用于显示网站标签，对应数据库中的 news_tag 表，可控属性包括 template, limit, order 等
<b>Menu: </b>用于显示各级目录结构，对应数据库中的 news_cat 表，可控属性包括 web_id, cat_id, deep 等
<b>Include: </b>用于在指定位置嵌入其他文件，可控属性有 file"
);

$rewrite = array(
	array("offical/login","module.php?m=offical&f=login_show"),
	array("offical/password","module.php?m=offical&f=password"),
	array("offical/login_check","module.php?m=offical&f=login"),
	array("offical/logout","module.php?m=offical&f=logout"),
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