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
			<th class="padleft">MyStep 最佳配置</th>
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
		<td class="padleft">5.2</td>
		<td class="padleft">5.3</td>
<?php
	$ver = phpversion();
	$sign = $ver>"5.2" ? "w" : "nw";
	if($sign=="nw") $ver .= '<span id="error"></span>';
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
	if($sign=="nw") $ver .= '<span id="error"></span>';
?>
		<td class="<?=$sign?> pdleft1"><?=$ver?></td>
		</tr>
		<tr>
		<td>短标签</td>
		<td class="padleft">开启</td>
		<td class="padleft">开启</td>
<?php
	$short_tag = strtolower(ini_get("short_open_tag"));
	if($short_tag==1 || $short_tag=="on") {
		$sign = "w";
		$ver = "开启";
	} else {
		$sign = "nw";
		$ver = "关闭".'<span id="error"></span>';
	}
?>
		<td class="<?=$sign?> pdleft1"><?=$ver?></td>
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
	"include/config.php",
	"include/",
	"template/",
	"plugin/",
	"files/",
	"cache/",
);

foreach($theList as $cur) {
	echo "<tr>\n";
	echo "<td>{$cur}</td><td class=\"pdleft1\">可写</td>";
	if(isWriteable(ROOT_PATH."/".$cur)) {
		echo '<td class="w pdleft1">可写</td>';
	} else {
		echo '<td class="nw pdleft1">不可写<span id="error"></span></td>';
	}
	echo "\n</tr>\n";
}
?>
		</table>
		
		<h2 class="title">函数依赖性检查</h2>
		<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
		<tr>
			<th>函数名称</th>
			<th class="padleft">建议</th>
			<th class="padleft">检查结果</th>
		</tr>
<?php
$theList = array(
	"mysql_connect",
	"fsockopen",
	"file_get_contents",
	"xml_parser_create",
	"json_encode",
	"iconv",
);

foreach($theList as $cur) {
	echo "<tr>\n";
	echo "<td>{$cur}</td>";
	echo "<td class=\"padleft\">支持</td>\n";
	if(function_exists($cur)) {
		echo '<td class="w pdleft1">支持</td>';
	} else {
		echo '<td class="nw pdleft1">不支持<span id="error"></span></td>';
	}
	echo "</tr>\n";
}
?>
		</table>
		
		<div id="err_info" style="text-align:center;color:#ff0000;">由于未能完全通过检测，当前插件有可能无法正确安装，请根据检测信息提示修正相关问题后，点击“复查”按钮！</div>
		<form action="index.php" method="post">
			<div class="btnbox marginbot">
				<input type="hidden" name="step" value="2" />
				<input type="button" onclick="location.href='./'" value="上一步"> &nbsp; &nbsp; &nbsp; &nbsp; 
				<input type="submit" id="install" value="下一步"><input class="btn" id="refresh" type="button" value=" 复 查 " onclick="location.reload()" />
			</div>
		</form>
	</div>

<script language="JavaScript" type="text/javascript">
//<![CDATA[
$(function(){
	if($("#error").length==0) {
		$("#err_info").hide();
		$("#refresh").hide();
		$("#install").show();
	} else {
		$("#err_info").show();
		$("#refresh").show();
		$("#install").hide();
	}
});
//]]> 
</script>