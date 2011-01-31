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
$setting['web']['close'] = '';
$setting['web']['close_page'] = '/index.html';
$setting['web']['cache_mode'] = 'file';

$setting['db'] = array();
$setting['db']['host'] = '127.0.0.1:3306';
$setting['db']['user'] = 'root';
$setting['db']['pass'] = 123456;
$setting['db']['charset'] = 'gbk';
$setting['db']['name'] = 'mystep';
$setting['db']['pre'] = 'ms_';

$setting['gen'] = array();
$setting['gen']['language'] = 'chs';
$setting['gen']['charset'] = 'gbk';
$setting['gen']['gzip_level'] = 4;
$setting['gen']['cache_ext'] = '.html';
$setting['gen']['template'] = 'default';
$setting['gen']['cache'] = '';

$setting['list'] = array();
$setting['list']['txt'] = 30;
$setting['list']['img'] = 16;
$setting['list']['mix'] = 15;
$setting['list']['rss'] = 50;

$setting['session'] = array();
$setting['session']['expire'] = 20;
$setting['session']['name'] = 'MyStepSession';
$setting['session']['mode'] = 'sess_mystep';
$setting['session']['gc'] = 1;
$setting['session']['trans_sid'] = '';

$setting['cookie'] = array();
$setting['cookie']['domain'] = '.mystep.com';
$setting['cookie']['path'] = '/';
$setting['cookie']['prefix'] = 'ms_';

$setting['path'] = array();
$setting['path']['upload'] = 'files/';
$setting['path']['cache'] = 'cache/';
$setting['path']['template'] = 'template/';

$setting['content'] = array();
$setting['content']['max_length'] = 10000;
$setting['content']['get_remote_img'] = 1;

$setting['watermark'] = array();
$setting['watermark']['mode'] = 3;
$setting['watermark']['txt'] = 'MyStep CMS';
$setting['watermark']['img'] = 'images/logo.png';
$setting['watermark']['credit'] = 'Original From MyStep';

$setting['memcache'] = array();
$setting['memcache']['server'] = '';
$setting['memcache']['weight'] = 2;
$setting['memcache']['timeout'] = 1;
$setting['memcache']['retry_interval'] = 30;
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