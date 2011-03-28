<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form id="setting" method="post" action="?method=install" onsubmit="return checkForm(this, checkPass)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr> 
				<td align="center" colspan=2" class="cat"><!--title--> - “<!--name-->”</td>
			</tr>
			<tr> 
				<td colspan=2" class="row" style="line-height:18px;">
				<b>插件名称：</b><!--name--><br />
				<b>插件索引：</b><!--idx--><br />
				<b>插件板本：</b><!--ver--><br />
				<b>入口类名：</b><!--class--><br />
				<b>功能描述：</b><!--intro--><br />
				<b>版权信息：</b><!--copyright--><br />
				<b>检测信息：</b><!--check-->
				</td>
			</tr>
			<tr> 
				<td colspan=2" class="row" style="line-height:18px;"><!--description--></td>
			</tr>
<?PHP
$language = $setting['language'];
include(ROOT_PATH."/plugin/".$idx."/config.php");
include(ROOT_PATH."/plugin/".$idx."/config-detail.php");

if(!isset($setting_type)) {
	echo <<<content
			<tr> 
				<td colspan="2" align="center" class="row" style="font-size:24px;font-weight:bold;">{$setting['language']['admin_web_plugin_err']}</td>
			</tr>
content;
} else {
	foreach($setting_type as $key => $value) {
		if($value[0]=="checkbox") {
			$theValue = explode(",", $plugin_setting[$idx][$key]);
			$plugin_setting[$idx][$key] = array();
			$i=0;
			foreach($value[1] as $key2 => $value2) {
				$plugin_setting[$idx][$key][$i++] = (array_search((STRING)$value2, $theValue)!==false);
			}
		}
	}
	foreach($plugin_setting[$idx] as $key => $value) {
			$cur_comment = $setting_comm[$key];
			$cur_description = $setting_descr[$key];
			switch($setting_type[$key][0]) {
				case "text":
					$cur_component = '<input type="text" name="plugin_setting['.$idx.']['.$key.']" value="'.any2str($value).'" maxlength="'.$setting_type[$key][2].'"'.($setting_type[$key][1]===false?'':(' need="'.$setting_type[$key][1].'"')).' />';
					break;
				case "password":
					$cur_component = '
						<input type="password" id="'.$idx.'_'.$key.'" name="plugin_setting['.$idx.']['.$key.']" value="'.$value.'" maxlength="'.$setting_type[$key][2].'" />
						<span class="comment">'.$cur_description.'</span>
					</td>
				<tr>
					<td class="cat" align="right">'.$language['admin_psw'].'</td>
					<td class="row">
						<input type="password" id="'.$idx.'_'.$key.'_r" name="setting['.$idx.']['.$key.'_r]" value="'.$value.'" maxlength="'.$setting_type[$key][2].'" />
					';
					$cur_description = $language['admin_psw_desc'];
					break;
				case "checkbox":
					$cur_component = '';
					$i = 0;
					foreach($setting_type[$key][1] as $key3 => $value3) {
						$checked = $plugin_setting[$idx][$key][$i++]?"checked":"";
						$cur_component .= '<input type="checkbox" class="cbox" id="plugin_setting['.$idx.']['.$key.']['.$key3.']" name="plugin_setting['.$idx.']['.$key.'][]" value="'.$value3.'" '.$checked.' / /><label for="plugin_setting['.$idx.']['.$key.']['.$key3.']">'.$key3.'</label> &nbsp; ';
					}
					break;
				case "radio":
					$cur_component = '';
					foreach($setting_type[$key][1] as $key3 => $value3) {
						$value3 = any2str($value3);
						$checked = $value3==any2str($plugin_setting[$idx][$key])?"checked":"";
						$cur_component .= '<input type="radio" class="cbox" id="plugin_setting['.$idx.']['.$key.']['.$key3.']" name="plugin_setting['.$idx.']['.$key.']" value="'.$value3.'" '.$checked.' /><label for="plugin_setting['.$idx.']['.$key.']['.$key3.']">'.$key3.'</label> &nbsp; '."\n";
					}
					break;
				case "select":
					$cur_component = "<select name=\"plugin_setting[{$idx}][{$key}]\">\n";
					foreach($setting_type[$key][1] as $key3 => $value3) {
						$value3 = any2str($value3);
						$checked = $value3==any2str($plugin_setting[$idx][$key])?"selected":"";
						$cur_component .= '<option value="'.$value3.'" '.$checked.'>'.$key3.'</option>'."\n";
					}
					$cur_component .= "</select>";
					break;
				default:
					$cur_component = '<input name="plugin_setting['.$idx.']['.$key.']" value="'.$value.'" />';
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
?>
			<tr> 
				<td align="center" colspan=2" class="cat">
					<input type="hidden" value="<!--idx-->" name="idx" />
					<input class="btn" type="Submit" value=" 安 装 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script Language="JavaScript">
function checkPass() {
	var theObjs = $("#setting input:password[id$=_r]");
	for(var i=0; i<theObjs.length; i++) {
		if($id(theObjs[i].id.replace(/_r$/, "")).value!=theObjs[i].value) {
			alert("两次输入密码请保持一致！");
			$id(theObjs[i].id.replace(/_r$/, "")).focus();
			return false;
		}
	}
	theObjs.remove();
	return true;
}
</script>