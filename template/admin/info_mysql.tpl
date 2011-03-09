<div class="title">MySQL 基本信息</div>
<div>&nbsp;</div>
<div>
	<table width="80%" cellspacing="0" cellpadding="0" align="center" border="0">
<?php
$mysql_stat = $db->GetStat();
foreach($mysql_stat as $key => $value) {
	$value = str_replace("\n", "<br />", $value);
	echo <<<mystep
	 <tr>
		 <td class="cat" width="250">{$key}</td>
		 <td class="row">{$value}</td>
	 </tr>
mystep;
}
?>
	</table>
</div>