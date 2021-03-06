<?php
/********************************************
*                                           *
* Name    : Core of the Web                 *
* Author  : Windy2000                       *
* Time    : 2010-12-16                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

class MyStep extends class_common {
	protected
		$func_start = array(),
		$func_end = array(),
		$func_tag = array(),
		$func_api = array(),
		$func_ajax = array(),
		$func_log = array(),
		$module = array(),
		$language = array(),
		$content = array(),
		$url = array(),
		$css = array(),
		$js = array();
	
	public static $func_log_s = array();
	
	public function __construct() {
		global $setting;
		error_reporting(E_ALL ^ E_NOTICE);
		date_default_timezone_set($setting['gen']['timezone']);
		set_error_handler("ErrorHandler");
		header("Content-Type: text/html; charset=".$setting['gen']['charset']);
		set_time_limit(30);
		ini_set('memory_limit', '128M');
		ini_set('magic_quotes_runtime', 0);
		ini_set('mysql.connect_timeout', 300);
		ini_set('default_socket_timeout', 300);
		if(function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) {
			strip_slash($_POST);
			strip_slash($_GET);
			strip_slash($_COOKIE);
		}
		return;
	}
	
	public function getInstance($calledClass = "") {
		global $setting, $class_list;
		if(!class_exists($calledClass)) {
			if(isset($class_list[$calledClass]) && defined('ROOT_PATH')) {
				include(ROOT_PATH."/source/class/".$class_list[$calledClass]);
			}
			if (!class_exists($calledClass)) {
				trigger_error("Unable to load class: ".$calledClass, E_USER_WARNING);
			}
		}
		$argList = func_get_args();
		$obj = call_user_func_array(array($this, 'parent::getInstance'), $argList);
		$obj->SetErrorHandle("WriteError");
		switch($calledClass) {
			case 'MySQL':
				$obj->Connect($setting['db']['pconnect'], $setting['db']['name']);
				break;
			case 'MyTpl':
				$obj->Reg_Tags($this->func_tag);
				$obj->Set_Variables($setting['language'], 'lang');
				break;
			case 'MyAjax':
				$obj->regMethods($this->func_ajax);
				break;
			case 'MyApi':
				$obj->regMethods($this->func_api);
				break;
			default:
				break;
		}
		return $obj;
	}
	
	public function setAddedContent($type, $content) {
		$this->content[$type][] = $content;
	}
	
	public function getAddedContent($type) {
		$result = "";
		if(isset($this->content[$type])) $result = join("\n", $this->content[$type]);
		return $result;
	}
	
	public function pushAddedContent(MyTpl $tpl) {
		$argList = func_get_args();
		$max_count = count($argList);
		if($max_count==1) {
			function joinIt($content){return join("\n", $content);}
			$tpl->Set_Variables(array_map("joinIt", $this->content), "page");
		} else {
			for($i=1; $i<$max_count; $i++) {
				$tpl->Set_Variable('page_'.$argList[$i], $this->getAddedContent($argList[$i]));
			}
		}
	}
	
	public function setLanguage($language) {
		if(is_array($language)) {
			$this->language = array_merge($this->language, $language);
		}
	}
	
	public function getLanguage($dir) {
		global $setting;
		if(is_file($dir."/default.php")) {
			include($dir."/default.php");
			if(isset($language)) $this->setLanguage($language);
			unset($language);
		}
		if(is_file($dir."/".$setting['gen']['language'].".php")) {
			include($dir."/".$setting['gen']['language'].".php");
			if(isset($language)) $this->setLanguage($language);
		}
	}
	
	public function setPlugin() {
		includeCache("plugin");
		global $plugin_setting, $setting, $op_mode;
		$web_id = $setting['info']['web']['web_id'];
		$plugins = array();
		if($op_mode==true) {
			$plugins = $GLOBALS['plugin'];
		} else {
			$plugin_idx = ROOT_PATH."/cache/plugin/".$setting['info']['web']['idx'].".php";
			if(file_exists($plugin_idx)) {
				include($plugin_idx);
			} else {
				$max_count = count($GLOBALS['plugin']);
				for($i=0; $i<$max_count; $i++) {
					if($GLOBALS['plugin'][$i]['subweb']=="" || strpos($GLOBALS['plugin'][$i]['subweb'], ",".$web_id.",")!==false) {
						$plugins[] = $GLOBALS['plugin'][$i];
					}
				}
				$result = var_export($plugins, true);
				$result = <<<mystep
<?php
\$plugins = {$result};
?>
mystep;
				WriteFile($plugin_idx, $result, "w");
			}
		}
		$mystep = $this;
		$plugin_setting = array();
		$max_count = count($plugins);
		for($i=0; $i<$max_count; $i++) {
			if($plugins[$i]['active']=='1') {
				$curPlugin = ROOT_PATH."/plugin/".$plugins[$i]['idx']."/config.php";
				if(is_file($curPlugin)) include($curPlugin);
				$curPlugin = ROOT_PATH."/plugin/".$plugins[$i]['idx']."/index.php";
				if(is_file($curPlugin)) include($curPlugin);
			}
		}
		return;
	}
	
	public function pageStart($setPlugin = false) {
		global $setting, $db, $req, $cache;
		
		ob_start();
		ob_implicit_flush(false);
		
		$setting['cookie']['prefix'] .= substr(md5($_SERVER["USERNAME"].$_SERVER["COMPUTERNAME"].$_SERVER["OS"]), 0, 4)."_";
		if($setting['session']['mode']=="sess_file") $setting['session']['path'] = ROOT_PATH."/".$setting['path']['cache']."/session/".date("Ymd")."/";
		$req = $this->getInstance("MyReq", $setting['cookie'], $setting['session']);
		$db = $this->getInstance("MySQL", $setting['db']['host'], $setting['db']['user'], $setting['db']['pass'], $setting['db']['charset']);
		$cache = $this->getInstance("MyCache", $setting['web']['cache_mode']);
		
		includeCache("website");
		includeCache("user_group");
		includeCache("user_type");
		
		$setting['info'] = array();
		$setting['info']['time'] = $_SERVER['REQUEST_TIME'];
		$setting['info']['time_start'] = GetMicrotime();
		$setting['info']['self'] = strtolower(basename($req->getServer("PHP_SELF")));
		$setting['info']['web'] = null;
		$host = $req->getServer("HTTP_HOST");
		for($i=0,$m=count($GLOBALS['website']);$i<$m;$i++) {
			if(strpos(",".$GLOBALS['website'][$i]['host'].",", ",".$host.",")!==false) {
				$GLOBALS['website'][$i]['host'] = $host;
				$setting['web']['url'] = "http://".$host;
				$setting['info']['web'] = $GLOBALS['website'][$i];
				break;
			}
		}
		if(is_null($setting['info']['web'])) $setting['info']['web'] = $GLOBALS['website'][0];
		if($setting['info']['web']===false) $setting['info']['web'] = getParaInfo("website", "web_id", 1);
		$setting_sub = getSubSetting($setting['info']['web']['web_id']);
		$setting_sub['web']['url'] = $setting['web']['url'];
		$setting['db_sub'] = $setting_sub['db'];
		if($setting['db']['name']==$setting_sub['db']['name']) {
			$setting['db']['pre_sub'] = $setting_sub['db']['pre'];
		} else {
			$setting['db']['pre_sub'] = $setting_sub['db']['name'].".".$setting_sub['db']['pre'];	
		}
		unset($setting_sub['db']);
		$setting = arrayMerge($setting, $setting_sub);
		$req->init($setting['cookie'], $setting['session']);
		
		if($setPlugin) $this->setPlugin();
		$this->getLanguage(ROOT_PATH."/source/language/");
		$setting['language']=$this->language;

		$req->SessionStart($GLOBALS['sess_handle']);
		
		$max_count = count($this->func_start);
		for($i=0; $i<$max_count; $i++) {
			call_user_func($this->func_start[$i]);
		}
		
		if(checkSign(1)) return;
		$username = $req->getSession("username");
		if((empty($username) || $username=="Guest")) $this->logcheck();
		$req->setSession("url", "http://".$req->getServer("HTTP_HOST").$req->getServer("URL"));
		$req->setSession("ip", GetIp());
		$setting['info']['user'] = array();
		$setting['info']['user']['name'] = $req->getSession("username");
		$setting['info']['user']['group'] = getParaInfo("user_group", "group_id", $req->getSession('usergroup'));
		$setting['info']['user']['type'] = getParaInfo("user_type", "type_id", $req->getSession('usertype'));
		if($setting['info']['user']['type']===false) {
			$setting['info']['user']['type'] = array (
			  'type_id' => '1',
			  'type_name' => 'Guest',
			  'view_lvl' => '0',
			);
		}
		$this->regAjax("reset_psw", "MyStep::ajax_reset_psw");
	}
	
	public function pageEnd($show_info = false) {
		global $setting;
		for($i=count($this->func_end)-1; $i>=0; $i--) {
			call_user_func($this->func_end[$i]);
		}
		$setting['info']['query_count'] = $GLOBALS['db']->Close();
		if($GLOBALS['db']->GetError($err_info) && isset($GLOBALS['op_mode'])) {
			ob_clean();
			echo showInfo($setting['language']['admin_database_error'].'<ol style="text-align:left;font-weight:normal;"><li>'.implode('</li><li>',$err_info).'</li></ol>', 0);
		}
		if(!empty($GLOBALS['goto_url']) && ob_get_length()==0) {
			header("location: ".$GLOBALS['goto_url']);
		} else {
			GzDocOut($setting['gen']['gzip_level'], $show_info);
		}
		unset($GLOBALS['db'],
					$GLOBALS['req'],
					$GLOBALS['setting'],
					$this);
		exit();
	}
	
	public function show(MyTpl $tpl) {
		if(outputErrMsg()) return;
		global $setting, $news_cat, $cat_idx;
		$tpl->Set_Variable('template', $setting['gen']['template']);
		$tpl->Set_Variable('web_title', $setting['web']['title']);
		$tpl->Set_Variable('web_url', $setting['web']['url']);
		$tpl->Set_Variable('web_email', $setting['web']['email']);
		$tpl->Set_Variable('rss_link', $setting['rewrite']['enable']?"rss.xml":"rss.php?cat=".$cat_idx);
		$tpl->Set_Variable('page_keywords', $setting['web']['keyword']);
		$tpl->Set_Variable('page_description', $setting['web']['description']);
		$tpl->Set_Variable('charset', $setting['gen']['charset']);
		$tpl->Set_Variable('last_modify', date("Y-m-d H:i:s"));
		$this->pushAddedContent($tpl, "start", "end");
		$max_count = count($news_cat);
		for($i=0; $i<$max_count; $i++) {
			if($news_cat[$i]['cat_layer']==1 && $news_cat[$i]['web_id']==$setting['info']['web']['web_id']) {
				if(($news_cat[$i]['cat_show'] & 1) != 1) continue;
				if(empty($news_cat[$i]['cat_link'])) $news_cat[$i]['cat_link'] = getUrl("list", $news_cat[$i]['cat_idx'], 1, $setting['info']['web']['web_id']);
				$tpl->Set_Loop('news_cat', $news_cat[$i]);
			}
		}
		if(count(ob_list_handlers())==0 && !headers_sent()) ob_start();
		echo $tpl->Get_Content('$db, $setting', $setting['gen']['minify']);
		unset($tpl);
	}
	
	public function regStart($func) {
		if(is_string($func)) {
			if(is_callable($func)) $this->func_start[] = $func;
		} elseif(is_array($func)) {
			$max_count = count($func);
			for($i=0; $i<$max_count; $i++) {
				if(is_callable($func[$i])) $this->func_start[] = $func[$i];
			}
		}
	}
	
	public function regEnd($func) {
		if(is_string($func)) {
			if(is_callable($func)) $this->func_end[] = $func;
		} elseif(is_array($func)) {
			$max_count = count($func);
			for($i=0; $i<$max_count; $i++) {
				if(is_callable($func[$i])) $this->func_end[] = $func[$i];
			}
		}
	}
	
	public function regTag($tag, $func) {
		$this->func_tag[$tag] = $func;
	}
	
	public function regAjax($name, $method="") {
		if(empty($method)) {
			$this->func_ajax[$name] = $name;
		} else {
			$this->func_ajax[$name] = $method;
		}
	}
	
	public function regApi($name, $method="") {
		if(empty($method)) {
			$this->func_api[$name] = $name;
		} else {
			$this->func_api[$name] = $method;
		}
	}
	
	public function regModule($module, $page) {
		$page = str_replace("\\", "/", $page);
		if(is_file($page)) {
			$this->module[$module] = $page;
		}
	}
	
	public function regUrl($mode, $func) {
		if(is_callable($func)) {
			$this->url[$mode] = $func;
		}
	}
	
	public function getUrl($mode) {
		$url = "#";
		if(isset($this->url[$mode])) {
			$argList = func_get_args();
			array_shift($argList);
			$url = call_user_func_array($this->url[$mode], $argList);
		}
		return $url;
	}
	
	public function module($module) {
		if(isset($this->module[$module])) {
			global $mystep, $req, $db, $tpl_info, $setting, $goto_url, $cache_info;
			include($this->module[$module]);
		} else {
			$GLOBALS['goto_url'] = "/";
		}
	}
	
	public function regLog($login, $logout="", $logcheck="", $chg_psw="") {
		$this->func_log = array();
		if(is_callable($login)) $this->func_log['login'] = $login;
		if(is_callable($logout)) $this->func_log['logout'] = $logout;
		if(is_callable($logcheck)) $this->func_log['logcheck'] = $logcheck;
		if(is_callable($chg_psw)) $this->func_log['chg_psw'] = $chg_psw;
		self::$func_log_s = $this->func_log;
	}
	
	public function logcheck($user_id="", $user_pwd="") {
		$userinfo = array();
		if(isset($this->func_log['logcheck'])) {
			$userinfo = call_user_func($this->func_log['logcheck'], $user_id, $user_pwd);
		} else {
			global $req, $db, $setting;
			$ms_user = "";
			if(!empty($user_id) && !empty($user_pwd)) {
				$user_pwd = md5($user_pwd);
				$ms_user = $user_id."\t".$user_pwd;
			} else {
				$ms_user = $req->getCookie('ms_user');
			}
			$userinfo = array();
			if(!empty($ms_user)) {
				list($user_id, $user_pwd)=explode("\t",$ms_user);
				$sql = $db->buildSel($setting['db']['pre']."users","user_id, group_id, type_id, username, email",array(array(array("user_id","n=",$user_id),array("username","=",$user_id,"or")),array("password","=",$user_pwd,"and")));
				if($userinfo = getData($sql, "record", 1200)) {
					$req->setSession("username", $userinfo['username']);
					$req->setSession("usergroup", $userinfo['group_id']);
					$req->setSession("usertype", $userinfo['type_id']);
					if($req->getCookie('ms_user')=="") $req->setCookie("ms_user", $userinfo['user_id']."\t".$user_pwd, 60*60*12);
					$userinfo = array(
						"name" => $userinfo['username'],
						"email" => $userinfo['email'],
					);
				} elseif(($user_id==0 || $user_id==$setting['web']['s_user']) && $user_pwd==$setting['web']['s_pass']) {
					$req->setSession("username", $setting['web']['s_user']);
					$req->setSession("usergroup", 1);
					$req->setSession("usertype", 3);
					if($req->getCookie('ms_user')=="") $req->setCookie("ms_user", "0\t".$user_pwd, 60*60*12);
					$userinfo = array(
						"name" => $setting['web']['s_user'],
						"email" => $setting['web']['email'],
					);
				}
			} elseif(!empty($GLOBALS['authority']) && md5($req->getReq($GLOBALS['authority']))==$setting['web']['s_pass']) {
				$req->setSession("username", $setting['web']['s_user']);
				$req->setSession("usergroup", 1);
				$req->setSession("usertype", 3);
				$userinfo = array(
					"name" => $setting['web']['s_user'],
					"email" => $setting['web']['email'],
				);
			}
			$req->setSession("userinfo", $userinfo);
			return $userinfo;
		}
	}
	
	public function login($user_name, $user_pwd) {
		$user_name = mysql_real_escape_string($user_name);
		$user_pwd = mysql_real_escape_string($user_pwd);
		if(isset($this->func_log['login'])) {
			$result = call_user_func($this->func_log['login'], $user_name, $user_pwd);
		} else {
			global $req;
			$req->setCookie("ms_info");
			$result = $this->logcheck($user_name, $user_pwd);
			$result = (count($result)==0)?$setting['language']['login_error_psw']:"";
		}
		return $result;
	}
	
	public function logout() {
		if(isset($this->func_log['logout'])) {
			$result = call_user_func($this->func_log['logout']);
		} else {
			global $setting, $req;
			$req->setCookie("ms_user");
			$req->setCookie("ms_info", $setting['language']['login_logout'], 60*10);
			$req->destroySession();	
		}
	}
	
	public static function chg_psw($psw_org, $psw_new) {
		global $setting, $db;
		$username = $_SESSION['username'];
		if($username==$setting['web']['s_user'] && md5($psw_org)==$setting['web']['s_pass']) return $setting['language']['psw_reset_err_op'];
		if($user_id = $db->record($setting['db']['pre']."users","user_id",array(array("username","=",$username), array("password","=",md5($psw_org))))) {
			$db->update($setting['db']['pre']."users", array("password"=>md5($psw_new)), array("username","=",$username));
			return "";
		} else {
			return $setting['language']['psw_reset_err'];
		}
	}
	
	public static function ajax_reset_psw($psw_org, $psw_new) {
		if(isset(self::$func_log_s['chg_psw'])) {
			$flag = call_user_func(self::$func_log_s['chg_psw'], $psw_org, $psw_new);
		} else {
			$flag = self::chg_psw($psw_org, $psw_new);
		}
		return $flag;
	}
	
	public function addCSS($cssFile) {
		$cssFile = str_replace("//", "/", ROOT_PATH."/".$cssFile);
		if(file_exists($cssFile)) $this->css[] = $cssFile;
	}
	
	public function removeCSS($cssFile) {
		$cssFile = str_replace("//", "/", ROOT_PATH."/".$cssFile);
		$key = array_search($cssFile, $this->css);
		if(is_numeric($key)) {
			unset($this->css[$key]);
			$this->css = array_values($this->css);
		}
	}
	
	public function getCSS() {
		return $this->css;
	}
	
	public function clearCSS() {
		$this->css = array();
		return;
	}
	
	public function addJS($jsFile) {
		$jsFile = str_replace("//", "/", ROOT_PATH."/".$jsFile);
		if(file_exists($jsFile)) $this->js[] = $jsFile;
	}
	
	public function removeJS($jsFile) {
		$jsFile = str_replace("//", "/", ROOT_PATH."/".$jsFile);
		$key = array_search($jsFile, $this->js);
		if(is_numeric($key)) {
			unset($this->js[$key]);
			$this->js = array_values($this->js);
		}
	}
	
	public function getJS() {
		return $this->js;
	}
	
	public function clearJS() {
		$this->js = array();
		return;
	}
}

interface plugin {
    public static function info();
    public static function check();
    public static function install();
    public static function uninstall();
}
?>