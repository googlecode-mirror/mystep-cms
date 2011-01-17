<div class="title"><!--title--></div>
<div class="nav">|&nbsp;
<!--loop:start key="anchor"-->
<a href="#<!--anchor_pos-->"><!--anchor_name--></a> |&nbsp;
<!--loop:end-->
</div>
<div align="center">
	<script src="../script/check_form.js" Language="JavaScript1.2"></script>
	<form method="post" action="?update" onsubmit="if($id('web_s_pass').value==$id('web_s_pass_r').value && $id('db_pass').value==$id('db_pass_r').value){return checkForm(this)}else{alert('两次输入的密码不一致！');return false;}">
		<table id="input_area" cellspacing="0" cellpadding="0">
<?PHP
include(ROOT_PATH."/include/config-detail.php");

$cur_section = "";
foreach($setting as $key1 => $value1) {
	if($cur_section!=$key1) {
		$cur_comment = $setting_comm[$key1."_comm"];
		$cur_section = $key1;
		echo <<<content
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
			case "password":
				$cur_component = '
					<input type="password" id="'.$key1.'_'.$key2.'" name="setting['.$key1.']['.$key2.']" value="" maxlength="'.$setting_type[$key1][$key2][2].'" />
					<span>'.$cur_description.'</span>
				</td>
			<tr>
				<td class="cat" align="right">重复密码</td>
				<td class="row">
					<input type="password" id="'.$key1.'_'.$key2.'_r" name="setting['.$key1.']['.$key2.'_r]" value="" maxlength="'.$setting_type[$key1][$key2][2].'" />
				';
				$cur_description = "请重复输入密码（如果密码不变，此项和前一项请留空！）";
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
					$checked = str2any($value3, false)==$setting[$key1][$key2]?"checked":"";
					$cur_component .= '<input type="radio" class="cbox" id="setting['.$key1.']['.$key2.']" name="setting['.$key1.']['.$key2.']" value="'.$value3.'" '.$checked.' /><label for="setting['.$key1.']['.$key2.']['.$key3.']">'.$key3.'</label>';
				}
				break;
			case "select":
				$cur_component = "<select name=\"setting[{$key1}][{$key2}]\">\n";
				foreach($setting_type[$key1][$key2][1] as $key3 => $value3) {
					$checked = str2any($value3, false)==$setting[$key1][$key2]?"selected":"";
					$cur_component .= '<option value="'.$value3.'" '.$checked.'>'.$key3.'</option>';
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
					<span>{$cur_description}</span>
				</td>
			</tr>
content;
		echo "\n";
	}
}
?>
			<tr align="center">
				<td class="row" colspan="2"><input id="set_default" name="set_default" class="cbox" type="checkbox" value="1"> <label for="set_default">定为默认</label></td>
			</tr>
			<tr>
				<td class="cat" colspan="2" align="center" style="padding:20px">
					<input class="btn" type="Submit" value=" 确认修改 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 恢复默认 " onclick="location.href='?restore'">&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重置数据 " />&nbsp;&nbsp;
				</td>
			</tr>
		</table>
	</form>
</div>