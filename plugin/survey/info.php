<?php
$info_default = array(
	"name" => "投票调查插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_survey",
	"intro" => "调查统计自定义生成",
	"cat_name" => "投票调查",
	"cat_desc" => "投票调查管理",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>本插件可自定义并生成单选或多选模式的用户投票，本插件可使系统支持如下模板标签：</b>
<b>survey: </b>用于显示对应ID的投票，可控属性包括 id, order, template 等
<b>survey_list: </b>用于显示现有调查列表，可控属性包括 order, limit, condition 等",
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