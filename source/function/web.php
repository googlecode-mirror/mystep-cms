<?php
/********************************************
*                                           *
* Name    : Functions 4 WEB                 *
* Author  : Windy2000                       *
* Time    : 2006-05-03                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
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
	WriteFile(ROOT_PATH."/".$setting['path']['cache']."/para/{$idx}.php", $detail, "wb");
	chmod(ROOT_PATH."/".$setting['path']['cache']."/para/{$idx}.php", 0666);
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
			printf($setting['language']['page_error'], $setting['web']['email']);
			exit();
		}
		return false;
	}
}

function getSubSetting($web_id) {
	$setting_sub = null;
	if($theWeb = getParaInfo("website", "web_id", $web_id)) {
		$setting_file = ROOT_PATH."/include/config_".$theWeb['idx'].".php";
		if(is_file($setting_file)) {
			include($setting_file);
			$setting_sub['info'] = $theWeb;
		}
	}
	if(is_null($setting_sub)) {
		global $setting;
		$setting_sub = array();
		$setting_sub['web'] = $setting['web'];
		$setting_sub['db'] = $setting['db'];
		$setting_sub['gen'] = $setting_sub['gen'];
		$setting_sub['cookie'] = $setting['cookie'];
	}
	return $setting_sub;
}

function getList($layer = 1, $cat_main = 0) {
	global $catalog, $max_layer;
	if($layer>$max_layer || !is_array($GLOBALS["catalog_{$layer}"])) return;
	$max_count = count($GLOBALS["catalog_{$layer}"]);
	for($i=0; $i<$max_count; $i++) {
		if($GLOBALS["catalog_{$layer}"][$i]['cat_main']==$cat_main) {
			$catalog[] = $GLOBALS["catalog_{$layer}"][$i];
			if(isset($GLOBALS["catalog_".($layer+1)])) getList($layer+1, $GLOBALS["catalog_{$layer}"][$i]['cat_id']);
		}
	}
	return;
}

function buildParaList($idx) {
	global $db, $setting;
	$cache_para = array();
	switch($idx) {
		case "news_cat":
			$catalog = array();
			$max_layer = $db->GetSingleResult("select max(cat_layer) from ".$setting['db']['pre']."news_cat");
			if(empty($max_layer)) break;
			for($i=1; $i<=$max_layer; $i++) {
				$GLOBALS["catalog_{$i}"] = array();
				$db->Query("select * from ".$setting['db']['pre']."news_cat where cat_layer={$i} order by cat_order asc");
				while($record = $db->GetRS()) {
					HtmlTrans(&$record);
					$GLOBALS["catalog_{$i}"][] = $record;
				}
			}
			$GLOBALS['catalog'] = $catalog;
			$GLOBALS['max_layer'] = $max_layer;
			getList();
			$max_count = count($GLOBALS['catalog']);
			for($i=0; $i<$max_count; $i++) {
				$db->Query("update ".$setting['db']['pre']."news_cat set cat_order=".($i+1)." where cat_id='".$GLOBALS['catalog'][$i]['cat_id']."'");
				$GLOBALS['catalog'][$i]['cat_order'] = $i+1;
			}
			$cache_para['news_cat'] = $GLOBALS['catalog'];
			break;
		case "link":
			$link_txt = array();
			$link_img = array();
			$db->Query("select * from ".$setting['db']['pre']."links order by level desc, id asc");
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
			$db->Query("select * from ".$setting['db']['pre']."website order by web_id");
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
			$db->Query("select * from ".$setting['db']['pre'].$idx." order by ".$theIdx."_id");
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				$theList[] = $record;
			}
			$cache_para[$idx] = $theList;
			break;
		case "admin_cat":
			$theList = array();
			$db->Query("select * from ".$setting['db']['pre']."admin_cat where pid=0 order by `order` desc, id asc");
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				$record['url'] = $record['path'].$record['file'];
				$theList[] = $record;
			}
			$max_count = count($theList);
			for($i=0; $i<$max_count; $i++) {
				$theList[$i]['sub'] = array();
				$db->Query("select * from ".$setting['db']['pre']."admin_cat where pid=".$theList[$i]['id']." order by `order` desc, id asc");
				while($record=$db->GetRS()) {
					HtmlTrans(&$record);
					$record['url'] = $record['path'].$record['file'];
					$theList[$i]['sub'][] = $record;
				}
			}
			$cache_para[$idx] = $theList;
			
			$theList = array();
			$db->Query("select * from ".$setting['db']['pre']."admin_cat order by `order` desc, id");
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				$record['url'] = $record['path'].$record['file'];
				$theList[] = $record;
			}
			$cache_para[$idx."_plat"] = $theList;
			break;
		case "plugin":
			$theList = array();
			$db->Query("select * from ".$setting['db']['pre'].$idx." order by `order` desc, id asc");
			while($record=$db->GetRS()) {
				HtmlTrans(&$record);
				$record['url'] = $record['path'].$record['file'];
				$theList[] = $record;
			}
			$cache_para[$idx] = $theList;
			break;
		default:
			return false;
	}
	$db->Free();
	if($cache_para) buildCache($idx, $cache_para);
	return $cache_para ? true : false;
}

function getParaInfo($idx, $col, $value) {
	if($idx=="news_cat_sub") {
		global $setting;
		$max_count = count($GLOBALS['news_cat']);
		for($i=0; $i<$max_count; $i++) {
			if(!isset($GLOBALS['news_cat'][$i][$col])) continue;
			if(strtolower($GLOBALS['news_cat'][$i][$col]) == strtolower($value) && $GLOBALS['news_cat'][$i]['web_id']==$setting['info']['web']['web_id']) {
				return $GLOBALS['news_cat'][$i];
			} 
		}
	}
	if(!isset($GLOBALS[$idx]) || !is_array($GLOBALS[$idx]) ) return false;
	$max_count = count($GLOBALS[$idx]);
	for($i=0; $i<$max_count; $i++) {
		if(!isset($GLOBALS[$idx][$i][$col])) continue;
		if(strtolower($GLOBALS[$idx][$i][$col]) == strtolower($value)) {
			return $GLOBALS[$idx][$i];
		} 
	}
	return false;
}
/*---------------------------------------Functions For Parameter End-------------------------------------*/

/*---------------------------------------Functions For Web Start-------------------------------------*/
function checkUser() {
	global $req, $db, $setting;
	$ms_user = $req->getCookie('ms_user');
	if(!is_null($ms_user)) {
		list($user_id, $user_pwd)=explode("\t",$ms_user);
		if($userinfo = $db->GetSingleRecord("SELECT username, group_id, type_id from ".$setting['db']['pre']."users where user_id='{$user_id}' and password='".mysql_real_escape_string($user_pwd)."'")) {
			$req->setSession("username", $userinfo['username']);
			$req->setSession("usergroup", $userinfo['group_id']);
			$req->setSession("usertype", $userinfo['type_id']);
		} elseif($user_id==0 && $user_pwd==$setting['web']['s_pass']) {
			$req->setSession("username", $setting['web']['s_user']);
			$req->setSession("usergroup", 1);
			$req->setSession("usertype", 3);
		}
	}
}

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

function getFuncData($func) {
	global $cache;
	$argList = func_get_args();
	$key = md5(implode(",", $argList));
	$result = $cache->get($key);
	if(!$result) {
		array_shift($argList);
		$result = call_user_func_array($func, $argList);
		$cache->set($key, $result, 600);
	}
	return $result;
}

function getFileURL($news_id=0, $cat_idx="", $web_id=1, $page=1) {
	global $setting;
	$webInfo = getParaInfo("website", "web_id", $web_id);
	$url = $webInfo['host'];
	if($setting['gen']['rewrite']) {
		$url = "http://".str_replace("//", "/", $url);
		if($news_id==0) {
			if(!empty($cat_idx)) {
				$url .= "/catalog/".$cat_idx."/";
			} else {
				$url .= "/catalog/misc/";
			}
			if($page>1) $url .= "index_{$page}".$setting['gen']['cache_ext'];
		} else {
			if(!empty($cat_idx)) {
				$url .= "/article/".$cat_idx."/";
			} else {
				$url .= "/article/misc/";
			}
			$url .= $news_id.($page==1?"":"_{$page}").$setting['gen']['cache_ext'];
		}
		$url = preg_replace("/([^:])\/+/", "\\1/", $url);
	} else {
		if($news_id==0) {
			$url = "http://".$url."/list.php?cat={$cat_idx}";
		} else {
			$url = "http://".$url."/read.php?id={$news_id}";
		}
		if($page>1) $url .= "&page={$page}";
	}
	return $url;
}

function delCacheFile($news_id) {
	global $db, $setting;
	if(!$setting['gen']['cache']) return false;
	list($cat_idx, $add_date, $page_count)=array_values($db->GetSingleRecord("select b.cat_idx, a.add_date, a.pages from ".$setting['db']['pre']."news_show a left join ".$setting['db']['pre']."news_cat b on a.cat_id=b.cat_id where a.news_id='{$news_id}'"));
	if(is_null($cat_idx) || is_null($add_date)) return false;

	$file_idx = ROOT_PATH."/".$setting['path']['cache']."/".$cat_idx."/".date("Ym",strtotime($add_date))."/".$news_id;
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

function showInfo($msg = "", $mode = true) {
	global $setting;
	$result = <<<windy2000
<div style="margin-top:40px;">
  <table align="center" border="0" width="80%" cellspacing="0" cellpadding="0">
    <tr><td>
      <table width="100%" style="padding:5px; background-color:#eeeeee; border:1px #666666 solid; table-layout:fixed;">
        <tr><td align="center" style="padding:40px;font-weight:bold;font-size:14px;color:black">{$msg}</td></tr>
      </table>
      <div style="text-align:center; margin-top:20px;">
      	<a href="javascript:history.go(-1)" style="font-size:12px;color:black;text-decoration:none;">[ {$setting['language']['link_back']} ]</a>
      </div>
    </td></tr>
  </table>
</div>
<script>
setTimeout("history.go(-1)", 2000);
</script>
windy2000;
	if($mode) {
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
			$page_more_end = 'бнбн ';
		} else if($page+$show>$page_count) {
			$page_start = $page_count - $show;
			$page_end = $page_count;
			$page_more_start = 'бнбн ';
		} else {
			$page_start = $page - $show/2;
			$page_end = $page + $show/2 + 1;
			$page_more_start = 'бнбн ';
			$page_more_end = 'бнбн ';
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
	$the_url = "http://".$req->getServer("SERVER_NAME").$req->getServer("REQUEST_URI");
	if($setting['gen']['rewrite']) {
		if(substr($the_url, -1, 1)=="/") {
			$the_url .= "index_{$page}{$setting['gen']['cache_ext']}";
		} else {
			$the_url = preg_replace("/(_\d+)?{$setting['gen']['cache_ext']}$/", ($page==1?"{$setting['gen']['cache_ext']}":"_{$page}{$setting['gen']['cache_ext']}"), $the_url);
		}
	} else {
		$qry_str = $req->getServer("QUERY_STRING");
		if(empty($qry_str)) {
			$the_url .= "?page={$page}";
		} else {
			if(preg_match("/page\=\d+/", $the_url)) {
				$the_url = preg_replace("/page=(\d+)/", "page={$page}", $the_url);
			} else {
				$the_url .= "&page={$page}";
			}
		}
	}
	return $the_url;
}

function CheckCanGzip(){
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

function __autoload($class_name) {
	if($class_name=="parent") return;
	global $class_list;
	if(isset($class_list[$class_name]) && defined('ROOT_PATH')) {
		include_once(ROOT_PATH."/source/class/".$class_list[$class_name]);
	}
	if (!class_exists($class_name, false)) {
		trigger_error("Unable to load class: {$class_name}", E_USER_WARNING);
	}
}
/*--------------------------------Functions For Web End--------------------------------------------*/

/*--------------------------------Functions For Error Start------------------------------------------*/
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
	/*
	$err_str .= "Line: {$err_line}\n";
	if(is_file($err_file)) {
		$content = file($err_file);
		$err_script = $content[$err_line-1];
		$err_str .= "Script: ".htmlspecialchars($err_script)."\n";
	}
	*/
	$err_str .= "Info.: {$err_msg}\n";
	$err_str .= "Debug: \n";
	$debug_info = debug_backtrace();
	$max_count = count($debug_info);
	$n=0;
	for($i=count($debug_info)-1; $i>=0; $i--){
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
	$max_count = count($lines);
	for($i=1; $i<$max_count; $i++) {
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