<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="120">网站名称：</td>
				<td class="row">
					<input name="web_id" type="hidden" value="<!--web_id-->">
					<input type="text" name="name" value="<!--name-->"  need=""/>
				</td>
			</tr>
			<tr> 
				<td class="cat">网站索引：</td>
				<td class="row">
					<input type="text" name="idx" value="<!--idx-->"  need="" onkeyup="if('<!--method-->'=='add'){var obj=document.getElementsByName('setting[db][pre]')[0];obj.value=obj.defaultValue+this.value+'_';}" />
				</td>
			</tr>
			<tr> 
				<td class="cat">网站域名：</td>
				<td class="row">
					<input type="text" name="host" value="<!--host-->"  need=""/>
				</td>
			</tr>
<?PHP
include_once(ROOT_PATH."/include/config-detail.php");

$setting_skip = array();
$setting_skip['web'] = array();
$setting_skip['web']['url'] = '';
$setting_skip['web']['email'] = '';
$setting_skip['web']['s_user'] = '';
$setting_skip['web']['s_pass'] = '';
$setting_skip['web']['close'] = '';
$setting_skip['web']['close_page'] = '';
$setting_skip['db'] = array();
$setting_skip['db']['host'] = '';
$setting_skip['db']['user'] = '';
$setting_skip['db']['pass'] = '';
$setting_skip['db']['pconnect'] = '';
$setting_skip['db']['charset'] = '';
$setting_skip['db']['pconnect'] = '';
$setting_skip['gen'] = array();
$setting_skip['gen']['language'] = '';
$setting_skip['gen']['charset'] = '';
$setting_skip['gen']['gzip_level'] = '';
$setting_skip['gen']['cache'] = '';
$setting_skip['gen']['rewrite'] = '';
$setting_skip['gen']['cache_ext'] = '';
$setting_skip['list'] = array();
$setting_skip['list']['txt'] = '';
$setting_skip['list']['img'] = '';
$setting_skip['list']['mix'] = '';
$setting_skip['list']['rss'] = '';
$setting_skip['session'] = array();
$setting_skip['session']['expire'] = '';
$setting_skip['session']['path'] = '';
$setting_skip['session']['gc'] = '';
$setting_skip['session']['trans_sid'] = '';
$setting_skip['session']['name'] = '';
$setting_skip['session']['mode'] = '';
$setting_skip['cookie'] = array();
$setting_skip['cookie']['path'] = '';
$setting_skip['cookie']['prefix'] = '';
$setting_skip['path'] = array();
$setting_skip['path']['template'] = '';
$setting_skip['content'] = array();
$setting_skip['content']['max_length'] = '';
$setting_skip['content']['get_remote_img'] = '';
$setting_skip['watermark'] = array();
$setting_skip['watermark']['mode'] = '';
$setting_skip['watermark']['txt'] = '';
$setting_skip['watermark']['img'] = '';
$setting_skip['watermark']['credit'] = '';

if($GLOBALS['web_info']) {
	if(is_file(ROOT_PATH."/include/config_".$GLOBALS['web_info']['idx'].".php")) {
		include_once(ROOT_PATH."/include/config_".$GLOBALS['web_info']['idx'].".php");
	}
}

$cur_section = "";
foreach($setting as $key1 => $value1) {
	if(count($setting_skip[$key1]) == count($setting[$key1])) continue;
	if($cur_section!=$key1) {
		$cur_comment = $setting_comm[$key1."_comm"];
		$cur_section = $key1;
		echo <<<content
			<tr> 
				<td class="cat" colspan="2">{$cur_comment}</td>
			</tr>
content;
		echo "\n";
	}
	foreach($value1 as $key2 => $value2) {
		if(isset($setting_skip[$key1][$key2])) continue;
		$cur_comment = $setting_comm[$key1][$key2];
		$cur_description = $setting_comm[$key1."_descr"][$key2];
		switch($setting_type[$key1][$key2][0]) {
			case "text":
				$cur_component = '<input type="text" name="setting['.$key1.']['.$key2.']" value="'.any2str($value2).'" maxlength="'.$setting_type[$key1][$key2][2].'"'.($setting_type[$key1][$key2][1]===false?'':(' need="'.$setting_type[$key1][$key2][1].'"')).' />';
				break;
			case "password":
				$cur_component = '
					<input type="password" name="setting['.$key1.']['.$key2.']" value="" maxlength="'.$setting_type[$key1][$key2][2].'" />
					<span>'.$cur_description.'</span>
				</td>
			<tr>
				<td class="cat" align="right">重复密码</td>
				<td class="row">
					<input type="password" name="setting['.$key1.']['.$key2.'_r]" value="" maxlength="'.$setting_type[$key1][$key2][2].'" />
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
			<tr> 
				<td align="center" colspan=2" class="cat"> 
					<input class="btn" type="Submit" value=" 确 定 ">&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 ">&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'">
				</td>
			</tr>
		</table>
	</form>
</div>
