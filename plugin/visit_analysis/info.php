<?php
$info_default = array(
	"name" => "��վ������Դ�������",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.6",
	"class" => "plugin_visit_analysis",
	"intro" => "��վ������Դͳ�ƣ��ؼ��ַ���",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name_1" => "��Դͳ��",
	"cat_desc_1" => "��վ������Դͳ��",
	"cat_name_2" => "�ؼ��ַ���",
	"cat_desc_2" => "��������ÿ�ؼ��ַ���",
	"description" => "<b>���������ͳ����վ������Դ���Լ�ͳ����Դ��������ļ����ؼ���</b>"
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