	<div style="height:110px;">
		<div class="setup step3">
			<h2>��װ���ݿ�</h2>
			<p>����ִ�����ݿⰲװ</p>
		</div>
		<div class="stepstat">
			<ul>
				<li class="">1</li>
				<li class="">2</li>
				<li class="current">3</li>
				<li class="unactivated last">4</li>
			</ul>
			<div class="stepstatbg stepstat3"></div>
		</div>
	</div>
	<div class="main">
		<div class=licenseblock>
			<div class=license>
<?php
$db = $mystep->getInstance("MySQL", $setting['db']['host'], $setting['db']['user'], $setting['db']['pass'], $setting['db']['charset']);
$charset_collate = $db->GetSingleRecord("SHOW CHARACTER SET LIKE '".strtolower($setting['db']['charset'])."'");
$strFind = array("{db_name}", "{pre}", "{charset}", "{host}", "{charset_collate}");
$strReplace = array($setting['db']['name'], $setting['db']['pre'], $setting['db']['charset'], $req->getServer("HTTP_HOST"), $charset_collate["Default collation"]);
$result = $db->ExeSqlFile("install.sql", $strFind, $strReplace);
//$result += $db->ExeSqlFile("common_district.sql", $strFind, $strReplace);
$max_count = count($result);
for($i=0;$i<$max_count;$i++) {
	switch($result[$i][1]){
			case "select":
				echo ($i+1) . " - ���ݱ� {$result[$i][2]} �����ɣ�<br />\n";
				break;
			case "create":
				echo ($i+1) . " - ����".($result[$i][0]=="table"?"��":"��")." {$result[$i][2]} �����ɣ�<br />\n";
				break;
			case "drop":
				echo ($i+1) . " - ����".($result[$i][0]=="table"?"��":"��")." {$result[$i][2]} ��ɾ����<br />\n";
				break;
			case "alter":
				echo ($i+1) . " - ���ݱ� {$result[$i][2]} �ѱ����<br />\n";
				break;
			case "delete":
				echo ($i+1) . " - ���ݱ� {$result[$i][2]} ��ɾ�� {$result[$i][3]} �����ݣ�<br />\n";
				break;
			case "truncate":
				echo ($i+1) . " - ���ݱ� {$result[$i][2]} �ѱ���գ�<br />\n";
				break;
			case "insert":
				echo ($i+1) . " - ���ݱ� {$result[$i][2]} ����� {$result[$i][3]} �����ݣ�<br />\n";
				break;
			case "update":
				echo ($i+1) . " - ���ݱ� {$result[$i][2]} �Ѹ��� {$result[$i][3]} �����ݣ�<br />\n";
				break;
			default:
				echo ($i+1) . " - ���ݱ� {$result[$i][2]} ִ���˲�����{$result[$i][1]}����<br />\n";
				break;
	}
}
?>
			</div>
		</div>
<?php
$err = array();
if($db->GetError($err)) {
	echo "<div>\n��װʱ�������⣺<br />\n";
	echo "<pre>\n";
	echo join("\n------------------------\n", $err);
	echo "</pre>\n</div>\n";
}
$db->Close();
unset($db);
?>
		<form action="index.php" method="post">
			<div class="btnbox marginbot">
				<input type="hidden" name="step" value="4" />
				<input type="button" onclick="location.href='./?step=2'" value="��һ��"> &nbsp; &nbsp; &nbsp; &nbsp; 
				<input type="submit" value="��һ��">
			</div>
		</form>
	</div>