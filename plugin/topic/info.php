<?php
$info_default = array(
	"name" => "ר����",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.2",
	"class" => "plugin_topic",
	"intro" => "������վר����Ŀ",
	"cat_name" => "��վר��",
	"cat_desc" => "��վר����Ŀ����",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>���������������վר����Ŀ����ʹϵͳ֧������ģ���ǩ��</b>
<b>topic_list: </b>������ʾ����ר���б��ɿ����԰��� order, limit, loop, template, condition, show_date ��
<b>topic: </b>������ʾ��Ӧר���������ӣ��ɿ����԰��� id, cat, order, limit, loop, template, condition, show_date, show_catalog ��",
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