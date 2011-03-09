<div class="title">服务器基本信息</div>
<div>&nbsp;</div>
<div>
	<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td class="cat" width="250">服务器语言环境</td>
			<td class="row"><?=$req->getServer("HTTP_ACCEPT_LANGUAGE")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">服务器域名</td>
			<td class="row"><?=$req->getServer("SERVER_NAME")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">服务器ip地址</td>
			<td class="row"><?=gethostbyname($req->getServer("SERVER_NAME"))?></td>
		</tr>
		<tr>
			<td class="cat" width="250">服务器端口</td>
			<td class="row"><?=$req->getServer("SERVER_PORT")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">服务器时间</td>
			<td class="row"><?=date("Y年m月d日 H:i:s",$_SERVER['REQUEST_TIME'])?></td>
		</tr>
		<tr>
			<td class="cat" width="250">服务器系统</td>
			<td class="row"><?=PHP_OS?></td>
		</tr>
		<tr>
			<td class="cat" width="250">服务器解译引擎</td>
			<td class="row"><?=$req->getServer("SERVER_SOFTWARE")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">服务端通信协议</td>
			<td class="row"><?=$req->getServer("SERVER_PROTOCOL")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">服务端剩余空间</td>
			<td class="row"><?=intval(diskfreespace(".") / (1024 * 1024 * 1024)).'GB'?></td>
		</tr>
		<tr>
			<td class="cat" width="250">系统当前用户名</td>
			<td class="row"><?=get_current_user()?></td>
		</tr>
		<tr>
			<td class="cat" width="250">本文件路径</td>
			<td class="row"><?=$req->getServer("PATH_TRANSLATED")?></td>
		</tr>
	</table>
</div>