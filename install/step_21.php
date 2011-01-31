	<div style="height:110px;">
		<div class="setup step2">
			<h2>设置运行环境</h2>
			<p>检测服务器环境以及设置基本网站参数</p>
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
				<b>数据库设置</b><br />
				<span class="red">您所输入的数据库信息有误，请确认！</span>
			</div>
			<table class="tb2">
				<tr>
					<th class="tbopt">数据库主机：</th>
					<td><input type="text" name="setting[db][host]" value="<?=$setting['db']['host']?>" size="35" class="txt" need=""></td>
					<td>数据库主机的地址</td>
				</tr>
				<tr>
					<th class="tbopt">数据库用户：</th>
					<td><input type="text" name="setting[db][user]" value="<?=$setting['db']['user']?>" size="35" class="txt" need=""></td>
					<td>服务器所分配的数据库用户名</td>
				</tr>
				<tr>
					<th class="tbopt">数据库密码：</th>
					<td><input type="text" name="setting[db][pass]" value="<?=$setting['db']['pass']?>" size="35" class="txt" need=""></td>
					<td>对应数据库用户的密码</td>
				</tr>
				<tr>
					<th class="tbopt">数据字符集：</th>
					<td><input type="text" name="setting[db][charset]" value="<?=$setting['db']['charset']?>" size="35" class="txt" need=""></td>
					<td>数据库存储数据的默认字符集</td>
				</tr>
				<tr>
					<th class="tbopt">数据库名称：</th>
					<td><input type="text" name="setting[db][name]" value="<?=$setting['db']['name']?>" size="35" class="txt" need=""></td>
					<td>存储网站数据表的数据库名称</td>
				</tr>
				<tr>
					<th class="tbopt">数据表前缀：</th>
					<td><input type="text" name="setting[db][pre]" value="<?=$setting['db']['pre']?>" size="35" class="txt" need=""></td>
					<td>用于区分本系统数据表与其他数据表数据表前缀</td>
				</tr>
			</table>
			
			<table align="center">
				<tr>
					<td>
						<input type="button" onclick="location.href='./?step=1" value="上一步"> &nbsp; &nbsp; &nbsp; &nbsp; <input type="submit" value="下一步">
						<input type="hidden" name="step" value="3" />
					</td>
				</tr>
			</table>
			
		</form>
	</div>
