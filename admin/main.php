<?php
require("inc.php");
$tpl_info = array(
		"idx" => "main",
		"style" => "admin",
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);
$pass  = "<font color=green><b>√</b></font>";
$error = "<font color=red><b>×</b></font>";
ob_start();
?>
<br />
<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
  <tr>
    <td class="border" colspan="2">
      <div class="font">
        <img src="images/arrow.gif" align="absmiddle">&nbsp;&nbsp;网站基本信息
      </div>
    </td>
  </tr>
  <tr>
    <td class="cat" width="250">网站运行时间</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."counter")?> 天</td>
  </tr>
  <tr>
    <td class="cat" width="250">注册会员数</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."users")?> 人</td>
  </tr>
  <tr>
    <td class="cat" width="250">登录新闻数量</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."news_show")?> 条</td>
  </tr>
  <tr>
    <td class="cat" width="250">当前在线人数</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."user_online")?> 人</td>
  </tr>
  <tr>
    <td class="cat" width="250">最高在线人数</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select max(online) from ".$setting['db']['pre']."counter")?> 人</td>
  </tr>
  <tr>
    <td class="cat" width="250">今日页面访问量</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select pv from ".$setting['db']['pre']."counter where date=curdate()")?> 次</td>
  </tr>
  <tr>
    <td class="cat" width="250">最高日页面访问量</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select max(pv) from ".$setting['db']['pre']."counter")?> 次</td>
  </tr>
  <tr>
    <td class="cat" width="250">网站页面日均访问量</td>
    <td class="row"> &nbsp; <?=(int)$db->GetSingleResult("select avg(pv) from ".$setting['db']['pre']."counter")?> 次</td>
  </tr>
  <tr>
    <td class="cat" width="250">网站页面总访问量</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select sum(pv) from ".$setting['db']['pre']."counter")?> 次</td>
  </tr>
  <tr>
    <td class="cat" width="250">今日 IP 访问量</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select iv from ".$setting['db']['pre']."counter where date=curdate()")?> 次</td>
  </tr>
  <tr>
    <td class="cat" width="250">最高日 IP 访问量</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select max(iv) from ".$setting['db']['pre']."counter")?> 次</td>
  </tr>
  <tr>
    <td class="cat" width="250">网站日均 IP 访问量</td>
    <td class="row"> &nbsp; <?=(int)$db->GetSingleResult("select avg(iv) from ".$setting['db']['pre']."counter")?> 次</td>
  </tr>
  <tr>
    <td class="cat" width="250">网站总 IP 访问量</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select sum(iv) from ".$setting['db']['pre']."counter")?> 次</td>
  </tr>
</table>
<br />
<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
  <tr>
    <td class="border" colspan="2">
      <div class="font">
        <img src="images/arrow.gif" align="absmiddle">&nbsp;&nbsp;服务器基本信息
      </div>
    </td>
  </tr>
  <tr>
    <td class="cat" width="250">服务器语言环境</td>
    <td class="row"><?=$req->getServer("HTTP_ACCEPT_LANGUAGE")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">服务器域名</td>
    <td class="row"><?=$req->getServer("SERVER_NAME")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">服务器ip地址</td>
    <td class="row"><?=gethostbyname($req->getServer("SERVER_NAME"))?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">服务器端口</td>
    <td class="row"><?=$req->getServer("SERVER_PORT")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">服务器时间</td>
    <td class="row"><?=date("Y年m月d日 h:i:s",$_SERVER['REQUEST_TIME'])?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">服务器系统</td>
    <td class="row"><?=PHP_OS?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">服务器解译引擎</td>
    <td class="row"><?=$req->getServer("SERVER_SOFTWARE")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">服务端通信协议</td>
    <td class="row"><?=$req->getServer("SERVER_PROTOCOL")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">服务端剩余空间</td>
    <td class="row"><?=intval(diskfreespace(".") / (1024 * 1024 * 1024)).'GB'?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">系统当前用户名</td>
    <td class="row"><?=get_current_user()?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">本文件路径</td>
    <td class="row"><?=$req->getServer("PATH_TRANSLATED")?>&nbsp;</td>
  </tr>
</table>
<br />
<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
  <tr>
    <td class="border" colspan="2">
      <div class="font">
        <img src="images/arrow.gif" align="absmiddle">&nbsp;&nbsp;PHP基本信息
      </div>
    </td>
  </tr>
  <tr>
    <td class="cat" width="250">PHP版本</td>
    <td class="row"><?=PHP_VERSION;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">PHP运行方式</td>
    <td class="row"><?=strtoupper(php_sapi_name())?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">Zend引擎版本</td>
    <td class="row"><?=zend_version()?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">自动定义全局变量</td>
    <td class="row"><?=get_cfg_var("register_globals") ? 'ON' : 'OFF';?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">运行于安全模式</td>
    <td class="row"><?=get_cfg_var("safe_mode") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">显示错误信息</td>
    <td class="row"><?=get_cfg_var("display_errors") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">动态加载连接库支持</td>
    <td class="row"><?=get_cfg_var("enable_dl") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">使用URL打开文件</td>
    <td class="row"><?=get_cfg_var("allow_url_fopen") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">允许使用的最大内存量</td>
    <td class="row"><?=get_cfg_var("memory_limit")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">POST最大字节数</td>
    <td class="row"><?=get_cfg_var("post_max_size")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">允许最大上传文件</td>
    <td class="row"><?=get_cfg_var("file_uploads") ?  get_cfg_var("upload_max_filesize") : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">程序超时限制</td>
    <td class="row"><?=get_cfg_var("max_execution_time")."秒";?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">被禁用的函数</td>
    <td class="row"><?=get_cfg_var("disable_functions") ? get_cfg_var("disable_functions") : "没有";?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">标记&lt;% %&gt;支持</td>
    <td class="row"><?=get_cfg_var("asp_tags") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">COOKIE支持</td>
    <td class="row"><?=isset($HTTP_COOKIE_VARS) ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">浮点运算有效数字显示位数</td>
    <td class="row"><?=get_cfg_var("precision")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">强制y2k兼容</td>
    <td class="row"><?=get_cfg_var("y2k_compliance") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">调试器地址</td>
    <td class="row"><?=get_cfg_var("debugger.host") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">调试器端口</td>
    <td class="row"><?=get_cfg_var("debugger.port") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">SMTP支持</td>
    <td class="row"><?=get_cfg_var("SMTP") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">SMTP地址</td>
    <td class="row"><?=get_cfg_var("SMTP")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">Html错误显示</td>
    <td class="row"><?=get_cfg_var("html_errors") ? $pass : $error;?>&nbsp;</td>
  </tr>
</table>
<br />
<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
  <tr>
    <td class="border" colspan="2">
      <div class="font">
        <img src="images/arrow.gif" align="absmiddle">&nbsp;&nbsp;MySQL 基本信息
      </div>
    </td>
  </tr>
<?php
$mysql_stat = $db->GetStat();
foreach($mysql_stat as $key => $value) {
	$value = str_replace("\n", "<br />", $value);
	echo <<<mystep
 <tr>
   <td class="cat" width="250">{$key}</td>
   <td class="row">{$value}</td>
 </tr>
mystep;
}
?>
</table>
<br />
<?php
$content = ob_get_contents();
ob_clean();
$tpl->Set_Variable("main", $content);
$mystep->show($tpl);
$mystep->pageEnd(false);
?>