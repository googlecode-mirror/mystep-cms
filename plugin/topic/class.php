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
		global $db, $setting, $admin_cat;
		$strFind = array("{pre}", "{charset}");
		$strReplace = array($setting['db']['pre'], $setting['db']['charset']);
		$result = $db->ExeSqlFile(dirname(__FILE__)."/install.sql", $strFind, $strReplace);
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['var'].'", "'.$info['plugin_topic'].'", 1, "'.$info['intro'].'", "'.$info['copyright'].'", 1)');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 4, '".$info['cat_name']."', 'topic.php', '../plugin/topic/', 0, 0, '".$info['cat_desc']."')");
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
		$db->query("truncate table ".$setting['db']['pre']."topic");
		$db->query("drop table ".$setting['db']['pre']."topic");
		$db->query("truncate table ".$setting['db']['pre']."topic_link");
		$db->query("drop table ".$setting['db']['pre']."topic_link");
		$db->query("delete from ".$setting['db']['pre']."admin_cat where file like 'topic.php%'");
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
			MultiDel(dirname(__FILE__)."/topic/");
			MakeDir(dirname(__FILE__)."/topic/");
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
			"/topic/",
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
		
		$style_list = mysql_real_escape_string($db->getSingleResult("select topic_cat from ".$setting['db']['pre']."topic where topic_id='{$att_list['id']}'"));
		$str_sql = "select id, link_name as subject, link_cat, link_url, add_date from ".$setting['db']['pre']."topic_link where topic_id='{$att_list['id']}'";
		if(!empty($att_list['cat'])) $str_sql .= " and link_cat=".$att_list['cat'];
		if(!empty($att_list['condition'])) $str_sql .= " and (".$att_list['condition'].")";
		$str_sql .= " order by ".$att_list['order'];
		$str_sql .= " limit ".$att_list['limit'];
		
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
\$result = getData("{$str_sql}", "all", 86400);
\$max_count = count(\$result);
for(\$num=0; \$num<\$max_count; \$num++) {
	\$record = \$result[\$num];
	HtmlTrans(&\$record);
	\$record['link'] = \$record['link_url'];
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
		
		$str_sql = "select topic_id as id, topic_name as subject, topic_idx, add_date from ".$setting['db']['pre']."topic where 1=1";
		if(!empty($att_list['condition'])) $str_sql .= " and (".$att_list['condition'].")";
		$str_sql .= " order by ".$att_list['order'];
		$str_sql .= " limit ".$att_list['limit'];
		
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
\$result = getData("{$str_sql}", "all", 86400);
\$max_count = count(\$result);
for(\$num=0; \$num<\$max_count; \$num++) {
	\$record = \$result[\$num];
	HtmlTrans(&\$record);
	\$record['link'] = "module.php?m=topic&idx=".\$record['topic_idx'];
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