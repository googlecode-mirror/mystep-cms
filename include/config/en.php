<?php
$setting_comm = array();

$setting_comm['web'] = array();
$setting_comm['web_comm'] = 'Website setting';
$setting_comm['web']['url'] = 'Website URL';
$setting_comm['web']['email'] = 'Website Email';
$setting_comm['web']['title'] = 'Website Name';
$setting_comm['web']['keyword'] = 'keyword';
$setting_comm['web']['description'] = 'Description';
$setting_comm['web']['s_user'] = 'SA Name';
$setting_comm['web']['s_pass'] = 'SA Password';
$setting_comm['web']['close'] = 'Website Close';
$setting_comm['web']['close_page'] = 'Close Page';
$setting_comm['web']['cache_mode'] = 'Cache Mode';
$setting_comm['web_descr']['url'] = 'The address of website';
$setting_comm['web_descr']['email'] = 'The email of administrator';
$setting_comm['web_descr']['title'] = 'Name of the website';
$setting_comm['web_descr']['keyword'] = 'Keywords for the searching engine';
$setting_comm['web_descr']['description'] = 'Description for the searching engine';
$setting_comm['web_descr']['s_user'] = 'Name of the super user.';
$setting_comm['web_descr']['s_pass'] = 'Password of the super user';
$setting_comm['web_descr']['close'] = 'Temporary close the website';
$setting_comm['web_descr']['close_page'] = 'When website was closed, the page will be show';
$setting_comm['web_descr']['cache_mode'] = 'Open the cache mode to reduce the db query';

$setting_comm['db'] = array();
$setting_comm['db_comm'] = 'Database Setting';
$setting_comm['db']['host'] = 'Server';
$setting_comm['db']['user'] = 'User';
$setting_comm['db']['pass'] = 'Password';
$setting_comm['db']['charset'] = 'Charset';
$setting_comm['db']['name'] = 'DB name';
$setting_comm['db']['pre'] = 'Table Prefix';
$setting_comm['db']['pconnect'] = 'Persistent Connections';
$setting_comm['db_descr']['host'] = 'Address of DB server';
$setting_comm['db_descr']['user'] = 'Username of DB';
$setting_comm['db_descr']['pass'] = 'Password of DB';
$setting_comm['db_descr']['charset'] = 'Default Charset of DB';
$setting_comm['db_descr']['name'] = 'The DB name which the website store in';
$setting_comm['db_descr']['pre'] = 'The prefix of all offical website tables';
$setting_comm['db_descr']['pconnect'] = 'Use persistent connections';

$setting_comm['gen'] = array();
$setting_comm['gen_comm'] = '��������';
$setting_comm['gen']['language'] = '��վ����';
$setting_comm['gen']['charset'] = '��վ����';
$setting_comm['gen']['gzip_level'] = 'ѹ������';
$setting_comm['gen']['cache'] = 'ҳ�滺��';
$setting_comm['gen']['rewrite'] = '��̬����';
$setting_comm['gen']['cache_ext'] = '��̬��չ��';
$setting_comm['gen']['template'] = 'Ĭ��ģ��';
$setting_comm['gen']['timezone'] = "Timezone";
$setting_comm['gen_descr']['language'] = '��վ��ʾ�����л�';
$setting_comm['gen_descr']['charset'] = '��վ��ʾ���뼯';
$setting_comm['gen_descr']['gzip_level'] = 'GZIP ѹ��ҳ��ļ���0-9����0 Ϊ�ر�ѹ��';
$setting_comm['gen_descr']['cache'] = '����ҳ�滺�棬���ٹ̶�ʱ���ڵĲ�ѯƵ�ʣ���ǿ��վЧ��';
$setting_comm['gen_descr']['rewrite'] = '����վ����ת��Ϊ��̬���ӣ������������ URL_Rewrite ֧��';
$setting_comm['gen_descr']['cache_ext'] = '��̬���Ӻͻ����ļ�����չ��';
$setting_comm['gen_descr']['template'] = '��վǰ̨��ʾ��ʽ';
$setting_comm['gen_descr']['timezone'] = "Set the timezone of the website";

$setting_comm['list'] = array();
$setting_comm['list_comm'] = '�б���ʾ��������';
$setting_comm['list']['txt'] = '�����б�';
$setting_comm['list']['img'] = 'ͼƬ�б�';
$setting_comm['list']['mix'] = 'ͼ���б�';
$setting_comm['list']['rss'] = '�ۺ��б�';
$setting_comm['list_descr']['txt'] = '�����б�ģʽ����ʾ���ŵĵ���';
$setting_comm['list_descr']['img'] = 'ͼƬ�б�ģʽ����ʾ���ŵĵ���';
$setting_comm['list_descr']['mix'] = 'ͼ�Ļ���б�ģʽ����ʾ���ŵĵ���';
$setting_comm['list_descr']['rss'] = 'RSS �ۺ���ʾ���ŵĵ���';

$setting_comm['session'] = array();
$setting_comm['session_comm'] = 'Session ����';
$setting_comm['session']['expire'] = '����ʱ��';
$setting_comm['session']['gc'] = '���ڻ���';
$setting_comm['session']['trans_sid'] = '���� SID';
$setting_comm['session']['name'] = '��������';
$setting_comm['session']['mode'] = '����ģʽ';
$setting_comm['session_descr']['expire'] = '�û��������ߵ��ʱ��';
$setting_comm['session_descr']['path'] = '�ļ��洢ģʽ��Session�ļ������·��';
$setting_comm['session_descr']['gc'] = '����ɾ�����õ�Session��Ϣ';
$setting_comm['session_descr']['trans_sid'] = 'ͨ��URL���Ӵ���SID����Ҫ�����û��ر�COOKIE�����';
$setting_comm['session_descr']['name'] = '�������ڴ洢Session����������';
$setting_comm['session_descr']['mode'] = '�洢Session��ģʽ����mystepģʽ��Ӱ�쵽����ͳ�ƣ�';

$setting_comm['cookie'] = array();
$setting_comm['cookie_comm'] = 'Cookie ����';
$setting_comm['cookie']['domain'] = '��������';
$setting_comm['cookie']['path'] = '����·��';
$setting_comm['cookie']['prefix'] = 'Cookieǰ׺';
$setting_comm['cookie_descr']['domain'] = 'Cookie���ڸ���������Ч';
$setting_comm['cookie_descr']['path'] = 'Cookie�����õ���վ·��';
$setting_comm['cookie_descr']['prefix'] = '�洢Cookie�ı���ǰ׺�����ڷ�ֹ�û�������ƭ';

$setting_comm['path'] = array();
$setting_comm['path_comm'] = '·������';
$setting_comm['path']['admin'] = '��̨·��';
$setting_comm['path']['upload'] = '�ϴ�·��';
$setting_comm['path']['cache'] = '����·��';
$setting_comm['path']['template'] = 'ģ��·��';
$setting_comm['path_descr']['admin'] = '��̨�����·��';
$setting_comm['path_descr']['upload'] = '�ϴ��ļ��Ĵ洢Ŀ¼';
$setting_comm['path_descr']['cache'] = '�洢����ҳ���Ŀ¼';
$setting_comm['path_descr']['template'] = 'ģ��洢��·��';

$setting_comm['content'] = array();
$setting_comm['content_comm'] = '��������';
$setting_comm['content']['max_length'] = '��������';
$setting_comm['content']['get_remote_img'] = '����Զ��ͼ';
$setting_comm['content_descr']['max_length'] = '��ҳ���ŵ����������';
$setting_comm['content_descr']['get_remote_img'] = '���������еķǱ���ͼƬ������';

$setting_comm['watermark'] = array();
$setting_comm['watermark_comm'] = 'ˮӡ����';
$setting_comm['watermark']['mode'] = 'ˮӡģʽ';
$setting_comm['watermark']['txt'] = 'ˮӡ����';
$setting_comm['watermark']['img'] = 'ˮӡͼƬ';
$setting_comm['watermark']['credit'] = '��Ȩ����';
$setting_comm['watermark_descr']['mode'] = '�Ƿ����������ݻ�ͼƬ�����ˮӡ';
$setting_comm['watermark_descr']['txt'] = '����ˮӡ������';
$setting_comm['watermark_descr']['img'] = '����ˮӡ��ͼƬ';
$setting_comm['watermark_descr']['credit'] = '��ʾ�����������еİ�Ȩ����';

$setting_comm['memcache'] = array();
$setting_comm['memcache_comm'] = '��������';
$setting_comm['memcache']['server'] = 'Memcache ������';
$setting_comm['memcache']['weight'] = 'Memcache ������Ȩ��';
$setting_comm['memcache']['persistant'] = 'Memcache ��������';
$setting_comm['memcache']['timeout'] = 'Memcache ��ʱʱ��';
$setting_comm['memcache']['retry_interval'] = 'Memcache ����Ƶ��';
$setting_comm['memcache']['status'] = 'Memcache ����״̬';
$setting_comm['memcache']['expire'] = 'Memcache ����ʱ��';
$setting_comm['memcache']['threshold'] = 'Memcache ѹ����ֵ';
$setting_comm['memcache']['min_savings'] = 'Memcache ѹ����';
$setting_comm['memcache_descr']['server'] = 'Memcache ��������IP:PORT��';
$setting_comm['memcache_descr']['weight'] = 'Memcache ������Ȩ��';
$setting_comm['memcache_descr']['persistant'] = 'Memcache �������ӣ���ʹ�ý�Ƶ��ʱ�Ƽ���';
$setting_comm['memcache_descr']['timeout'] = 'Memcache ��ʱʱ�䣨�룩';
$setting_comm['memcache_descr']['retry_interval'] = 'Memcache ʧ������Ƶ�ʣ��룩';
$setting_comm['memcache_descr']['status'] = 'Memcache ״̬�Ƿ����';
$setting_comm['memcache_descr']['expire'] = 'Memcache ����ʱ��';
$setting_comm['memcache_descr']['threshold'] = 'Memcache ���ƶ��ֵ�����Զ�ѹ������ֵ';
$setting_comm['memcache_descr']['min_savings'] = 'Memcache ����ѹ����ѹ����';

$setting_type['web'] = array();
$setting_type['web']['url'] = array("text", "url", "50");
$setting_type['web']['email'] = array("text", "email", "50");
$setting_type['web']['title'] = array("text", "name", "40");
$setting_type['web']['keyword'] = array("text", "", "60");
$setting_type['web']['description'] = array("text", "", "100");
$setting_type['web']['s_user'] = array("text", "alpha", "16");
$setting_type['web']['s_pass'] = array("password", "", "40");
$setting_type['web']['close'] = array("radio", array("��վ�ر�"=>"true", "��վ����"=>"false"));
$setting_type['web']['close_page'] = array("text", "", "100");
$setting_type['web']['cache_mode'] = array("select", array("File Mode"=>"file", "DB Mode"=>"mysql", "MemCache"=>"memcache", "eAccelerator"=>"eaccelerator", "xCache"=>"xcache"));

$setting_type['db'] = array();
$setting_type['db']['host'] = array("text", "", "30");
$setting_type['db']['user'] = array("text", "alpha", "20");
$setting_type['db']['pass'] = array("password", "", "40");
$setting_type['db']['charset'] = array("select", array("GBK"=>"gbk", "UTF-8"=>"utf8", "Latin1"=>"latin1"));
$setting_type['db']['name'] = array("text", "alpha", "20");
$setting_type['db']['pre'] = array("text", "alpha", "10");
$setting_type['db']['pconnect'] = array("radio", array("Open"=>"true", "Close"=>"false"));

$setting_type['gen'] = array();
$setting_type['gen']['language'] = array("text", "alpha", "10");
$setting_type['gen']['charset'] = array("text", "alpha", "10");
$setting_type['gen']['gzip_level'] = array("text", "digital", "1");
$setting_type['gen']['cache'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['gen']['rewrite'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['gen']['cache_ext'] = array("text", "", "10");
$setting_type['gen']['template'] = array("text", "alpha", "20");
$setting_type['gen']['timezone'] = array("select", array("GMT-12"=>"Etc/GMT+12", "GMT-11"=>"Etc/GMT+11", "GMT-10"=>"Etc/GMT+10", "GMT-9"=>"Etc/GMT+9", "GMT-8"=>"Etc/GMT+8", "GMT-7"=>"Etc/GMT+7", "GMT-6"=>"Etc/GMT+6", "GMT-5"=>"Etc/GMT+5", "GMT-4"=>"Etc/GMT+4", "GMT-3"=>"Etc/GMT+3", "GMT-2"=>"Etc/GMT+2", "GMT-1"=>"Etc/GMT+1", "GMT"=>"Etc/GMT", "GMT+1"=>"Etc/GMT-1", "GMT+2"=>"Etc/GMT-2", "GMT+3"=>"Etc/GMT-3", "GMT+4"=>"Etc/GMT-4", "GMT+5"=>"Etc/GMT-5", "GMT+6"=>"Etc/GMT-6", "GMT+7"=>"Etc/GMT-7", "GMT+8"=>"Etc/GMT-8", "GMT+9"=>"Etc/GMT-9", "GMT+10"=>"Etc/GMT-10", "GMT+11"=>"Etc/GMT-11", "GMT+12"=>"Etc/GMT-12"));

$setting_type['list'] = array();
$setting_type['list']['txt'] = array("text", "digital", "2");
$setting_type['list']['img'] = array("text", "digital", "2");
$setting_type['list']['mix'] = array("text", "digital", "2");
$setting_type['list']['rss'] = array("text", "digital", "2");

$setting_type['session'] = array();
$setting_type['session']['expire'] = array("text", "digital", "2");
$setting_type['session']['gc'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['session']['trans_sid'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['session']['name'] = array("text", "alpha", "10");
$setting_type['session']['mode'] = array("select", array("MyStep mode"=>"sess_mystep", "DB mode"=>"sess_mysql", "File Mode"=>"sess_file"));

$setting_type['cookie'] = array();
$setting_type['cookie']['domain'] = array("text", "", "20");
$setting_type['cookie']['path'] = array("text", "", "30");
$setting_type['cookie']['prefix'] = array("text", "alpha", "10");

$setting_type['path'] = array();
$setting_type['path']['admin'] = array("text", "", "20");
$setting_type['path']['upload'] = array("text", "", "20");
$setting_type['path']['cache'] = array("text", "", "20");
$setting_type['path']['template'] = array("text", "", "20");

$setting_type['content'] = array();
$setting_type['content']['max_length'] = array("text", "digital", "8");
$setting_type['content']['get_remote_img'] = array("radio", array("Open"=>"true", "Close"=>"false"));

$setting_type['watermark'] = array();
$setting_type['watermark']['mode'] = array("checkbox", array("Text"=>1, "Image"=>2));
$setting_type['watermark']['txt'] = array("text", "", "30");
$setting_type['watermark']['img'] = array("text", "", "30");
$setting_type['watermark']['credit'] = array("text", "", "30");

$setting_type['cache'] = array();
$setting_type['cache']['memcache'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['cache']['eaccelerator'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['cache']['xcache'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['memcache']['server'] = array("text", false, "40");
$setting_type['memcache']['weight'] = array("text", "digital", "2");
$setting_type['memcache']['persistant'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['memcache']['timeout'] = array("text", "digital", "2");
$setting_type['memcache']['retry_interval'] = array("text", "digital", "2");
$setting_type['memcache']['status'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['memcache']['expire'] = array("text", "digital", "8");
$setting_type['memcache']['threshold'] = array("text", "number", "8");
$setting_type['memcache']['min_savings'] = array("text", "number", "3");
?>