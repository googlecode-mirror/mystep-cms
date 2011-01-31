	<div style="height:110px;">
		<div class="setup step1">
			<h2>开始安装</h2>
			<p>环境以及文件目录权限检查</p>
		</div>
		<div class="stepstat">
			<ul>
				<li class="current">1</li>
				<li class="unactivated">2</li>
				<li class="unactivated">3</li>
				<li class="unactivated last">4</li>
			</ul>
			<div class="stepstatbg stepstat1"></div>
		</div>
	</div>
	<div class="main">
		<h2 class="title">环境检查</h2>
		<table class="tb" style="margin:20px 0 20px 55px;">
		<tr>
			<th>项目</th>
			<th class="padleft">MyStep 所需配置</th>
			<th class="padleft">MyStep 最佳</th>
			<th class="padleft">当前服务器</th>
		</tr>
		<tr>
		<td>操作系统</td>
		<td class="padleft">不限制</td>
		<td class="padleft">类Unix</td>
		<td class="w pdleft1"><?=$req->getEnv("OS")?></td>
		</tr>
		<tr>
		<td>PHP 版本</td>
		<td class="padleft">5.0</td>
		<td class="padleft">5.3</td>
<?php
	$ver = phpversion();
	$sign = $ver>"5.0" ? "w" : "nw";
?>
		<td class="<?=$sign?> pdleft1"><?=$ver?></td>
		</tr>
		<tr>
		<td>附件上传</td>
		<td class="padleft">不限制</td>
		<td class="padleft">2M</td>
		<td class="w pdleft1"><?=ini_get('upload_max_filesize')?></td>
		</tr>
		<tr>
		<td>GD 库</td>
		<td class="padleft">1.0</td>
		<td class="padleft">2.0</td>
<?php
	$ver = "";
	if(function_exists("gd_info")) {
		$ver = gd_info();
		$ver = preg_replace("/^.+?([\d\.]+).+?$/", "\\1", $ver['GD Version']);
	}
	$sign = $ver>"2.0" ? "w" : "nw";
?>
		<td class="<?=$sign?> pdleft1"><?=$ver?></td>
		</tr>
		<tr>
		<td>磁盘空间</td>
		<td class="padleft">10M</td>
		<td class="padleft">不限制</td>
<?php
$dir = split("/", str_replace("\\", "/", dirname(__FILE__)));
if(empty($dir[0])) $dir[0] = "/";
$free = ceil(disk_free_space($dir[0])/1024/1024);
$sign = $free>10 ? "w" : "nw";
?>
		<td class="<?=$sign?> pdleft1"><?=$free."MB"?></td>
		</tr>
		</table>
		
		<h2 class="title">目录、文件权限检查</h2>
		<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
			<tr>
			<th>目录文件</th>
			<th class="padleft">所需状态</th>
			<th class="padleft">当前状态</th>
		</tr>
<?php
$theList = array(
	"template/",
	"plugin/",
	"include/",
	"files/",
	"cache/",
);

foreach($theList as $cur) {
	echo "<tr>\n";
	echo "<td>{$cur}</td><td class=\"w pdleft1\">可写</td>";
	if(iswriteable(ROOT_PATH."/".$cur)) {
		echo '<td class="w pdleft1">可写</td>';
	} else {
		echo '<td class="nw pdleft1">不可写</td>';
	}
	echo "\n</tr>\n";
}
?>
		</table>
		
		<h2 class="title">函数依赖性检查</h2>
		<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
		<tr>
			<th>函数名称</th>
			<th class="padleft">检查结果</th>
			<th class="padleft">建议</th>
		</tr>
<?php
$theList = array(
	"mysql_connect",
	"fsockopen",
	"file_get_contents",
	"xml_parser_create",
	"iconv",
);

foreach($theList as $cur) {
	echo "<tr>\n";
	echo "<td>{$cur}</td>";
	if(function_exists($cur)) {
		echo '<td class="w pdleft1">支持</td>';
	} else {
		echo '<td class="nw pdleft1">不支持</td>';
	}
	echo "<td class=\"padleft\">无</td>\n</tr>\n";
}
?>
		</table>
		
		<form action="index.php" method="post">
			<div class="btnbox marginbot">
				<input type="hidden" name="step" value="2" />
				<input type="button" onclick="location.href='./'" value="上一步"> &nbsp; &nbsp; &nbsp; &nbsp; 
				<input type="submit" value="下一步">
			</div>
		</form>
	</div>