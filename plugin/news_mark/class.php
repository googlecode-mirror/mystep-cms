<?php
class plugin_news_mark implements plugin {
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
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['ver'].'", "plugin_news_mark", 1, "'.$info['intro'].'", "'.$info['copyright'].'", 1, "")');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 7, '".$info['cat_name']."', 'news_mark.php', '../plugin/news_mark/', 0, 0, '".$info['cat_desc']."')");
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
			echo showInfo($setting['language']['plugin_install_done'], false);
		}
	}
	
	public static function uninstall() {
		global $db, $setting, $admin_cat;
		$info = self::info();
		$db->query("truncate table ".$setting['db']['pre']."news_mark");
		$db->query("drop table ".$setting['db']['pre']."news_mark");
		$db->query("delete from ".$setting['db']['pre']."admin_cat where file='news_mark.php'");
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
			echo showInfo($setting['language']['plugin_uninstall_done'], false);
		}
	}
	
	public static function info() {
		$info = null;
		if(is_file(dirname(__FILE__)."/info.php")) include(dirname(__FILE__)."/info.php");
		return $info;
	}	
	
	public static function check() {
		//make some check for current plugin
		return "";
	}
	
	public static function setting() {
		$plugin_setting['news_mark'] = null;
		if(is_file(dirname(__FILE__)."/config.php")) include(dirname(__FILE__)."/config.php");
		return $plugin_setting['news_mark'];
	}
	
	public static function news_rank(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['news_id'])) $att_list['news_id'] = $GLOBALS['news_id'];
		if(!isset($att_list['web_id'])) $att_list['web_id'] = $setting['info']['web']['web_id'];
		
		$str_sql = "select * from ".$setting['db']['pre']."news_mark where news_id='".$att_list['news_id']."' and web_id='".$att_list['web_id']."'";
		$content = $tpl->Get_TPL(dirname(__FILE__)."/tpl/news_rank.tpl");
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $content, $block_all);
		
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."rank_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $unit);
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$tpl_para['".$tpl->hash."']['para']['\\1']}", $unit);
		
		$result = <<<mytpl
<?php
global \$plugin_setting;
\$rank_max = \$plugin_setting['news_mark']['rank_max'];
\$rank_min = \$plugin_setting['news_mark']['rank_min'];
\$str_sql = "{$str_sql}";
\$record = getData(\$str_sql, "record", 3600*24);
if(\$record===false) {
	getData(\$str_sql, "remove");
	\$record = array();
	\$record['rank_times']==0;
	\$record['rank_total']==0;
}
\$record['precent'] = \$record['rank_times']==0?0:ceil((\$record['rank_total']/\$record['rank_times']-(\$rank_min)+1)*100/((\$rank_max)-(\$rank_min)+1));
\$record['average'] = \$record['rank_times']==0?0:round(\$record['rank_total']/\$record['rank_times'], 2);
for(\$i=\$rank_min; \$i<=\$rank_max; \$i++) {
	\$record['value'] = \$i;
	echo <<<content
{$unit}
content;
	echo "\\n";
}
?>
mytpl;
		$content = str_replace($block, $result, $content);
		foreach($att_list as $key => $value) {
			$content = str_replace("<!--att_list_".$key."-->", '<?="'.$value.'"?>', $content);
		}
		$content = preg_replace("/".preg_quote($tpl->delimiter_l)."rank_(\w+)".preg_quote($tpl->delimiter_r)."/i", "<?=\$record['\\1']?>", $content);
		$content = preg_replace("/".preg_quote($tpl->delimiter_l)."(\w+)".preg_quote($tpl->delimiter_r)."/i", "<?=\$tpl_para['".$tpl->hash."']['para']['\\1']?>", $content);
		return $content;
	}
	
	public static function news_jump(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['news_id'])) $att_list['news_id'] = $GLOBALS['news_id'];
		if(!isset($att_list['web_id'])) $att_list['web_id'] = $setting['info']['web']['web_id'];
		
		$str_sql = "select * from ".$setting['db']['pre']."news_mark where news_id='".$att_list['news_id']."' and web_id='".$att_list['web_id']."'";
		$content = $tpl->Get_TPL(dirname(__FILE__)."/tpl/news_jump.tpl");
		
		foreach($att_list as $key => $value) {
			$content = str_replace("<!--att_list_".$key."-->", $value, $content);
		}
		$content = preg_replace("/".preg_quote($tpl->delimiter_l)."jump_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $content);
		$content = preg_replace("/".preg_quote($tpl->delimiter_l)."(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$tpl_para['".$tpl->hash."']['para']['\\1']}", $content);
		$result = <<<mytpl
<?php
\$str_sql = "{$str_sql}";
\$record = getData(\$str_sql, "record", 3600*24);
if(\$record===false) {
	getData(\$str_sql, "remove");
	\$record = array();
	\$record['jump'] = 0;
}
echo <<<content
{$content}
content;
?>
mytpl;
		return $result;
	}
	
	public static function news_mark(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		if(!isset($att_list['web_id'])) $att_list['web_id'] = "";
		if(!isset($att_list['cat_id'])) $att_list['cat_id'] = "";
		if(!isset($att_list['css1'])) $att_list['css1'] = "";
		if(!isset($att_list['css2'])) $att_list['css2'] = $att_list['css1'];
		if(!isset($att_list['limit'])) $att_list['limit'] = 10;
		if(!isset($att_list['loop'])) $att_list['loop'] = 0;
		if(!isset($att_list['type'])) $att_list['type'] = "jump";
		if(!isset($att_list['time'])) $att_list['time'] = 7;
		$att_list['time'] *= 60*60*24;
	
		$str_sql = "select * from ".$setting['db']['pre']."news_mark where 1=1";
		if(!empty($att_list['web_id'])) $str_sql .= " and web_id='{$att_list['web_id']}'";
		if(!empty($att_list['cat_id'])) $str_sql .= " and cat_id in ({$att_list['cat_id']})";
		if($att_list['type'] == "jump") {
			$str_sql .= " and jump_time>(UNIX_TIMESTAMP()-".$att_list['time'].") order by jump desc";
		} else {
			$str_sql .= " and rank_time>(UNIX_TIMESTAMP()-".$att_list['time'].") order by rank_total/rank_times desc";
		}
		$str_sql .= ", news_id desc";
		
		if(!empty($att_list['limit'])) $str_sql .= " limit ".$att_list['limit'];
		
		$cur_content = $tpl->Get_TPL($tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_news_{$att_list['template']}.tpl", $tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_news_classic.tpl");
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit_blank = preg_replace("/".preg_quote($tpl->delimiter_l).".*?".preg_quote($tpl->delimiter_r)."/is", "", $unit);
		$unit_blank = preg_replace("/<(td|li|p|dd|dt)([^>]*?)>.*?<\/\\1>/is", "<\\1\\2>&nbsp;</\\1>", $unit_blank);
		$unit_blank = addslashes($unit_blank);
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."news_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $unit);
		$result = <<<mytpl
<?php
global \$plugin_setting;
\$n = 0;
\$str_sql = str_replace(" and cat_id in (0)", "", "{$str_sql}");
\$result = getData(\$str_sql, "all", \$plugin_setting['offical']['ct_news']);
\$max_count = count(\$result);
for(\$num=0; \$num<\$max_count; \$num++) {
	\$record = \$result[\$num];
	\$record['subject_org'] = htmlspecialchars(\$record['subject']);
	HtmlTrans(&\$record);
	\$record['style'] = \$n++%2 ? "{$att_list['css1']}" : "{$att_list['css2']}";
	\$cat_info = getParaInfo("news_cat", "cat_id", \$record['cat_id']);
	if(empty(\$record['link'])) \$record['link'] = getUrl("read", array(\$record['news_id'], (\$cat_info?\$cat_info['cat_idx']:"")), 1, \$record['web_id']);
	\$record['add_date'] = "";
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
		$result = str_replace($block, $result, $cur_content);
		return $result;
	}
	
	public static function ajax_jump($news_id, $web_id, $type) {
		global $db, $setting;
		$str_sql = "select * from ".$setting['db']['pre']."news_mark where news_id='".$news_id."' and web_id='".$web_id."'";
		$record = getData($str_sql, "record", 3600*24);
		if($record===false) {
			$webInfo = getSubSetting($web_id);
			$newInfo = $db->getSingleRecord("select cat_id, subject from `".$webInfo['db']['name']."`.`".$webInfo['db']['pre']."news_show` where news_id='{$news_id}'");
			if($newInfo===false) return array();
			$subject = mysql_real_escape_string($newInfo['subject']);
			$cat_id = $newInfo['cat_id'];
			$db->query("insert into {$setting['db']['pre']}news_mark values('{$web_id}', '{$news_id}', '{$cat_id}', '{$subject}', 0, '0', 0, 0, '0')");
		}
		$value = $type=="up"?"+1":"-1";
		$db->query("update ".$setting['db']['pre']."news_mark set jump=jump".$value.", jump_time=UNIX_TIMESTAMP() where web_id='".$web_id."' and news_id='".$news_id."'");
		$str_sql = "select * from ".$setting['db']['pre']."news_mark where news_id='".$news_id."' and web_id='".$web_id."'";
		getData($str_sql, "remove");
		return getData($str_sql, "record", 3600*24);
	}
	
	public static function ajax_rank($news_id, $web_id, $value) {
		global $db, $setting;
		$str_sql = "select * from ".$setting['db']['pre']."news_mark where news_id='".$news_id."' and web_id='".$web_id."'";
		$record = getData($str_sql, "record", 3600*24);
		if($record===false) {
			$webInfo = getSubSetting($web_id);
			$newInfo = $db->getSingleRecord("select cat_id, subject from `".$webInfo['db']['name']."`.`".$webInfo['db']['pre']."news_show` where news_id='{$news_id}'");
			if($newInfo===false) return array();
			$subject = mysql_real_escape_string($newInfo['subject']);
			$cat_id = $newInfo['cat_id'];
			$db->query("insert into {$setting['db']['pre']}news_mark values('{$web_id}', '{$news_id}', '{$cat_id}', '{$subject}', 0, '0', 0, 0, '0')");
		}
		if(strpos($value, "-")===false) $value = "+".$value;
		$db->query("update ".$setting['db']['pre']."news_mark set rank_total=rank_total".$value.", rank_times=rank_times+1, rank_time=UNIX_TIMESTAMP() where web_id='".$web_id."' and news_id='".$news_id."'");
		$str_sql = "select * from ".$setting['db']['pre']."news_mark where news_id='".$news_id."' and web_id='".$web_id."'";
		getData($str_sql, "remove");
		return getData($str_sql, "record", 3600*24);
	}
}
?>