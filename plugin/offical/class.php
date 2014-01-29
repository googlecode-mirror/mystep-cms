<?php
class plugin_offical implements plugin {
	public static function install() {
		//no use but nessesary...	
	}
	
	public static function uninstall() {
		showInfo("You cannot uninstall the offical plugin!");
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
		$plugin_setting['offical'] = null;
		if(is_file(dirname(__FILE__)."/config.php")) include(dirname(__FILE__)."/config.php");
		return $plugin_setting['offical'];
	}
	
	public static function page_start() {
		$setting = self::setting();
		if($setting['cache']) {
			$etag_expires = getCacheExpire();
			header("Pragma: public");
			header("Cache-Control: private, max-age=".$etag_expires);
			header("Last-Modified: ".gmdate('D, d M Y H:i:s')." GMT");
			header("Expires: ".gmdate('D, d M Y H:i:s', time()+$etag_expires)." GMT");
			$etag = md5($_SERVER["REQUEST_URI"].implode(",", $GLOBALS['ms_version']).$GLOBALS['setting']['gen']['etag']);
			if ($_SERVER['HTTP_IF_NONE_MATCH'] == $etag){
				header('Etag:'.$etag, true, 304);
				exit();
			} else {
				header('Etag:'.$etag);
			}
		} else {
			if(!isset($GLOBALS['etag_expires'])) {
				header("Expires: -1");
				header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0");
				header("Cache-Control: private", false);
				header("Pragma: no-cache");
			}
		}
	}
	
	public static function page_end() {
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(strpos($agent, "spider")!==false || strpos($agent, "bot")!==false) return;
		$file = basename($_SERVER["PHP_SELF"]);
		if(checkSign(1)) return;
		$setting = self::setting();
		if(!$setting['counter']) return;
		global $db, $req;
		include(ROOT_PATH."/include/config.php");
		$ip = getIp();
		$cnt_visitor	= $req->getCookie('cnt_visitor');
		$add_ip = 0;
		$pv = 0;
		$iv = 0;
		if (empty($cnt_visitor) || $cnt_visitor!=$ip){
			$req->setCookie("cnt_visitor", $ip, 60*60*24);
			$add_ip = 1;
		}
		if($add_ip==1 && $db->result($setting['db']['pre']."user_online","ip",array("ip","=",$ip))) {
			$add_ip = 0;
		}
		$count_online = $db->result($setting['db']['pre']."user_online","count(distinct ip)");
		if($record = $db->record($setting['db']['pre']."counter","pv, iv, online",array("date","f=","curdate()"))) {
			$pv = $record['pv'] + 1;
			$iv = $record['iv'] + $add_ip;
			$online = max($record['online'], $count_online);
		}else{
			$pv = 1;
			$iv = 1;
			$online = 1;
		}
		return $db->replace($setting['db']['pre']."counter", array("curdate()",$pv,$iv,$online));
	}
	
	public static function api_rss($id=0, $mode="cat") {
		global $setting, $db;
		$cat_id = "";
		if($mode=="cat") {
			if($cat_info = getParaInfo("news_cat", "cat_id", $id)) {
				$web_info = getSubSetting($cat_info['web_id']);
				$cat_id = $id;
			} else {
				$web_info = getSubSetting($setting['info']['web']['web_id']);
			}
		} else {
			$web_info = getSubSetting($id);
		}
		$charset_tag = '<?xml version="1.0" encoding="'.$setting['gen']['charset'].'"?>'."\n";
		$tpl_info = array(
				"idx" => "rss",
				"style" => "../plugin/".basename(realpath(dirname(__FILE__)))."/tpl/",
				"path" => ROOT_PATH."/".$setting['path']['template'],
				);
		$tpl = new MyTpl;
		$tpl->init($tpl_info);
		
		$tpl->Set_Variable('web_title', $setting['web']['title']);
		$tpl->Set_Variable('web_url', $setting['web']['url']);
		$tpl->Set_Variable('web_email', $setting['web']['email']);
		$tpl->Set_Variable('page_keywords', $setting['web']['keyword']);
		$tpl->Set_Variable('page_description', $setting['web']['description']);
		$tpl->Set_Variable('charset_tag', $charset_tag);
		$tpl->Set_Variable('cat_txt', $cat_txt);
		$tpl->Set_Variable('now', date("r"));

		$condition = array();
		if(!empty($cat_id)) $condition[] = array("cat_id","n=",$cat_id);
		$db->select(
			array(
				array(
					"name" => $web_info['db']['name'].".".$web_info['db']['pre']."news_show",
					"idx" => "a",
					"col" => "*",
					"condition" => $condition
				),
				array(
					"name" => $setting['db']['pre']."news_cat",
					"idx" => "b",
					"col" => "cat_name",
					"join" => "cat_id",
				)
			),
			array(),
			array("limit"=>$setting['list']['rss'])
		);
		while($record = $db->GetRS()) {
			$record['link'] = getUrl("read", array($record['news_id'], $record['cat_idx']), 1, $record['web_id']);
			$record['add_date'] = date("r", strtotime($record['add_date']));
			$tpl->Set_Loop("record", $record);
		}
		$db->Free();
		header('Content-Type: application/rss+xml; charset='.$setting['gen']['charset']);
		return $tpl->Get_Content('$db, $setting');
	}
	
	public static function api_news($id=0, $web_id=1) {
		global $setting, $db;
		if(!is_numeric($id)) return;
		$web_info = getSubSetting($web_id);
		$result = $db->record($web_info['db']['name'].".".$web_info['db']['pre']."news_show", "*", array("news_id","n=",$id));
		$result['link'] = getUrl("read", array($record['news_id'], $record['cat_idx']), 1, $record['web_id']);
		$result['add_date'] = date("Y-m-d H:i:s", strtotime($result['add_date']));
		$result['content'] = array();
		$db->select($web_info['db']['name'].".".$web_info['db']['pre']."news_detail","*", array("news_id","n=",$id), array("order"=>"page asc"));
		while($record = $db->GetRS()) {
			$result['content'][] = $record['content'];
		}
		$db->Free();
		return $result;
	}
	
	public static function api_newslist($id=0, $mode="cat") {
		global $setting, $db;
		$cat_id = "";
		if($mode=="cat") {
			if($cat_info = getParaInfo("news_cat", "cat_id", $id)) {
				$web_info = getSubSetting($cat_info['web_id']);
				$cat_id = $id;
			} else {
				$web_info = getSubSetting($setting['info']['web']['web_id']);
			}
		} else {
			$web_info = getSubSetting($id);
		}

		$condition = array();
		if(!empty($cat_id)) $condition[] = array("cat_id","n=",$cat_id);
		$db->select(
			array(
				array(
					"name" => $web_info['db']['name'].".".$web_info['db']['pre']."news_show",
					"idx" => "a",
					"col" => "*",
					"condition" => $condition
				),
				array(
					"name" => $setting['db']['pre']."news_cat",
					"idx" => "b",
					"col" => "cat_name",
					"join" => "cat_id",
				)
			),
			array(),
			array("limit"=>$setting['list']['rss'])
		);
		$result = array();
		while($record = $db->GetRS()) {
			$record['link'] = getUrl("read", array($record['news_id'], $record['cat_idx']), 1, $record['web_id']);
			$record['add_date'] = date("Y-m-d H:i:s", strtotime($record['add_date']));
			$result[] = $record;
		}
		return $result;
	}
	
	public static function ajax_login() {
		global $req;
		$result = array();
		$result['username'] = $req->getSession("username");
		$result['usergroup'] = $req->getSession("usergroup");
		$result['usertype'] = $req->getSession("usertype");
		if(is_null($result['username'])) $result['username'] = "Guest";
		if(is_null($result['usergroup'])) $result['usergroup'] = 0;
		if(is_null($result['usertype'])) $result['usertype'] = 1;
		if($result['usertype']>1) {
			if($group = getParaInfo("user_group", "group_id", $result['usergroup'])) {
				$result['group_name'] = $group['group_name'];
			}
			if($type = getParaInfo("user_type", "type_id", $result['usertype'])) {
				$result['type_name'] = $type['type_name'];
			}
		}
		return $result;
	}
	
	public static function ajax_autocomplete($mode, $keyword) {
		global $req, $setting;
		$keyword = getString($keyword);
		$result = array(
			query => $keyword,
			suggestions => array(),
			data => array()
		);
		$dataFile = ROOT_PATH."/script/jquery.autocomplete/".$mode.".php";
		if(file_exists($dataFile)) {
			include($dataFile);
			$data = $$mode;
			unset($$mode);
			$keyword = strtolower($keyword);
			for($i=0,$m=count($data);$i<$m;$i++) {
				if(strpos(strtolower(implode("|", $data[$i])), $keyword)!==false) {
					if($setting['gen']['language']=="en") {
						$result['suggestions'][] = $data[$i][1];
						$result['data'][] = $data[$i][1];
					} else {
						$result['suggestions'][] = $data[$i][0];
						$result['data'][] = $data[$i][1];
					}
				}
			}
		}
		return $result;
	}
	
	public static function ajax_subcat($cat_id) {
		global $news_cat;
		$result = array();
		foreach($news_cat as $cur_cat) {
			if($cur_cat['cat_main']==$cat_id) {
				$result[] = array("name"=>$cur_cat['cat_name'], "link"=>getUrl("list", $cur_cat['cat_idx'], 1, $cur_cat['web_id']));
			}
		}
		return $result;
	}
	
	public static function login($user_name, $user_psw) {
		global $mystep, $setting;
		$result = $mystep->logcheck($user_name, $user_psw);
		return (count($result)==0)?$setting['language']['login_error_psw']:"";
	}
	
	public static function logout() {
		global $req;
		$req->setCookie("ms_user");
		$req->destroySession();
	}
	
	public static function parse_news(MyTPL $tpl, $att_list = array()) {
		global $setting, $db;
		$result = "";
		/*
		foreach($att_list as $key => $value) {
			eval("\$att_list['".$key."'] = \"".$value."\";");
		}
		*/
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		if(!isset($att_list['web_id'])) $att_list['web_id'] = "";
		if(!isset($att_list['cat_id'])) $att_list['cat_id'] = "";
		if(!isset($att_list['order'])) {
			if(empty($att_list['cat_id'])) {
				$att_list['order'] = " news_id desc";
			} else {
				$att_list['order'] = " `order` desc, news_id desc";
			}
		}
		if(!isset($att_list['setop'])) $att_list['setop'] = "";
		if(!empty($att_list['setop'])) {
			$show_list = array(
				"index.php" => 1,
				"list.php" => 2,
				"read.php" => 4,
			);
			$att_list['setop'] = $show_list[$setting['info']['self']] + ($att_list['setop']=="img"?2:1) * 1024;
		}
		if(!isset($att_list['show_image'])) $att_list['show_image'] = "";
		if(!isset($att_list['xid'])) $att_list['xid'] = "";
		if(!isset($att_list['css1'])) $att_list['css1'] = "";
		if(!isset($att_list['css2'])) $att_list['css2'] = $att_list['css1'];
		if(!isset($att_list['limit'])) $att_list['limit'] = 0;
		if(!isset($att_list['loop'])) $att_list['loop'] = 0;
		if(!isset($att_list['expire'])) $att_list['expire'] = "";
		if(!isset($att_list['condition'])) $att_list['condition'] = "";
		if(!isset($att_list['show_catalog'])) $att_list['show_catalog'] = "";
		if(!isset($att_list['show_date'])) $att_list['show_date'] = "";
		if(!empty($att_list['show_date']) && date($att_list['show_date'])==$att_list['show_date']) $att_list['show_date'] = "Y-m-d";
		if(!isset($att_list['tag'])) $att_list['tag'] = "";
		if(!empty($att_list['cat_id'])) {
			if($cat_info=getParaInfo("news_cat", "cat_id", $att_list['cat_id'])) $att_list['web_id'] = $cat_info['web_id'];
		}
		
		$pre = "{db_pre}";
		if(!empty($att_list['web_id'])) {
			$setting_sub = getSubSetting($att_list['web_id']);
			$pre = $setting_sub['db']['name'].".".$setting_sub['db']['pre'];
		}
		$condition = array();
		if(!empty($att_list['expire'])) $condition[] = array(array("a.expire", "is", null), array("expire", "f>", "now()", "or"));
		if(!empty($att_list['web_id'])) $condition[] = array("a.web_id", "n=", $att_list['web_id'],"and");
		if(!empty($att_list['cat_id'])) {
			if(is_numeric($att_list['cat_id'])) {
				$condition[] = array(array("a.cat_id", "=", $att_list['cat_id']), array("b.cat_main", "=", $att_list['cat_id'], "or"), "and");
			} else {
				$condition[] = array(array("a.cat_id", "in", $att_list['cat_id']), array("b.cat_main", "in", $att_list['cat_id'], "or"), "and");
			}
		}
		if(!empty($att_list['show_image'])) $condition[] = array("a.image", "!=", "", "and");
		if(!empty($att_list['setop'])) $condition[] = array("(a.setop & {$att_list['setop']})", "n=", $att_list['setop'], "and");
		if(!empty($att_list['xid'])) $condition[] = array("a.news_id", "not in", $att_list['xid'], "and");

		$tag = "";
		if(!empty($att_list['tag'])) {
			if(strpos($att_list['tag'], '$GLOBALS')===false) {
				$tag = explode(",",trim($att_list['tag']));
				$att_list['tag'] = "";
			} else {
				$tag = array("{tag}");
			}
			$tag_list = array();
			for($i=0,$m=count($tag);$i<$m;$i++) {
				$att_list['tag'][$i] = trim($tag[$i]);
				if(strlen($tag[$i])<2) continue;
				$tag_list[] = array("a.tag", "like", $tag[$i], "or");
			}
			$tag_list[] = "and";
			$condition[] = $tag_list;
		}

		$opt = array();
		$opt["order"] = $att_list['order'];
		if(!empty($att_list['limit'])) $opt["limit"] = $att_list['limit'];
		if(!empty($att_list['condition'])) $opt["condition"] = $att_list['condition'];
		
		$sql = $db->buildSel(
			array(
				array(
					"name" => $pre."news_show",
					"idx" => "a",
					"col" => "*",
				),
				array(
					"name" => $setting['db']['pre']."news_cat",
					"idx" => "b",
					"join" => "cat_id",
				)
			),
			$condition,
			$opt
		);
		
		$cur_content = $tpl->Get_TPL($tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_news_{$att_list['template']}.tpl", $tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_news_classic.tpl");
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit_blank = preg_replace("/".preg_quote($tpl->delimiter_l).".*?".preg_quote($tpl->delimiter_r)."/is", "", $unit);
		$unit_blank = preg_replace("/<(td|li|p|dd|dt)([^>]*?)>.*?<\/\\1>/is", "<\\1\\2>&nbsp;</\\1>", $unit_blank);
		$unit_blank = addslashes($unit_blank);
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."news_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$record['\\1']}", $unit);
		$tag = $att_list['tag'];
		$result = <<<mytpl
<?php
global \$plugin_setting;
\$n = 0;
\$sql = str_replace("{db_pre}", \$setting['db']['pre_sub'], "{$sql}");
\$sql = str_replace("and  order", "order", \$sql);
\$tag = "{$att_list['tag']}";
if(!empty(\$tag)) {
	\$tag = str_replace("'", "", \$tag);
	\$tag = str_replace("£¬", ",", \$tag);
	\$tag = str_replace(" ", ",", \$tag);
	\$tag = preg_replace("/,+/", ",", \$tag);
	\$tag = trim(\$tag, ",");
	\$tag = str_replace(",", "%' or a.tag like '%", \$tag);
	\$sql = str_replace("{tag}", \$tag, \$sql);
} else {
	\$sql = str_replace("(`a`.`tag` like '%{tag}%')", "true", \$sql);
}
\$result = getData(\$sql, "all", \$plugin_setting['offical']['ct_news']);
for(\$num=0,\$m=count(\$result); \$num<\$m; \$num++) {
	\$record = \$result[\$num];
	HtmlTrans(&\$record);
	\$theStyle = explode(",", \$record['style']);
	\$style = "";
	for(\$i=0;\$i<count(\$theStyle);\$i++) {
		\$record['subject_org'] = htmlspecialchars(\$record['subject']);
		if(\$theStyle[\$i]=="i") {
			\$style .= "font-style:italic;";
		} elseif((\$theStyle[\$i]=="b")) {
			\$style .= "font-weight:bold;";
		} else {
			\$style .= "color:".\$theStyle[\$i].";";
		}
	}
	if(!empty(\$style)) \$record['subject'] = "<span style=\"".\$style."\">".\$record['subject']."</span>";
	if("{$att_list['template']}"=="classic" && \$setting['info']['time_start']/1000-strtotime(\$record['add_date'])<86400) \$record['subject'] .= ' <img src="images/new.gif" />';
	\$record['style'] = \$n++%2 ? "{$att_list['css1']}" : "{$att_list['css2']}";
	\$cat_info = getParaInfo("news_cat", "cat_id", \$record['cat_id']);
	if(empty(\$record['link'])) \$record['link'] = getUrl("read", array(\$record['news_id'], (\$cat_info?\$cat_info['cat_idx']:"")), 1, \$record['web_id']);
	\$record['add_date'] = ("{$att_list['show_date']}"!="") ? date("{$att_list['show_date']}", strtotime(\$record['add_date'])) : "";
	\$record['catalog'] = "";
	if("{$att_list['show_catalog']}"!="") {
		\$cat_info = getParaInfo("news_cat", "cat_id", \$record['cat_id']);
		if(\$cat_info) {
			\$record['catalog'] = "<a href=\"".getUrl("list", \$cat_info['cat_idx'], 1, \$record['web_id'])."\" target=\"_blank\">[".\$cat_info['cat_name']."]</a>";
		}
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
		$result = str_replace($block, $result, $cur_content);
		return $result;
	}

	public static function parse_info(MyTPL $tpl, $att_list = array()) {
		global $setting, $db;
		$result = "";
		$condition = array();
		if(isset($att_list['id'])) {
			$condition[] = array("id", "n=", $att_list['id']);
		} elseif(isset($att_list['title'])) {
			$condition[] = array("subject", "=", $att_list['title']);
		}
		if(!empty($condition)) {
			$condition[] = array(array("web_id", "n=", $setting['info']['web']['web_id']), array("web_id", "n=", 0,"or"),"and");
			$sql = $db->buildSel($setting['db']['pre']."info_show","content",$condition);
			$result = <<<mytpl
<?php
global \$plugin_setting;
echo getData("{$sql}", "result", \$plugin_setting['offical']['ct_info']);
?>
mytpl;
		}
		return $result;
	}
	
	public static function parse_link(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['idx'])) $att_list['idx'] = "";
		if(!isset($att_list['type'])) $att_list['type'] = "all";
		if(!isset($att_list['limit']) || !is_numeric($att_list['limit'])) $att_list['limit'] = 0;
		if($att_list['type']=="image") {
			$tpl_file = $tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_link_img.tpl";
			$result = <<<mytpl
<?php
\$link_idx = "{$att_list['idx']}";
\$link_list = \$GLOBALS['link_img'];
mytpl;
		} else {
			$tpl_file = $tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_link_txt.tpl";
			$result = <<<mytpl
<?php
\$link_idx = "{$att_list['idx']}";
\$link_list = \$GLOBALS['link_txt'];
if("{$att_list['type']}"=="all") \$link_list = array_merge(\$link_list, \$GLOBALS['link_img']);
mytpl;
		}
		$cur_content = $tpl->Get_TPL($tpl_file);
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."link_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$link_list[\$i]['\\1']}", $unit);
		$result .= <<<mytpl
\$n = 0;
for(\$i=0,\$m=count(\$link_list); \$i<\$m; \$i++) {
	if(\$link_list[\$i]['level']==0 || (\$link_list[\$i]['web_id']!=0 && \$link_list[\$i]['web_id']!={$setting['info']['web']['web_id']})) continue;
	if(!empty(\$link_idx) && strpos(",".\$link_idx.",", ",".\$link_list[\$i]['idx'].",")===false) continue;
	echo <<<content
{$unit}
content;
	echo "\\n";
	\$n++;
	if({$att_list['limit']}>0 && {$att_list['limit']}<\$n) break;
}
?>
mytpl;
		$result = str_replace($block, $result, $cur_content);
		return $result;
	}
	
	public static function parse_tag(MyTPL $tpl, $att_list = array()) {
		global $setting, $db;
		$result = "";
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		if(!isset($att_list['limit'])) $att_list['limit'] = 20;
		if(!is_numeric($att_list['limit'])) $att_list['limit'] = 20;
		if(!isset($att_list['condition'])) $att_list['condition'] = "";
		if(!isset($att_list['order'])) $att_list['order'] = "rand()";
		$cur_content = $tpl->Get_TPL($tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_tag_{$att_list['template']}.tpl", $tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_tag_classic.tpl");
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $cur_content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."tag_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$tag_list[\$i]['\\1']}", $unit);
		$sql = $db->buildSel("{db_pre}news_tag", "tag, count","",$att_list);
		$result = <<<mytpl
<?php
global \$plugin_setting;
\$base_size = 8;
\$dyn_size = 32;
\$count_max = 0;
\$tag_list = array();
\$result = getData(str_replace("{db_pre}", \$setting['db']['pre_sub'], "{$sql}"), "all", \$plugin_setting['offical']['ct_tag']);
for(\$num=0,\$m=count(\$result); \$num<\$m; \$num++) {
	\$record = \$result[\$num];
	\$record['link'] = getUrl("tag", urlencode(\$record['tag']), 1, \$setting['info']['web']['web_id']);
	\$record['size'] = \$base_size;
	if(\$count_max<\$record['count']) \$count_max = \$record['count'];
	\$tag_list[] = \$record;
	unset(\$record);
}
unset(\$result);
for(\$i=0,\$m=count(\$tag_list); \$i<\$m; \$i++) {
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

	public static function parse_login(MyTPL $tpl, $att_list = array()) {
		global $setting;
		if(!isset($att_list['id'])) $att_list['id'] = "";
		if(!isset($att_list['class'])) $att_list['class'] = "";
		$result = $tpl->Get_TPL($tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_login.tpl");
		$result = str_replace($tpl->delimiter_l."id".$tpl->delimiter_r, $att_list['id'], $result);
		$result = str_replace($tpl->delimiter_l."class".$tpl->delimiter_r, $att_list['class'], $result);
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
	
	public static function parse_menu(MyTPL $tpl, $att_list = array()) {
		if(!isset($att_list['web_id'])) $att_list['web_id'] = "";
		if(!isset($att_list['cat_id'])) $att_list['cat_id'] = "";
		if(!isset($att_list['deep'])) $att_list['deep'] = 2;
		if(!isset($att_list['class'])) $att_list['class'] = "";
		if(!isset($att_list['all'])) $att_list['all'] = "";
		if($att_list['cat_id']===0) $att_list['cat_id'] = "";
		
		$result = <<<mytpl
<?php
echo plugin_offical::getMenuContent("{$att_list['cat_id']}", "{$att_list['web_id']}", "{$att_list['deep']}", "{$att_list['class']}", "{$att_list['all']}");
?>
mytpl;
		return $result;
	}
	
	public static function getMenuContent($cat_id, $web_id, $deep, $class="", $all="") {
		global $news_cat, $cache;
		if($cat_id==0) $cat_id = "";
		$key = md5("Menu_".$cat_id."_".$web_id."_".$deep);
		$result = $cache->get($key);
		if(!$result) {
			$result = "";
			$last_idx = -1;
			$deep_start = 0;
			$deep_max = 0;
			$deep_cur = 0;
			$catInfo = getParaInfo("news_cat", "cat_id", $cat_id);
			if(!$catInfo) $catInfo = array("cat_layer"=>1);
			for($i=0,$m=count($news_cat); $i<$m; $i++) {
				if(!empty($web_id) && $web_id!=$news_cat[$i]['web_id']) continue;
				if(empty($all)) {
					if($deep_start==0 && $news_cat[$i]['cat_layer']!=$catInfo['cat_layer']) continue;
					if(($news_cat[$i]['cat_show'] & 2)!=2) {
						if($last_idx==-1 || $last_idx==$i-1) $last_idx = $i;
						continue;
					}
					if($deep_start>0 && ($news_cat[$i]['cat_show'] & 2)==2 && $last_idx!=-1 && $news_cat[$last_idx]['cat_layer']<$news_cat[$i]['cat_layer']) continue;
				}
				$last_idx = -1;
				//if(empty($all) && (($news_cat[$i]['cat_show'] & 2)!=2 || ($deep_start==0 && $news_cat[$i]['cat_layer']>$catInfo['cat_layer']))) continue;
				if($deep_start>0) {
					$theLink = $news_cat[$i]['cat_link'];
					if(empty($theLink)) $theLink = getUrl("list", $news_cat[$i]['cat_idx'], 1, $news_cat[$i]['web_id']);
					if($deep_cur==$news_cat[$i]['cat_layer']) {
						if($cat_id!="" && $cat_id!=$news_cat[$i]['cat_id'] && $deep_start==$news_cat[$i]['cat_layer']) break;
						$result .= "</li>\n";
						$result .= str_repeat("\t", $news_cat[$i]['cat_layer'])."<li><a href=\"".$theLink."\">".$news_cat[$i]['cat_name']."</a>";
					} elseif($deep_cur<$news_cat[$i]['cat_layer']) {
						if($news_cat[$i]['cat_layer']<$deep_max) {
							$result .= "<ul>\n";
							$result .= str_repeat("\t", $news_cat[$i]['cat_layer'])."<li><a href=\"".$theLink."\">".$news_cat[$i]['cat_name']."</a>";
							$deep_cur = $news_cat[$i]['cat_layer'];
						}
					} else {
						if($news_cat[$i]['cat_layer']>$deep_start || $cat_id=="") {
							$result .= "</li>\n".str_repeat("\t", $deep_cur)."</ul></li>\n";
							for($j=$deep_cur-$news_cat[$i]['cat_layer']-1; $j>0; $j--) {
								$result .= str_repeat("\t", $j)."</ul></li>\n";
							}
							$result .= str_repeat("\t", $news_cat[$i]['cat_layer'])."<li><a href=\"".$theLink."\">".$news_cat[$i]['cat_name']."</a>";
							$deep_cur = $news_cat[$i]['cat_layer'];
						} else {
							if($cat_id!="") break;
						}
					}
				} else {
					if($cat_id==$news_cat[$i]['cat_id'] || $cat_id=="") {
						$theLink = $news_cat[$i]['cat_link'];
						if(empty($theLink)) $theLink = getUrl("list", $news_cat[$i]['cat_idx'], 1, $news_cat[$i]['web_id']);
						$deep_cur = $news_cat[$i]['cat_layer'];
						$deep_start = $news_cat[$i]['cat_layer'];
						$deep_max = $deep_start + $deep;
						$result .= "<ul class=\"{$class}\">\n";
						$result .= str_repeat("\t", $news_cat[$i]['cat_layer'])."<li><a href=\"".$theLink."\">".$news_cat[$i]['cat_name']."</a>";
					}
				}
			}
			if(!empty($result)) {
				$result .= "</li>\n";
				for($i=$deep_cur-$deep_start; $i>0; $i--) {
					$result .= str_repeat("\t", $i+1)."</ul></li>\n";
				}
				$result .= "</ul>\n";
				$cache->set($key, $result, 3600);
			}
		}
		return $result;
	}
}
?>