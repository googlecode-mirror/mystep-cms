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
			<div class="stepstatbg stepstat2"></div>
		</div>
	</div>
<?php
$web_url = "http://".$req->getServer("SERVER_NAME").str_replace("\\", "/", dirname(dirname($req->getServer("SCRIPT_NAME"))));
$cookie_domain = ".".implode(".", array_slice(explode(".", $req->getServer("SERVER_NAME")), -2));
?>
	<div class="main">
		<form method="post" action="index.php" onsubmit="return checkForm(this)">
			<div class="desc"><b>网站设置</b></div>
			<table class="tb2">
				<tr>
					<th class="tbopt">网站地址：</th>
					<td><input type="text" name="setting[web][url]" value="<?=$web_url?>" size="35" class="txt" need="url"></td>
					<td>通过互联网可以访问的网址</td>
				</tr>
				<tr>
					<th class="tbopt">网站邮件：</th>
					<td><input type="text" name="setting[web][email]" value="" size="35" class="txt" need="email"></td>
					<td>用于网站问题的回报</td>
				</tr>
				<tr>
					<th class="tbopt">网站名称：</th>
					<td><input type="text" name="setting[web][title]" value="<?=$setting['web']['title']?>" size="35" class="txt" need=""></td>
					<td>用于在浏览器上显示网站名称</td>
				</tr>
				<tr>
						<th class="tbopt">网站关键字：</th>
					<td><input type="text" name="setting[web][keyword]" value="mystep,cms,free" size="35" class="txt" need=""></td>
					<td>用于搜索引擎检索网站，多个关键字请用“,”间隔</td>
				</tr>
				<tr>
						<th class="tbopt">网站描述：</th>
					<td><input type="text" name="setting[web][description]" value="开源网站内容管理系统" size="35" class="txt" need=""></td>
					<td>用于搜索引擎的网站简介</td>
				</tr>
				<tr>
					<th class="tbopt">创始人名称：</th>
					<td><input type="text" name="setting[web][s_user]" value="mystep" size="35" class="txt" need=""></td>
					<td>拥有全部权限，且不依赖数据库</td>
				</tr>
				<tr>
					<th class="tbopt">创始人密码：</th>
					<td><input type="text" name="setting[web][s_pass]" value="" size="35" class="txt" need=""></td>
					<td>请确认密码的安全可靠</td>
				</tr>
			</table>
			
			<div class="desc"><b>数据库设置</b></div>
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
						<input type="button" onclick="location.href='./?step=1'" value="上一步"> &nbsp; &nbsp; &nbsp; &nbsp; <input type="submit" value="下一步">
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
