<?php
$info_default = array(
	"name" => "�Զ����ѯ���",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_custom_sql",
	"intro" => "�Զ����ѯ����",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "�Զ����ѯ",
	"cat_desc" => "�Զ����ѯ����",
	"description" => "<b>��������ڴ洢��ִ���û��Զ���SQLָ��޿����ò���</b>"
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