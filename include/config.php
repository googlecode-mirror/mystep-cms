<?php
$setting = array();

$setting['web'] = array();
$setting['web']['url'] = 'http://www.mystep.com/';
$setting['web']['email'] = 'windy2006@gmail.com';
$setting['web']['title'] = 'MyStep';
$setting['web']['keyword'] = 'mystep,cms,free';
$setting['web']['description'] = '开源网站内容管理系统';
$setting['web']['s_user'] = 'mystep';
$setting['web']['s_pass'] = 'e10adc3949ba59abbe56e057f20f883e';
$setting['web']['close'] = false;
$setting['web']['close_page'] = '/index.html';
$setting['web']['cache_mode'] = 'file';

$setting['db'] = array();
$setting['db']['host'] = '127.0.0.1:3306';
$setting['db']['user'] = 'root';
$setting['db']['pass'] = 123456;
$setting['db']['pconnect'] = false;
$setting['db']['charset'] = 'gbk';
$setting['db']['name'] = 'mystep';
$setting['db']['pre'] = 'ms_';

$setting['gen'] = array();
$setting['gen']['language'] = 'default';
$setting['gen']['charset'] = 'gbk';
$setting['gen']['gzip_level'] = 4;
$setting['gen']['cache'] = false;
$setting['gen']['rewrite'] = false;
$setting['gen']['cache_ext'] = '.html';
$setting['gen']['template'] = 'classic';
$setting['gen']['timezone'] = 'Etc/GMT-8';
$setting['gen']['update'] = 'http://cccfna.org.cn/update/';
$setting['gen']['minify'] = false;
$setting['gen']['etag'] = 20120201;

$setting['email'] = array();
$setting['email']['mode'] = '';
$setting['email']['host'] = '';
$setting['email']['port'] = 25;
$setting['email']['user'] = '';
$setting['email']['password'] = '';

$setting['js'] = array();
$setting['js']['debug'] = true;

$setting['list'] = array();
$setting['list']['txt'] = 30;
$setting['list']['img'] = 10;
$setting['list']['mix'] = 25;
$setting['list']['rss'] = 50;

$setting['session'] = array();
$setting['session']['expire'] = 20;
$setting['session']['name'] = 'MyStepSession';
$setting['session']['mode'] = 'sess_mystep';
$setting['session']['gc'] = true;
$setting['session']['trans_sid'] = false;

$setting['cookie'] = array();
$setting['cookie']['domain'] = '.mystep.com';
$setting['cookie']['path'] = '/';
$setting['cookie']['prefix'] = 'ms_';

$setting['path'] = array();
$setting['path']['admin'] = 'admin/';
$setting['path']['upload'] = 'files/';
$setting['path']['cache'] = 'cache/';
$setting['path']['template'] = 'template/';

$setting['content'] = array();
$setting['content']['get_remote_img'] = true;

$setting['watermark'] = array();
$setting['watermark']['txt'] = 'MyStep CMS';
$setting['watermark']['img'] = 'images/logo.png';
$setting['watermark']['credit'] = 'Original From MyStep';
$setting['watermark']['mode'] = 2;

$setting['memcache'] = array();
$setting['memcache']['server'] = '127.0.0.1';
$setting['memcache']['weight'] = 2;
$setting['memcache']['persistant'] = true;
$setting['memcache']['timeout'] = 1;
$setting['memcache']['retry_interval'] = 30;
$setting['memcache']['status'] = true;
$setting['memcache']['expire'] = 86400;
$setting['memcache']['threshold'] = 10240;
$setting['memcache']['min_savings'] = 0.5;


$expire_list = array (
  'default' => 600,
  'index' => 1800,
  'list' => 3600,
  'tag' => 86400,
  'read' => 604800,
);
?>