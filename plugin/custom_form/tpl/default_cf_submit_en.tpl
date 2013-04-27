<div style="padding-top:20px;text-align:center;font-size:18px;font-weight:bold;">
	<!--custom_form_name-->
</div>
<hr />
<br />
<script src="script/checkForm.js" Language="JavaScript1.2"></script>
<script src="script/jquery.date_input.js" Language="JavaScript1.2"></script>
<form name="cf_submit" method="post" ACTION="/module.php?m=cf_submit" ENCTYPE="multipart/form-data" onsubmit="return checkForm(this)">
	<input name="id" type="hidden" value="0" />
	<input name="mid" type="hidden" value="<!--mid-->" />
	<table width="780" border="0" class="cf_form" align="center" cellpadding="2" cellspacing="1">
<?php
foreach($para as $key => $value) {
	if($value['manager']=='true') continue;
	if(empty($value['title_en'])) continue;
	if(empty($value['comment_en'])) $value['comment_en'] = "No Comment";
	echo <<<mystep
				<tr>
					<td class="cat" width="80">{$value['title_en']}</td>
					<td class="row">
mystep;
	switch($value['type']) {
		case "text":
			$format = "";
			if($value['format']!=".") $format = ' need="'.$value['format'].'"';
			$length = "";
			if($value['length']!="") $length = ' len="'.$value['length'].'"';
			$class="";
			if(array_search($key, array("country", "location", "province"))!==false) $class="ac_input";
			echo <<<mystep
						<input name="{$key}" class="{$class}" type="text" value="{$value['default_en']}" size="50"{$length}{$format} />
mystep;
			break;
		case "radio":
			for($i=0; $i<count($value['value']['en']); $i++) {
				$selected = ($value['value']['en'][$i]==$value['default_en']?" checked":"");
				$the_value = $i+1;
				echo <<<mystep
						<input name="{$key}" id="i_{$key}_{$i}" type="radio" value="{$the_value}"{$selected} /><label for="i_{$key}_{$i}"> {$value['value']['en'][$i]}</label>
mystep;
			}
			break;
		case "select":
			echo "<select name=\"{$key}\">";
			for($i=0; $i<count($value['value']['en']); $i++) {
				$selected = ($value['value']['en'][$i]==$value['default_en']?" selected":"");
				$the_value = $i+1;
				echo <<<mystep
						<option value="{$the_value}"{$selected}>{$value['value']['en'][$i]}</option>
mystep;
			}
			echo "</select>";
			break;
		case "checkbox":
			for($i=0; $i<count($value['value']['en']); $i++) {
				$selected = (strpos($value['default_en'], $value['value']['en'][$i])!==false?" checked":"");
				$the_value = pow(2, $i);
				echo <<<mystep
						<input name="{$key}[]" id="i_{$key}_{$i}" type="checkbox" value="{$the_value}"{$selected} /><label for="i_{$key}_{$i}"> {$value['value']['en'][$i]}</label><br />
mystep;
			}
			break;
		case "textarea":
			echo <<<mystep
						<textarea name="{$key}" style="width:100%;height:50px;">{$value['default_en']}</textarea><br />
mystep;
			break;
		default:
			echo "Wrong Format!";
			break;
	}
	echo <<<mystep
						<span class="comment">({$value['comment_en']})</span>
					</td>
				</tr>
mystep;
}
?>
		<TR CLASS="row">
			<TD colspan="2"><center><input type="checkbox" name="print" value="y" id="print" /><label for="print"> Print</label></center></TD>
		</TR>
		<TR CLASS="row">
			<TD colspan="2" style="text-align:center;padding:20px;">
				<input type="submit" value=" Submit " /> &nbsp; &nbsp; &nbsp; <input type="reset" value=" Reset " />
			</TD>
		</TR>
	</table>
</form>
<script language="JavaScript" type="text/javascript" src="/script/jquery.autocomplete.js"></script>
<script Language="JavaScript1.2">
var uTime = (new Date()).getTime();
var date = new Date();
date.setTime(uTime+10*60*1000);
$.cookie('cf_time', null);
$.cookie('cf_time', Math.round(date.getTime()/1000), {expires: date, path: '/', domain: '<?=$setting['cookie']['domain']?>'});
</script>

