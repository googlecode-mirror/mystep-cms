<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	��<!--meeting_name-->�� �λ�������ϵǼǱ�
</div>
<hr />
<br />
<script src="script/checkForm.js" Language="JavaScript1.2"></script>
<form name="regist" method="post" ACTION="?m=regist" ENCTYPE="multipart/form-data" onsubmit="return checkForm(this)">
	<input name="id" type="hidden" value="0" />
	<input name="mid" type="hidden" value="<!--mid-->" />
	<table width="700" border="0" id="tbl_reg" align="center" cellpadding="2" cellspacing="1">
<?php
foreach($para as $key => $value) {
	if(empty($value['title_en']) && !empty($value['comment_en'])) continue;
	if(empty($value['title'])) continue;
	if(empty($value['comment'])) $value['comment'] = "��ע��";
	echo <<<mystep
        <tr>
          <td class="cat" width="80">{$value['title']}</td>
          <td class="row">
mystep;
	switch($value['type']) {
		case "text":
			$format = "";
			if($value['format']!=".") $format = ' need="'.$value['format'].'"';
			$length = "";
			if($value['length']!="") $length = ' len="'.$value['length'].'"';
			echo <<<mystep
          	<input name="{$key}" type="text" value="" size="50"{$length}{$format} />
mystep;
			break;
		case "radio":
			for($i=0; $i<count($value['value']['cn']); $i++) {
				$selected = ($value['value']['cn'][$i]==$value['default']?" checked":"");
				echo <<<mystep
          	<input name="{$key}" id="i_{$key}_{$i}" type="radio" value="{$value['value']['cn'][$i]}"{$selected} /><label for="i_{$key}_{$i}"> {$value['value']['cn'][$i]}</label>
mystep;
			}
			break;
		case "select":
			echo "<select name=\"{$key}\">";
			for($i=0; $i<count($value['value']['cn']); $i++) {
				$selected = ($value['value']['cn'][$i]==$value['default']?" selected":"");
				echo <<<mystep
          	<option value="{$value['value']['cn'][$i]}"{$selected}>{$value['value']['cn'][$i]}</option>
mystep;
			}
			echo "</select>";
			break;
		case "checkbox":
			for($i=0; $i<count($value['value']['cn']); $i++) {
				$selected = (strpos($value['default'], $value['value']['cn'][$i])!==false?" checked":"");
				echo <<<mystep
          	<input name="{$key}[]" id="i_{$key}_{$i}" type="checkbox" value="{$value['value']['cn'][$i]}"{$selected} /><label for="i_{$key}_{$i}"> {$value['value']['cn'][$i]}</label><br />
mystep;
			}
			break;
		case "textarea":
			echo <<<mystep
          	<textarea name="{$key}" style="width:100%;height:50px;"></textarea><br />
mystep;
			break;
		default:
			echo "��ʽ���ʹ���";
			break;
	}
	echo <<<mystep
          	<span class="comment">��{$value['comment']}��</span>
          </td>
        </tr>
mystep;
}
?>
		<TR CLASS="tdlight">
			<TD colspan="2"><center><input type="submit" value=" �� �� "> &nbsp; <input type="reset" value=" �� λ "></center></TD>
		</TR>
	</table>
</form>
<script Language="JavaScript1.2">
var uTime = (new Date()).getTime();
var date = new Date();
date.setTime(uTime+5*60*1000);
$.cookie('reg_time', Math.round(date.getTime()/1000), {expires: date});
</script>