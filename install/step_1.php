	<div style="height:110px;">
		<div class="setup step1">
			<h2>��ʼ��װ</h2>
			<p>�����Լ��ļ�Ŀ¼Ȩ�޼��</p>
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
		<h2 class="title">�������</h2>
		<table class="tb" style="margin:20px 0 20px 55px;">
		<tr>
			<th>��Ŀ</th>
			<th class="padleft">MyStep ��������</th>
			<th class="padleft">MyStep ���</th>
			<th class="padleft">��ǰ������</th>
		</tr>
		<tr>
		<td>����ϵͳ</td>
		<td class="padleft">������</td>
		<td class="padleft">��Unix</td>
		<td class="w pdleft1"><?=$req->getEnv("OS")?></td>
		</tr>
		<tr>
		<td>PHP �汾</td>
		<td class="padleft">5.0</td>
		<td class="padleft">5.3</td>
<?php
	$ver = phpversion();
	$sign = $ver>"5.0" ? "w" : "nw";
?>
		<td class="<?=$sign?> pdleft1"><?=$ver?></td>
		</tr>
		<tr>
		<td>�����ϴ�</td>
		<td class="padleft">������</td>
		<td class="padleft">2M</td>
		<td class="w pdleft1"><?=ini_get('upload_max_filesize')?></td>
		</tr>
		<tr>
		<td>GD ��</td>
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
		<td>���̿ռ�</td>
		<td class="padleft">10M</td>
		<td class="padleft">������</td>
<?php
$dir = split("/", str_replace("\\", "/", dirname(__FILE__)));
if(empty($dir[0])) $dir[0] = "/";
$free = ceil(disk_free_space($dir[0])/1024/1024);
$sign = $free>10 ? "w" : "nw";
?>
		<td class="<?=$sign?> pdleft1"><?=$free."MB"?></td>
		</tr>
		</table>
		
		<h2 class="title">Ŀ¼���ļ�Ȩ�޼��</h2>
		<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
			<tr>
			<th>Ŀ¼�ļ�</th>
			<th class="padleft">����״̬</th>
			<th class="padleft">��ǰ״̬</th>
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
	echo "<td>{$cur}</td><td class=\"w pdleft1\">��д</td>";
	if(iswriteable(ROOT_PATH."/".$cur)) {
		echo '<td class="w pdleft1">��д</td>';
	} else {
		echo '<td class="nw pdleft1">����д</td>';
	}
	echo "\n</tr>\n";
}
?>
		</table>
		
		<h2 class="title">���������Լ��</h2>
		<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
		<tr>
			<th>��������</th>
			<th class="padleft">�����</th>
			<th class="padleft">����</th>
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
		echo '<td class="w pdleft1">֧��</td>';
	} else {
		echo '<td class="nw pdleft1">��֧��</td>';
	}
	echo "<td class=\"padleft\">��</td>\n</tr>\n";
}
?>
		</table>
		
		<form action="index.php" method="post">
			<div class="btnbox marginbot">
				<input type="hidden" name="step" value="2" />
				<input type="button" onclick="location.href='./'" value="��һ��"> &nbsp; &nbsp; &nbsp; &nbsp; 
				<input type="submit" value="��һ��">
			</div>
		</form>
	</div>