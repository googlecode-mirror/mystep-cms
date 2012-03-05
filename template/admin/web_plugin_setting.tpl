<div class="title"><!--title--></div>
<div align="center">
	<script src="../script/checkForm.js" Language="JavaScript1.2"></script>
	<form id="setting" method="post" action="?method=setting_ok" onsubmit="return checkForm(this, checkPass)">
		<table id="input_area" cellspacing="0" cellpadding="0" align="center">
			<tr>
				<td align="center" colspan=2" class="cat">“<!--name-->”参数设置</td>
			</tr>
			<tr>
				<td colspan=2" class="row" style="line-height:18px;"><!--description--></td>
			</tr>
<?PHP
$language = $setting['language'];
$the_file = ROOT_PATH."/plugin/".$idx."/config.php";
if(file_exists($the_file)) {
	include($the_file);
	$flag = true;
	$the_path = ROOT_PATH."/plugin/".$idx."/config/";
	if(isset($setting['gen']['language'])) {
		if(is_file($the_path.$setting['gen']['language'].".php")) {
			include($the_path.$setting['gen']['language'].".php");
			$flag = false;
		}
	}
	if($flag) include($the_path."/default.php");
	unset($flag, $the_path);
}
unset($the_file);

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
						$cur_component .= '<input type="checkbox" class="cbox" id="plugin_setting['.$idx.']['.$key.']['.$key3.']" name="plugin_setting['.$idx.']['.$key.'][]" value="'.$value3.'" '.$checked.' /><label for="plugin_setting['.$idx.']['.$key.']['.$key3.']">'.$key3.'</label> &nbsp; ';
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
				<td class="cat" align="right">子站赋权</td>
				<td class="row">
					<div id="subweb" style="width:500px;">
						<input type="checkbox" onclick="checkAll('subweb');" id="subweb_all" class="cbox" name="subweb[]" value="all" /><label for="subweb_all"> 全部权限</label><br />
<!--loop:start key="subweb"-->
						<input type="checkbox" onclick="checkStatus('subweb');" id="subweb_<!--subweb_web_id-->" class="cbox" name="subweb[]" value="<!--subweb_web_id-->" <!--subweb_checked--> /><label for="subweb_<!--subweb_web_id-->" /> <!--subweb_name--></label> <br />
<!--loop:end-->
					</div>
				</td>
			</tr>
			<tr>
				<td align="center" colspan=2" class="cat">
					<input type="hidden" value="<!--idx-->" name="idx" />
					<input class="btn" type="Submit" value=" 确 定 " />&nbsp;&nbsp;
					<input class="btn" type="reset" value=" 重 置 " />&nbsp;&nbsp;
					<input class="btn" type="button" value=" 打 包 " onClick="location.href='?method=pack&idx=<!--idx-->'" />&nbsp;&nbsp;
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
function checkAll(checkSet, sign) {
	var objs = document.getElementsByName(checkSet + "[]");
	var flag = $id(checkSet+"_all").checked;
	if(typeof(sign)!=="undefined") flag = sign;
	for(var i=0; i<objs.length; i++) {
		objs[i].checked = flag;
	}
}
function checkStatus(checkSet) {
	var objs = document.getElementsByName(checkSet + "[]");
	if(objs.length<2) return;
	var curStatus = objs[1].checked;
	var flag = curStatus?1:0;
	for(var i=1; i<objs.length; i++) {
		if(objs[i].checked==curStatus) continue;
		flag = 2;
		break;
	}
	var obj = $id(checkSet+"_all");
	if(flag==2) {
		$id(checkSet+"_all").checked = false;
		$id(checkSet+"_all").indeterminate = true;
	} else {
		$id(checkSet+"_all").checked = (flag==1);
		$id(checkSet+"_all").indeterminate = false;
	}
}
$(function(){
	if("<!--subweb-->"=="") checkAll('subweb', true);
	checkStatus('subweb');
});
</script>