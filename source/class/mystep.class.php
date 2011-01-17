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
		$func_ajax = array(),
		$language = array(),
		$content = array();
	
	public function getInstance($calledClass = "") {
		global $setting, $language;
		$argList = func_get_args();
		$obj = call_user_func_array(array($this, 'parent::getInstance'), $argList);
		switch($calledClass) {
			case 'MySQL':
				$obj->Connect($setting['db']['pconnect']);
				$obj->SelectDB($setting['db']['name']);
				break;
			case 'MyTpl':
				$obj->Reg_Tags($this->func_tag);
				$obj->Set_Variables($language, 'lang');
				break;
			case 'MyAjax':
				$obj->regMethods($this->func_ajax);
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
		if(file_exists($dir."/default.php")) {
			include_once($dir."/default.php");
			if(isset($language)) $this->setLanguage($language);
			unset($language);
		}
		if(file_exists($dir."/".$setting['gen']['language'].".php")) {
			include_once($dir."/".$setting['gen']['language'].".php");
			if(isset($language)) $this->setLanguage($language);
		}
	}
	
	public function setPlugin() {
		includeCache("plugin");
		$mystep = $this;
		$max_count = count($GLOBALS['plugin']);
		for($i=0; $i<$max_count; $i++) {
			$curPlugin = ROOT_PATH."/plugin/".$GLOBALS['plugin'][$i]['idx']."/index.php";
			if(is_file($curPlugin) && $GLOBALS['plugin'][$i]['active']=='1') include_once($curPlugin);
		}
	}
	
	public function pageStart($subsetting = true) {
		global $setting, $req;
		
		if($setting['gen']['cache']) {
			header("Expires: -1");
			header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0", false);
			header("Pragma: no-cache");
		}
		header("Content-Type: text/html; charset=".$setting['gen']['charset']);

		date_default_timezone_set("PRC");
		set_magic_quotes_runtime(0);
		set_time_limit(30);
		ini_set('memory_limit', '32M');
		
		error_reporting(E_ALL ^ E_NOTICE);
		
		ob_start();
		ob_implicit_flush(false);

		$GLOBALS['time_start'] = GetMicrotime();
		$GLOBALS['self'] = strtolower(basename($req->getServer("PHP_SELF")));

		$this->getLanguage(ROOT_PATH."/source/language/");
		$GLOBALS['language']=$this->language;

		$host = $req->getServer("HTTP_HOST");
		includeCache("website");
		if($GLOBALS['web_info'] = getParaInfo("website", "host", $host) && $subsetting) {
			if(is_file(ROOT_PATH."/include/config_".$GLOBALS['web_info']['idx'].".php")) {
				include_once(ROOT_PATH."/include/config_".$GLOBALS['web_info']['idx'].".php");
			}
		}
		
		$max_count = count($this->func_start);
		for($i=0; $i<$max_count; $i++) {
			call_user_func($this->func_start[$i]);
		}

		includeCache("user_group");
		//$setting['session']['path'] = ROOT_PATH."/".$setting['path']['cache']."/session/".date("Ymd")."/";
		$req->SessionStart($GLOBALS['sess_handle']);
		$username = $req->getSession("username");
		if((empty($username) || $username=="guest") && $req->getCookie('ms_user')!=null) checkUser();
		$req->setSession("url", $req->getServer("URL"));
		$req->setSession("ip", GetIp());
	}
	
	public function pageEnd($show_info = true) {
		global $setting;
		$max_count = count($this->func_end);
		for($i=0; $i<$max_count; $i++) {
			call_user_func($this->func_end[$i]);
		}
		if(!empty($GLOBALS['goto_url'])) {
			header("location: ".$GLOBALS['goto_url']);
			exit();
		}
		unset($this);
		GzDocOut($setting['gen']['gzip_level'], $show_info);
	}
	
	public function show(MyTpl $tpl) {
		global $setting;
		$tpl->Set_Variable('template', $setting['gen']['template']);
		$tpl->Set_Variable('web_title', $setting['web']['title']);
		$tpl->Set_Variable('web_url', $setting['web']['url']);
		$tpl->Set_Variable('web_email', $setting['web']['email']);
		$tpl->Set_Variable('rss_link', "rss.php");
		$tpl->Set_Variable('page_keywords', $setting['web']['keyword']);
		$tpl->Set_Variable('page_description', $setting['web']['description']);
		$tpl->Set_Variable('charset', $setting['gen']['charset']);
		$tpl->Set_Variable('last_modify', date("Y-m-d H:i:s"));
		$this->pushAddedContent($tpl, "start", "end");
		
		if(count(ob_list_handlers())==0 && !headers_sent()) ob_start();
		echo $tpl->Get_Content('$db, $setting');
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
	
	public function regTag($func_arr) {
		$this->func_tag[$func_arr[0]] = $func_arr[1];
	}
}

interface plugin {
    public static function info();
    public static function install();
    public static function uninstall();
}
?>