<div class="title"><!--title--></div>
<div class="nav" style="display:none;">
<a href="#" onclick="setSection()">显示全部</a>
<!--loop:start key="anchor"-->
|&nbsp; <a href="#<!--anchor_pos-->" onclick="setSection('<!--anchor_pos-->')"><!--anchor_name--></a> &nbsp;
<!--loop:end-->
</div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?update" onsubmit="if($id('web_s_pass').value==$id('web_s_pass_r').value && $id('db_pass').value==$id('db_pass_r').value){return checkForm(this)}else{alert('两次输入的密码不一致！');return false;}">
		<table id="input_area" cellspacing="0" cellpadding="0">
			<tbody id="head">
			<div style="text-align:center;">
				<select onchange="setSection(this.value)" style="font-size:14px;font-weight:bold;line-height:20px;margin:10px 10px 10px 10px;">
					<option value="">显示全部设置项目</option>
<!--loop:start key="anchor"-->
					<option value="<!--anchor_pos-->"><!--anchor_name--></option>
<!--loop:end-->
				</select>
			</div>
<?PHP
$language = $setting['language'];
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/config-detail.php");
$setting['watermark']['mode'] = array(($setting['watermark']['mode']&1)==1, ($setting['watermark']['mode']&2)==2);

$cur_section = "";
foreach($setting as $key1 => $value1) {
	if($cur_section!=$key1) {
		$cur_comment = $setting_comm[$key1."_comm"];
		$cur_section = $key1;
		echo <<<content
			</tbody>
			<tbody id="{$key1}">
			<tr>
				<td class="cat" colspan="2"><a name="{$key1}">{$cur_comment}</a></td>
			</tr>
content;
		echo "\n";
	}
	foreach($value1 as $key2 => $value2) {
		$cur_comment = $setting_comm[$key1][$key2];
		$cur_description = $setting_comm[$key1."_descr"][$key2];
		switch($setting_type[$key1][$key2][0]) {
			case "text":
				$cur_component = '<input type="text" name="setting['.$key1.']['.$key2.']" value="'.any2str($value2).'" maxlength="'.$setting_type[$key1][$key2][2].'"'.($setting_type[$key1][$key2][1]===false?'':(' need="'.$setting_type[$key1][$key2][1].'"')).' />';
				break;
			case "textarea":
				$cur_component = '<textarea name="plugin_setting['.$idx.']['.$key.']" wrap="off" rows="'.$setting_type[$key][2].'"'.($setting_type[$key][1]===false?'':(' need="'.$setting_type[$key][1].'"')).'>'.any2str($value).'</textarea>';
				break;
			case "password":
				$cur_component = '
					<input type="password" id="'.$key1.'_'.$key2.'" name="setting['.$key1.']['.$key2.']" value="" maxlength="'.$setting_type[$key1][$key2][2].'" />
					<span class="comment">'.$cur_description.'</span>
				</td>
			<tr>
				<td class="cat" align="right">'.$language['admin_psw'].'</td>
				<td class="row">
					<input type="password" id="'.$key1.'_'.$key2.'_r" name="setting['.$key1.']['.$key2.'_r]" value="" maxlength="'.$setting_type[$key1][$key2][2].'" />
				';
				$cur_description = $language['admin_psw_desc'].$language['admin_psw_desc_addon'];
				break;
			case "checkbox":
				$cur_component = '';
				$i = 0;
				foreach($setting_type[$key1][$key2][1] as $key3 => $value3) {
					$checked = $setting[$key1][$key2][$i++]?"checked":"";
					$cur_component .= '<input type="checkbox" class="cbox" id="setting['.$key1.']['.$key2.']['.$key3.']" name="setting['.$key1.']['.$key2.'][]" value="'.$value3.'" '.$checked.' /><label for="setting['.$key1.']['.$key2.']['.$key3.']">'.$key3.'</label>';
				}
				break;
			case "radio":
				$cur_component = '';
				foreach($setting_type[$key1][$key2][1] as $key3 => $value3) {
					$value3 = any2str($value3);
					$checked = $value3==any2str($setting[$key1][$key2])?"checked":"";
					$cur_component .= '<input type="radio" class="cbox" id="setting['.$key1.']['.$key2.']['.$key3.']" name="setting['.$key1.']['.$key2.']" value="'.$value3.'" '.$checked.' /><label for="setting['.$key1.']['.$key2.']['.$key3.']">'.$key3.'</label>'."\n";
				}
				break;
			case "select":
				$cur_component = "<select name=\"setting[{$key1}][{$key2}]\">\n";
				foreach($setting_type[$key1][$key2][1] as $key3 => $value3) {
					$value3 = any2str($value3);
					$checked = $value3==any2str($setting[$key1][$key2])?"selected":"";
					$cur_component .= '<option value="'.$value3.'" '.$checked.'>'.$key3.'</option>'."\n";
				}
				$cur_component .= "</select>";
				break;
			default:
				$cur_component = '<input name="setting['.$key1.']['.$key2.']" value="'.$value2.'" />';
		}
		echo <<<content
			<tr>
				<td class="cat" align="right">{$cur_comment}</td>
				<td class="row">
					{$cur_component}
					<span class="comment">{$cur_description}</span>
				</td>
			</tr>
content;
		echo "\n";
	}
}
$setting['gen']['minify'] = false;
?>
			</tbody>
			<tbody id="foot">
			<tr>
				<td class="cat" colspan="2" align="center" style="line-height:24px;">
					<input id="set_default" name="set_default" class="cbox" type="checkbox" value="1" /><label for="set_default">定为默认</label>
					<br />
					<input class="btn" type="Submit" value=" 确认修改 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 恢复默认 " onclick="location.href='?restore'" />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重置数据 " />
				</td>
			</tr>
			</tbody>
		</table>
	</form>
</div>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
function setSection(idx) {
	if(idx==null || idx=="") {
		$("#input_area > tbody").show();
	} else {
		$("#input_area > tbody").hide();
		$("#input_area > #head").show();
		$("#input_area > #foot").show();
		$("#input_area > #"+idx).show(200);
	}
}
//]]> 
</script>