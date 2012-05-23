<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	<!--custom_form_name-->11111
</div>
<hr />
<br />
<script src="script/checkForm.js" Language="JavaScript1.2"></script>
<script src="script/jquery.date_input.js" Language="JavaScript1.2"></script>
<form name="cf_submit" method="post" ACTION="?m=cf_submit" ENCTYPE="multipart/form-data" onsubmit="return checkForm(this)">
	<input name="id" type="hidden" value="0" />
	<input name="mid" type="hidden" value="<!--mid-->" />
	<table width="780" border="0" class="cf_form" align="center" cellpadding="2" cellspacing="1">
<?php
foreach($para as $key => $value) {
	if(empty($value['title_en']) && !empty($value['comment_en'])) continue;
	if(empty($value['title'])) continue;
	if(empty($value['comment'])) $value['comment'] = "无注释";
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
						<input name="{$key}" type="text" value="{$value['default']}" size="50"{$length}{$format} />
mystep;
			break;
		case "radio":
			for($i=0; $i<count($value['value']['cn']); $i++) {
				$selected = ($value['value']['cn'][$i]==$value['default']?" checked":"");
				$the_value = $i+1;
				echo <<<mystep
						<input name="{$key}" id="i_{$key}_{$i}" type="radio" value="{$the_value}"{$selected} /><label for="i_{$key}_{$i}"> {$value['value']['cn'][$i]}</label>
mystep;
			}
			break;
		case "select":
			echo "<select name=\"{$key}\">";
			for($i=0; $i<count($value['value']['cn']); $i++) {
				$selected = ($value['value']['cn'][$i]==$value['default']?" selected":"");
				$the_value = $i+1;
				echo <<<mystep
						<option value="{$the_value}"{$selected}>{$value['value']['cn'][$i]}</option>
mystep;
			}
			echo "</select>";
			break;
		case "checkbox":
			for($i=0; $i<count($value['value']['cn']); $i++) {
				$selected = (strpos($value['default'], $value['value']['cn'][$i])!==false?" checked":"");
				$the_value = pow(2, $i);
				echo <<<mystep
						<input name="{$key}[]" id="i_{$key}_{$i}" type="checkbox" value="{$the_value}"{$selected} /><label for="i_{$key}_{$i}"> {$value['value']['cn'][$i]}</label><br />
mystep;
			}
			break;
		case "textarea":
			echo <<<mystep
						<textarea name="{$key}" style="width:100%;height:50px;">{$value['default']}</textarea><br />
mystep;
			break;
		default:
			echo "格式类型错误！";
			break;
	}
	echo <<<mystep
						<span class="comment">（{$value['comment']}）</span>
					</td>
				</tr>
mystep;
}
?>
		<TR CLASS="row">
			<TD colspan="2"><center><input type="submit" value=" 提 交 " /> &nbsp; <input type="reset" value=" 复 位 " /></center></TD>
		</TR>
	</table>
</form>
<script Language="JavaScript1.2">
var uTime = (new Date()).getTime();
var date = new Date();
date.setTime(uTime+10*60*1000);
$.cookie('cf_time', Math.round(date.getTime()/1000), {expires: date});
</script>
