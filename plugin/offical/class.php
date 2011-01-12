<?php
class plugin_offical implements plugin {
	public static function install() {
		//not need...	
	}
	
	public static function uninstall() {
		die("You cannot uninstall the offical plugin!");
	}
	
	public static function info() {
		$info = null;
		if(is_file(dirname(__FILE__)."/info.php")) include(dirname(__FILE__)."/info.php");
		return $info;
	}
	
	public static function page_start() {
		global $setting, $req;
		$GLOBALS['time_start'] = GetMicrotime();
		$GLOBALS['self'] = strtolower(basename($req->getServer("PHP_SELF")));

		$host = $req->getServer("HTTP_HOST");
		includeCache("website");
		if($web_info = getParaInfo("website", "host", $host)) {
			if(is_file(ROOT_PATH."/include/config_".$web_info['idx'].".php")) {
				include_once(ROOT_PATH."/include/config_".$web_info['idx'].".php");
			}
		}
	}
	
	public static function page_end() {
		// Website Counter
		global $db, $req, $setting;
		$ip = getIp();
		$cnt_visitor	= $req->getCookie('cnt_visitor');
		$add_ip = 0;
		$pv = 0;
		$iv = 0;
		if (empty($cnt_visitor) || $cnt_visitor!=$ip){
			$req->setCookie("cnt_visitor", $ip, $_SERVER['REQUEST_TIME']+3600*24);
			$add_ip = 1;
		}
		$count_online = $db->GetSingleResult("select count(*) from ".$setting['db']['pre']."user_online");
		if($record = $db->GetSingleRecord("select pv, iv, online from ".$setting['db']['pre']."counter where date=curdate()")) {
			$pv = $record['pv'] + 1;
			$iv = $record['iv'] + $add_ip;
			$online = max($record['online'], $count_online);
		}else{
			$pv = 1;
			$iv = 1;
			$online = 1;
		}
		$result = $db->Query("replace into ".$setting['db']['pre']."counter values(curdate(), $pv, $iv, $online)");
		
		// release source
		$GLOBALS['query_count'] = $GLOBALS['db']->Close();
		unset($GLOBALS['db'],
					$GLOBALS['req'],
					$GLOBALS['tpl']);
	}
	
	public static function parse_news(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		if(isset($att_list['catalog'])) {
			$catalog = explode(",", $att_list['catalog']);
			$att_list['cat_id'] = "";
			$max_count = count($catalog);
			for($n=0; $n<$max_count; $n++) {
				if($cat_info = getParaInfo("news_cat", "cat_idx", $catalog[$n])) {
					$att_list['cat_id'] .= $cat_info['cat_id'].",";
				}
			}
			$att_list['cat_id'] .= "0";
		}
		if(!isset($att_list['order'])) $att_list['order'] = " news_id desc";
		if(!isset($att_list['setop'])) $att_list['setop'] = "";
		if(!isset($att_list['show_image'])) $att_list['show_image'] = "";
		if(!isset($att_list['xid'])) $att_list['xid'] = "";
		if(!isset($att_list['css1'])) $att_list['css1'] = "";
		if(!isset($att_list['css2'])) $att_list['css2'] = $att_list['css1'];
		if(!isset($att_list['limit'])) $att_list['limit'] = 0;
		if(!isset($att_list['loop'])) $att_list['loop'] = 0;
		if(!isset($att_list['condition'])) $att_list['condition'] = "";
		if(!isset($att_list['show_catalog'])) $att_list['show_catalog'] = "";
		if(!isset($att_list['show_date'])) $att_list['show_date'] = "";
		if(isset($att_list['show_date']) && date($att_list['show_date'])==$att_list['show_date']) $att_list['show_date'] = "Y-m-d";
		if(!isset($att_list['tag'])) $att_list['tag'] = "";
		$att_list['tag'] = str_replace("£¬", ",", $att_list['tag']);
		$att_list['tag'] = str_replace(" ", ",", $att_list['tag']);
		$att_list['tag'] = preg_replace("/,+/", ",", $att_list['tag']);
		$att_list['tag'] = trim($att_list['tag'],",");
		if(!empty($att_list['tag'])) $att_list['tag'] = "tag like '%".str_replace(",", "%' or tag like '%", $att_list['tag'])."%'";
	
		$str_sql = "select * from ".$setting['db']['pre']."news_show where 1=1";
		if(isset($att_list['cat_id'])) $str_sql .= " and cat_id in ({$att_list['cat_id']})";
		if(!empty($att_list['show_image'])) $str_sql .= " and image!=''";
		if(!empty($att_list['setop'])) $str_sql .= " and (setop & {$setop})={$setop}";
		if(!empty($att_list['tag'])) $str_sql .= " and (".$att_list['tag'].")";
		if(!empty($att_list['xid'])) $str_sql .= " and news_id not in (".$att_list['xid'].")";
		if(!empty($att_list['condition'])) $str_sql .= " and (".$att_list['condition'].")";
		$str_sql .= " order by ".$att_list['order'];
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
\$db->Query("{$str_sql}");
while(\$record = \$db->GetRS()) {
	\$record['subject'] = trans_title(\$record['subject']);
	\$record['style'] = \$n++%2 ? "{$att_list['css1']}" : "{$att_list['css2']}";
	\$cat_info = getParaInfo("news_cat", "cat_id", \$record['cat_id']);
	if(empty(\$record['link'])) \$record['link'] = getFileURL(\$record['news_id'], (\$cat_info?\$cat_info['cat_idx']:""));
	\$record['add_date'] = ("{$att_list['show_date']}"!="") ? date("{$att_list['show_date']}", strtotime(\$record['add_date'])) : "";
	\$record['catalog'] = "";
	if("{$att_list['show_catalog']}"!="") {
		\$cat_info = getParaInfo("news_cat", "cat_id", \$record['cat_id']);
		if(\$cat_info) {
			\$record['catalog'] = "<a href=\"".getFileURL(0, \$cat_info['cat_idx'])."\" target=\"_blank\">[".\$cat_info['cat_name']."]</a>";
		}
	}
	echo <<<content
{$unit}
content;
	echo "\\n";
}
\$db->Free();
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
	
	public static function parse_info(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		$str_sql = "";
		if(isset($att_list['id'])) {
			$str_sql = "select content from ".$setting['db']['pre']."info_show where id='".$att_list['id']."'";
		} elseif(isset($att_list['title'])) {
			$str_sql = "select content from ".$setting['db']['pre']."info_show where subject='".$att_list['title']."'";
		} else {
			$str_sql = "";
		}
		if(!empty($str_sql)) {
			$result = <<<mytpl
<?php
echo \$db->getSingleResult("{$str_sql}");
?>
mytpl;
		}
		return $result;
	}
	
	public static function parse_link(MyTPL $tpl, $att_list = array()) {
		$result = "";
		if(!isset($att_list['type'])) $att_list['type'] = "";
		if(!isset($att_list['limit']) || !is_numeric($att_list['limit'])) $att_list['limit'] = 0;
		if($att_list['type']=="image") {
			$tpl_file = $tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_link_img.tpl";
			$result = <<<mytpl
<?php
\$link_list = \$GLOBALS['link_img'];
mytpl;
		} else {
			$tpl_file = $tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_link_txt.tpl";
			$result = <<<mytpl
<?php
\$link_list = \$GLOBALS['link_txt'];
mytpl;
		}
		$cur_content = $tpl->Get_TPL($tpl_file);
		preg_match_all("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0][0];
		$unit = $block_all[1][0];
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."link_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$link_list[\$i]['\\1']}", $unit);
	
		$result .= <<<mytpl
\$max_count = count(\$link_list);
if({$att_list['limit']}>0 && {$att_list['limit']}<\$max_count) \$max_count = {$att_list['limit']};
for(\$i=0; \$i<\$max_count; \$i++) {
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
	
	public static function parse_tag(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		if(!isset($att_list['limit'])) $att_list['limit'] = 20;
		if(!is_numeric($att_list['limit'])) $att_list['limit'] = 20;
		if(!isset($att_list['condition'])) $att_list['condition'] = "";
		if(!isset($att_list['order'])) $att_list['order'] = "rand()";
		$cur_content = $tpl->Get_TPL($tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_tag_{$att_list['template']}.tpl", $tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_tag_classic.tpl");
		preg_match_all("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0][0];
		$unit = $block_all[1][0];
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."tag_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$tag_list[\$i]['\\1']}", $unit);
		$str_sql = "select tag, count from ".$setting['db']['pre']."news_tag where count>5 and length(tag)>3 and ".(empty($att_list['condition'])?"1=1":$att_list['condition'])." order by ".$att_list['order']." limit ".$att_list['limit'];
		//$str_sql = addslashes($str_sql);
		$result = <<<mytpl
<?php
\$base_size = 8;
\$dyn_size = 32;
\$count_max = 0;
\$db->Query("{$str_sql}");
\$tag_list = array();
while(\$record = \$db->GetRS()) {
	if(\$setting['gen']['rewrite']) {
		\$record['link'] = \$setting['web']['url'].\$path_cache."/tag/".urlencode(\$record['tag']).\$setting['gen']['cache_ext'];
	} else {
		\$record['link'] = \$setting['web']['url']."/tag.php?tag=".urlencode(\$record['tag']);
	}
	\$record['link'] = str_replace("//", "/", \$record['link']);
	\$record['link'] = str_replace("http:/", "http://", \$record['link']);
	\$record['size'] = \$base_size;
	if(\$count_max<\$record['count']) \$count_max = \$record['count'];
	\$tag_list[] = \$record;
}
\$db->Free();
\$max_count = count(\$tag_list);
for(\$i=0; \$i<\$max_count; \$i++) {
	\$tag_list[\$i]['size'] = \$base_size + round(\$dyn_size * \$tag_list[\$i]['count'] / \$count_max);
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
	
	public static function parse_include(MyTPL $tpl, $att_list = array()) {
		$result = "";
		if(isset($att_list['file'])) {
			if(file_exists($att_list['file'])) {
				$result = $tpl->GetFile($att_list['file']);
			}
		}
		return $result;
	}
}
?>