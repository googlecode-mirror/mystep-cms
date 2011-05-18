<?php
/********************************************
*                                           *
* Name    : Core of the Web                 *
* Author  : Windy2000                       *
* Time    : 2010-12-16                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
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
		$module = array(),
		$language = array(),
		$content = array();
	
	public function getInstance($calledClass = "") {
		global $setting, $class_list;
		if(!class_exists($calledClass)) {
			if(isset($class_list[$calledClass]) && defined('ROOT_PATH')) {
				include_once(ROOT_PATH."/source/class/".$class_list[$calledClass]);
			}
			if (!class_exists($calledClass)) {
				trigger_error("Unable to load class: ".$calledClass, E_USER_WARNING);
			}
		}
		$argList = func_get_args();
		$obj = call_user_func_array(array($this, 'parent::getInstance'), $argList);
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
		$obj->SetErrorHandle("WriteError");
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
		global $plugin_setting;
		$mystep = $this;
		$plugin_setting = array();
		$max_count = count($GLOBALS['plugin']);
		for($i=0; $i<$max_count; $i++) {
			if($GLOBALS['plugin'][$i]['active']=='1') {
				$curPlugin = ROOT_PATH."/plugin/".$GLOBALS['plugin'][$i]['idx']."/index.php";
				if(is_file($curPlugin)) include($curPlugin);
				$curPlugin = ROOT_PATH."/plugin/".$GLOBALS['plugin'][$i]['idx']."/config.php";
				if(is_file($curPlugin)) include($curPlugin);
			}
		}
	}
	
	public function pageStart($setPlugin = false) {
		global $setting, $db, $req, $cache;
		header("Content-Type: text/html; charset=".$setting['gen']['charset']);
		set_magic_quotes_runtime(false);
		set_time_limit(30);
		ini_set('memory_limit', '128M');
		ini_set('magic_quotes_gpc', 'Off');
		
		error_reporting(E_ALL ^ E_NOTICE);
		set_error_handler("ErrorHandler");
		date_default_timezone_set($setting['gen']['timezone']);
		
		ob_start();
		ob_implicit_flush(false);

		if($setting['session']['mode']=="sess_file") $setting['session']['path'] = ROOT_PATH."/".$setting['path']['cache']."/session/".date("Ymd")."/";
		$req = $this->getInstance("MyReq", $setting['cookie'], $setting['session']);
		$db = $this->getInstance("MySQL", $setting['db']['host'], $setting['db']['user'], $setting['db']['pass'], $setting['db']['charset']);
		$cache = $this->getInstance("MyCache", $setting['web']['cache_mode']);
		
		includeCache("website");
		includeCache("user_group");
		includeCache("user_type");
		
		$setting['info'] = array();
		$setting['info']['time_start'] = GetMicrotime();
		$setting['info']['self'] = strtolower(basename($req->getServer("PHP_SELF")));
		$host = $req->getServer("HTTP_HOST");
		$setting['info']['web'] = getParaInfo("website", "host", $host);
		if($setting['info']['web']===false) $setting['info']['web'] = getParaInfo("website", "web_id", 1);
		$setting_sub = getSubSetting($setting['info']['web']['web_id']);
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
		
		$max_count = count($this->func_start);
		for($i=0; $i<$max_count; $i++) {
			call_user_func($this->func_start[$i]);
		}

		$req->SessionStart($GLOBALS['sess_handle']);
		$username = $req->getSession("username");
		if((empty($username) || $username=="Guest") && $req->getCookie('ms_user')!="") checkUser();
		$req->setSession("url", "http://".$req->getServer("HTTP_HOST").$req->getServer("URL"));
		$req->setSession("ip", GetIp());
		$setting['info']['user'] = array();
		$setting['info']['user']['name'] = $req->getSession("username");
		$setting['info']['user']['group'] = getParaInfo("user_group", "group_id", $req->getSession('usergroup'));
		$setting['info']['user']['type'] = getParaInfo("user_type", "type_id", $req->getSession('usertype'));
	}
	
	public function pageEnd($show_info = true) {
		global $setting;
		$max_count = count($this->func_end);
		for($i=0; $i<$max_count; $i++) {
			call_user_func($this->func_end[$i]);
		}
		$setting['info']['query_count'] = $GLOBALS['db']->Close();
		if(!empty($GLOBALS['goto_url'])) {
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
		$tpl->Set_Variable('rss_link', $setting['gen']['rewrite']?"rss.xml":"rss.php?cat=".$cat_idx);
		$tpl->Set_Variable('page_keywords', $setting['web']['keyword']);
		$tpl->Set_Variable('page_description', $setting['web']['description']);
		$tpl->Set_Variable('charset', $setting['gen']['charset']);
		$tpl->Set_Variable('last_modify', date("Y-m-d H:i:s"));
		$this->pushAddedContent($tpl, "start", "end");
		$max_count = count($news_cat);
		for($i=0; $i<$max_count; $i++) {
			if($news_cat[$i]['cat_layer']==1 && $news_cat[$i]['web_id']==$setting['info']['web']['web_id']) {
				if(($news_cat[$i]['cat_show'] & 1) != 1) continue;
				if(empty($news_cat[$i]['cat_link'])) $news_cat[$i]['cat_link'] = getFileURL(0, $news_cat[$i]['cat_idx'], $setting['info']['web']['web_id']);
				$tpl->Set_Loop('news_cat', $news_cat[$i]);
			}
		}
		if(count(ob_list_handlers())==0 && !headers_sent()) ob_start();
		echo $tpl->Get_Content('$db, $setting');
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
		if(is_file($page))
			$this->module[$module] = $page;
	}
	
	public function module($module) {
		if(isset($this->module[$module])) {
			global $mystep, $req, $db, $tpl_info, $setting, $goto_url;
			include($this->module[$module]);
		} else {
			$GLOBALS['goto_url'] = "/";
		}
	}
}

interface plugin {
    public static function info();
    public static function check();
    public static function install();
    public static function uninstall();
}
?>