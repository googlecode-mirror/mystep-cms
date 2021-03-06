<?php
class plugin_survey implements plugin {
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
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_survey",1,$info['intro'],$info['copyright'],1,""));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,7,$info['cat_name'],'survey.php', '../plugin/survey/', 0, 0,$info['cat_desc']));
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
		$db->delete($setting['db']['pre']."survey");
		$db->exec("drop","table",$setting['db']['pre']."survey");
		$db->delete($setting['db']['pre']."admin_cat", array("file","like","survey.php%"));
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
			MultiDel(ROOT_PATH."/".$setting['path']['cache']."/plugin/survey/");
			MultiDel(dirname(__FILE__)."/data/");
			MakeDir(dirname(__FILE__)."/data/");
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
			"/data/",
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
	
	public static function survey(MyTPL $tpl, $att_list = array()) {
		global $setting,$db;
		$result = "";
		if(!isset($att_list['id'])) return "";
		if(!isset($att_list['order'])) $att_list['order'] = "";
		if(!isset($att_list['template'])) $att_list['template'] = "classic";
		$att_list['order_desc'] = "";
		if(strtolower(substr($att_list['order'], -5))==" desc") $att_list['order_desc'] = "yes";
		$att_list['order'] = preg_replace("/\s+\w+$/", "", $att_list['order']);
		
		$content = $tpl->Get_TPL(dirname(__FILE__)."/tpl/block_survey_".$att_list['template'].".tpl", dirname(__FILE__)."/tpl/block_survey_classic.tpl");
		preg_match("/".preg_quote($tpl->delimiter_l)."loop:start".preg_quote($tpl->delimiter_r)."(.*)".preg_quote($tpl->delimiter_l)."loop:end".preg_quote($tpl->delimiter_r)."/isU", $content, $block_all);
		$block = $block_all[0];
		$unit = $block_all[1];
		$unit = preg_replace("/".preg_quote($tpl->delimiter_l)."vote_(\w+)".preg_quote($tpl->delimiter_r)."/i", "{\$vote_list[\$i]['\\1']}", $unit);
		$sql = $db->buildSel($setting['db']['pre']."survey", "*", array("id","n=",$att_list['id']));
		$thePath = dirname(__FILE__)."/data/";
		$result = <<<mytpl
<?php
global \$mystep;
\$mydb = \$mystep->getInstance("MyDB", "survey_{$att_list['id']}", "{$thePath}");
\$vote_list = \$mydb->queryAll();
if("{$att_list['order']}"!="") {
	\$mydb->setOrder(\$vote_list, "{$att_list['order']}", "{$att_list['order_desc']}"=="yes");
}
\$mydb->closeTBL();
unset(\$mydb);
\$record = getData("{$sql}", "record", 86400);
\$theId = \$record['id'];
\$theType = (\$record['type']=="1"?"radio":"checkbox");
\$vote_sum = 0;
for(\$i=0, \$m=count(\$vote_list); \$i<\$m; \$i++) {
	\$vote_sum += \$vote_list[\$i]['vote'];
}
if(\$vote_sum==0) \$vote_sum = 1;

for(\$i=0; \$i<\$m; \$i++) {
	\$vote_list[\$i]['id'] = \$theId;
	\$vote_list[\$i]['type'] = \$theType;
	\$vote_list[\$i]['rate'] = ceil((int)\$vote_list[\$i]['vote']*100/\$vote_sum);
	if(empty(\$vote_list[\$i]['vote'])) \$vote_list[\$i]['vote'] = "0";
	if(empty(\$vote_list[\$i]['url'])) {
		\$vote_list[\$i]['url'] = "###";
		\$vote_list[\$i]['link_text'] = "";
	} else {
		\$vote_list[\$i]['link_text'] = "[Link]";
	}
	echo <<<content
{$unit}
content;
	echo "\\n";
}
?>
mytpl;
		$content = str_replace($block, $result, $content);
		$sql = $db->buildSel($setting['db']['pre']."survey", "*", array("id","n=",$att_list['id']));
		if(is_numeric($att_list['id']) && $record = getData($sql, "record", 86400)) {
			$att_list['times'] = $record['times'];
			$att_list['max_select'] = $record['max_select'];
			$att_list['type'] = ($record['max_select']==1 ? "radio" : "checkbox");
			unset($record);
			foreach($att_list as $key => $value) {
				$content = str_replace('<!--'.$key.'-->', '<?="'.$value.'"?>', $content);
			}
		} else {
			$content = preg_replace("/".preg_quote($tpl->delimiter_l)."(\w+)".preg_quote($tpl->delimiter_r)."/i", "<?=\$tpl_para['".$tpl->hash."']['para']['survey'][\"{$att_list['id']}\"]['\\1']?>", $content);
		}
		return $content;
	}
	
	public static function survey_list(MyTPL $tpl, $att_list = array()) {
		global $setting;
		$result = "";
		if(!isset($att_list['order'])) $att_list['order'] = "id desc";
		if(!isset($att_list['limit'])) $att_list['limit'] = 10;
		if(!isset($att_list['loop'])) $att_list['loop'] = 0;
		if(!isset($att_list['condition'])) $att_list['condition'] = "";
		if(!isset($att_list['show_date'])) $att_list['show_date'] = "";
		if(!empty($att_list['show_date']) && date($att_list['show_date'])==$att_list['show_date']) $att_list['show_date'] = "Y-m-d";
		
		$sql = $db->buildSel($setting['db']['pre']."survey", "id, subject, add_date", "", $att_list);
		$content = $tpl->Get_TPL($tpl->tpl_info["path"]."/".$tpl->tpl_info["style"]."/block_news_classic.tpl");
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
\$max_count = count(\$result);
for(\$num=0; \$num<\$max_count; \$num++) {
	\$record = \$result[\$num];
	HtmlTrans(&\$record);
	\$record['link'] = getUrl("survey", \$record['id']);
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
	
	public static function getUrl($url, $idx, $page=1) {
		global $setting;
		if($setting['rewrite']['enable']) {
			$url .= "/survey/".$idx;
		} else {
			$url .= "/module.php?m=survey&id=".$idx;
		}
		$url = str_replace("//", "/", $url);
		$url = str_replace("http:/", "http://", $url);
		return $url;
	}
	
	public static function ajax_vote($id, $vote_list) {
		global $db, $setting, $mystep;
		$sql = $db->buildSel($setting['db']['pre']."survey", "*", array("id","n=",$id));
		if($record = getData($sql, "record", 3600)) {
			extract($record, EXTR_SKIP);
		} else {
			return array();
		}
		$result = array();
		$result['done'] = false;
		if($expire>0 && ($add_date+$expire)<($setting['info']['time_start']/1000)) {
			$result['info'] = $setting['language']['plugin_survey_info_expire'];
		} elseif($setting['info']['user']['type']['view_lvl']==$user_lvl) {
			$result['info'] = $setting['language']['plugin_survey_info_nopower'];
		} elseif($max_select!=0 && $max_select<count($vote_list)) {
			$result['info'] = $setting['language']['plugin_survey_info_overlimit'];
		}else {
			$mydb = $mystep->getInstance("MyDB", "user_".$id, dirname(__FILE__)."/data/");
			if($record=$mydb->queryDate("username=".$setting['info']['user']['name'], true, &$fp_pos, &$row_pos)) {
				$result['info'] = $setting['language']['plugin_survey_info_voted'];
			} else {
				$mydb->insertDate(array($setting['info']['user']['name'], implode(",", $vote_list)));
				$mydb->resetDB("survey_{$id}");
				$max_count = count($vote_list);
				for($i=0; $i<$max_count; $i++) {
					$record = $mydb->queryDate("idx={$vote_list[$i]}", true, &$fp_pos, &$row_pos);
					$data = array(
						"idx"		=> $record['idx'],
						"catalog"		=> $record['catalog'],
						"title"	=> $record['title'],
						"image"	=> $record['image'],
						"url"	=> $record['url'],
						"vote"	=> (int)$record['vote'] + 1,
						);
					$mydb->updateDate($data, $row_pos, true);
				}
				$db->update($setting['db']['pre']."survey", array("times"=>"+1"), array("id","n=",$id));
				$result['info'] = $setting['language']['plugin_survey_info_done'];
				$result['done'] = true;
			}
			$mydb->closeTBL();
			unset($mydb);
			$img_cache = ROOT_PATH."/".$setting['path']['cache']."/plugin/survey/{$id}.png";
			if(file_exists($img_cache)) unlink($img_cache);
		}
		return $result;
	}
}
?>