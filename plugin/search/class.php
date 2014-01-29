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
		global $db, $admin_cat;
		$strFind = array("{pre}", "{charset}");
		$strReplace = array($setting['db']['pre'], $setting['db']['charset']);
		$result = $db->ExeSqlFile(dirname(__FILE__)."/install.sql", $strFind, $strReplace);
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_search",1,$info['intro'],$info['copyright'],1,""));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,7,$info['cat_name_1'],'search.php?method=engine', '../plugin/search/', 0, 0,$info['cat_desc_1']));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,5,$info['cat_name_2'],'search.php?method=keyword', '../plugin/search/', 0, 0,$info['cat_desc_2']));
		deleteCache("admin_cat");
		deleteCache("plugin");
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_install']."
			<br />
			<pre>
			".join("\n------------------------\n", $err)."
			</pre>
			");
		} else {
			includeCache("admin_cat");
			$admin_cat = toJson($admin_cat, $setting['gen']['charset']);
			echo <<<mystep
<script language="javascript">
parent.admin_cat = {$admin_cat};
parent.setNav();
</script>
mystep;
			buildParaList("plugin");
			echo showInfo($setting['language']['plugin_install_done'], false);
		}
	}
	
	public static function uninstall() {
		global $db, $setting, $admin_cat;
		$info = self::info();
		$db->delete($setting['db']['pre']."search_keyword");
		$db->exec("drop","table",$setting['db']['pre']."search_keyword");
		$db->delete($setting['db']['pre']."admin_cat", array("file","like","search.php%"));
		$db->delete($setting['db']['pre']."plugin", array("idx","=",$info['idx']));
		deleteCache("admin_cat");
		deleteCache("plugin");
		$err = array();
		if($db->GetError($err)) {
			showInfo($setting['language']['plugin_err_uninstall']."
			<br />
			<pre>
			".join("\n------------------------\n", $err)."
			</pre>
			");
		} else {
			includeCache("admin_cat");
			$admin_cat = toJson($admin_cat, $setting['gen']['charset']);
			echo <<<mystep
<script language="javascript">
parent.admin_cat = {$admin_cat};
parent.setNav();
</script>
mystep;
			buildParaList("plugin");
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
			"/se.php",
		);
		$error = false;
		foreach($theList as $cur) {
			if(isWriteable(dirname(__FILE__).$cur)) {
				$result .= $cur . ' - <span style="color:green">Writable</span><br />';
			} else {
				$result .= $cur . ' - <span style="color:red">Readonly</span><br />';
				$error = true;
			}
		}
		if($error) $result .= '<span id="error"></span>';
		return $result;
	}
	
	public static function tag_search(MyTPL $tpl, $att_list = array()) {
		$cur_content = $tpl->Get_TPL(dirname(__FILE__)."/tpl/block_search.tpl");
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
	
	public static function getUrl($url, $idx, $page=1) {
		global $setting;
		if($setting['rewrite']['enable']) {
			$url .= "/search/".$idx."/".$page;
		} else {
			$url .= "/module.php?m=search&k=".$idx."&page=".$page;
		}
		return $url;
	}
	
	public static function tag_keyword(MyTPL $tpl, $att_list = array()) {
		global $db,$setting;
		if(!isset($att_list['limit'])) $att_list['limit'] = 10;
		if(!isset($att_list['order'])) $att_list['order'] = "chg_date";
		$cur_content = $tpl->Get_TPL(dirname(__FILE__)."/tpl/block_keyword.tpl");
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit_blank = preg_replace("/".preg_quote($tpl->delimiter_l).".*?".preg_quote($tpl->delimiter_r)."/is", "", $unit);
		$unit_blank = preg_replace("/<(td|li|p|dd|dt)([^>]*?)>.*?<\/\\1>/is", "<\\1\\2>&nbsp;</\\1>", $unit_blank);
		$unit_blank = addslashes($unit_blank);
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."keyword_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $unit);
		$sql = $db->buildSel($setting['db']['pre']."search_keyword","keyword", array(array("amount","n>","0","and"),array("chg_date","f>","UNIX_TIMESTAMP()-604800","and"),array("length(keyword)","n>","4","and"),array("length(keyword)","n<","30","and")),array("order"=>$att_list['order'],"limit"=>$att_list['limit']));
		$result = <<<mytpl
<?php
\$result = getData("{$sql}", "all", 60*60*24);
for(\$num=0,\$m=count(\$result); \$num<\$m; \$num++) {
	\$record = \$result[\$num];
	\$record["encode"] = urlencode(\$record["keyword"]);
	\$record["url"] = getUrl("search", \$record["keyword"]);
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