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
			<th class="padleft">MyStep �������</th>
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
	if($sign=="nw") $ver .= '<span id="error"></span>';
?>
		<td class="<?=$sign?> pdleft1"><?=$ver?></td>
		</tr>
		<tr>
		<td>�̱�ǩ</td>
		<td class="padleft">����</td>
		<td class="padleft">����</td>
<?php
	$short_tag = strtolower(ini_get("short_open_tag"));
	if($short_tag==1 || $short_tag=="on") {
		$sign = "w";
		$ver = "����";
	} else {
		$sign = "nw";
		$ver = "�ر�".'<span id="error"></span>';
	}
?>
		<td class="<?=$sign?> pdleft1"><?=$ver?></td>
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
	"include/config.php",
	"include/",
	"template/",
	"plugin/",
	"files/",
	"cache/",
);

foreach($theList as $cur) {
	echo "<tr>\n";
	echo "<td>{$cur}</td><td class=\"pdleft1\">��д</td>";
	if(isWriteable(ROOT_PATH."/".$cur)) {
		echo '<td class="w pdleft1">��д</td>';
	} else {
		echo '<td class="nw pdleft1">����д<span id="error"></span></td>';
	}
	echo "\n</tr>\n";
}
?>
		</table>
		
		<h2 class="title">���������Լ��</h2>
		<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
		<tr>
			<th>��������</th>
			<th class="padleft">����</th>
			<th class="padleft">�����</th>
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
	echo "<td class=\"padleft\">֧��</td>\n";
	if(function_exists($cur)) {
		echo '<td class="w pdleft1">֧��</td>';
	} else {
		echo '<td class="nw pdleft1">��֧��<span id="error"></span></td>';
	}
	echo "</tr>\n";
}
?>
		</table>
		
		<div id="err_info" style="text-align:center;color:#ff0000;">����δ����ȫͨ����⣬��ǰ����п����޷���ȷ��װ������ݼ����Ϣ��ʾ�����������󣬵�������顱��ť��</div>
		<form action="index.php" method="post">
			<div class="btnbox marginbot">
				<input type="hidden" name="step" value="2" />
				<input type="button" onclick="location.href='./'" value="��һ��"> &nbsp; &nbsp; &nbsp; &nbsp; 
				<input type="submit" id="install" value="��һ��"><input class="btn" id="refresh" type="button" value=" �� �� " onclick="location.reload()" />
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