<?php
class plugin_comment implements plugin {
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
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_comment",1,$info['intro'],$info['copyright'],1,""));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,4,$info['cat_name'],'comment.php', '../plugin/comment/', 0, 0,$info['cat_desc']));
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
		$db->delete($setting['db']['pre']."comment");
		$db->exec("drop","table",$setting['db']['pre']."comment");
		$db->delete($setting['db']['pre']."admin_cat", array("file","=","comment.php"));
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
			MultiDel(dirname(__FILE__)."/cache/");
			MakeDir(dirname(__FILE__)."/cache/");
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
			"/cache/",
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
	
	public static function setting() {
		$plugin_setting['comment'] = null;
		if(is_file(dirname(__FILE__)."/config.php")) include(dirname(__FILE__)."/config.php");
		return $plugin_setting['comment'];
	}
	
	public static function news_comment(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		if(!isset($att_list['web_id'])) $att_list['web_id'] = $setting['info']['web']['web_id'];
		if(!isset($att_list['news_id'])) $att_list['news_id'] = "";
		if(!isset($att_list['css1'])) $att_list['css1'] = "";
		if(!isset($att_list['css2'])) $att_list['css2'] = $att_list['css1'];
		if(!isset($att_list['limit'])) $att_list['limit'] = 10;
		if(!isset($att_list['loop'])) $att_list['loop'] = 0;
		if(!isset($att_list['order'])) $att_list['order'] = "id desc";
		if(!isset($att_list['count'])) $att_list['count'] = false;
	
		$webInfo = getSubSetting($att_list['web_id']);
		$pre_sub = $webInfo['db']['name'].".".$webInfo['db']['pre'];
		if($att_list['count']) {
			$sql = $db->buildSel($setting['db']['pre']."comment","news_id, count(*) as counter",array("web_id","n=",$att_list['web_id']),array("group"=>"news_id","limit"=>$att_list['limit']));
			$sql = $db->buildSel(
				array(
					array(
						"query" => $sql,
						"idx" => "a",
						"col" => "counter",
						"order" => "counter desc, news_id desc"
					),
					array(
						"name" => $pre_sub."news_show",
						"idx" => "b",
						"col" => "news_id, subject, web_id, cat_id",
						"join" => "news_id",
					)
				)
			);
		} else {
			$condition = array();
			$condition[] = array("web_id","n=",$att_list['web_id']);
			if(!empty($att_list['news_id'])) $condition[] = array("news_id","n=",$att_list['news_id']);
			$sql = $db->buildSel(
				array(
					array(
						"name" => $setting['db']['pre']."comment",
						"idx" => "a",
						"col" => array("*", "comment as describe"),
						"condition" => $condition
					),
					array(
						"name" => $pre_sub."news_show",
						"idx" => "b",
						"col" => "subject, cat_id",
						"join" => "news_id",
					)
				),
				"",
				$att_list
			);
		}
		
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
	HtmlTrans(&\$record);
	\$record['style'] = \$n++%2 ? "{$att_list['css1']}" : "{$att_list['css2']}";
	\$record['subject_org'] = \$record['subject'];
	\$record['describe'] = \$record['comment'];
	if(empty(\$record['link'])) \$record['link'] = getUrl("read", array(\$record['news_id'], \$record['cat_id']), 1, \$record['web_id']);
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
	
	public static function comment(MyTPL $tpl, $att_list = array()) {
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		$content = $tpl->Get_TPL(dirname(__FILE__)."/tpl/comment_{$att_list['template']}.tpl");
		if(isset($att_list['news_id'])) {
			$content = str_replace("<!--news_id-->", $att_list['news_id'], $content);
		} else {
			$content = str_replace("<!--news_id-->", "<?=\$GLOBALS['news_id']?>", $content);
		}
		if(isset($att_list['web_id'])) {
			$content = str_replace("<!--web_id-->", $att_list['web_id'], $content);
		} else {
			$content = str_replace("<!--web_id-->", "<?=\$setting['info']['web']['web_id']?>", $content);
		}
		$content = str_replace("<!--comment_page_size-->", "<?=\$comment_page_size?>", $content);
		$script .= <<<mystep
<?php
global \$req, \$plugin_setting;
\$req->setCookie("comment_check_".\$GLOBALS['news_id'], md5(date("Y-m-d")), 86400);
\$comment_page_size = \$plugin_setting['comment']['page_size'];
?>
mystep;
		return $script.$content;
	}
	
	public static function ajax_post($news_id, $web_id, $quote, $comment, $vcode) {
		global $db, $req, $setting;
		if($req->getCookie("comment_check_".$news_id)!=md5(date("Y-m-d"))) return array("done"=>false, "info"=>$setting['language']['plugin_comment_error_declined']);
		$plugin_setting = self::setting();
		$result = array();
		$result['done'] = false;
		if($req->getCookie("comment_done")!="") {
			$result['info'] = sprintf($setting['language']['plugin_comment_error_posted'], $plugin_setting['interval']);
		} elseif(strtolower($vcode) != strtolower($req->getCookie('vcode'))) {
			$result['info'] = $setting['language']['plugin_comment_error_vcode'];
		} elseif($setting['info']['user']['type']['view_lvl']<$plugin_setting['view_lvl']) {
			$result['info'] = $setting['language']['plugin_comment_error_level'];
		} else {
			$data['id'] = 0;
			$data['web_id'] = $web_id;
			$data['news_id'] = $news_id;
			$data['user_name'] = getString($setting['info']['user']['name']);
			$data['ip'] = getIp();
			$data['add_date'] = date("Y-m-d H:i:s");
			$data['comment'] = getString($comment);
			$data['agree'] = 0;
			$data['oppose'] = 0;
			$data['report'] = 0;
			$data['quote'] = empty($quote)?0:$quote;
			$db->insert($setting['db']['pre']."comment", $data, true);
			$result['info'] = $setting['language']['plugin_comment_done'];
			$result['done'] = true;
			$result['id'] = $db->GetInsertId();
			$result['user'] = $data['user_name'];
			$result['add_date'] = $data['add_date'];
			self::build_list($news_id, $web_id);
		}
		if($result['done']) $req->setCookie("comment_done", date("Y-m-d H:i:s"), $plugin_setting['interval']*60);
		$req->setCookie("vcode");
		return $result;
	}
	
	public static function ajax_report($comment_id, $type) {
		global $db, $req, $setting;
		$plugin_setting = self::setting();
		$comment_id = mysql_real_escape_string($comment_id);
		$sql = $db->buildSel($setting['db']['pre']."comment","news_id, web_id",array("id","n=",$comment_id));
		list($news_id, $web_id) = array_values(getData($sql, "record", 86400));
		if($req->getCookie("comment_check_".$news_id)!=md5(date("Y-m-d"))) return array("info"=>$setting['language']['plugin_comment_error_declined']);
		$result = array();
		if($req->getCookie("comment_rate")!="") {
			$result['info'] = sprintf($setting['language']['plugin_comment_error_rate'], $plugin_setting['interval_rate']);
		} else {
			if($type==1) {
				$db->update($setting['db']['pre']."comment", array("agree"=>"+1"), array("id","n=",$comment_id));
			} elseif($type==2) {
				$db->update($setting['db']['pre']."comment", array("oppose"=>"+1"), array("id","n=",$comment_id));
			} else {
				$db->update($setting['db']['pre']."comment", array("report"=>"+1","rpt_date"=>"now()"), array("id","n=",$comment_id));
			}
			$result['info'] = $setting['language']['plugin_comment_report'];
			self::build_list($news_id, $web_id);
			$req->setCookie("comment_rate", "done", $plugin_setting['interval_rate']);
		}
		return $result;
	}
	
	public static function build_list($news_id, $web_id) {
		global $db, $setting;
		$comment_list = array();
		$db->select($setting['db']['pre']."comment","*",array(array("news_id","n=",$news_id),array("web_id","n=",$web_id,"and")),array("order"=>"id asc"));
		while($comment=$db->GetRS($query)){
			HtmlTrans($comment);
			$comment['quote_txt'] = "";
			if($comment['quote']>0) {
				if(isset($comment_list[$comment['quote']-1])) {
					$quote_comment = $comment_list[$comment['quote']-1];
					$quote_text = sprintf($setting['language']['plugin_comment_quote'], $comment['quote'], $quote_comment['user_name']);
					$comment['quote_txt'] = <<<windy2000
<fieldset>
	<legend>{$quote_text}</legend>
	<div>{$quote_comment['quote_txt']}</div>
	<div><pre>{$quote_comment['comment']}</pre></div>
</fieldset>
windy2000;
				}
			}
			$comment_list[] = $comment;
		}
		$content = toJson($comment_list, $setting['gen']['charset']);
		if(is_null($content)) $content = "";
		
		WriteFile(ROOT_PATH."/plugin/comment/cache/".$web_id."/".(ceil($news_id/1000)*1000)."/".$news_id.".txt", $content, "wb");
		return;
	}
}
?>