<?php
$info_default = array(
	"name" => "广告展示插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_ad_show",
	"intro" => "网站广告展示",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "广告展示",
	"cat_desc" => "网站广告展示",
	"description" => "<b>本插件用于显示和管理网站广告，本插件可使系统支持如下模板标签：</b>
<b>ad: </b>用于显示对应索引的广告，可控属性包括 idx, limit, class, css, width, height, css_ad, width_ad, height_ad 等"
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