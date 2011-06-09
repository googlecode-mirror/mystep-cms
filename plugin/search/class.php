<?php
class plugin_search implements plugin {
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
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['var'].'", "'.$info['plugin_cfna'].'", 1, "'.$info['intro'].'", "'.$info['copyright'].'", 1)');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 7, '".$info['cat_name_1']."', 'se_manager.php?method=engine', '../plugin/search/', 0, 0, '".$info['cat_desc_1']."')");
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 5, '".$info['cat_name_2']."', 'se_manager.php?method=keyword', '../plugin/search/', 0, 0, '".$info['cat_desc_2']."')");
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_install']."
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
			showInfo($setting['language']['plugin_install_done']);
		}
	}
	
	public static function uninstall() {
		global $db, $setting, $admin_cat;
		$info = self::info();
		$db->query("truncate table ".$setting['db']['pre']."search_keyword");
		$db->query("drop table ".$setting['db']['pre']."search_keyword");
		$db->query("delete from ".$setting['db']['pre']."plugin where idx='".$info['idx']."'");
		$db->query("delete from ".$setting['db']['pre']."admin_cat where file like 'se_manager.php%'");
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
			showInfo($setting['language']['plugin_uninstall_done']);
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
			"/se.php",
		);
		foreach($theList as $cur) {
			if(isWriteable(dirname(__FILE__).$cur)) {
				$result .= $cur . ' <span style="color:green">Writable</span><br />';
			} else {
				$result .= $cur . ' <span style="color:red">Readonly</span><br />';
			}
		}
		return $result;
	}
	
	public static function tag_search(MyTPL $tpl, $att_list = array()) {
		$cur_content = $tpl->Get_TPL(dirname(__FILE__)."/block_search.tpl");
		foreach($att_list as $key => $value) {
			$value = preg_replace("/^(\{.+\})$/", '<?="\1"?>', $value);
			$cur_content = str_replace($tpl->delimiter_l.$key.$tpl->delimiter_r, $value, $cur_content);
		}
		$se_file = dirname(__FILE__)."/se.php";
		include($se_file);
		$se = var_export($se, true);
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit_blank = preg_replace("/".preg_quote($tpl->delimiter_l).".*?".preg_quote($tpl->delimiter_r)."/is", "", $unit);
		$unit_blank = preg_replace("/<(td|li|p|dd|dt)([^>]*?)>.*?<\/\\1>/is", "<\\1\\2>&nbsp;</\\1>", $unit_blank);
		$unit_blank = addslashes($unit_blank);
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."search_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $unit);
		$result = <<<mytpl
<?php
include("{$se_file}");
foreach(\$se as \$key => \$value) {
	\$record['idx'] = \$key;
	echo <<<content
{$unit}
content;
	echo "\\n";
}
?>
mytpl;
		$result = str_replace($block, $result, $cur_content);
		return $result;
	}
	
	
	public static function tag_keyword(MyTPL $tpl, $att_list = array()) {
		if(!isset($att_list['limit'])) $att_list['limit'] = 10;
		$cur_content = $tpl->Get_TPL(dirname(__FILE__)."/block_keyword.tpl");
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit_blank = preg_replace("/".preg_quote($tpl->delimiter_l).".*?".preg_quote($tpl->delimiter_r)."/is", "", $unit);
		$unit_blank = preg_replace("/<(td|li|p|dd|dt)([^>]*?)>.*?<\/\\1>/is", "<\\1\\2>&nbsp;</\\1>", $unit_blank);
		$unit_blank = addslashes($unit_blank);
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."keyword_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $unit);
		$result = <<<mytpl
<?php
\$result = getData("select keyword from ".\$setting['db']['pre']."search_keyword order by `count` desc limit {$att_list['limit']}", "all", 60*60*24);
\$max_count = count(\$result);
for(\$num=0; \$num<\$max_count; \$num++) {
	\$record = \$result[\$num];
	\$record["encode"] = urlencode(\$record["keyword"]);
	HtmlTrans(&\$record);
	echo <<<content
{$unit}
content;
	echo "\\n";
	unset(\$record);
}
unset(\$result);
?>
mytpl;
		$result = str_replace($block, $result, $cur_content);
		return $result;
	}
}
?>