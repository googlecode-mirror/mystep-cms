<?php
$info_default = array(
	"name" => "管理目录维护插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_admin_cat",
	"intro" => "管理目录添加、修改、删除、排序",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "管理目录",
	"cat_desc" => "管理目录维护",
	"description" => "<b>本插件用于管理后台功能目录的添加、修改、删除、排序等维护操作，无可设置参数</b>"
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