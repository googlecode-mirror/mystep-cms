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
		global $db, $admin_cat;
		$strFind = array("{pre}", "{charset}");
		$strReplace = array($setting['db']['pre'], $setting['db']['charset']);
		$result = $db->ExeSqlFile(dirname(__FILE__)."/install.sql", $strFind, $strReplace);
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_news_mark",1,$info['intro'],$info['copyright'],1,","));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,7,$info['cat_name'],'news_mark.php', '../plugin/news_mark/', 0, 0,$info['cat_desc']));
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
		$db->delete($setting['db']['pre']."news_mark");
		$db->exec("drop","table",$setting['db']['pre']."news_mark");
		$db->delete($setting['db']['pre']."admin_cat", array("file","=","news_mark.php"));
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
	
	public static function setting() {
		$plugin_setting['news_mark'] = null;
		if(is_file(dirname(__FILE__)."/config.php")) include(dirname(__FILE__)."/config.php");
		return $plugin_setting['news_mark'];
	}
	
	public static function news_rank(MyTPL $tpl, $att_list = array()) {
		global $setting, $db;
		$result = "";
		if(!isset($att_list['news_id'])) $att_list['news_id'] = $GLOBALS['news_id'];
		if(!isset($att_list['web_id'])) $att_list['web_id'] = $setting['info']['web']['web_id'];
		
		$sql = $db->buildSel($setting['db']['pre']."news_mark", "*", array(array("news_id","n=",$att_list['news_id']),array("web_id","n=",$att_list['web_id'])));
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
\$sql = "{$sql}";
\$record = getData(\$sql, "record", 3600*24);
if(\$record===false) {
	getData(\$sql, "remove");
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
		global $setting, $db;
		$result = "";
		if(!isset($att_list['news_id'])) $att_list['news_id'] = $GLOBALS['news_id'];
		if(!isset($att_list['web_id'])) $att_list['web_id'] = $setting['info']['web']['web_id'];
		
		$sql = $db->buildSel($setting['db']['pre']."news_mark", "*", array(array("news_id","n=",$att_list['news_id']),array("web_id","n=",$att_list['web_id'])));
		$content = $tpl->Get_TPL(dirname(__FILE__)."/tpl/news_jump.tpl");
		
		foreach($att_list as $key => $value) {
			$content = str_replace("<!--att_list_".$key."-->", $value, $content);
		}
		$content = preg_replace("/".preg_quote($tpl->delimiter_l)."jump_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $content);
		$content = preg_replace("/".preg_quote($tpl->delimiter_l)."(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$tpl_para['".$tpl->hash."']['para']['\\1']}", $content);
		$result = <<<mytpl
<?php
\$sql = "{$sql}";
\$record = getData(\$sql, "record", 3600*24);
if(\$record===false) {
	getData(\$sql, "remove");
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
	
		$the_order = array();
		$condition = array();
		if(!empty($att_list['web_id'])) $condition[] = array("web_id","n=",$att_list['web_id']);
		if(!empty($att_list['cat_id'])) $condition[] = array("cat_id","nin",$att_list['cat_id']);
		if($att_list['type'] == "jump") {
			$condition[] = array("jump_time","f>","UNIX_TIMESTAMP()-".$att_list['time']);
			$the_order[] = "jump desc";
		} else {
			$condition[] = array("rank_time","f>","UNIX_TIMESTAMP()-".$att_list['time']);
			$the_order[] = "rank_total/rank_times desc";
		}
		$the_order[] = "news_id desc";
		$sql = $db->buildSel($setting['db']['pre']."news_mark", "*", $condition, array("order"=>$the_order,"limit"=>$att_list['limit']));
		
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
	
	public static function ajax_jump($news_id, $web_id, $type) {
		global $db, $setting;
		$sql = $db->buildSel($setting['db']['pre']."news_mark", "*", array(array("news_id","n=",$news_id),array("web_id","n=",$web_id)));
		$record = getData($sql, "record", 3600*24);
		if($record===false) {
			$webInfo = getSubSetting($web_id);
			$newInfo = $db->record($webInfo['db']['name'].".".$webInfo['db']['pre']."news_show","cat_id, subject",array("news_id","n=",$news_id));
			if($newInfo===false) return array();
			$subject = mysql_real_escape_string($newInfo['subject']);
			$cat_id = $newInfo['cat_id'];
			$db->insert($setting['db']['pre']."news_mark",array($web_id,$news_id,$cat_id,$subject,0, 0, 0, 0, 0));
		}
		$value = $type=="up"?"+1":"-1";
		$db->update($setting['db']['pre']."news_mark", array("jump"=>$value,"jump_time"=>"UNIX_TIMESTAMP()"),array(array("web_id","n=",$web_id),array("news_id","n=",$news_id,"and")));
		$sql = $db->buildSel($setting['db']['pre']."news_mark","*",array(array("web_id","n=",$web_id),array("news_id","n=",$news_id,"and")));
		getData($sql, "remove");
		return getData($sql, "record", 3600*24);
	}
	
	public static function ajax_rank($news_id, $web_id, $value) {
		global $db, $setting;
		$sql = $db->buildSel($setting['db']['pre']."news_mark", "*", array(array("news_id","n=",$news_id),array("web_id","n=",$web_id)));
		$record = getData($sql, "record", 3600*24);
		if($record===false) {
			$webInfo = getSubSetting($web_id);
			$newInfo = $db->record($webInfo['db']['name'].".".$webInfo['db']['pre']."news_show","cat_id, subject",array("news_id","n=",$news_id));
			if($newInfo===false) return array();
			$subject = mysql_real_escape_string($newInfo['subject']);
			$cat_id = $newInfo['cat_id'];
			$db->insert($setting['db']['pre']."news_mark",array($web_id,$news_id,$cat_id,$subject,0, 0, 0, 0, 0));
		}
		if(strpos($value, "-")===false) $value = "+".$value;
		$db->update($setting['db']['pre']."news_mark", array("rank_total"=>$value,"rank_times"=>"+1","rank_time"=>"UNIX_TIMESTAMP()"),array(array("web_id","n=",$web_id),array("news_id","n=",$news_id,"and")));
		$sql = $db->buildSel($setting['db']['pre']."news_mark","*",array(array("web_id","n=",$web_id),array("news_id","n=",$news_id,"and")));
		getData($sql, "remove");
		return getData($sql, "record", 3600*24);
	}
}
?>