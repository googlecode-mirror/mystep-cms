<?php
$info = array(
	"name" => "������ϵͳ",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.5",
	"class" => "plugin_custom_form",
	"intro" => "��������������",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>�������Ҫ���ڶ��Ʋ����ɱ��������ע�ᱨ�������ϵ����</b>"
);
$rewrite = array(
	array("cform/submit/(\d+)", "module.php?m=cf_submit&mid=$1"),
	array("cform/list/(\d+)(/(\d+))?", "module.php?m=cf_list&mid=$1&page=$3"),
);
?>