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
$setting['gen']['cache_ext'] = '.html';
$setting['gen']['template'] = 'classic';
$setting['gen']['timezone'] = 'Etc/GMT-8';
$setting['gen']['update'] = 'http://www.mysteps.cn/update/';
$setting['gen']['minify'] = false;
$setting['gen']['etag'] = 20120601;
$setting['gen']['show_info'] = false;

$setting['rewrite'] = array();
$setting['rewrite']['enable'] = false;
$setting['rewrite']['read'] = 'article';
$setting['rewrite']['list'] = 'catalog';
$setting['rewrite']['tag'] = 'tag';

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
$setting['watermark']['mode'] = 2;
$setting['watermark']['txt'] = 'MyStep CMS';
$setting['watermark']['img'] = 'images/logo.png';
$setting['watermark']['position'] = 3;
$setting['watermark']['img_rate'] = 4;
$setting['watermark']['txt_font'] = 'images/font.ttc';
$setting['watermark']['txt_fontsize'] = 12;
$setting['watermark']['txt_fontcolor'] = '#FFFFFF';
$setting['watermark']['txt_bgcolor'] = '#000000';
$setting['watermark']['alpha'] = 50;
$setting['watermark']['credit'] = 'Original From MyStep';

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


$rewrite_list = array (
  0 => 
  array (
    0 => 'article/[^\\/]+/(\\d+)(_(\\d+))?\\.html',
    1 => 'read.php?id=$1&page=$3',
  ),
  1 => 
  array (
    0 => 'article(/)?',
    1 => 'list.php',
  ),
  2 => 
  array (
    0 => 'article/(index(_(\\d+))?\\.html)?',
    1 => 'list.php?page=$3',
  ),
  3 => 
  array (
    0 => 'catalog(/)?',
    1 => 'list.php',
  ),
  4 => 
  array (
    0 => 'catalog/(index(_(\\d+))?\\.html)?',
    1 => 'list.php?page=$3',
  ),
  5 => 
  array (
    0 => 'catalog/([^\\/]+)/(index(_(\\d+))?\\.html)?',
    1 => 'list.php?cat=$1&page=$4',
  ),
  6 => 
  array (
    0 => 'catalog/([^\\/]+)/([^\\/]+)/(index(_(\\d+))?\\.html)?',
    1 => 'list.php?cat=$1&pre=$2&page=$5',
  ),
  7 => 
  array (
    0 => 'tag/(.+?)(_(\\d+))?\\.html',
    1 => 'tag.php?tag=$1&page=$3',
  ),
  8 => 
  array (
    0 => 'tag(/)?',
    1 => 'tag.php',
  ),
  9 => 
  array (
    0 => 'rss.xml',
    1 => 'rss.php',
  ),
  10 => 
  array (
    0 => '(.+?)/rss.xml',
    1 => 'rss.php?cat=$1',
  ),
  11 => 
  array (
    0 => 'api/(.+?)/(.+?)(/(.+))?',
    1 => 'api.php?$1|$2|$4',
  ),
  12 => 
  array (
    0 => 'ajax/(.+?)(/(.+))?',
    1 => 'ajax.php?func=$1&return=$3',
  ),
);
$expire_list = array (
  'default' => 600,
  'index' => 1800,
  'list' => 3600,
  'tag' => 86400,
  'read' => 604800,
);
$ignore_list = array (
  0 => '.',
  1 => '..',
  2 => '_maker',
  3 => 'cache',
  4 => 'update',
  5 => 'install.lock',
  6 => 'article',
  7 => 'pic',
  8 => 'tmp',
  9 => 'web.config',
  10 => 'aspnet_client',
  11 => '.svn',
  12 => '2011',
  13 => '2012',
  14 => '_bak',
  15 => 'colorway',
  16 => 'ciguang',
  17 => 'news_show',
  18 => 'apple',
  19 => '_archive',
  20 => 'install',
  21 => 'xcache',
);
$authority = "mystep";
?>