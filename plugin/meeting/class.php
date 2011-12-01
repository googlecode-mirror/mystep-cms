<?php
class plugin_meeting implements plugin {
	public static function install() {
		global $setting;
		$info = self::info();
		if($plugin_info = getParaInfo("plugin", "idx", $info['idx'])) {
			showInfo(sprintf($setting['language']['plugin_err_dup'], $info['name']));
		}
		if($plugin_info = getParaInfo("plugin", "class", $info['class'])) {
			showInfo(sprintf($setting['language']['plugin_err_classname'], $info['name']));
		}
		global $db, $setting, $admin_cat;
		$strFind = array("{pre}", "{charset}");
		$strReplace = array($setting['db']['pre'], $setting['db']['charset']);
		$result = $db->ExeSqlFile(dirname(__FILE__)."/install.sql", $strFind, $strReplace);
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['ver'].'", "plugin_meeting", 1, "'.$info['intro'].'", "'.$info['copyright'].'", 1)');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 0, '会议', 'meeting.php', '../plugin/meeting/', 0, 0, '".$info['intro']."')");
		$new_id = $db->GetInsertId();
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_install']."
			<br />
			<pre>
			".join("\n------------------------\n", $err)."
			</pre>
			");
		} else {
			WriteFile(dirname(__FILE__)."/config.php", "<?php
\$catid = {$new_id};
?>", "wb");
			deleteCache("admin_cat");
			includeCache("admin_cat");
			$admin_cat = toJson($admin_cat, $setting['gen']['charset']);
			echo <<<mystep
<script language="javascript">
parent.admin_cat = {$admin_cat};
parent.setNav();
</script>
mystep;
			deleteCache("plugin");
			buildParaList("plugin");
			echo showInfo($setting['language']['plugin_install_done'], false);
		}
	}
	
	public static function uninstall() {
		global $db, $setting, $admin_cat;
		$info = self::info();
		$db->Query("select mid from ".$setting['db']['pre']."meeting");
		$sql_list = array();
		while($record = $db->GetRS()) {
			$sql_list[] = "truncate table ".$setting['db']['pre']."meeting_".$record['mid'];
			$sql_list[] = "drop table ".$setting['db']['pre']."meeting_".$record['mid'];
			unlink(dirname(__FILE__)."/tpl/{$record['mid']}_regist_cn.tpl");
			unlink(dirname(__FILE__)."/tpl/{$record['mid']}_regist_en.tpl");
			unlink(dirname(__FILE__)."/tpl/{$record['mid']}_reglist_cn.tpl");
			unlink(dirname(__FILE__)."/tpl/{$record['mid']}_reglist_en.tpl");
			unlink(dirname(__FILE__)."/tpl/{$record['mid']}_mail_cn.tpl");
			unlink(dirname(__FILE__)."/tpl/{$record['mid']}_mail_en.tpl");
			unlink(dirname(__FILE__)."/tpl/{$record['mid']}_edit_reg.tpl");
			unlink(dirname(__FILE__)."/setting/{$record['mid']}.php");
		}
		$db->Free();
		$db->BatchExec($sql_list);
		include("config.php");
		if(isset($catid) && $catid!=0)	$db->query("delete from ".$setting['db']['pre']."admin_cat where pid='".$catid."'");
		$db->query("truncate table ".$setting['db']['pre']."meeting");
		$db->query("drop table ".$setting['db']['pre']."meeting");
		$db->query("delete from ".$setting['db']['pre']."admin_cat where name='会议'");
		$db->query("delete from ".$setting['db']['pre']."plugin where idx='".$info['idx']."'");
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_uninstall']."
			<br />
			<pre>
			".join("\n------------------------\n", $err)."
			</pre>
			");
		} else {
			deleteCache("admin_cat");
			includeCache("admin_cat");
			$admin_cat = toJson($admin_cat, $setting['gen']['charset']);
			echo <<<mystep
<script language="javascript">
parent.admin_cat = {$admin_cat};
parent.setNav();
</script>
mystep;
			deleteCache("plugin");
			buildParaList("plugin");
			WriteFile(dirname(__FILE__)."/config.php", '<?php
$catid = 0;
?>', "wb");
			echo showInfo($setting['language']['plugin_uninstall_done'], false);
		}
	}
	
	public static function info() {
		$info = null;
		if(is_file(dirname(__FILE__)."/info.php")) include(dirname(__FILE__)."/info.php");
		return $info;
	}
	
	public static function check() {
		$result = "";
		$theList = array(
			"/",
			"/tpl/",
			"/setting/",
		);
		foreach($theList as $cur) {
			if(isWriteable(dirname(__FILE__).$cur)) {
				$result .= $cur . ' - <span style="color:green">Writable</span><br />';
			} else {
				$result .= $cur . ' - <span style="color:red">Readonly</span><br />';
			}
		}
		return $result;
	}
	
	public static function tag_reg(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['mid'])) return "";
		if(!isset($att_list['lng'])) $att_list['lng'] = "cn";
		if(!isset($att_list['order'])) $att_list['order'] = "id desc";
		if(!isset($att_list['limit'])) $att_list['limit'] = 0;
		if(!isset($att_list['loop'])) $att_list['loop'] = 0;
		if(!isset($att_list['condition'])) $att_list['condition'] = "";
		
		$str_sql = "select * from ".$setting['db']['pre']."meeting_".$att_list['mid']." where 1=1";
		if(!empty($att_list['condition'])) $str_sql .= " and (".$att_list['condition'].")";
		$str_sql .= " order by ".$att_list['order'];
		if(!empty($att_list['limit'])) $str_sql .= " limit ".$att_list['limit'];
		
		$cur_content = $tpl->Get_TPL(dirname(__FILE__)."/tpl/block_reg".($att_list['lng']=="en"?"_en":"_cn").".tpl");
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit_blank = preg_replace("/".preg_quote($tpl->delimiter_l).".*?".preg_quote($tpl->delimiter_r)."/is", "", $unit);
		$unit_blank = preg_replace("/<(td|li|p|dd|dt)([^>]*?)>.*?<\/\\1>/is", "<\\1\\2>&nbsp;</\\1>", $unit_blank);
		$unit_blank = addslashes($unit_blank);
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."reg_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $unit);
		$result = <<<mytpl
<?php
\$db->Query("{$str_sql}");
while(\$record=\$db->getRS()) {
	HtmlTrans(&\$record);
	echo <<<content
{$unit}
content;
	echo "\\n";
	unset(\$record);
}
for(; \$n<{$att_list['loop']}-1; \$n++) {
	echo "{$unit_blank}";
	echo "\\n";
}
?>
mytpl;
		$result = str_replace($block, $result, $cur_content);
		return $result;
	}
}
?>