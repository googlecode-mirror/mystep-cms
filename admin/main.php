<?php
require("inc.php");
$tpl_info = array(
		"idx" => "main",
		"style" => "admin",
		"path" => ROOT_PATH."/".$setting['path']['template'],
		);
$tpl = $mystep->getInstance("MyTpl", $tpl_info);
$pass  = "<font color=green><b>��</b></font>";
$error = "<font color=red><b>��</b></font>";
ob_start();
?>
<br />
<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
  <tr>
    <td class="border" colspan="2">
      <div class="font">
        <img src="images/arrow.gif" align="absmiddle">&nbsp;&nbsp;��վ������Ϣ
      </div>
    </td>
  </tr>
  <tr>
    <td class="cat" width="250">��վ����ʱ��</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."counter")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">ע���Ա��</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."users")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">��¼��������</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."news_show")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">��ǰ��������</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select count(*) from ".$setting['db']['pre']."user_online")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">�����������</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select max(online) from ".$setting['db']['pre']."counter")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">����ҳ�������</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select pv from ".$setting['db']['pre']."counter where date=curdate()")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">�����ҳ�������</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select max(pv) from ".$setting['db']['pre']."counter")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">��վҳ���վ�������</td>
    <td class="row"> &nbsp; <?=(int)$db->GetSingleResult("select avg(pv) from ".$setting['db']['pre']."counter")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">��վҳ���ܷ�����</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select sum(pv) from ".$setting['db']['pre']."counter")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">���� IP ������</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select iv from ".$setting['db']['pre']."counter where date=curdate()")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">����� IP ������</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select max(iv) from ".$setting['db']['pre']."counter")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">��վ�վ� IP ������</td>
    <td class="row"> &nbsp; <?=(int)$db->GetSingleResult("select avg(iv) from ".$setting['db']['pre']."counter")?> ��</td>
  </tr>
  <tr>
    <td class="cat" width="250">��վ�� IP ������</td>
    <td class="row"> &nbsp; <?=$db->GetSingleResult("select sum(iv) from ".$setting['db']['pre']."counter")?> ��</td>
  </tr>
</table>
<br />
<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
  <tr>
    <td class="border" colspan="2">
      <div class="font">
        <img src="images/arrow.gif" align="absmiddle">&nbsp;&nbsp;������������Ϣ
      </div>
    </td>
  </tr>
  <tr>
    <td class="cat" width="250">���������Ի���</td>
    <td class="row"><?=$req->getServer("HTTP_ACCEPT_LANGUAGE")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">����������</td>
    <td class="row"><?=$req->getServer("SERVER_NAME")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">������ip��ַ</td>
    <td class="row"><?=gethostbyname($req->getServer("SERVER_NAME"))?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">�������˿�</td>
    <td class="row"><?=$req->getServer("SERVER_PORT")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">������ʱ��</td>
    <td class="row"><?=date("Y��m��d�� h:i:s",$_SERVER['REQUEST_TIME'])?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">������ϵͳ</td>
    <td class="row"><?=PHP_OS?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">��������������</td>
    <td class="row"><?=$req->getServer("SERVER_SOFTWARE")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">�����ͨ��Э��</td>
    <td class="row"><?=$req->getServer("SERVER_PROTOCOL")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">�����ʣ��ռ�</td>
    <td class="row"><?=intval(diskfreespace(".") / (1024 * 1024 * 1024)).'GB'?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">ϵͳ��ǰ�û���</td>
    <td class="row"><?=get_current_user()?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">���ļ�·��</td>
    <td class="row"><?=$req->getServer("PATH_TRANSLATED")?>&nbsp;</td>
  </tr>
</table>
<br />
<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
  <tr>
    <td class="border" colspan="2">
      <div class="font">
        <img src="images/arrow.gif" align="absmiddle">&nbsp;&nbsp;PHP������Ϣ
      </div>
    </td>
  </tr>
  <tr>
    <td class="cat" width="250">PHP�汾</td>
    <td class="row"><?=PHP_VERSION;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">PHP���з�ʽ</td>
    <td class="row"><?=strtoupper(php_sapi_name())?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">Zend����汾</td>
    <td class="row"><?=zend_version()?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">�Զ�����ȫ�ֱ���</td>
    <td class="row"><?=get_cfg_var("register_globals") ? 'ON' : 'OFF';?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">�����ڰ�ȫģʽ</td>
    <td class="row"><?=get_cfg_var("safe_mode") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">��ʾ������Ϣ</td>
    <td class="row"><?=get_cfg_var("display_errors") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">��̬�������ӿ�֧��</td>
    <td class="row"><?=get_cfg_var("enable_dl") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">ʹ��URL���ļ�</td>
    <td class="row"><?=get_cfg_var("allow_url_fopen") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">����ʹ�õ�����ڴ���</td>
    <td class="row"><?=get_cfg_var("memory_limit")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">POST����ֽ���</td>
    <td class="row"><?=get_cfg_var("post_max_size")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">��������ϴ��ļ�</td>
    <td class="row"><?=get_cfg_var("file_uploads") ?  get_cfg_var("upload_max_filesize") : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">����ʱ����</td>
    <td class="row"><?=get_cfg_var("max_execution_time")."��";?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">�����õĺ���</td>
    <td class="row"><?=get_cfg_var("disable_functions") ? get_cfg_var("disable_functions") : "û��";?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">���&lt;% %&gt;֧��</td>
    <td class="row"><?=get_cfg_var("asp_tags") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">COOKIE֧��</td>
    <td class="row"><?=isset($HTTP_COOKIE_VARS) ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">����������Ч������ʾλ��</td>
    <td class="row"><?=get_cfg_var("precision")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">ǿ��y2k����</td>
    <td class="row"><?=get_cfg_var("y2k_compliance") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">��������ַ</td>
    <td class="row"><?=get_cfg_var("debugger.host") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">�������˿�</td>
    <td class="row"><?=get_cfg_var("debugger.port") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">SMTP֧��</td>
    <td class="row"><?=get_cfg_var("SMTP") ? $pass : $error;?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">SMTP��ַ</td>
    <td class="row"><?=get_cfg_var("SMTP")?>&nbsp;</td>
  </tr>
  <tr>
    <td class="cat" width="250">Html������ʾ</td>
    <td class="row"><?=get_cfg_var("html_errors") ? $pass : $error;?>&nbsp;</td>
  </tr>
</table>
<br />
<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
  <tr>
    <td class="border" colspan="2">
      <div class="font">
        <img src="images/arrow.gif" align="absmiddle">&nbsp;&nbsp;MySQL ������Ϣ
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