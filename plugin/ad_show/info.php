<?php
$info_default = array(
	"name" => "���չʾ���",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_ad_show",
	"intro" => "��վ���չʾ",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "���չʾ",
	"cat_desc" => "��վ���չʾ",
	"description" => "<b>�����������ʾ�͹�����վ��棬�������ʹϵͳ֧������ģ���ǩ��</b>
<b>ad: </b>������ʾ��Ӧ�����Ĺ�棬�ɿ����԰��� idx, limit, class, css, width, height, css_ad, width_ad, height_ad ��"
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