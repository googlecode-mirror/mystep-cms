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
//$cookie_domain = ".".implode(".", array_slice(explode(".", $req->getServer("SERVER_NAME")), 1));
$cookie_domain = $req->getServer("SERVER_NAME");
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
					<td><input type="text" name="setting[db][pass]" value="" size="35" class="txt" need=""></td>
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
					<td>�洢��վ���ݱ�����ݿ����ƣ������ݿ⽫����գ�������Ҫ���ݣ���ע�ⱸ�ݣ���</td>
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
						<input type="hidden" name="setting[cookie][domain]" value="<?=$cookie_domain?>">
						<input type="button" onclick="location.href='./?step=1'" value="��һ��"> &nbsp; &nbsp; &nbsp; &nbsp; <input type="submit" value="��һ��">
						<input type="hidden" name="step" value="3" />
					</td>
				</tr>
			</table>
			
		</form>
	</div>
