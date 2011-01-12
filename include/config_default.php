<?php
$setting = array();

// Website
$setting['web']['url'] = "http://www.mystepcms.com/";
$setting['web']['email'] = "windy2006@gmail.com";
$setting['web']['title'] = "MyStep 2010";
$setting['web']['keyword'] = "MyStep,cms,free";
$setting['web']['description'] = "MyStep content managerment system, free cms";
$setting['web']['close'] = false;
$setting['web']['close_page'] = "/index.html";
$setting['web']['s_user'] = "mystep";
$setting['web']['s_pass'] = "00e6c03864246e89dcea7297b3af8003";

// Database
$setting['db']['host'] = "127.0.0.1:3306";
$setting['db']['user'] = "root";
$setting['db']['pass'] = "";
$setting['db']['pconnect'] = true;
$setting['db']['charset'] = "gbk";
$setting['db']['name'] = "mystep";
$setting['db']['pre'] = "ms_";

// General
$setting['gen']['language'] = "chs";
$setting['gen']['charset'] = "gbk";
$setting['gen']['gzip_level'] = 3;
$setting['gen']['cache'] = false;
$setting['gen']['rewrite'] = false;
$setting['gen']['cache_ext'] = ".html";
$setting['gen']['template'] = "default";

// Display
$setting['list']['txt'] = 30;
$setting['list']['img'] = 16;
$setting['list']['mix'] = 15;
$setting['list']['rss'] = 50;

// Session
$setting['session']['expire'] = 20;
$setting['session']['path'] = "";
$setting['session']['gc'] = true;
$setting['session']['trans_sid'] = false;
$setting['session']['name'] = "MyStepSession";
$setting['session']['mode'] = "sess_mystep";

// Cookie
$setting['cookie']['domain'] = ".mystepcms.com";
$setting['cookie']['path'] = "/";

// Path
$setting['path']['upload'] = "files/";
$setting['path']['cache']	= "html/";
$setting['path']['template'] = "template/";

// Content
$setting['content']['max_length'] = 10000;
$setting['content']['get_remote_img'] = true;

// Watermark
$setting['watermark']['mode'] = 3;
$setting['watermark']['pic'] = "images/logo.png";
$setting['watermark']['txt'] = "MyStep CMS";
$setting['watermark']['credit'] = "Original From MyStep 2010";
?>