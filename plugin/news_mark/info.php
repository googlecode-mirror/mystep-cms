<?php
$info_default = array(
	"name" => "�������۲��",
	"idx" => basename(realpath(dirname(__FILE__))),
	"ver" => "1.1",
	"class" => "plugin_news_mark",
	"intro" => "�������֡�����",
	"copyright" => "��Ȩ���� 2011 <a href='mailto:windy2006@gmail.com'>Windy2000</a>",
	"cat_name" => "��������",
	"cat_desc" => "�������֡�����",
	"description" => "<b>�������ʹϵͳ֧������ģ���ǩ��</b>
<b>news_rank: </b>���ڶ�������½������֣��ɿ����԰��� news_id, web_id, cat_id ��
<b>news_jump: </b>���ڶ�������½�����������ѹ�������ɿ����԰��� news_id, web_id, cat_id ��"
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