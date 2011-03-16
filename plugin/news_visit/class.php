<?php
class plugin_news_visit implements plugin {
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
		$db->query('insert into '.$setting['db']['pre'].'plugin VALUES (0, "'.$info['name'].'", "'.$info['idx'].'", "'.$info['var'].'", "'.$info['plugin_news_visit'].'", 1, "'.$info['intro'].'", "'.$info['copyright'].'")');
		$db->query("insert into ".$setting['db']['pre']."admin_cat value (0, 7, '".$info['cat_name']."', 'news_visit.php', '../plugin/news_visit/', 0, 0, '".$info['cat_desc']."')");
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
			$admin_cat = json_encode(chg_charset($admin_cat, $setting['gen']['charset'], "utf-8"));
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
		$db->query("truncate table ".$setting['db']['pre']."news_visit");
		$db->query("drop table ".$setting['db']['pre']."news_visit");
		$db->query("delete from ".$setting['db']['pre']."admin_cat where file='news_visit.php'");
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
			$admin_cat = json_encode(chg_charset($admin_cat, $setting['gen']['charset'], "utf-8"));
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
	
	public static function page_end() {
		global $db, $setting, $web_info, $news_id, $cat_id, $subject;
		if($GLOBALS['self']!="read.php") return;
		$info_count = $db->GetSingleRecord("select * from ".$setting['db']['pre']."news_visit where web_id='".$web_info['web_id']."' and news_id='".$news_id."'");
		if($info_count===false) {
			$db->Query("insert into ".$setting['db']['pre']."news_visit values('".$web_info['web_id']."', '{$news_id}', '{$cat_id}', '{$subject}', 1, unix_timestamp(), 1, unix_timestamp(), 1, unix_timestamp(), 1, unix_timestamp(), 1, unix_timestamp(), 1, unix_timestamp(), 1, unix_timestamp(), 1, unix_timestamp(), 1)");
		} else {
			$info_count['views'] += 1;
			if(date("d") != date("d", $info_count['day_start'])) {
				$info_count['day_start'] = $_SERVER['REQUEST_TIME'];
				$info_count['day_count'] = 1;
			} else {
				$info_count['day_count'] += 1;
				if($info_count['day_count'] > $info_count['day_max_count']) {
					$info_count['day_max_count'] = $info_count['day_count'];
					$info_count['day_max_time'] = $_SERVER['REQUEST_TIME'];
				}
			}
			if(date("W") != date("W", $info_count['week_start'])) {
				$info_count['week_start'] = $_SERVER['REQUEST_TIME'];
				$info_count['week_count'] = 1;
			} else {
				$info_count['week_count'] += 1;
				if($info_count['week_count'] > $info_count['week_max_count']) {
					$info_count['week_max_count'] = $info_count['week_count'];
					$info_count['week_max_time'] = $_SERVER['REQUEST_TIME'];
				}
			}
			if(date("n") != date("n", $info_count['month_start'])) {
				$info_count['month_start'] = $_SERVER['REQUEST_TIME'];
				$info_count['month_count'] = 1;
			} else {
				$info_count['month_count'] += 1;
				if($info_count['month_count'] > $info_count['month_max_count']) {
					$info_count['month_max_count'] = $info_count['month_count'];
					$info_count['month_max_time'] = $_SERVER['REQUEST_TIME'];
				}
			}
			if(date("Y") != date("Y", $info_count['month_start'])) {
				$info_count['year_start'] = $_SERVER['REQUEST_TIME'];
				$info_count['year_count'] = 1;
			} else {
				$info_count['year_count'] += 1;
				if($info_count['year_count'] > $info_count['year_max_count']) {
					$info_count['year_max_count'] = $info_count['year_count'];
					$info_count['year_max_time'] = $_SERVER['REQUEST_TIME'];
				}
			}
			$db->Query($db->buildSQL($setting['db']['pre']."news_visit", $info_count, "replace"));
		}
	}
	
	public static function parse_news(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		if(!isset($att_list['web_id'])) $att_list['web_id'] = "";
		if(!isset($att_list['cat_id'])) $att_list['cat_id'] = "";
		if(!isset($att_list['css1'])) $att_list['css1'] = "";
		if(!isset($att_list['css2'])) $att_list['css2'] = $att_list['css1'];
		if(!isset($att_list['limit'])) $att_list['limit'] = 0;
		if(!isset($att_list['loop'])) $att_list['loop'] = 0;
		if(!isset($att_list['during'])) $att_list['during'] = "year";
	
		$str_sql = "select * from {db_pre}news_visit where 1=1";
		if(!empty($att_list['web_id'])) $str_sql .= " and web_id in ({$att_list['web_id']})";
		if(!empty($att_list['cat_id'])) $str_sql .= " and cat_id in ({$att_list['cat_id']})";
		$str_sql .= " order by ";
		
		switch($att_list['during']) {
			case "day":
				$str_sql .= "day_count desc";
				break;
			case "week":
				$str_sql .= "week_count desc";
				break;
			case "month":
				$str_sql .= "month_count desc";
				break;
			default:
				$str_sql .= "year_count desc";
				break;
		}
		$str_sql .= ", news_id desc";
		
		if(!empty($att_list['limit'])) $str_sql .= " limit ".$att_list['limit'];
		//$str_sql = addslashes($str_sql);
		
		$cur_content = $tpl->Get_TPL($tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_news_{$att_list['template']}.tpl", $tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_news_classic.tpl");
		preg_match_all("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0][0];
		$unit = $block_all[1][0];
		$unit_blank = preg_replace("/".preg_quote($tpl->delimiter_l).".*?".preg_quote($tpl->delimiter_r)."/is", "", $unit);
		$unit_blank = preg_replace("/<(td|li|p|dd|dt)([^>]*?)>.*?<\/\\1>/is", "<\\1\\2>&nbsp;</\\1>", $unit_blank);
		$unit_blank = addslashes($unit_blank);
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."news_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $unit);
		$result = <<<mytpl
<?php

\$n = 0;
\$str_sql = str_replace("{db_pre}", \$setting['db']['pre_sub'], "{$str_sql}");
\$str_sql = str_replace(" and cat_id in (0)", "", \$str_sql);
\$result = getData(\$str_sql, "all", 600);
\$max_count = count(\$result);
for(\$num=0; \$num<\$max_count; \$num++) {
	\$record = \$result[\$num];
	HtmlTrans(&\$record);
	\$theStyle = explode(",", \$record['style']);
	\$style = "";
	for(\$i=0;\$i<count(\$theStyle);\$i++) {
		\$record['subject_org'] = \$record['subject'];
		if(\$theStyle[\$i]=="i") {
			\$style .= "font-style:italic;";
		} elseif((\$theStyle[\$i]=="b")) {
			\$style .= "font-width:bold;";
		} else {
			\$style .= "color:".\$theStyle[\$i].";";
		}
	}
	if(!empty(\$style)) \$record['subject'] = "<span style=\"".\$style."\">".\$record['subject']."</span>";
	\$record['style'] = \$n++%2 ? "{$att_list['css1']}" : "{$att_list['css2']}";
	\$cat_info = getParaInfo("news_cat", "cat_id", \$record['cat_id']);
	if(empty(\$record['link'])) \$record['link'] = getFileURL(\$record['news_id'], (\$cat_info?\$cat_info['cat_idx']:""));
	\$record['add_date'] = "";
	\$record['catalog'] = "";
	echo <<<content
{$unit}
content;
	echo "\\n";
	unset(\$record);
}
unset(\$result);
for(; \$n<={$att_list['loop']}; \$n++) {
	\$unit = str_replace("style=\"\"", "style=\"".(\$n%2?"{$att_list['css1']}":"{$att_list['css2']}")."\"", "{$unit_blank}");
	echo \$unit;
	echo "\\n";
}
?>
mytpl;
		$result = str_replace($block, $result, $cur_content);
		return $result;
	}
	
	public static function parse_news_day(MyTPL $tpl, $att_list = array()) {
		$att_list['during'] = "day";
		return self::parse_news($tpl, $att_list);
	}
	
	public static function parse_news_week(MyTPL $tpl, $att_list = array()) {
		$att_list['during'] = "week";
		return self::parse_news($tpl, $att_list);
	}
	
	public static function parse_news_month(MyTPL $tpl, $att_list = array()) {
		$att_list['during'] = "month";
		return self::parse_news($tpl, $att_list);
	}
	
	public static function parse_news_year(MyTPL $tpl, $att_list = array()) {
		$att_list['during'] = "year";
		return self::parse_news($tpl, $att_list);
	}

}
?>