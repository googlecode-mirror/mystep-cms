<div class="title"><!--title--></div>
<div align="left">
	<script src="../script/checkForm.js" language="JavaScript" type="text/javascript"></script>
	<form method="post" action="?method=<!--method-->_ok" onsubmit="return checkForm(this)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td class="cat" width="120">子站名称：<span>*</span></td>
				<td class="row">
					<input name="web_id" type="hidden" value="<!--web_id-->" />
					<input type="text" name="name" value="<!--name-->" need="" />
					<span class="comment">（将显示在浏览器标题栏的网站名称）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">网站索引：<span>*</span></td>
				<td class="row">
					<input type="text" name="idx" value="<!--idx-->" need="word" />
					<span class="comment">（网站内部索引，只能为英文或数字）</span>
				</td>
			</tr>
			<tr>
				<td class="cat">网站域名：<span>*</span></td>
				<td class="row">
					<input type="text" name="host" value="<!--host-->" need="" />
					<span class="comment">（多个域名请用半角逗号间隔）</span>
				</td>
			</tr>
			<tr>
				<td class="cat" colspan="2">子站参数设置：</td>
			</tr>
<?PHP
$language = $setting['language'];
include(ROOT_PATH."/include/config.php");
include(ROOT_PATH."/include/config-detail.php");

$setting_skip = array();
$setting_skip['web'] = array();
$setting_skip['web']['url'] = '';
$setting_skip['web']['email'] = '';
$setting_skip['web']['title'] = '';
$setting_skip['web']['s_user'] = '';
$setting_skip['web']['s_pass'] = '';
$setting_skip['web']['cache_mode'] = '';
$setting_skip['web']['sign'] = '';
$setting_skip['db'] = array();
$setting_skip['db']['host'] = '';
$setting_skip['db']['user'] = '';
$setting_skip['db']['pass'] = '';
$setting_skip['db']['pconnect'] = '';
$setting_skip['db']['charset'] = '';
$setting_skip['db']['pconnect'] = '';
$setting_skip['gen'] = array();
$setting_skip['gen']['charset'] = '';
$setting_skip['gen']['gzip_level'] = '';
$setting_skip['gen']['cache'] = '';
$setting_skip['gen']['rewrite'] = '';
$setting_skip['gen']['cache_ext'] = '';
$setting_skip['gen']['timezone'] = '';
$setting_skip['gen']['update'] = '';
$setting_skip['gen']['minify'] = '';
$setting_skip['gen']['etag'] = '';
$setting_skip['js']['debug'] = '';
$setting_skip['rewrite']['enable'] = '';
$setting_skip['rewrite']['read'] = '';
$setting_skip['rewrite']['list'] = '';
$setting_skip['rewrite']['tag'] = '';
$setting_skip['email']['mode'] = '';
$setting_skip['email']['smtp'] = '';
$setting_skip['email']['port'] = '';
$setting_skip['email']['user'] = '';
$setting_skip['email']['password'] = '';
$setting_skip['list'] = array();
$setting_skip['list']['txt'] = '';
$setting_skip['list']['img'] = '';
$setting_skip['list']['mix'] = '';
$setting_skip['list']['rss'] = '';
$setting_skip['session'] = array();
$setting_skip['session']['expire'] = '';
$setting_skip['session']['gc'] = '';
$setting_skip['session']['trans_sid'] = '';
$setting_skip['session']['name'] = '';
$setting_skip['session']['mode'] = '';
$setting_skip['cookie'] = array();
$setting_skip['cookie']['path'] = '';
$setting_skip['cookie']['prefix'] = '';
$setting_skip['path'] = array();
$setting_skip['path']['admin'] = '';
$setting_skip['path']['template'] = '';
$setting_skip['path']['cache'] = '';
$setting_skip['path']['upload'] = '';
$setting_skip['content'] = array();
$setting_skip['content']['max_length'] = '';
$setting_skip['content']['get_remote_img'] = '';
$setting_skip['watermark'] = array();
$setting_skip['watermark']['credit'] = '';
$setting_skip['memcache'] = array();
$setting_skip['memcache']['server'] = '';
$setting_skip['memcache']['weight'] = '';
$setting_skip['memcache']['persistant'] = '';
$setting_skip['memcache']['timeout'] = '';
$setting_skip['memcache']['retry_interval'] = '';
$setting_skip['memcache']['status'] = '';
$setting_skip['memcache']['expire'] = '';
$setting_skip['memcache']['threshold'] = '';
$setting_skip['memcache']['min_savings'] = '';

if($GLOBALS['subweb_idx']) {
	if(is_file(ROOT_PATH."/include/config_".$GLOBALS['subweb_idx'].".php")) {
		include(ROOT_PATH."/include/config_".$GLOBALS['subweb_idx'].".php");
		$setting = arrayMerge($setting, $setting_sub);
	}
}
$setting['watermark']['mode'] = array(($setting['watermark']['mode']&1)==1, ($setting['watermark']['mode']&2)==2);


$cur_section = "";
foreach($setting as $key1 => $value1) {
	if(count($setting_skip[$key1]) == count($setting[$key1])) continue;
	if($cur_section!=$key1) {
		$cur_comment = $setting_comm[$key1."_comm"];
		$cur_section = $key1;
		echo <<<content
			<tr style="display:none;">
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
?>
			<tr class="row">
				<td align="center" colspan=2">
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 返 回 " onClick="location.href='<!--back_url-->'" />
				</td>
			</tr>
		</table>
	</form>
</div>
