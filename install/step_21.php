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
			<div class="stepstatbg stepstat1"></div>
		</div>
	</div>
<?php
$web_url = "http://".$req->getServer("SERVER_NAME").dirname(dirname($req->getServer("SCRIPT_NAME")))."/";
$cookie_domain = ".".implode(".", array_slice(explode(".", $req->getServer("SERVER_NAME")), -2));
?>
	<div class="main">
		<form method="post" action="index.php" onsubmit="return checkForm(this)">
			<div class="desc">
				<b>���ݿ�����</b><br />
				<span class="red">������������ݿ���Ϣ������ȷ�ϣ�</span>
			</div>
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
						<input type="button" onclick="location.href='./?step=1" value="��һ��"> &nbsp; &nbsp; &nbsp; &nbsp; <input type="submit" value="��һ��">
						<input type="hidden" name="step" value="3" />
					</td>
				</tr>
			</table>
			
		</form>
	</div>
