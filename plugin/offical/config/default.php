<?php
$setting_comm = array();
$setting_comm['cache'] = "���������";
$setting_comm['counter'] = "������ͳ��";
$setting_comm['ct_news'] = "���Ż���";
$setting_comm['ct_info'] = "��Ϣ����";
$setting_comm['ct_tag'] = "��ǩ����";
$setting_comm['bgsound'] = "��������";
$setting_comm['para_1'] = "�ı�����";
$setting_comm['para_2'] = "���ֲ���";
$setting_comm['para_3'] = "��ѡ����";
$setting_comm['para_4'] = "��ѡ����";
$setting_comm['para_5'] = "ѡ������";
$setting_comm['para_6'] = "�������";

$setting_descr = array();
$setting_descr['cache'] = "���ⷴ�����÷�����ҳ�棬����Ӱ������ͳ��";
$setting_descr['counter'] = "�򵥷���ͳ�ƣ��������μ򵥲�ѯ";
$setting_descr['ct_news'] = "�����б���ʱ��";
$setting_descr['ct_info'] = "ҳ����Ϣ����ʱ��";
$setting_descr['ct_tag'] = "��ǩ�б���ʱ��";
$setting_descr['bgsound'] = "��վ�������֣���Ϊ���ػ������ַ";
$setting_descr['para_1'] = "����Ϊ������ţ��޳�50��";
$setting_descr['para_2'] = "ֻ��Ϊ�Ϸ�ʵ�����޳�10λ";
$setting_descr['para_3'] = "�ɶ�ѡ";
$setting_descr['para_4'] = "��ѡ";
$setting_descr['para_5'] = "�����б�";
$setting_descr['para_6'] = "�������������룬�޳�15λ";

$setting_type = array();
$setting_type['cache'] = array("radio", array("����"=>"true", "�ر�"=>"false"));
$setting_type['counter'] = array("radio", array("����"=>"true", "�ر�"=>"false"));
$setting_type['ct_news'] = array("text", "number", "6");
$setting_type['ct_info'] = array("text", "number", "6");
$setting_type['ct_tag'] = array("text", "number", "6");
$setting_type['bgsound'] = array("text", false, "200");
$setting_type['para_1'] = array("text", "name", "50");
$setting_type['para_2'] = array("text", "number", "10");
$setting_type['para_3'] = array("checkbox", array("ѡ�� 1"=>1, "ѡ�� 2"=>2, "ѡ�� 3"=>3, "ѡ�� 4"=>4));
$setting_type['para_4'] = array("radio", array("����"=>"true", "�ر�"=>"false"));
$setting_type['para_5'] = array("select", array("ѡ�� 1"=>"select_1", "ѡ�� 2"=>"select_2", "ѡ�� 3"=>"select_3", "ѡ�� 4"=>"select_4"));
$setting_type['para_6'] = array("password", "", "15");
?>