<?php
$setting = array();

$setting['web'] = array();
$setting['web']['url'] = 'http://www.mystep.com/';
$setting['web']['email'] = 'winyd2006@gmail.com';
$setting['web']['title'] = 'MyStep';
$setting['web']['keyword'] = 'mystep,cms,free';
$setting['web']['description'] = '开源网站内容管理系统';
$setting['web']['s_user'] = 'mystep';
$setting['web']['s_pass'] = 'e10adc3949ba59abbe56e057f20f883e';
$setting['web']['close'] = false;
$setting['web']['close_page'] = '/index.html';

$setting['db'] = array();
$setting['db']['host'] = '127.0.0.1:3306';
$setting['db']['user'] = 'root';
$setting['db']['pass'] = 123456;
$setting['db']['charset'] = 'gbk';
$setting['db']['name'] = 'mystep';
$setting['db']['pre'] = 'ms_';
$setting['db']['pconnect'] = true;

$setting['gen'] = array();
$setting['gen']['language'] = 'chs';
$setting['gen']['charset'] = 'gbk';
$setting['gen']['gzip_level'] = 4;
$setting['gen']['cache'] = false;
$setting['gen']['rewrite'] = false;
$setting['gen']['cache_ext'] = '.html';
$setting['gen']['template'] = 'default';

$setting['list'] = array();
$setting['list']['txt'] = 30;
$setting['list']['img'] = 16;
$setting['list']['mix'] = 15;
$setting['list']['rss'] = 50;

$setting['session'] = array();
$setting['session']['expire'] = 20;
$setting['session']['path'] = '';
$setting['session']['gc'] = true;
$setting['session']['trans_sid'] = false;
$setting['session']['name'] = 'MyStepSession';
$setting['session']['mode'] = 'sess_mystep';

$setting['cookie'] = array();
$setting['cookie']['domain'] = '.mystep.com';
$setting['cookie']['path'] = '/';
$setting['cookie']['prefix'] = 'ms_';

$setting['path'] = array();
$setting['path']['upload'] = 'files/';
$setting['path']['cache'] = 'html/';
$setting['path']['template'] = 'template/';

$setting['content'] = array();
$setting['content']['max_length'] = 10000;
$setting['content']['get_remote_img'] = true;

$setting['watermark'] = array();
$setting['watermark']['mode'] = 3;
$setting['watermark']['txt'] = 'MyStep CMS';
$setting['watermark']['img'] = '';
$setting['watermark']['credit'] = 'Original From Garlic 2010';



$expire_list = array(
	"default" => 60*10,
	"index" => 60*30,
	"list" => 60*60,
	"tag" => 60*60*24,
	"read" => 60*60*24*7,
);
?>