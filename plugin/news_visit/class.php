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
		global $db, $admin_cat;
		$strFind = array("{pre}", "{charset}");
		$strReplace = array($setting['db']['pre'], $setting['db']['charset']);
		$result = $db->ExeSqlFile(dirname(__FILE__)."/install.sql", $strFind, $strReplace);
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_news_visit",1,$info['intro'],$info['copyright'],1,""));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,7,$info['cat_name'],'news_visit.php', '../plugin/news_visit/', 0, 0,$info['cat_desc']));
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
		$db->delete($setting['db']['pre']."news_visit");
		$db->exec("drop","table",$setting['db']['pre']."news_visit");
		$db->delete($setting['db']['pre']."admin_cat", array("file","=","news_visit.php"));
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
		//make some check for current plugin
		return "";
	}
	
	public static function page_end() {
		global $db, $setting, $news_id, $cat_id, $subject, $req;
		$agent = strtolower($req->getServer('HTTP_USER_AGENT'));
		if(strpos($agent, "spider")!==false || strpos($agent, "bot")!==false) return;
		if($setting['info']['self']!="read.php" || empty($cat_id)) return;
		$info_count = $db->record($setting['db']['pre']."news_visit","*",array(array("web_id","n=",$setting['info']['web']['web_id']),array("news_id","n=",$news_id)));
		$subject = mysql_real_escape_string($subject);
		if($info_count===false) {
			$db->insert($setting['db']['pre']."news_visit",array($setting['info']['web']['web_id'],$news_id,$cat_id,$subject,1, "unix_timestamp()", 1, "unix_timestamp()", 1, "unix_timestamp()", 1, "unix_timestamp()", 1, "unix_timestamp()", 1, "unix_timestamp()", 1, "unix_timestamp()", 1, "unix_timestamp()", 1));
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
			$db->replace($setting['db']['pre']."news_visit", $info_count);
		}
	}
	
	public static function parse_news(MyTPL $tpl, $att_list = array()) {
		global $setting,$db;
		$result = "";
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		if(!isset($att_list['web_id'])) $att_list['web_id'] = $setting['info']['web']['web_id'];
		if(!isset($att_list['cat_id'])) $att_list['cat_id'] = "";
		if(!isset($att_list['css1'])) $att_list['css1'] = "";
		if(!isset($att_list['css2'])) $att_list['css2'] = $att_list['css1'];
		if(!isset($att_list['limit'])) $att_list['limit'] = 10;
		if(!isset($att_list['loop'])) $att_list['loop'] = 0;
		if(!isset($att_list['during'])) $att_list['during'] = "year";
	
		switch($att_list['during']) {
			case "day":
				$att_list['order'] = "day_count desc";
				break;
			case "week":
				$att_list['order'] = "week_count desc";
				break;
			case "month":
				$att_list['order'] = "month_count desc";
				break;
			default:
				$att_list['order'] = "year_count desc";
				break;
		}
		$att_list['order'] .= ", news_id desc";
		
		$condition = array();
		if(!empty($att_list['web_id'])) $condition[] = array("web_id","nin",$att_list['web_id']);
		if(!empty($att_list['cat_id'])) $condition[] = array("cat_id","nin",$att_list['cat_id']);
		$sql = $db->buildSel($setting['db']['pre']."news_visit","*",$condition,$att_list);
		
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
\$result = getData("{$sql}", "all", \$plugin_setting['offical']['ct_news']);
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