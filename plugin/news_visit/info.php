<?php
$info_default = array(
	"name" => "���ŷ���ͳ�Ʋ��",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.3",
	"class" => "plugin_news_visit",
	"intro" => "�߼����ŷ���ͳ�Ƽ���ʾ",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "���·���",
	"cat_desc" => "���·���ͳ��",
	"description" => "<b>�������ʹϵͳ֧������ģ���ǩ��</b>
<b>parse_news_day: </b>���շ�������ʾ�����б��ɿ����԰��� web_id, cat_id, css1, css2, limit, loop, template ��
<b>parse_news_week: </b>���ܷ�������ʾ�����б��ɿ����԰��� web_id, cat_id, css1, css2, limit, loop, template ��
<b>parse_news_month: </b>���·�������ʾ�����б��ɿ����԰��� web_id, cat_id, css1, css2, limit, loop, template ��
<b>parse_news_year: </b>�����������ʾ�����б��ɿ����԰��� web_id, cat_id, css1, css2, limit, loop, template ��"
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