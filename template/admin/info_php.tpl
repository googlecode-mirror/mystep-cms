<div class="title">PHP ������Ϣ</div>
<div>&nbsp;</div>
<div>
	<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td class="cat" width="250">PHP�汾</td>
			<td class="row"><?=PHP_VERSION;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">PHP���з�ʽ</td>
			<td class="row"><?=strtoupper(php_sapi_name())?></td>
		</tr>
		<tr>
			<td class="cat" width="250">Zend����汾</td>
			<td class="row"><?=zend_version()?></td>
		</tr>
		<tr>
			<td class="cat" width="250">�Զ�����ȫ�ֱ���</td>
			<td class="row"><?=get_cfg_var("register_globals") ? 'ON' : 'OFF';?></td>
		</tr>
		<tr>
			<td class="cat" width="250">�����ڰ�ȫģʽ</td>
			<td class="row"><?=get_cfg_var("safe_mode") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">��ʾ������Ϣ</td>
			<td class="row"><?=get_cfg_var("display_errors") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">��̬�������ӿ�֧��</td>
			<td class="row"><?=get_cfg_var("enable_dl") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">ʹ��URL���ļ�</td>
			<td class="row"><?=get_cfg_var("allow_url_fopen") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">����ʹ�õ�����ڴ���</td>
			<td class="row"><?=get_cfg_var("memory_limit")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">POST����ֽ���</td>
			<td class="row"><?=get_cfg_var("post_max_size")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">��������ϴ��ļ�</td>
			<td class="row"><?=get_cfg_var("file_uploads") ?	get_cfg_var("upload_max_filesize") : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">����ʱ����</td>
			<td class="row"><?=get_cfg_var("max_execution_time")."��";?></td>
		</tr>
		<tr>
			<td class="cat" width="250">�����õĺ���</td>
			<td class="row"><?=get_cfg_var("disable_functions") ? get_cfg_var("disable_functions") : "û��";?></td>
		</tr>
		<tr>
			<td class="cat" width="250">���&lt;% %&gt;֧��</td>
			<td class="row"><?=get_cfg_var("asp_tags") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">COOKIE֧��</td>
			<td class="row"><?=(isset($HTTP_COOKIE_VARS) || isset($_COOKIE)) ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">����������Ч������ʾλ��</td>
			<td class="row"><?=get_cfg_var("precision")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">ǿ��y2k����</td>
			<td class="row"><?=get_cfg_var("y2k_compliance") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">��������ַ</td>
			<td class="row"><?=get_cfg_var("debugger.host") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">�������˿�</td>
			<td class="row"><?=get_cfg_var("debugger.port") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">SMTP֧��</td>
			<td class="row"><?=get_cfg_var("SMTP") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">SMTP��ַ</td>
			<td class="row"><?=get_cfg_var("SMTP")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">Html������ʾ</td>
			<td class="row"><?=get_cfg_var("html_errors") ? $pass : $error;?></td>
		</tr>
	</table>
</div>