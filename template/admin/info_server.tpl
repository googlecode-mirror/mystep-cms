<div class="title">������������Ϣ</div>
<div>&nbsp;</div>
<div>
	<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
		<tr>
			<td class="cat" width="250">���������Ի���</td>
			<td class="row"><?=$req->getServer("HTTP_ACCEPT_LANGUAGE")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">����������</td>
			<td class="row"><?=$req->getServer("SERVER_NAME")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">������ip��ַ</td>
			<td class="row"><?=gethostbyname($req->getServer("SERVER_NAME"))?></td>
		</tr>
		<tr>
			<td class="cat" width="250">�������˿�</td>
			<td class="row"><?=$req->getServer("SERVER_PORT")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">������ʱ��</td>
			<td class="row"><?=date("Y��m��d�� H:i:s",$_SERVER['REQUEST_TIME'])?></td>
		</tr>
		<tr>
			<td class="cat" width="250">������ϵͳ</td>
			<td class="row"><?=PHP_OS?></td>
		</tr>
		<tr>
			<td class="cat" width="250">��������������</td>
			<td class="row"><?=$req->getServer("SERVER_SOFTWARE")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">�����ͨ��Э��</td>
			<td class="row"><?=$req->getServer("SERVER_PROTOCOL")?></td>
		</tr>
		<tr>
			<td class="cat" width="250">�����ʣ��ռ�</td>
			<td class="row"><?=intval(diskfreespace(".") / (1024 * 1024 * 1024)).'GB'?></td>
		</tr>
		<tr>
			<td class="cat" width="250">ϵͳ��ǰ�û���</td>
			<td class="row"><?=get_current_user()?></td>
		</tr>
		<tr>
			<td class="cat" width="250">���ļ�·��</td>
			<td class="row"><?=$req->getServer("PATH_TRANSLATED")?></td>
		</tr>
	</table>
</div>