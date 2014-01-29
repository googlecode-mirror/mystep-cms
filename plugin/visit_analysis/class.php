<?php
class plugin_visit_analysis implements plugin {
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
		$db->insert($setting['db']['pre'].'plugin', array(0,$info['name'],$info['idx'],$info['ver'],"plugin_visit_analysis",1,$info['intro'],$info['copyright'],1,""));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,7,$info['cat_name_1'],'visit_analysis.php?method=referer', '../plugin/visit_analysis/', 0, 0,$info['cat_desc_1']));
		$db->insert($setting['db']['pre'].'admin_cat', array(0,7,$info['cat_name_2'],'visit_analysis.php?method=keyword', '../plugin/visit_analysis/', 0, 0,$info['cat_desc_2']));
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
		$db->delete($setting['db']['pre']."visit_analysis");
		$db->exec("drop","table",$setting['db']['pre']."visit_analysis");
		$db->delete($setting['db']['pre']."visit_keyword");
		$db->exec("drop","table",$setting['db']['pre']."visit_keyword");
		$db->delete($setting['db']['pre']."admin_cat", array("file","like","visit_analysis.php%"));
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
		return "";
	}
	
	public static function referer_analysis() {
		if(checkSign(255)) return;
		global $db, $setting, $req;
		$referer = $req->getServer("HTTP_REFERER");
		$agent = strtolower($req->getServer('HTTP_USER_AGENT'));
		if(strpos($agent, "spider")!==false || strpos($agent, "bot")!==false) return;
		$db->update($setting['db']['pre']."visit_analysis",array("count_month"=>0),array("month(FROM_UNIXTIME(chg_date))","f!=","month(now())"));
		$db->update($setting['db']['pre']."visit_analysis",array("count_year"=>0),array("year(FROM_UNIXTIME(chg_date))","f!=","year(now())"));
		if(strlen($referer)>10) {
			$url_info = parse_url($referer);
			if(strpos($url_info['host'],$req->getServer("HTTP_HOST"))!==false) return;
			if(preg_match("/^[\w\.\-]+$/", $url_info['host'])==false) return;
			if($record = $db->record($setting['db']['pre']."visit_analysis","*",array("host","=",$url_info['host']))) {
				$db->update($setting['db']['pre']."visit_analysis", array("count"=>"+1","count_month"=>"+1","count_year"=>"+1","chg_date"=>"UNIX_TIMESTAMP()"),array("host","=",$url_info['host']));
			} else {
				$db->insert($setting['db']['pre']."visit_analysis", array(0, $url_info['host'], 1, 1, 1, "UNIX_TIMESTAMP()", "UNIX_TIMESTAMP()"));
			}
			unset($record);
			if(!empty($url_info['query'])) {
				parse_str($url_info['query'], $query);
				if(is_numeric($query['w'])) $query['w']="";
				$keyword = $query['k'].$query['q'].$query['wd'].$query['w'].$query['query'].$query['keyword'];
				if(strpos($url_info['host'],"google")>0) $referer = "http://".$url_info['host']."/search?q=".urlencode($query['q']);
				if(strpos($url_info['host'],"baidu")>0) $referer = "http://".$url_info['host']."/s?wd=".urlencode($query['wd']);
				if(strlen($referer)>250) $referer = substrPro($referer, 0, 250);
				if(!empty($keyword)) {
					$keyword = safeEncoding($keyword, $setting['gen']['charset']);
					if(strpos($keyword, $setting['web']['title'])!==false) return;
					$keyword = substrPro($keyword, 0, 190);
					$keyword = mysql_real_escape_string($keyword);
					$url = "http://".$req->getServer("HTTP_HOST").safeEncoding($req->getServer("REQUEST_URI"), $setting['gen']['charset']);
					
					if($record = $db->record($setting['db']['pre']."visit_keyword","*",array("keyword","=",$keyword))) {
						$db->update($setting['db']['pre']."visit_keyword", array("count"=>"+1","chg_date"=>"UNIX_TIMESTAMP()","url"=>$url,"referer"=>$referer),array("keyword","=",$keyword));
					} else {
						$db->insert($setting['db']['pre']."visit_keyword", array(0, $keyword, 1, $url, $referer, "UNIX_TIMESTAMP()", "UNIX_TIMESTAMP()"));
					}
				}
			}
		} else {
			$db->update($setting['db']['pre']."visit_analysis", array("count"=>"+1","count_month"=>"+1","count_year"=>"+1","chg_date"=>"UNIX_TIMESTAMP()"),array("host","=","None"));
		}
		return;
	}
}
?>