<?php
$info_default = array(
	"name" => "���������ز��",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.3",
	"class" => "plugin_se_detect",
	"intro" => "���������ء�ͳ��",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name_1" => "��������",
	"cat_desc_1" => "����������",
	"cat_name_2" => "������¼",
	"cat_desc_2" => "��������ÿ����¼��¼",
	"description" => "<b>��������ڼ�������������������վ���������</b>"
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