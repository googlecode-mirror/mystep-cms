	<div style="height:110px;">
		<div class="setup step2">
			<h2>�������л���</h2>
			<p>�������������Լ����û�����վ����</p>
		</div>
		<div class="stepstat">
			<ul>
				<li class="">1</li>
				<li class="current">2</li>
				<li class="unactivated">3</li>
				<li class="unactivated last">4</li>
			</ul>
			<div class="stepstatbg stepstat2"></div>
		</div>
	</div>
<?php
$web_url = "http://".$req->getServer("SERVER_NAME").str_replace("\\", "/", dirname(dirname($req->getServer("SCRIPT_NAME"))));
$cookie_domain = ".".implode(".", array_slice(explode(".", $req->getServer("SERVER_NAME")), -2));
?>
	<div class="main">
		<form method="post" action="index.php" onsubmit="return checkForm(this)">
			<div class="desc"><b>��վ����</b></div>
			<table class="tb2">
				<tr>
					<th class="tbopt">��վ��ַ��</th>
					<td><input type="text" name="setting[web][url]" value="<?=$web_url?>" size="35" class="txt" need="url"></td>
					<td>ͨ�����������Է��ʵ���ַ</td>
				</tr>
				<tr>
					<th class="tbopt">��վ�ʼ���</th>
					<td><input type="text" name="setting[web][email]" value="" size="35" class="txt" need="email"></td>
					<td>������վ��ȡ����ϵ�ĵ�������</td>
				</tr>
				<tr>
					<th class="tbopt">��վ���ƣ�</th>
					<td><input type="text" name="setting[web][title]" value="<?=$setting['web']['title']?>" size="35" class="txt" need=""></td>
					<td>���������������ʾ��վ����</td>
				</tr>
				<tr>
						<th class="tbopt">��վ�ؼ��֣�</th>
					<td><input type="text" name="setting[web][keyword]" value="mystep,cms,free" size="35" class="txt" need=""></td>
					<td>�����������������վ������ؼ������á�,�����</td>
				</tr>
				<tr>
						<th class="tbopt">��վ������</th>
					<td><input type="text" name="setting[web][description]" value="��Դ��վ���ݹ���ϵͳ" size="35" class="txt" need=""></td>
					<td>���������������վ���</td>
				</tr>
				<tr>
					<th class="tbopt">��ʼ�����ƣ�</th>
					<td><input type="text" name="setting[web][s_user]" value="mystep" size="35" class="txt" need=""></td>
					<td>ӵ��ȫ��Ȩ�ޣ��Ҳ��������ݿ�</td>
				</tr>
				<tr>
					<th class="tbopt">��ʼ�����룺</th>
					<td><input type="text" name="setting[web][s_pass]" value="" size="35" class="txt" need=""></td>
					<td>��ȷ������İ�ȫ�ɿ�</td>
				</tr>
			</table>
			
			<div class="desc"><b>���ݿ�����</b></div>
			<table class="tb2">
				<tr>
					<th class="tbopt">���ݿ�������</th>
					<td><input type="text" name="setting[db][host]" value="<?=$setting['db']['host']?>" size="35" class="txt" need=""></td>
					<td>���ݿ������ĵ�ַ</td>
				</tr>
				<tr>
					<th class="tbopt">���ݿ��û���</th>
					<td><input type="text" name="setting[db][user]" value="<?=$setting['db']['user']?>" size="35" class="txt" need=""></td>
					<td>����������������ݿ��û���</td>
				</tr>
				<tr>
					<th class="tbopt">���ݿ����룺</th>
					<td><input type="text" name="setting[db][pass]" value="<?=$setting['db']['pass']?>" size="35" class="txt" need=""></td>
					<td>��Ӧ���ݿ��û�������</td>
				</tr>
				<tr>
					<th class="tbopt">�����ַ�����</th>
					<td><input type="text" name="setting[db][charset]" value="<?=$setting['db']['charset']?>" size="35" class="txt" need=""></td>
					<td>���ݿ�洢���ݵ�Ĭ���ַ���</td>
				</tr>
				<tr>
					<th class="tbopt">���ݿ����ƣ�</th>
					<td><input type="text" name="setting[db][name]" value="<?=$setting['db']['name']?>" size="35" class="txt" need=""></td>
					<td>�洢��վ���ݱ�����ݿ�����</td>
				</tr>
				<tr>
					<th class="tbopt">���ݱ�ǰ׺��</th>
					<td><input type="text" name="setting[db][pre]" value="<?=$setting['db']['pre']?>" size="35" class="txt" need=""></td>
					<td>�������ֱ�ϵͳ���ݱ����������ݱ����ݱ�ǰ׺</td>
				</tr>
			</table>
			<table align="center">
				<tr>
					<td>
						<input type="button" onclick="location.href='./?step=1'" value="��һ��"> &nbsp; &nbsp; &nbsp; &nbsp; <input type="submit" value="��һ��">
						<input type="hidden" name="step" value="3" />
						<input type="hidden" name="setting[web][close]" value="<?=($setting['web']['close']?"true":"false")?>">
						<input type="hidden" name="setting[web][close_page]" value="<?=$setting['web']['close_page']?>">
						<input type="hidden" name="setting[gen][language]" value="<?=$setting['gen']['language']?>">
						<input type="hidden" name="setting[gen][charset]" value="<?=$setting['gen']['charset']?>">
						<input type="hidden" name="setting[gen][gzip_level]" value="<?=$setting['gen']['gzip_level']?>">
						<input type="hidden" name="setting[gen][cache]" value="<?=($setting['gen']['cache']?"true":"false")?>">
						<input type="hidden" name="setting[gen][rewrite]" value="<?=($setting['gen']['rewrite']?"true":"false")?>">
						<input type="hidden" name="setting[gen][cache_ext]" value="<?=$setting['gen']['cache_ext']?>">
						<input type="hidden" name="setting[gen][template]" value="<?=$setting['gen']['template']?>">
						<input type="hidden" name="setting[list][txt]" value="<?=$setting['list']['txt']?>">
						<input type="hidden" name="setting[list][img]" value="<?=$setting['list']['img']?>">
						<input type="hidden" name="setting[list][mix]" value="<?=$setting['list']['mix']?>">
						<input type="hidden" name="setting[list][rss]" value="<?=$setting['list']['rss']?>">
						<input type="hidden" name="setting[session][expire]" value="<?=$setting['session']['expire']?>">
						<input type="hidden" name="setting[session][path]" value="<?=$setting['session']['path']?>">
						<input type="hidden" name="setting[session][gc]" value="<?=($setting['session']['gc']?"true":"false")?>">
						<input type="hidden" name="setting[session][trans_sid]" value="<?=($setting['session']['trans_sid']?"true":"false")?>">
						<input type="hidden" name="setting[session][name]" value="<?=$setting['session']['name']?>">
						<input type="hidden" name="setting[session][mode]" value="<?=$setting['session']['mode']?>">
						<input type="hidden" name="setting[cookie][domain]" value="<?=$cookie_domain?>">
						<input type="hidden" name="setting[cookie][path]" value="<?=$setting['cookie']['path']?>">
						<input type="hidden" name="setting[cookie][prefix]" value="ms_">
						<input type="hidden" name="setting[path][upload]" value="<?=$setting['path']['upload']?>">
						<input type="hidden" name="setting[path][cache]" value="<?=$setting['path']['cache']?>">
						<input type="hidden" name="setting[path][template]" value="<?=$setting['path']['template']?>">
						<input type="hidden" name="setting[content][max_length]" value="<?=$setting['content']['max_length']?>">
						<input type="hidden" name="setting[content][get_remote_img]" value="<?=($setting['content']['get_remote_img']?"true":"false")?>">
						<input type="hidden" name="setting[watermark][mode]" value="<?=$setting['watermark']['mode']?>">
						<input type="hidden" name="setting[watermark][txt]" value="<?=$setting['watermark']['txt']?>">
						<input type="hidden" name="setting[watermark][img]" value="<?=$setting['watermark']['img']?>">
						<input type="hidden" name="setting[watermark][credit]" value="<?=$setting['watermark']['credit']?>">
						<input type="hidden" name="setting[db][pconnect]" value="<?=($setting['db']['pconnect']?"true":"false")?>">
					</td>
				</tr>
			</table>
			
		</form>
	</div>
