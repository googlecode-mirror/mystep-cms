<?php
$setting_comm = array();
$setting_comm['mode'] = '����ģʽ';
$setting_comm['host'] = '��������ַ';
$setting_comm['port'] = '�������˿�';
$setting_comm['user'] = '�������˻�';
$setting_comm['password'] = '����������';

$setting_descr = array();
$setting_descr['mode'] = 'ѡ�����ʼ�����������֤�ķ�ʽ';
$setting_descr['host'] = '�����ʼ�����SMTP������';
$setting_descr['port'] = 'SMTP�������˿�';
$setting_descr['user'] = '��������������ʼ��˻�';
$setting_descr['password'] = '��Ӧ�ʼ��˻�������';

$setting_type = array();
$setting_type['mode'] = array("select", array("���ú���"=>"", "��ͨ��֤"=>"smtp", "SSL ��֤"=>"ssl", "TLS ��֤"=>"tls", "SSL/TLS �����֤"=>"ssl/tls"));
$setting_type['host'] = array("text", false, "30");
$setting_type['port'] = array("text", "digital_", "5");
$setting_type['user'] = array("text", false, "30");
$setting_type['password'] = array("text", false, "40");
?>