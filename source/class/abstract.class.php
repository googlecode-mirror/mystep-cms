<?php
/********************************************
*                                           *
* Name    : Base Function For All Classes   *
* Author  : Windy2000                       *
* Time    : 2008-07-16                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

abstract class class_common {
	public 
		$singleton = false;
		
	protected
		$err_msg = "",
		$error_handle = "",
		$paras = array();

	public function __construct($error_handle = "die", $singleton = false) {
		$this->SetErrorHandle($error_handle);
		$this->singleton = $singleton;
		$this->err_msg = "";
	}
	
	public function __destruct() {
		$varList = array_keys(get_class_vars(get_class($this)));
		for($i=0,$m=count($varList);$i<$m;$i++) {
			unset($this->{$varList[$i]});
		}
	}
	
	public function __get($para) {
		if($para=="instatnce") {
			$class_name = get_called_class();
			return new $class_name();
		} else {
			if($this->paras == null) return null;
			return array_key_exists($para, $this->paras) ? $this->paras[$para] : null;
		}
	}

	public function __set($para, $value) {
		$this->paras[$para] = $value;
	}

	public function __isset($para) {
		return isset($this->paras[$para]);
	}

	public function __unset($para) {
		unset($this->paras[$para]);
	}
	
	public function __call($func, $paras) {
		if(is_callable($func)) {
			$result = call_user_func_array($func, $paras);
		} else {
			$result = false;
		}
		return $result;
	}
	
	public static function __callStatic($func, $paras) {
		if(is_callable($func)) {
			$result = call_user_func_array($func, $paras);
		} else {
			$result = false;
		}
		return $result;
	}

	public function __sleep() {
		return array_keys(get_class_vars(get_class($this)));
	}
	
	public function __wakeup() {
		if(isset($GLOBALS['my_wakeup'])) {
			try {
				eval($GLOBALS['my_wakeup']);
				return true;
			} catch(Exception $e) {
				trigger_error($e->getMessage(), E_USER_ERROR);
				return false;
			}
		}
	}
	
	public function __clone() {
		if($this->singleton) {
			trigger_error('Clone is not allowed.', E_USER_ERROR);
			return false;
		} else {
			foreach($this as $key => $val) {
				if(is_array($val)){
					$this->$key = unserialize(serialize($val));
				} elseif(is_object($val)) {
					$this->$key= clone($this->$key);
				}
			}
		}
	}

	public function __toString() {
		$result = array();
		$result['name'] = get_class($this);
		$result['vars'] = array();
		$vars = get_class_vars(get_class($this));
		foreach($vars as $var => $value) {
			$result['vars'][$var] = $this->$var;
		}
		$result['methods'] = array();
		$methods = get_class_methods(get_class($this));
		foreach($methods as $method) {
			$result['methods'][] = $method;
		}
		return serialize($result);
	}

	public function __invoke($para) {
		if(is_string($para)) {
			return str_shuffle(md5($para));
		} elseif(is_numeric($para)) {
			mt_srand($para);
			return mt_rand();
		} elseif(is_array($para) || is_object($para)) {
			foreach($para as $key => $value) {
				$this->$key = $value;
			}
			return true;
		} else {
			return debug_backtrace();
		}
	}
	
	public static function __set_state($para_arr) {
		$class_name = get_class($this);
		$instance = new $class_name();
		foreach($para_arr as $key => $value) {
			$instance->$key = $value;
		}
		return $instance;
	}
	
	public function getInstance($calledClass = "") {
		if(empty($calledClass)) $calledClass = get_class($this);
		$argList = func_get_args();
		array_shift($argList);
		if($this->singleton) {
			static $instanceList = array();
			if(!isset($instanceList[$calledClass])) {
				$instanceList[$calledClass] = new $calledClass();
				if(count($argList)>0) {
					if(is_callable(array($calledClass, "init"))) {
						call_user_func_array(array($instanceList[$calledClass], "init"), $argList);
					} else {
						call_user_func_array(array($instanceList[$calledClass], '__construct'), $argList);
					}
				}
			} else {
				if(is_callable(array($calledClass, "init")) && count($argList)>0) {
					call_user_func_array(array($instanceList[$calledClass], "init"), $argList);
				}
			}
			return $instanceList[$calledClass];
		} else {
			$instance = new $calledClass();
			if(count($argList)>0) {
				if(method_exists($calledClass, "init")) {
					call_user_func_array(array($instance, "init"), $argList);
				} else {
					call_user_func_array(array($calledClass, '__construct'), $argList);
				}
			}
			return $instance;
		}
	}

	public function SetErrorHandle($error_function = "") {
		$this->error_handle = (!empty($error_function) && is_callable($error_function)) ? $error_function : "";
	}

	protected function Error($msg, $exit=false) {
		$err_msg  = "MyStep Error: \n";
		$err_msg .= "Time: ".gmdate("Y-n-j G:i:s", $_SERVER['REQUEST_TIME'] + 8 * 3600)."\n";
		$err_msg .= "URL: http://".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']."\n";
		$err_msg .= "File: ".$_SERVER["PHP_SELF"]."\n";
		if(!empty($msg)) $err_msg .= "Info.: {$msg}\n";
		$err_msg .= "Debug: \n";
		$debug_info = debug_backtrace();
		$n=0;
		for($i=count($debug_info)-1;$i>=0;$i--){
			if(empty($debug_info[$i]['file'])) continue;
			$err_msg .= (++$n)." - ".$debug_info[$i]['file']." (line:".$debug_info[$i]['line'].", function:".$debug_info[$i]['function'].")\n";
		}
		$err_msg .= "\n--------------------------------------------\n\n";
		$this->err_msg = $err_msg;
		$func = $this->error_handle;
		//trigger_error($err_msg, E_USER_ERROR);
		if(!empty($func) && is_callable($func)) call_user_func($func, $err_msg);
		$GLOBALS['errMsg'] = $err_msg;
		if($exit) die(str_replace("\n","<br />\n",$err_msg));
		return true;
	}
	
	public function ClearError() {
		$this->err_msg = "";
		unset($GLOBALS['errMsg']);
	}
}
?>