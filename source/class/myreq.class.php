<?php
/********************************************
*                                           *
* Name    : Request Object Functions        *
* Author  : Windy2000                       *
* Time    : 2003-05-03                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/


/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$MyReq->init($cookie_opt, $session_opt)			// Set the Request Object
	$MyReq->setCookieOpt($setting)							// Set cookie settings
	$MyReq->setSessionOpt($setting)							// Set session settings
	
	$MyReq->setGlobal($name, $value)						// Set a global varible
	$MyReq->setCookie($name, $value, $expire, $path, $domain, $secure)		// Set a cookie
	$MyReq->getPara($type, $para)								// Get any varibes (GLOBAL, GET, SERVER, COOKIE and so on...)
	$MyReq->getGet($para)												// Get varible from query string
	$MyReq->getPost($para)											// Get varible from post data
	$MyReq->getReq($para)												// Get varible from _REQUEST
	$MyReq->getServer($para)										// Get varible from _SERVER
	$MyReq->getGlobal($para)										// Get varible from GLOBAL
	
	$MyReq->SessionStart($handle)								// $MyReq->Start(array("sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc"));
	$MyReq->setSessionCookie()									// Set Cookies need by session
	$MyReq->checkSession($para)									// Check if a session varible has been set
	$MyReq->getSession($para)										// Get a session value or Get all session data with a encode string
	$MyReq->setSession($key, $value)						// Set or Unset a session varible
	$MyReq->setSessions($data)									// Decode and batch set sessions from a encode string
	$MyReq->getSessionId()											// Get the current session id
	$MyReq->setSessionId($id)										// Set or renew the current session id
	$MyReq->setSessionPath($path)								// Get or set the current session save path
	$MyReq->setSessionName($name)								// Get or set the current session name
	$MyReq->storeSession()											// Write session data and end session
	$MyReq->destroySession()										// Free and destroySessions all session variables

	No Use Function :	session_module_name();
	External Method : $MyReq->MakeDir
--------------------------------------------------------------------------------------------------------------------*/


class MyReq extends class_common {
	protected
		$cookie_path = "",
		$cookie_domain = "",
		$cookie_prefix = "",
		$session_flag	= false,
		$session_expire = 30,
		$session_gc = false,
		$session_trans_sid = false;

	public function init($cookie_opt = array(), $session_opt = array()) {
		$this->setCookieOpt($cookie_opt);
		$this->setSessionOpt($session_opt);
	}
	
	public function setCookieOpt($setting) {
		if(isset($setting['path'])) $this->cookie_path = $setting['path'];
		if(isset($setting['domain'])) $this->cookie_domain = $setting['domain'];
		if(isset($setting['prefix'])) $this->cookie_prefix = $setting['prefix'];
	}
	
	public function setSessionOpt($setting) {
		if(isset($setting['expire'])) $this->session_expire = $setting['expire'];
		if(isset($setting['gc'])) $this->session_gc = $setting['gc'];
		if(isset($setting['trans_sid'])) $this->session_trans_sid = $setting['trans_sid'];
		if(isset($setting['path'])) $this->setSessionPath($setting['path']);
		if(isset($setting['name'])) $this->setSessionName($setting['name']);
	}

	public function setGlobal($name, $value = "") {
		global $$name;
		$$name = $value;
		$GLOBALS[$name] = $value;
	}

	public function setCookie($name, $value = "", $expire = 0, $path = "", $domain = "", $secure = false) {
		$cmd = "";
		if($expire<=0) {
			$expire = $_SERVER['REQUEST_TIME'] - 3600;
		} else {
			$expire = $_SERVER['REQUEST_TIME'] + $expire;
		}
		if(empty($path) && !empty($this->cookie_path)) {
			$path = $this->cookie_path;
		} else {
			$path = "/";
		}
		if(empty($domain) && !empty($this->cookie_domain)) $domain = $this->cookie_domain;
		setcookie($this->cookie_prefix.$name, $value, $expire, $path, $domain, $secure);
		return;
	}

	public function getPara($type = "get", $para = "") {
		$type = "_".strtoupper($type);
		eval("\$flag = isset(\${$type});");
		if($flag) {
			eval("\$type = \${$type};");
		} else {
			return false;
		}
		if(empty($para)) {
			foreach($type as $key => $value) {
				//if(get_magic_quotes_gpc() && is_string($value)) $value = stripslashes($value);
				$this->setGlobal($key, $value);
			}
		} else {
			//return (isset($type[$para]))?(get_magic_quotes_gpc() && is_string($type[$para])?stripslashes($type[$para]):$type[$para]):null;
			return isset($type[$para])?$type[$para]:"";
		}
		return true;
	}

	public function getGet($para = "") {
		if(empty($para)) {
			$this->getPara("get");
			return count($_GET);
		} else {
			return $this->getPara("get", $para);
		}
	}

	public function getPost($para = "") {
		if(empty($para)) {
			$this->getPara("post");
			return count($_POST);
		} else {
			return $this->getPara("post", $para);
		}
	}

	public function getReq($para = "") {
		if(empty($para)) {
			$this->getPara("request");
			return count($_REQUEST);
		} else {
			return $this->getPara("request", $para);
		}
	}

	public function getServer($para = "") {
		if(empty($para)) return "";
		if($this->getPara("server", $para) == "") {
			return $this->getPara("env", $para);
		} else {
			return $this->getPara("server", $para);
		}
	}

	public function getGlobal($para = "") {
		if(empty($para)) return "";
		if(isset($GLOBALS[$para])) {
			return $GLOBALS[$para];
		} else {
			return "";
		}
	}

	public function getCookie($para = "") {
		if(empty($para)) {
			$this->getPara("cookie");
			return count($_COOKIE);
		} else {
			return $this->getPara("cookie", $this->cookie_prefix.$para);
		}
	}
	
	public function SessionStart($handle = array(), $secure = false, $httponly = false) {
		if($this->session_flag) return;
		if(count($handle)==6) {
			ini_set('session.save_handler', 'user');
			if(!session_set_save_handler($handle[0], $handle[1], $handle[2], $handle[3], $handle[4], $handle[5])) {
				ini_set('session.save_handler', 'files');
			}
		}
		if($this->session_gc) {
			ini_set('session.gc_maxlifetime', $this->session_expire * 3);
			ini_set('session.gc_probability', 5);
			ini_set('session.gc_divisor', 100);
		}
		ini_set('session.use_trans_sid', ($this->session_trans_sid?'1':'0'));
		if($this->session_trans_sid) {
			ini_set("session.use_cookies", "0");
			ini_set("url_rewriter.tags", "a=href,area=href,script=src,link=href,frame=src,input=src,form=fakeentry");
		} else {
			ini_set("session.use_cookies", "1");
			$this->setSessionCookie($secure, $httponly);
		}
		session_cache_limiter('private, must-revalidate');
		session_cache_expire($this->session_expire);
		session_start();
		if(!$this->session_trans_sid) setcookie(session_name(), session_id(), $_SERVER["REQUEST_TIME"]+$this->session_expire*60, $this->cookie_path, $this->cookie_domain);
		$this->session_flag = true;
		return;
	}
	
	public function setSessionCookie($secure = false, $httponly = false) {
		$lifetime = $this->session_expire*60;
		$path = $this->cookie_path;
		$domain = $this->cookie_domain;
		session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
		return session_get_cookie_params();
	}

	public function checkSession($para) {
		if(!$this->session_flag) $this->SessionStart();
		return isset($_SESSION[$para]);
	}

	public function getSession($para="") {
		if(empty($para)) return session_encode();
		return $this->checkSession($para) ? $_SESSION[$para] : null;
	}

	public function setSession($key, $value = "") {
		if(is_int($key)) return;
		if(!$this->session_flag) $this->SessionStart();
		if(empty($value)) {
			unset($_SESSION[$key]);
		} else{
			$_SESSION[$key] = $value;
		}
	}

	public function setSessions($data) {
		if(!$this->session_flag) $this->SessionStart();
		$old_session = $_SESSION;
		if(session_decode($data)) {
			return $old_session;
		} else {
			$_SESSION = array();
			$_SESSION = $old_session;
			return false;
		}
	}

	public function getSessionId() {
		return session_id();
	}

	public function setSessionId($id = "") {
		if(empty($id)) {
			session_regenerate_id();
			return session_id();
		} else {
			return session_id($id);
		}
	}

	public function setSessionPath($path = "") {
		if(empty($path)) {
			return session_save_path();
		} else {
			if($this->MakeDir($path)) {
				$path =  realpath($path);
				session_save_path($path);
			}
			return session_save_path();
		}
	}

	public function setSessionName($name = "") {
		if(empty($name)) {
			return session_name();
		} else {
			return session_name($name);
		}
	}

	public function storeSession() {
		if($this->session_flag) {
			session_write_close();
			$this->session_flag = false;
		}
		return;
	}

	public function destroySession() {
		if(!$this->session_flag) $this->SessionStart();
		$_SESSION = array();
		session_unset();
		session_destroy();
		$this->session_flag	= false;
		return;
	}
	
	public static function sessEncode($array, $safe = true) {
		if($safe) $array = unserialize(serialize($array));
		$raw = '';
		$line = 0;
		foreach($array as $key => $value) {
			$line ++ ;
			$raw .= $key .'|' ;
			if(is_array($value) && isset($value['MySessSign'])) {
				$raw .= 'R:'. $value['MySessSign'] . ';' ;
			} else {
				$raw .= serialize($value);
			}
			$array[$key] = Array('MySessSign' => $line) ;
		}
		return $raw;
	}
	
	public static function sessDecode($str) {
		$str = (string)$str;
		$endptr = strlen($str);
		$p = 0;
		$serialized = '';
		$items = 0;
		$level = 0;
		while ($p < $endptr) {
			$q = $p;
			while ($str[$q] != '|')
				if (++$q >= $endptr) break 2;
	
			if ($str[$p] == '!') {
				$p++;
				$has_value = false;
			} else {
				$has_value = true;
			}
			$name = substr($str, $p, $q - $p);
			$q++;
			$serialized .= 's:' . strlen($name) . ':"' . $name . '";';
			if ($has_value) {
				for (;;) {
					$p = $q;
					switch ($str[$q]) {
						case 'N': /* null */
						case 'b': /* boolean */
						case 'i': /* integer */
						case 'd': /* decimal */
							do $q++;
							while ( ($q < $endptr) && ($str[$q] != ';') );
							$q++;
							$serialized .= substr($str, $p, $q - $p);
							if ($level == 0) break 2;
							break;
						case 'R': /* reference  */
							$q+= 2;
							for ($id = ''; ($q < $endptr) && ($str[$q] != ';'); $q++) $id .= $str[$q];
							$q++;
							$serialized .= 'R:' . ($id + 1) . ';'; /* increment pointer because of outer array */
							if ($level == 0) break 2;
							break;
						case 's': /* string */
							$q+=2;
							for ($length=''; ($q < $endptr) && ($str[$q] != ':'); $q++) $length .= $str[$q];
							$q+=2;
							$q+= (int)$length + 2;
							$serialized .= substr($str, $p, $q - $p);
							if ($level == 0) break 2;
							break;
						case 'a': /* array */
						case 'O': /* object */
							do $q++;
							while ( ($q < $endptr) && ($str[$q] != '{') );
							$q++;
							$level++;
							$serialized .= substr($str, $p, $q - $p);
							break;
						case '}': /* end of array|object */
							$q++;
							$serialized .= substr($str, $p, $q - $p);
							if (--$level == 0) break 2;
							break;
						default:
							return false;
					}
				}
			} else {
				$serialized .= 'N;';
				$q+= 2;
			}
			$items++;
			$p = $q;
		}
		return unserialize( 'a:' . $items . ':{' . $serialized . '}' );
	}
}
?>