<?php
$info_default = array(
	"name" => "��վ��������ת�Ʋ��",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.0",
	"class" => "plugin_data_trans",
	"intro" => "�����������ڲ�ͬ��վ�и��ƻ�ת��",
	"copyright" => "��Ȩ���� 2013 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "����ת��",
	"cat_desc" => "��������ת��",
	"description" => "<b>��������ڽ����������ڲ�ͬ��վ�и��ƻ�ת�ƣ��޿����ò���</b>"
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