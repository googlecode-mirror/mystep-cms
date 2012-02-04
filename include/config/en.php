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
$setting_comm['gen_comm'] = 'General Setting';
$setting_comm['gen']['language'] = 'Language';
$setting_comm['gen']['charset'] = 'Charset';
$setting_comm['gen']['gzip_level'] = 'Gzip output';
$setting_comm['gen']['cache'] = 'HTML Cache';
$setting_comm['gen']['rewrite'] = 'URL Rewrite';
$setting_comm['gen']['cache_ext'] = 'Rewrite Ext.';
$setting_comm['gen']['template'] = 'Template';
$setting_comm['gen']['timezone'] = "Timezone";
$setting_comm['gen']['update'] = "Update URL";
$setting_comm['gen']['minify'] = "HTML Minify";
$setting_comm['gen']['etag'] = "Etag Fix";
$setting_comm['gen_descr']['language'] = 'Change CMS language';
$setting_comm['gen_descr']['charset'] = 'Charset of CMS';
$setting_comm['gen_descr']['gzip_level'] = 'GZIP page content (Level 0-9)';
$setting_comm['gen_descr']['cache'] = 'Save high frequency db query data into cache';
$setting_comm['gen_descr']['rewrite'] = 'Generate a .html url for every page of CMS';
$setting_comm['gen_descr']['cache_ext'] = 'Extension name of URL Rewrite';
$setting_comm['gen_descr']['template'] = 'Default Style for website';
$setting_comm['gen_descr']['timezone'] = "Set the timezone of the website";
$setting_comm['gen_descr']['update'] = "From the URL your can get the newest update of CMS";
$setting_comm['gen_descr']['minify'] = "Minify the html code of each page to reduce the internet transfer time";
$setting_comm['gen_descr']['etag'] = "Append to Etag with which to avoid non-modification HTML pages transfer";

$setting_comm['email'] = array();
$setting_comm['email_comm'] = 'SMTP Parameter Set';
$setting_comm['email']['mode'] = 'Mode';
$setting_comm['email']['smtp'] = 'Server';
$setting_comm['email']['port'] = 'Port';
$setting_comm['email']['user'] = 'User';
$setting_comm['email']['password'] = 'Password';
$setting_comm['email_descr']['mode'] = 'Authority mode of SMTP Server';
$setting_comm['email_descr']['smtp'] = 'Address of SMTP server';
$setting_comm['email_descr']['port'] = 'Port of SMTP server';
$setting_comm['email_descr']['user'] = 'Account of SMTP server';
$setting_comm['email_descr']['password'] = 'Password of SMTP server';

$setting_comm['js'] = array();
$setting_comm['js_comm'] = 'JS Parameter Set';
$setting_comm['js']['debug'] = 'Debug Info';
$setting_comm['js_descr']['debug'] = 'Show JaveScript Error Messege';

$setting_comm['list'] = array();
$setting_comm['list_comm'] = 'Parameter for Artile List';
$setting_comm['list']['txt'] = 'Text List';
$setting_comm['list']['img'] = 'Image List';
$setting_comm['list']['mix'] = 'Mix List';
$setting_comm['list']['rss'] = 'Rss List';
$setting_comm['list_descr']['txt'] = 'How many artile will be show in subject only list.';
$setting_comm['list_descr']['img'] = 'How many artile will be show in image with subject list.';
$setting_comm['list_descr']['mix'] = 'How many artile will be show in image with description list.';
$setting_comm['list_descr']['rss'] = 'How many artile will be show in RSS.';

$setting_comm['session'] = array();
$setting_comm['session_comm'] = 'Session Setting';
$setting_comm['session']['expire'] = 'Expire time';
$setting_comm['session']['gc'] = 'Gabage Collection ';
$setting_comm['session']['trans_sid'] = 'Send SID';
$setting_comm['session']['name'] = 'Session Name';
$setting_comm['session']['mode'] = 'Session Mode';
$setting_comm['session_descr']['expire'] = 'How long to keep the guest online status.';
$setting_comm['session_descr']['gc'] = 'Delete expire Session data';
$setting_comm['session_descr']['trans_sid'] = 'Send SID in local URL when cookie cannot be use.';
$setting_comm['session_descr']['name'] = 'Session Name of the CMS';
$setting_comm['session_descr']['mode'] = 'Which mode will be used to save the Session data';

$setting_comm['cookie'] = array();
$setting_comm['cookie_comm'] = 'Cookie Setting';
$setting_comm['cookie']['domain'] = 'Domain';
$setting_comm['cookie']['path'] = 'Path';
$setting_comm['cookie']['prefix'] = 'Prefix';
$setting_comm['cookie_descr']['domain'] = 'Cookie will only avilable in the domain.';
$setting_comm['cookie_descr']['path'] = 'Cookie will only avilable in the path';
$setting_comm['cookie_descr']['prefix'] = 'The prefix will add to the name of every cookie';

$setting_comm['path'] = array();
$setting_comm['path_comm'] = 'Path Setting';
$setting_comm['path']['admin'] = 'OP Path';
$setting_comm['path']['upload'] = 'Upload Path';
$setting_comm['path']['cache'] = 'Cache Path';
$setting_comm['path']['template'] = 'Template Path';
$setting_comm['path_descr']['admin'] = 'The path of operation panel';
$setting_comm['path_descr']['upload'] = 'The path of upload files';
$setting_comm['path_descr']['cache'] = 'The path for cache storage';
$setting_comm['path_descr']['template'] = 'The path of template';

$setting_comm['content'] = array();
$setting_comm['content_comm'] = 'Content Setting';
$setting_comm['content']['get_remote_img'] = 'Get Image';
$setting_comm['content_descr']['get_remote_img'] = 'Download content images from other website';

$setting_comm['watermark'] = array();
$setting_comm['watermark_comm'] = 'Watermark Setting';
$setting_comm['watermark']['mode'] = 'Watermark Mode';
$setting_comm['watermark']['txt'] = 'Watermark Text';
$setting_comm['watermark']['img'] = 'Watermark Image';
$setting_comm['watermark']['credit'] = 'Credit Infor.';
$setting_comm['watermark_descr']['mode'] = 'Add Watermark to artile content or content images';
$setting_comm['watermark_descr']['txt'] = 'Watermark Text that will be added to artile content or content images';
$setting_comm['watermark_descr']['img'] = 'Watermark Text that will be added to content images';
$setting_comm['watermark_descr']['credit'] = 'Credit information that will be added to the end of every line';

$setting_comm['memcache'] = array();
$setting_comm['memcache_comm'] = 'Memory Cache Setting';
$setting_comm['memcache']['server'] = 'Server host';
$setting_comm['memcache']['weight'] = 'Server Weight';
$setting_comm['memcache']['persistant'] = 'Persistant Connect';
$setting_comm['memcache']['timeout'] = 'Timeout time';
$setting_comm['memcache']['retry_interval'] = 'Retry Interval';
$setting_comm['memcache']['status'] = 'Memcache Status';
$setting_comm['memcache']['expire'] = 'Expire Period';
$setting_comm['memcache']['threshold'] = 'Memcache Threshold';
$setting_comm['memcache']['min_savings'] = 'Compress Level';
$setting_comm['memcache_descr']['server'] = 'Memcache Host Address (IP:PORT)';
$setting_comm['memcache_descr']['weight'] = 'Memcache Host Weight';
$setting_comm['memcache_descr']['persistant'] = 'Use Persistant Connect or not';
$setting_comm['memcache_descr']['timeout'] = 'Memcache Server connect timeout time (in second)';
$setting_comm['memcache_descr']['retry_interval'] = 'Memcache Retry frequency (in second)';
$setting_comm['memcache_descr']['status'] = 'Memcache Status information';
$setting_comm['memcache_descr']['expire'] = 'How long will Memcache expire';
$setting_comm['memcache_descr']['threshold'] = 'Controls the minimum value length before attempting to compress';
$setting_comm['memcache_descr']['min_savings'] = 'Specifies the minimum amount of savings to actually store the value compressed. (0-1)';

$setting_type['web'] = array();
$setting_type['web']['url'] = array("text", "url", "50");
$setting_type['web']['email'] = array("text", "email", "50");
$setting_type['web']['title'] = array("text", "name", "40");
$setting_type['web']['keyword'] = array("text", "", "60");
$setting_type['web']['description'] = array("text", "", "100");
$setting_type['web']['s_user'] = array("text", "alpha", "16");
$setting_type['web']['s_pass'] = array("password", "", "40");
$setting_type['web']['close'] = array("radio", array("อ๘ีพนุฑี"=>"true", "อ๘ีพฟชฦ๔"=>"false"));
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
$setting_type['gen']['update'] = array("text", "url", "200");
$setting_type['gen']['minify'] = array("radio", array("Open"=>"true", "Close"=>"false"));
$setting_type['gen']['etag'] = array("text", "", "10");

$setting_type['email'] = array();
$setting_type['email']['mode'] = array("select", array("PHP mail()"=>"", "Normal SMTP"=>"smtp", "SSL SMTP"=>"ssl", "TLS SMTP"=>"tls", "SSL/TLS Mix"=>"ssl/tls"));
$setting_type['email']['smtp'] = array("text", "", "30");
$setting_type['email']['port'] = array("text", "digital", "5");
$setting_type['email']['user'] = array("text", "", "30");
$setting_type['email']['password'] = array("text", "", "40");

$setting_type['js'] = array();
$setting_type['js']['debug'] = array("radio", array("Open"=>"true", "Close"=>"false"));

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