<div class="title">PHP 基本信息</div>
<div>&nbsp;</div>
<div>
	<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td class="cat" width="250">PHP版本</td>
			<td class="row"><?=PHP_VERSION;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">PHP运行方式</td>
			<td class="row"><?=strtoupper(php_sapi_name())?></td>
		</tr>
		<tr>
			<td class="cat" width="250">Zend引擎版本</td>
			<td class="row"><?=zend_version()?></td>
		</tr>
		<tr>
			<td class="cat" width="250">自动定义全局变量</td>
			<td class="row"><?=get_cfg_var("register_globals") ? 'ON' : 'OFF';?></td>
		</tr>
		<tr>
			<td class="cat" width="250">运行于安全模式</td>
			<td class="row"><?=get_cfg_var("safe_mode") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">显示错误信息</td>
			<td class="row"><?=get_cfg_var("display_errors") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">动态加载连接库支持</td>
			<td class="row"><?=get_cfg_var("enable_dl") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">使用URL打开文件</td>
			<td class="row"><?=get_cfg_var("allow_url_fopen") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">允许使用的最大内存量</td>
			<td class="row"><?=get_cfg_var("memory_limit")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">POST最大字节数</td>
			<td class="row"><?=get_cfg_var("post_max_size")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">允许最大上传文件</td>
			<td class="row"><?=get_cfg_var("file_uploads") ?	get_cfg_var("upload_max_filesize") : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">程序超时限制</td>
			<td class="row"><?=get_cfg_var("max_execution_time")."秒";?></td>
		</tr>
		<tr>
			<td class="cat" width="250">被禁用的函数</td>
			<td class="row"><?=get_cfg_var("disable_functions") ? get_cfg_var("disable_functions") : "没有";?></td>
		</tr>
		<tr>
			<td class="cat" width="250">标记&lt;% %&gt;支持</td>
			<td class="row"><?=get_cfg_var("asp_tags") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">COOKIE支持</td>
			<td class="row"><?=(isset($HTTP_COOKIE_VARS) || isset($_COOKIE)) ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">浮点运算有效数字显示位数</td>
			<td class="row"><?=get_cfg_var("precision")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">强制y2k兼容</td>
			<td class="row"><?=get_cfg_var("y2k_compliance") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">调试器地址</td>
			<td class="row"><?=get_cfg_var("debugger.host") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">调试器端口</td>
			<td class="row"><?=get_cfg_var("debugger.port") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">SMTP支持</td>
			<td class="row"><?=get_cfg_var("SMTP") ? $pass : $error;?></td>
		</tr>
		<tr>
			<td class="cat" width="250">SMTP地址</td>
			<td class="row"><?=get_cfg_var("SMTP")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">Html错误显示</td>
			<td class="row"><?=get_cfg_var("html_errors") ? $pass : $error;?></td>
		</tr>
	</table>
</div>