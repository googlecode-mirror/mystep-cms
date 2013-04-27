<?php
$info_default = array(
	"name" => "子站文章数据转移插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_data_trans",
	"intro" => "将文章数据在不同子站中复制或转移",
	"copyright" => "版权所有 2013 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "数据转移",
	"cat_desc" => "文章数据转移",
	"description" => "<b>本插件用于将文章数据在不同子站中复制或转移，无可设置参数</b>"
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