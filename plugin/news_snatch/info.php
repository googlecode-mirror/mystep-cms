<?php
$info_default = array(
	"name" => "���²ɼ����",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.2",
	"class" => "plugin_news_snatch",
	"intro" => "ͨ���û��������ץȡ��ҳ����",
	"cat_name_1" => "�ɼ�����",
	"cat_desc_1" => "��������ץȡ������ű�",
	"cat_name_2" => "�ɼ�����",
	"cat_desc_2" => "�Ѳɼ��������б�",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"description" => "<b>�������ͨ���û�����Ĺ���ץȡ������վ���ݣ������뱾�����ݿ�</b>",
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