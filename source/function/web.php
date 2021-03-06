<?php
/********************************************
*                                           *
* Name    : Functions 4 WEB                 *
* Author  : Windy2000                       *
* Time    : 2006-05-03                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*---------------------------------------Functions For Parameter Start-------------------------------------*/
function makeVarsCode($var, $var_name='') {
	$result = "";
	if(is_array($var)) {
		foreach($var as $key => $value) {
			if(empty($var_name)) {
				$var_name_new = '$'.$key;
			} else {
				$var_name_new = $var_name."['".$key."']";
			}
			$result .= $var_name_new." = ";
			if(is_array($value)) {
				$result .= "array();\n";
				$result .= makeVarsCode($value, $var_name_new);
				$result .= "\n";
			} else {
				if(is_bool($value)) {
					$result .= $value?'true':'false';
				} elseif(is_numeric($value) || strtolower($value)=="true" || strtolower($value)=="false" ) {
					$result .= strtolower($value);
				} else {	
					$result .= "'".addslashes($value)."'";
				}
				$result .= ";\n";
			}
		}
	}
	return $result;
}
function getArrayDetail($array, &$detail, $layer = 0) {
	if(is_array($array)) {
		foreach($array as $key => $value) {
			if(is_array($value)) {
				$detail .= ($layer==0 ? "\n\$GLOBALS['{$key}'] = array(" : str_repeat("\t", $layer)."'{$key}' => array(")."\n";
				getArrayDetail($value, $detail, $layer+1);
				$detail .= ($layer==0 ? ");" : str_repeat("\t", $layer)."),")."\n";
			} else {
				$detail .= ($layer==0 ? "\n\$GLOBALS['{$key}'] = " : str_repeat("\t", $layer)."'{$key}' => ")."'{$value}'".",\n";
			}
		}
	}
	return;
}
function buildCache($idx, $cache_para) {
	global $setting;
	$detail = "<?php";
	getArrayDetail($cache_para, &$detail);
	$detail .= "?>";
	$theFile = str_replace("//", "/", ROOT_PATH."/".$setting['path']['cache']."/para/{$idx}.php");
	WriteFile($theFile, $detail, "wb");
	@chmod($theFile, 0666);
	return true;
}
function deleteCache($idx) {
	global $setting;
	return unlink(ROOT_PATH."/".$setting['path']['cache']."/para/{$idx}.php");
}
function checkCache($idx) {
	global $setting;
	return is_file(ROOT_PATH."/".$setting['path']['cache']."/para/{$idx}.php");
}
function includeCache($idx, $show_error = true) {
	global $setting;
	if(!checkCache($idx)) buildParaList($idx);
	if(checkCache($idx)) {
		include(ROOT_PATH."/".$setting['path']['cache']."/para/{$idx}.php");
		return true;
	} else {
		if($show_error) {
			if(!isset($setting['language']['page_error'])) $setting['language']['page_error'] = "Error occurred...";
			printf($setting['language']['page_error'], $setting['web']['email']);
			exit();
		}
		return false;
	}
}
function getSubSetting($web_id=1) {
	$setting_sub = null;
	$theWeb = getParaInfo("website", "web_id", $web_id);
	if($theWeb === false) {
		$theWeb = getParaInfo("website", "web_id", 1);
	}
	$setting_file = ROOT_PATH."/include/config_".$theWeb['idx'].".php";
	if(is_file($setting_file)) {
		include($setting_file);
	} else {
		global $setting;
		$setting_sub = array();
		$setting_sub['web'] = $setting['web'];
		$setting_sub['db'] = $setting['db'];
		$setting_sub['gen'] = $setting['gen'];
		$setting_sub['cookie'] = $setting['cookie'];
	}
	$setting_sub['info'] = $theWeb;
	return $setting_sub;
}
function getSetting($para_1="", $para_2="", $idx="") {
	if(!empty($idx) && file_exists(ROOT_PATH."/include/config_".$idx.".php")) {
		include(ROOT_PATH."/include/config_".$idx.".php");
		$result = $setting_sub;
	} else {
		include(ROOT_PATH."/include/config.php");
		$result = $setting;
	}
	if(!empty($para_1) && isset($result[$para_1])) {
		$result = $result[$para_1];
		if(!empty($para_2) && isset($result[$para_2])) {
			$result = $result[$para_2];
		}
	}
	return $result;
}
function changeSetting($setting_new, $para_new = array(), $if_write = true) {
	require(ROOT_PATH."/include/config.php");
	$setting = arrayMerge($setting, $setting_new);
	if(isset($para_new["rewrite"])) $rewrite_list = $para_new["rewrite"];
	if(isset($para_new["expire"])) $expire_list = $para_new["expire"];
	if(isset($para_new["authority"])) $authority = $para_new["authority"];
	$rewrite_list_str = var_export($rewrite_list, true);
	$expire_list_str = var_export($expire_list, true);
	$content = <<<mystep
<?php
\$setting = array();

/*--settings--*/
\$rewrite_list = {$rewrite_list_str};
\$expire_list = {$expire_list_str};
\$authority = "{$authority}";
?>
mystep;
	$content = str_replace("/*--settings--*/", makeVarsCode($setting, '$setting'), $content);
	if($if_write) WriteFile(ROOT_PATH."/include/config.php", $content, "wb");
	return $content;
}
function getList($layer = 1, $cat_main = 0) {
	global $catalog, $max_layer;
	if($layer>$max_layer || !is_array($GLOBALS["catalog_{$layer}"])) return;
	for($i=0,$m=count($GLOBALS["catalog_{$layer}"]); $i<$m; $i++) {
		if($GLOBALS["catalog_{$layer}"][$i]['cat_main']==$cat_main) {
			$catalog[] = $GLOBALS["catalog_{$layer}"][$i];
			if(isset($GLOBALS["catalog_".($layer+1)])) getList($layer+1, $GLOBALS["catalog_{$layer}"][$i]['cat_id']);
		}
	}
	return;
}
function buildParaList($idx) {
	global $db, $setting;
	if(empty($db)) {
		$db = new MySQL;
		$db->init($setting['db']['host'], $setting['db']['user'], $setting['db']['pass'], $setting['db']['charset']);
		$db->Connect($setting['db']['pconnect'], $setting['db']['name']);
		$new_db = true;
	}
	$cache_para = array();
	switch($idx) {
		case "news_cat":
			$catalog = array();
			$max_layer = $db->result($setting['db']['pre']."news_cat", "max(cat_layer)");
			if(empty($max_layer)) break;
			for($i=1; $i<=$max_layer; $i++) {
				$GLOBALS["catalog_{$i}"] = array();
				$db->select($setting['db']['pre']."news_cat","*",array("cat_layer","n=",$i),array("order"=>"web_id asc, cat_order asc"));
				while($record = $db->GetRS()) {
					HtmlTrans(&$record);
					$GLOBALS["catalog_{$i}"][] = $record;
				}
			}
			$GLOBALS['catalog'] = $catalog;
			$GLOBALS['max_layer'] = $max_layer;
			getList();
			for($i=0,$m=count($GLOBALS['catalog']); $i<$m; $i++) {
				$db->update($setting['db']['pre']."news_cat", array("cat_order", $i+1), array("cat_id", "n=", $GLOBALS['catalog'][$i]['cat_id']));
				$GLOBALS['catalog'][$i]['cat_order'] = $i+1;
			}
			$cache_para['news_cat'] = $GLOBALS['catalog'];
			break;
		case "link":
			$link_txt = array();
			$link_img = array();
			$db->select($setting['db']['pre']."links","*","",array("order"=>"level desc, id asc"));
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				if(empty($record["image"])) {
					$link_txt[] = $record;
				} else {
					$link_img[] = $record;
				}
			}
			$cache_para['link_txt'] = $link_txt;
			$cache_para['link_img'] = $link_img;
			break;
		case "website":
			$theList = array();
			$db->select($setting['db']['pre']."website","*","",array("order"=>"web_id"));
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				$theList[] = $record;
			}
			$cache_para['website'] = $theList;
			break;
		case "user_group":
		case "user_type":
		case "user_power":
			$theIdx = str_replace("user_", "", $idx);
			$theList = array();
			$db->select($setting['db']['pre'].$idx,"*","",array("order"=>$theIdx."_id"));
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				$theList[] = $record;
			}
			$cache_para[$idx] = $theList;
			break;
		case "admin_cat":
			$theList = array();
			$db->select($setting['db']['pre']."admin_cat","*",array("pid","n=",0),array("order"=>"order desc, id asc"));
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				$record['url'] = $record['path'].$record['file'];
				$theList[] = $record;
			}
			for($i=0,$m=count($theList); $i<$m; $i++) {
				$theList[$i]['sub'] = array();
				$db->select($setting['db']['pre']."admin_cat","*",array("pid","n=",$theList[$i]['id']),array("order"=>"order desc, id asc"));
				while($record=$db->GetRS()) {
					HtmlTrans(&$record);
					$record['url'] = $record['path'].$record['file'];
					$theList[$i]['sub'][] = $record;
				}
			}
			$cache_para[$idx] = $theList;
			
			$theList = array();
			$db->select($setting['db']['pre']."admin_cat","*","",array("order"=>"order desc, id asc"));
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				$record['url'] = $record['path'].$record['file'];
				$theList[] = $record;
			}
			$cache_para[$idx."_plat"] = $theList;
			break;
		case "plugin":
			$theList = array();
			$db->select($setting['db']['pre'].$idx,"*","",array("order"=>"order desc, id asc"));
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				$record['url'] = $record['path'].$record['file'];
				$theList[] = $record;
			}
			$cache_para[$idx] = $theList;
			break;
		default:
			$theList = array();
			$db->select($idx,"*","",array("order"=>"id"));
			if(isset($GLOBALS['errMsg'])) return false;
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				$theList[] = $record;
			}
			$cache_para[$idx] = $theList;
	}
	$db->Free();
	if($cache_para) buildCache($idx, $cache_para);
	if(isset($new_db)) {
		$db->close();
		unset($db);
	}
	return $cache_para ? true : false;
}
function getParaInfo($idx, $col, $value, $like = false) {
	if($idx=="news_cat_sub") {
		global $setting;
		for($i=0,$m=count($GLOBALS['news_cat']); $i<$m; $i++) {
			if(!isset($GLOBALS['news_cat'][$i][$col])) continue;
			if(strtolower($GLOBALS['news_cat'][$i][$col]) == strtolower($value) && ($col=='cat_id' || ($col!='cat_id' && $GLOBALS['news_cat'][$i]['web_id']==$setting['info']['web']['web_id']))) {
				return $GLOBALS['news_cat'][$i];
			} 
		}
	}
	if(!isset($GLOBALS[$idx]) || !is_array($GLOBALS[$idx]) ) return false;
	for($i=0,$m=count($GLOBALS[$idx]); $i<$m; $i++) {
		if(!isset($GLOBALS[$idx][$i][$col])) continue;
		if($like && strpos(strtolower($GLOBALS[$idx][$i][$col]), strtolower($value))===0) {
			return $GLOBALS[$idx][$i];
		}
		if(strtolower($GLOBALS[$idx][$i][$col]) == strtolower($value)) {
			return $GLOBALS[$idx][$i];
		} 
	}
	return false;
}
function checkSign($sign) {
	global $ms_sign;
	return $ms_sign!=null && ($ms_sign & $sign = $sign);
}
/*---------------------------------------Functions For Parameter End-------------------------------------*/

/*---------------------------------------Functions For Web Start-------------------------------------*/
function getData($query, $mode="all", $ttl = 600) {
	global $db, $cache;
	$key = md5($query);
	if($mode=="remove") {
		$cache->set($key);
		return "";
	}
	$result = $cache->get($key);
	if(!$result) {
		switch($mode) {
			case "record":
				$result = $db->GetSingleRecord($query);
				break;
			case "result":
				$result = $db->GetSingleResult($query);
				break;
			default:
				$result = array();
				$db->Query($query);
				while($record = $db->GetRS()) $result[]=$record;
				break;
		}
		$db->Free();
		$cache->set($key, $result, $ttl);
	}
	return $result;
}
function getFuncData($func, $ttl = 600) {
	global $cache;
	$argList = func_get_args();
	$key = md5(implode(",", $argList));
	$result = $cache->get($key);
	if(!$result) {
		array_shift($argList);
		$result = call_user_func_array($func, $argList);
		$cache->set($key, $result, $ttl);
	}
	return $result;
}
function getUrl($mode, $idx="", $page=1, $web_id=0) {
	global $setting;
	if($web_id == 0) {
		$webInfo = $setting['info']['web'];
	} else {
		$webInfo = getParaInfo("website", "web_id", $web_id);
	}
	if(!is_numeric($page)) $page = "all";
	if($webInfo===false) return "#";
	$url = $webInfo['host'];
	if(strpos($url, ",")!==false) $url = substr($url, 0, strpos($url, ","));
	$url = "http://".$url;
	switch($mode) {
		case "read":
			if(is_array($idx)) {
				$news_id = $idx[0];
				$cat_idx = $idx[1];
			} else {
				$news_id = $idx;
				$cat_idx = "";
			}
			if($setting['rewrite']['enable']) {
				if(is_numeric($cat_idx)) {
					if($cat_info = getParaInfo("news_cat_sub", "cat_id", $cat_idx)) {
						$cat_idx = $cat_info['cat_idx'];
					} else {
						$cat_idx = "";
					}
				}
				$url .= "/".$setting['rewrite']['read']."/";
				if($news_id!=0) {
					if(empty($cat_idx)) $cat_idx = "misc";
					$url .= $cat_idx."/";
					$url .= $news_id.($page==1?"":"_{$page}").$setting['gen']['cache_ext'];
				}
			} else {
				if($news_id!=0) {
					$url .= "/read.php?id=".$news_id."&page=".$page;
				} else {
					$url .= "/list.php?cat=".$cat_idx;
				}
			}
			break;
		case "list":
			if(is_array($idx)) {
				$cat_idx = $idx[0];
				$cat_pre = $idx[1];
			} else {
				$cat_idx = $idx;
				$cat_pre = "";
			}
			if($setting['rewrite']['enable']) {
				if(is_numeric($cat_idx)) {
					if($cat_info = getParaInfo("news_cat_sub", "cat_id", $cat_idx)) {
						$cat_idx = $cat_info['cat_idx'];
					} else {
						$cat_idx = "";
					}
				}
				$url .= "/".$setting['rewrite']['list']."/";
				if(!empty($cat_idx)) {
					$url .= $cat_idx."/";
				} else {
					$url .= "misc/";
				}
				if(!empty($cat_pre)) {
					$url .= $cat_pre."/";
				}
				$url .= "index";
				if($page>1) $url .= "_{$page}";
				$url .= $setting['gen']['cache_ext'];
			} else {
				$url .= "/list.php?cat=".$cat_idx."&pre=".$cat_pre."&page=".$page;
			}
			break;
		case "tag":
			if($setting['rewrite']['enable']) {
				$url .= "/tag/".$idx.($page==1?"":"_{$page}").$setting['gen']['cache_ext'];
			} else {
				$url .= "/tag.php?tag=".$idx."&page=".$page;
			}
			break;
		default:
			global $mystep;
			$url = $mystep->getUrl($mode, $url, $idx, $page);
			break;
	}
	$url = str_replace("//", "/", $url);
	$url = str_replace("http:/", "http://", $url);
	return $url;
}
function delCacheFile($news_id, $web_id=0) {
	global $db, $setting;
	if(!$setting['gen']['cache']) return false;
	if($web_id==0) $web_id=$setting['info']['web']['web_id'];
	$setting_sub = getSubSetting($web_id);
	$db_pre = $setting_sub['db']['name'].".".$setting_sub['db']['pre'];
	
	$sql = $db->buildSel(array(
		array(
			"name" => $db_pre."news_show",
			"idx" => "a",
			"col" => "add_date, pages",
			"condition" => array("news_id", "n=", $news_id)
		),
		array(
			"name" => $setting['db']['pre']."news_cat",
			"idx" => "b",
			"col" => "cat_idx",
			"join" => "cat_id",
		)
	));
	list($add_date, $page_count, $cat_idx)=$db->GetSingleRecord($sql, false);
	if(is_null($cat_idx) || is_null($add_date)) return false;
	$file_idx = ROOT_PATH."/".$setting['path']['cache']."/html/".$setting_sub['info']['idx']."/".date("Y/md",strtotime($add_date))."/".$news_id;
	unlink($file_idx.$setting['gen']['cache_ext']);
	for($i=2; $i<=$page_count; $i++) {
		unlink($file_idx."_{$i}".$setting['gen']['cache_ext']);
	}
	return true;
}
function getCacheExpire() {
	global $expire_list, $setting;
	$the_file = str_replace(".php", "", $setting['info']['self']);
	return isset($expire_list[$the_file]) ? $expire_list[$the_file] : $expire_list["default"];
}
function showInfo($msg = "", $exit = true, $link = "") {
	global $setting;
	if(empty($link)) $link = "javascript:history.go(-1)";
	$result = <<<windy2000
<div style="margin-top:40px;">
  <table align="center" border="0" width="80%" cellspacing="0" cellpadding="0">
    <tr><td>
      <table width="100%" style="padding:5px; background-color:#eeeeee; border:1px #666666 solid; table-layout:fixed;">
        <tr><td align="center" style="padding:40px;font-weight:bold;font-size:14px;color:black">{$msg}</td></tr>
      </table>
      <div style="text-align:center; margin-top:20px;">
      	<a href="{$link}" style="font-size:12px;color:black;text-decoration:none;">[ {$setting['language']['link_back']} ]</a>
      </div>
    </td></tr>
  </table>
</div>
windy2000;
	if($exit) {
		global $db;
		if(!empty($db)) {
			$db->close();
			unset($db);
		}
		if(ob_get_length()!==false) ob_end_flush();
		echo $result;
		exit();
	}
	return $result;
}
function PageList($page, $page_count, $show=6) {
	global $setting;
	$list = "";
	if($page_count>1) {
		$page_start = 0;
		$page_end = $page_count;
		$page_more_start = '';
		$page_more_end = '';
		
		if($page_count<=$show+2) {
			if($page_count>1) {
				$page_start = 2;
				$page_end = $page_count;
			}
		} else if($page<$show) {
			$page_start = 2;
			$page_end = $show + 1;
			$page_more_end = '&#8230;&#8230; ';
		} else if($page+$show>$page_count) {
			$page_start = $page_count - $show;
			$page_end = $page_count;
			$page_more_start = '&#8230;&#8230; ';
		} else {
			$page_start = $page - $show/2;
			$page_end = $page + $show/2 + 1;
			$page_more_start = '&#8230;&#8230; ';
			$page_more_end = '&#8230;&#8230; ';
		}

		if($page==1) {
			$list .= '<em>'.$setting['language']['link_prev'].'</em> ';
		} else {
			$list .= '<a href="'.gotoPage($page-1).'">'.$setting['language']['link_prev'].'</a> ';
		}
		$list .= ($page==1 ? '<strong>1</strong> ' : '<a href="'.gotoPage(1).'">1</a> ');
		$list .= $page_more_start;
		
		for($i=$page_start; $i<$page_end; $i++) {
			if($page==$i) {
				$list .= '<strong>'.$i.'</strong> ';
			} else {
				$list .= '<a href="'.gotoPage($i).'">'.$i.'</a> ';
			}
		}
		
		$list .= $page_more_end;
		$list .= ($page==$page_count ? '<strong>'.$page_count.'</strong> ' : '<a href="'.gotoPage($page_count).'">'.$page_count.'</a> ');
		if($page==$page_count) {
			$list .= '<em>'.$setting['language']['link_next'].'</em> ';
		} else {
			$list .= '<a href="'.gotoPage($page+1).'">'.$setting['language']['link_next'].'</a> ';
		}
	}
	return $list;
}
function gotoPage($page) {
	global $req, $setting;
	$script = $req->getServer("HTTP_X_ORIGINAL_URL");
	if(empty($script)) $script = $req->getServer("SCRIPT_NAME");
	$the_url = "http://".$req->getServer("SERVER_NAME").$script;
	if($setting['rewrite']['enable'] && (isset($_SERVER['HTTP_X_ORIGINAL_URL']) || (!isset($_SERVER['HTTP_X_ORIGINAL_URL']) && strpos($_SERVER['REQUEST_URI'],".php")===false))) {
		if(substr($the_url, -1, 1)=="/") {
			$the_url .= "index_{$page}{$setting['gen']['cache_ext']}";
		} elseif(preg_match("/\/\d+$/", $the_url)) {
			$the_url = preg_replace("/\/\d+$/", "/".$page, $the_url);
		} elseif(preg_match("/\/\w+$/", $the_url)) {
			$the_url .= "/index_{$page}{$setting['gen']['cache_ext']}";
		} else {
			$the_url = preg_replace("/(_\d+)?{$setting['gen']['cache_ext']}$/", ($page==1?"{$setting['gen']['cache_ext']}":"_{$page}{$setting['gen']['cache_ext']}"), $the_url);
		}
	} else {
		$qry_str = $req->getServer("QUERY_STRING");
		if(!empty($qry_str)) $the_url .= "?".$qry_str;
		if(empty($qry_str)) {
			$the_url .= "?page={$page}";
		} else {
			if(preg_match("/page\=\d*/", $the_url)) {
				$the_url = preg_replace("/page=(\d*)/", "page={$page}", $the_url);
			} else {
				$the_url .= "&page={$page}";
			}
		}
	}
	return $the_url;
}
function CheckCanGzip() {
	$ENCODING = " ";
	isset($_SERVER["HTTP_ACCEPT_ENCODING"]) ? $ENCODING.=$_SERVER["HTTP_ACCEPT_ENCODING"] : null;
	isset($_ENV["HTTP_ACCEPT_ENCODING"]) ? $ENCODING.=$_ENV["HTTP_ACCEPT_ENCODING"] : null;
	if (headers_sent() || connection_aborted()) return 0;
	if (strpos($ENCODING, 'x-gzip')) return "x-gzip";
	if (strpos($ENCODING, 'gzip')) return "gzip";
	return 0;
}
function GzDocOut($level = 3, $show = false) {
	global $setting;
	$ENCODING = CheckCanGzip();
	$Content  = ob_get_contents();
	$cache_use = isset($GLOBALS['cache_info']) && is_array($GLOBALS['cache_info']);
	if($ENCODING && $level) {
		if(count(ob_list_handlers())>0) ob_end_clean();
		$rate = ceil(strlen(gzcompress($Content,$level)) * 100 / (strlen($Content)==0?1:strlen($Content))). "%";
		
		if($show) {
			$Content .= "
<div align='center' style='color:#ccc; margin-top:5px;'>
{$setting['language']['info_compressmode']} $ENCODING &nbsp; | &nbsp;
{$setting['language']['info_compresslevel']} $level &nbsp; | &nbsp;
{$setting['language']['info_compressrate']} $rate &nbsp; | &nbsp;
{$setting['language']['info_querycount']}".(empty($setting['info']['query_count'])?0:$setting['info']['query_count'])." &nbsp; | &nbsp;
{$setting['language']['info_exectime']}".(gettimediff($setting['info']['time_start'])/1000)." ms &nbsp; | &nbsp;
{$setting['language']['info_cacheuse']}".($cache_use?"Yes":"No")."
</div>";
		}
		header("Content-Encoding: $ENCODING");
		print "\x1f\x8b\x08\x00\x00\x00\x00\x00";
		$Size = strlen($Content);
		$Crc = crc32($Content);
		$Content = gzcompress($Content,$level);
		$Content = substr($Content, 0, strlen($Content) - 4);
		print $Content;
		print pack('V',$Crc);
		print pack('V',$Size);
	} else {
		if(!empty($Content)) ob_end_flush();
		if($show) {
			echo "
<div align='center' style='color:#ccc; margin-top:5px;'>
{$setting['language']['info_querycount']}".(empty($setting['info']['query_count'])?0:$setting['info']['query_count'])." &nbsp; | &nbsp;
{$setting['language']['info_exectime']}".(gettimediff($setting['info']['time_start'])/1000)." ms &nbsp; | &nbsp;
{$setting['language']['info_cacheuse']}".($cache_use?"Yes":"No")."
</div>
";
		}
	}
	return; 
}
function itemTrans($str, $type, $from=0, $to=1) {
	if(!is_string($str)) return $str;
	$the_file = ROOT_PATH."/script/jquery.autocomplete/".$type.".php";
	if(file_exists($the_file)) {
		include($the_file);
		$type = $$type;
		for($i=0,$m=count($type);$i<$m;$i++) {
			if($type[$i][$from]==$str) {
				$str = $type[$i][$to];
				break;
			}
		}
	}
	return $str;
}
function __autoload($class_name) {
	if($class_name=="parent") return;
	global $class_list;
	if(isset($class_list[$class_name]) && defined('ROOT_PATH')) {
		include(ROOT_PATH."/source/class/".$class_list[$class_name]);
	}
	if (!class_exists($class_name, false)) {
		trigger_error("Unable to load class: {$class_name}", E_USER_WARNING);
	}
}
/*--------------------------------Functions For Web End--------------------------------------------*/

/*--------------------------------Functions For Error Start------------------------------------------*/
function getString($str) {
	if(is_array($str)) {
		foreach($str as $key => $value) {
			$str[$key] = getString($value);
		}
	} else {
		if(preg_match("/(\-[\w]{2})+/", $str)) $str = str_replace("-", "%", $str);
		if(preg_match("/(%[\w]{2})+/", $str)) $str = urldecode($str);
		if(is_utf8($str)) {
			global $setting;
			$str = chg_charset($str, "utf-8", $setting['gen']['charset']);
		}
	}
	return $str;
}
function ErrorHandler ($err_no, $err_msg, $err_file, $err_line, $err_context) {
	$err_type = array(
		E_ERROR => 'Fatal Error',
		E_WARNING => 'Warning',
		E_PARSE => 'Parse Error',
		E_NOTICE => 'Notice',
		E_CORE_ERROR => 'Fatal Core Error',
		E_CORE_WARNING => 'Core Warning',
		E_COMPILE_ERROR => 'Compilation Error',
		E_COMPILE_WARNING => 'Compilation Warning',
		E_USER_ERROR => 'Triggered Error',
		E_USER_WARNING => 'Triggered Warning',
		E_USER_NOTICE => 'Triggered Notice',
		E_STRICT => 'Deprecation Notice',
		E_RECOVERABLE_ERROR => 'Catchable Fatal Error',
		E_ALL =>	"Impossible Error",
	);
	if($err_no==E_NOTICE || $err_no==E_WARNING || $err_no==E_STRICT) return;
	$cur_err = $err_type[$err_no];
	$err_str  = "MyStep Error\n";
	$err_str .= "Time: ".date("Y-m-d H:i:s")."\n";
	$err_str .= "Type: {$cur_err}\n";
	$err_str .= "File: {$err_file}\n";
	$err_str .= "Info.: {$err_msg}\n";
	$err_str .= "URL: http://".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']."\n";
	$err_str .= "Debug: \n";
	$debug_info = debug_backtrace();
	$n=0;
	for($i=count($debug_info)-1; $i>=0; $i--) {
		if(empty($debug_info[$i]['file'])) continue;
		$err_str .= (++$n)." - ".$debug_info[$i]['file']." (line:".$debug_info[$i]['line'].", function:".$debug_info[$i]['function'].")\n";
	}
	$err_str .= "-------------------------------------\n";
	$err_str = str_replace("\r", "", $err_str);
	if(strpos($err_script,"@")===false) WriteError($err_str);
	if(ob_get_length()!==false) ob_end_clean();
	$GLOBALS['errMsg'] = $err_str;
	return;
}
function WriteError($err) {
	$err_file = ROOT_PATH."/error.log";
	WriteFile($err_file, $err, "ab");
	return;
}
function outputErrMsg() {
	if(!isset($GLOBALS['errMsg'])) return false;
	$lines = explode("\n", $GLOBALS['errMsg']);
	echo <<<mystep
<div style="line-height:24px;border:#999 1px solid;">
<div style="background-color:#999;color:#FFF">&nbsp;<strong>{$lines[0]}</strong></div>

mystep;
	for($i=1,$m=count($lines); $i<$m; $i++) {
		if(empty($lines[$i])) {
			break;
		} elseif(preg_match("/^([\w\s\.]+\:)(.*)$/", $lines[$i], $matches)) {
			echo "<div style=\"background-color:".($i%2?"#eee":"#fff")."\">&nbsp;<strong>".$matches[1]."</strong>".$matches[2]."</div>\n";
		} else {
			echo "<div>&nbsp; &nbsp; ".$lines[$i]."</div>\n";
		}
	}
	echo "</div>";
	return true;
}
/*--------------------------------Functions For Error End--------------------------------------------*/
?>