<?php
class plugin_topic implements plugin {
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
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_topic",1,$info['intro'],$info['copyright'],1,""));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,7,$info['cat_name'],'topic.php', '../plugin/topic/', 0, 0,$info['cat_desc']));
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
		$db->delete($setting['db']['pre']."topic");
		$db->exec("drop","table",$setting['db']['pre']."topic");
		$db->delete($setting['db']['pre']."topic_link");
		$db->exec("drop","table",$setting['db']['pre']."topic_link");
		$db->delete($setting['db']['pre']."admin_cat", array("file","=","topic.php"));
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
			MultiDel(dirname(__FILE__)."/topic/");
			MakeDir(dirname(__FILE__)."/topic/");
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
			"/topic/",
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
	
	public static function topic(MyTPL $tpl, $att_list = array()) {
		global $setting, $db;
		$result = "";
		if(!isset($att_list['id'])) return "";
		if(!isset($att_list['cat'])) $att_list['cat'] = "";
		if(!isset($att_list['order'])) $att_list['order'] = "id desc";
		if(!isset($att_list['limit'])) $att_list['limit'] = 10;
		if(!isset($att_list['loop'])) $att_list['loop'] = 0;
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		if(!isset($att_list['condition'])) $att_list['condition'] = "";
		if(!isset($att_list['show_catalog'])) $att_list['show_catalog'] = "";
		if(!isset($att_list['show_date'])) $att_list['show_date'] = "";
		if(!empty($att_list['show_date']) && date($att_list['show_date'])==$att_list['show_date']) $att_list['show_date'] = "Y-m-d";
		
		
		$condition = array();
		$condition[] = array("topic_id","n=",$att_list['id']);
		$style_list = mysql_real_escape_string($db->result($setting['db']['pre']."topic","topic_cat",$condition));
		
		if(!empty($att_list['cat'])) $condition[] = array("link_cat","=",$att_list['cat']);
		$sql = $db->buildSel($setting['db']['pre']."topic_link","id, link_name as subject, link_cat, link_url as link, add_date",$condition,array("order"=>$att_list['order'],"limit"=>$att_list['limit'],"condition"=>$att_list['condition']));
		
		$content = $tpl->Get_TPL(dirname(__FILE__)."/tpl/block_news_".$att_list['template'].".tpl", dirname(__FILE__)."/tpl/block_news_classic.tpl");
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit_blank = preg_replace("/".preg_quote($tpl->delimiter_l).".*?".preg_quote($tpl->delimiter_r)."/is", "", $unit);
		$unit_blank = preg_replace("/<(td|li|p|dd|dt)([^>]*?)>.*?<\/\\1>/is", "<\\1\\2>&nbsp;</\\1>", $unit_blank);
		$unit_blank = addslashes($unit_blank);
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."news_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $unit);
		
		$result = <<<mytpl
<?php
\$style_list = explode(",", "{$style_list}");
\$result = getData("{$sql}", "all", 86400);
for(\$n=0,\$m=count(\$result); \$n<\$m; \$n++) {
	\$record = \$result[\$n];
	HtmlTrans(&\$record);
	\$record['subject_org'] = \$record['subject'];
	\$record['add_date'] = ("{$att_list['show_date']}"!="") ? date("{$att_list['show_date']}", strtotime(\$record['add_date'])) : "";
	\$record['catalog'] = "";
	if("{$att_list['show_catalog']}"!="") {
		\$record['catalog'] = "[".\$style_list[\$record['link_cat']]."]";
	}
	echo <<<content
{$unit}
content;
	echo "\\n";
	unset(\$record);
}
unset(\$result);
for(; \$n<{$att_list['loop']}; \$n++) {
	\$unit = str_replace("style=\"\"", "style=\"".(\$n%2?"{$att_list['css1']}":"{$att_list['css2']}")."\"", "{$unit_blank}");
	echo \$unit;
	echo "\\n";
}
?>
mytpl;
		$content = str_replace($block, $result, $content);
		return $content;
	}
	
	public static function getUrl($url, $idx="", $page=1) {
		global $setting;
		if($setting['rewrite']['enable']) {
			$url .= "/topic/".$idx;
		} else {
			$url .= "/module.php?m=topic&id=".$idx;
		}
		$url = str_replace("//", "/", $url);
		$url = str_replace("http:/", "http://", $url);
		return $url;
	}
	
	public static function topic_list(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['order'])) $att_list['order'] = "id desc";
		if(!isset($att_list['limit'])) $att_list['limit'] = 10;
		if(!isset($att_list['loop'])) $att_list['loop'] = 0;
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		if(!isset($att_list['condition'])) $att_list['condition'] = "";
		if(!isset($att_list['show_date'])) $att_list['show_date'] = "";
		if(!empty($att_list['show_date']) && date($att_list['show_date'])==$att_list['show_date']) $att_list['show_date'] = "Y-m-d";

		$sql = $db->buildSel($setting['db']['pre']."topic","topic_id as id, topic_name as subject, topic_idx, topic_link, add_date","",$att_list);
		$content = $tpl->Get_TPL(dirname(__FILE__)."/tpl/block_news_".$att_list['template'].".tpl", dirname(__FILE__)."/tpl/block_news_classic.tpl");
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit_blank = preg_replace("/".preg_quote($tpl->delimiter_l).".*?".preg_quote($tpl->delimiter_r)."/is", "", $unit);
		$unit_blank = preg_replace("/<(td|li|p|dd|dt)([^>]*?)>.*?<\/\\1>/is", "<\\1\\2>&nbsp;</\\1>", $unit_blank);
		$unit_blank = addslashes($unit_blank);
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."news_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $unit);
		
		$result = <<<mytpl
<?php
\$result = getData("{$sql}", "all", 86400);
for(\$n=0,\$m=count(\$result); \$n<\$m; \$n++) {
	\$record = \$result[\$n];
	HtmlTrans(&\$record);
	if(empty(\$record['topic_link'])) {
		\$record['link'] = getUrl("topic", \$record['topic_idx']);
	} else {
		\$record['link'] = \$record['topic_link'];
	}
	\$record['add_date'] = ("{$att_list['show_date']}"!="") ? date("{$att_list['show_date']}", strtotime(\$record['add_date'])) : "";
	\$record['catalog'] = "";
	echo <<<content
{$unit}
content;
	echo "\\n";
	unset(\$record);
}
unset(\$result);
for(; \$n<{$att_list['loop']}; \$n++) {
	\$unit = str_replace("style=\"\"", "style=\"".(\$n%2?"{$att_list['css1']}":"{$att_list['css2']}")."\"", "{$unit_blank}");
	echo \$unit;
	echo "\\n";
}
?>
mytpl;
		$result = str_replace($block, $result, $content);
		return $result;
	}
}
?>