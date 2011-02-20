<?php
$setting_comm = array();

$setting_comm['web'] = array();
$setting_comm['web_comm'] = '站点设置';
$setting_comm['web']['url'] = '网站地址';
$setting_comm['web']['email'] = '网站邮箱';
$setting_comm['web']['title'] = '网站名称';
$setting_comm['web']['keyword'] = '网站关键字';
$setting_comm['web']['description'] = '网站描述';
$setting_comm['web']['s_user'] = '创始人名称';
$setting_comm['web']['s_pass'] = '创始人密码';
$setting_comm['web']['close'] = '网站关闭';
$setting_comm['web']['close_page'] = '关闭页面';
$setting_comm['web']['cache_mode'] = '数据缓存';
$setting_comm['web_descr']['url'] = '通过互联网可以访问的网址';
$setting_comm['web_descr']['email'] = '用于与站长取得联系的电子邮箱';
$setting_comm['web_descr']['title'] = '用于在浏览器上显示网站名称';
$setting_comm['web_descr']['keyword'] = '用于搜索引擎检索网站，多个关键字请用“,”间隔';
$setting_comm['web_descr']['description'] = '用于搜索引擎的网站简介';
$setting_comm['web_descr']['s_user'] = '拥有全部权限，且不依赖数据库';
$setting_comm['web_descr']['s_pass'] = '请确认密码的安全可靠';
$setting_comm['web_descr']['close'] = '使一般用户无法访问网站';
$setting_comm['web_descr']['close_page'] = '网站关闭时所显示的页面';
$setting_comm['web_descr']['cache_mode'] = '开启数据缓存，减少数据重复查询，以提高效率';

$setting_comm['db'] = array();
$setting_comm['db_comm'] = '数据库设置';
$setting_comm['db']['host'] = '数据库地址';
$setting_comm['db']['user'] = '数据库用户';
$setting_comm['db']['pass'] = '数据库密码';
$setting_comm['db']['charset'] = '数据库编码';
$setting_comm['db']['name'] = '所用数据库';
$setting_comm['db']['pre'] = '数据表前缀';
$setting_comm['db']['pconnect'] = '持久连接';
$setting_comm['db_descr']['host'] = '数据库主机的地址';
$setting_comm['db_descr']['user'] = '服务器所分配的数据库用户名';
$setting_comm['db_descr']['pass'] = '对应数据库用户的密码';
$setting_comm['db_descr']['charset'] = '数据库存储数据的默认字符集';
$setting_comm['db_descr']['name'] = '存储网站数据表的数据库名称';
$setting_comm['db_descr']['pre'] = '用于区分本系统数据表与其他数据表数据表前缀';
$setting_comm['db_descr']['pconnect'] = '开启数据库持久连接，减少反复连接数据库造成的资源消耗';

$setting_comm['gen'] = array();
$setting_comm['gen_comm'] = '基本设置';
$setting_comm['gen']['language'] = '网站语言';
$setting_comm['gen']['charset'] = '网站编码';
$setting_comm['gen']['gzip_level'] = '压缩级别';
$setting_comm['gen']['cache'] = '页面缓存';
$setting_comm['gen']['rewrite'] = '静态连接';
$setting_comm['gen']['cache_ext'] = '静态扩展名';
$setting_comm['gen']['template'] = '默认模板';
$setting_comm['gen_descr']['language'] = '网站显示语种切换';
$setting_comm['gen_descr']['charset'] = '网站显示编码集';
$setting_comm['gen_descr']['gzip_level'] = 'GZIP 压缩页面的级别（0-9），0 为关闭压缩';
$setting_comm['gen_descr']['cache'] = '开启页面缓存，减少固定时间内的查询频率，增强网站效率';
$setting_comm['gen_descr']['rewrite'] = '将网站链接转换为静态连接，需服务器开启 URL_Rewrite 支持';
$setting_comm['gen_descr']['cache_ext'] = '静态连接和缓存文件的扩展名';
$setting_comm['gen_descr']['template'] = '网站前台显示样式';

$setting_comm['list'] = array();
$setting_comm['list_comm'] = '列表显示数量设置';
$setting_comm['list']['txt'] = '文字列表';
$setting_comm['list']['img'] = '图片列表';
$setting_comm['list']['mix'] = '图文列表';
$setting_comm['list']['rss'] = '聚合列表';
$setting_comm['list_descr']['txt'] = '文字列表模式下显示新闻的调试';
$setting_comm['list_descr']['img'] = '图片列表模式下显示新闻的调试';
$setting_comm['list_descr']['mix'] = '图文混合列表模式下显示新闻的调试';
$setting_comm['list_descr']['rss'] = 'RSS 聚合显示新闻的调试';

$setting_comm['session'] = array();
$setting_comm['session_comm'] = 'Session 设置';
$setting_comm['session']['expire'] = '过期时间';
$setting_comm['session']['gc'] = '定期回收';
$setting_comm['session']['trans_sid'] = '传递 SID';
$setting_comm['session']['name'] = '名称设置';
$setting_comm['session']['mode'] = '处理模式';
$setting_comm['session_descr']['expire'] = '用户保持在线的最长时间';
$setting_comm['session_descr']['path'] = '文件存储模式下Session文件保存的路径';
$setting_comm['session_descr']['gc'] = '定期删除无用的Session信息';
$setting_comm['session_descr']['trans_sid'] = '通过URL连接传递SID，主要用于用户关闭COOKIE的情况';
$setting_comm['session_descr']['name'] = '程序用于存储Session索引的名称';
$setting_comm['session_descr']['mode'] = '存储Session的模式（非mystep模式会影响到在线统计）';

$setting_comm['cookie'] = array();
$setting_comm['cookie_comm'] = 'Cookie 设置';
$setting_comm['cookie']['domain'] = '作用域名';
$setting_comm['cookie']['path'] = '作用路径';
$setting_comm['cookie']['prefix'] = 'Cookie前缀';
$setting_comm['cookie_descr']['domain'] = 'Cookie仅在该域名下生效';
$setting_comm['cookie_descr']['path'] = 'Cookie起作用的网站路径';
$setting_comm['cookie_descr']['prefix'] = '存储Cookie的变量前缀，用于防止用户密码欺骗';

$setting_comm['path'] = array();
$setting_comm['path_comm'] = '路径设置';
$setting_comm['path']['admin'] = '后台路径';
$setting_comm['path']['upload'] = '上传路径';
$setting_comm['path']['cache'] = '缓存路径';
$setting_comm['path']['template'] = '模板路径';
$setting_comm['path_descr']['admin'] = '后台管理的路径';
$setting_comm['path_descr']['upload'] = '上传文件的存储目录';
$setting_comm['path_descr']['cache'] = '存储缓存页面的目录';
$setting_comm['path_descr']['template'] = '模板存储的路径';

$setting_comm['content'] = array();
$setting_comm['content_comm'] = '内容设置';
$setting_comm['content']['max_length'] = '长度限制';
$setting_comm['content']['get_remote_img'] = '下载远程图';
$setting_comm['content_descr']['max_length'] = '单页新闻的最大文字数';
$setting_comm['content_descr']['get_remote_img'] = '下载新闻中的非本网图片到本地';

$setting_comm['watermark'] = array();
$setting_comm['watermark_comm'] = '水印设置';
$setting_comm['watermark']['mode'] = '水印模式';
$setting_comm['watermark']['txt'] = '水印文字';
$setting_comm['watermark']['img'] = '水印图片';
$setting_comm['watermark']['credit'] = '版权文字';
$setting_comm['watermark_descr']['mode'] = '是否在文章内容或图片上添加水印';
$setting_comm['watermark_descr']['txt'] = '用于水印的文字';
$setting_comm['watermark_descr']['img'] = '用于水印的图片';
$setting_comm['watermark_descr']['credit'] = '显示在文章内容中的版权文字';

$setting_comm['memcache'] = array();
$setting_comm['memcache_comm'] = '缓存设置';
$setting_comm['memcache']['server'] = 'Memcache 服务器';
$setting_comm['memcache']['weight'] = 'Memcache 服务器权重';
$setting_comm['memcache']['persistant'] = 'Memcache 持续连接';
$setting_comm['memcache']['timeout'] = 'Memcache 超时时间';
$setting_comm['memcache']['retry_interval'] = 'Memcache 重试频率';
$setting_comm['memcache']['status'] = 'Memcache 在线状态';
$setting_comm['memcache']['expire'] = 'Memcache 过期时间';
$setting_comm['memcache']['threshold'] = 'Memcache 压缩阈值';
$setting_comm['memcache']['min_savings'] = 'Memcache 压缩率';
$setting_comm['memcache_descr']['server'] = 'Memcache 服务器（IP:PORT）';
$setting_comm['memcache_descr']['weight'] = 'Memcache 服务器权重';
$setting_comm['memcache_descr']['persistant'] = 'Memcache 持续连接（在使用较频繁时推荐）';
$setting_comm['memcache_descr']['timeout'] = 'Memcache 超时时间（秒）';
$setting_comm['memcache_descr']['retry_interval'] = 'Memcache 失败重试频率（秒）';
$setting_comm['memcache_descr']['status'] = 'Memcache 状态是否可用';
$setting_comm['memcache_descr']['expire'] = 'Memcache 过期时间';
$setting_comm['memcache_descr']['threshold'] = 'Memcache 控制多大值进行自动压缩的阈值';
$setting_comm['memcache_descr']['min_savings'] = 'Memcache 启用压缩的压缩率';

$setting_type['web'] = array();
$setting_type['web']['url'] = array("text", "url", "50");
$setting_type['web']['email'] = array("text", "email", "50");
$setting_type['web']['title'] = array("text", "name", "40");
$setting_type['web']['keyword'] = array("text", "", "60");
$setting_type['web']['description'] = array("text", "", "100");
$setting_type['web']['s_user'] = array("text", "alpha", "16");
$setting_type['web']['s_pass'] = array("password", "", "40");
$setting_type['web']['close'] = array("radio", array("网站关闭"=>"true", "网站开启"=>"false"));
$setting_type['web']['close_page'] = array("text", "", "100");
$setting_type['web']['cache_mode'] = array("select", array("文件缓存"=>"file", "数据库缓存"=>"mysql", "MemCache"=>"memcache", "eAccelerator"=>"eaccelerator", "xCache"=>"xcache"));

$setting_type['db'] = array();
$setting_type['db']['host'] = array("text", "", "30");
$setting_type['db']['user'] = array("text", "alpha", "20");
$setting_type['db']['pass'] = array("password", "", "40");
$setting_type['db']['charset'] = array("select", array("GBK"=>"gbk", "UTF-8"=>"utf8", "Latin1"=>"latin1"));
$setting_type['db']['name'] = array("text", "alpha", "20");
$setting_type['db']['pre'] = array("text", "alpha", "10");
$setting_type['db']['pconnect'] = array("radio", array("开启"=>"true", "关闭"=>"false"));

$setting_type['gen'] = array();
$setting_type['gen']['language'] = array("text", "alpha", "10");
$setting_type['gen']['charset'] = array("text", "alpha", "10");
$setting_type['gen']['gzip_level'] = array("text", "digital", "1");
$setting_type['gen']['cache'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['gen']['rewrite'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['gen']['cache_ext'] = array("text", "", "10");
$setting_type['gen']['template'] = array("text", "alpha", "20");

$setting_type['list'] = array();
$setting_type['list']['txt'] = array("text", "digital", "2");
$setting_type['list']['img'] = array("text", "digital", "2");
$setting_type['list']['mix'] = array("text", "digital", "2");
$setting_type['list']['rss'] = array("text", "digital", "2");

$setting_type['session'] = array();
$setting_type['session']['expire'] = array("text", "digital", "2");
$setting_type['session']['gc'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['session']['trans_sid'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['session']['name'] = array("text", "alpha", "10");
$setting_type['session']['mode'] = array("select", array("MyStep模式"=>"sess_mystep", "数据库存储"=>"sess_mysql", "文件存储"=>"sess_file"));

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
$setting_type['content']['get_remote_img'] = array("radio", array("开启"=>"true", "关闭"=>"false"));

$setting_type['watermark'] = array();
$setting_type['watermark']['mode'] = array("checkbox", array("文字水印"=>1, "图片水印"=>2));
$setting_type['watermark']['txt'] = array("text", "", "30");
$setting_type['watermark']['img'] = array("text", "", "30");
$setting_type['watermark']['credit'] = array("text", "", "30");

$setting_type['cache'] = array();
$setting_type['cache']['memcache'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['cache']['eaccelerator'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['cache']['xcache'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['memcache']['server'] = array("text", false, "40");
$setting_type['memcache']['weight'] = array("text", "digital", "2");
$setting_type['memcache']['persistant'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['memcache']['timeout'] = array("text", "digital", "2");
$setting_type['memcache']['retry_interval'] = array("text", "digital", "2");
$setting_type['memcache']['status'] = array("radio", array("开启"=>"true", "关闭"=>"false"));
$setting_type['memcache']['expire'] = array("text", "digital", "8");
$setting_type['memcache']['threshold'] = array("text", "number", "8");
$setting_type['memcache']['min_savings'] = array("text", "number", "3");
?>