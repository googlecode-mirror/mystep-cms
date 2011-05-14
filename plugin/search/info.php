<?php
$info = array(
	"name" => "文章内容检索插件",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_search",
	"intro" => "通过本网或搜索引擎检索网站内容",
	"cat_name_1" => "文章检索",
	"cat_desc_1" => "文章搜索引擎管理",
	"cat_name_2" => "检索关键字",
	"cat_desc_2" => "访客检索关键字管理",
	"copyright" => "版权所有 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => '
<b>本插件主要用于通过关键字检索本网站相关文章，也可以调用其他搜索引擎</b>

如果需要本站检索，请为相关子站建立一个 seach.tpl 模版，并包含如下标签：

<font color="red">&lt;!--news limit=\'$limit\' show_date="1" show_catalog="1" condition=\'$condition\' loop=\'20\'--&gt;</font>
'
);
?>