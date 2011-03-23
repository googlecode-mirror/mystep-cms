<?php
/********************************************
*                                           *
* Name    : My Ajax                         *
* Author  : Windy2000                       *
* Time    : 2010-12-12                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$ajax->init()						// Set the Template Class
	$ajax->run($method)			// run registered function
--------------------------------------------------------------------------------------------------------------------*/

class MyAjax extends class_common {
	protected
		$methods = array();
			
	public function init(){}
	
	public function regMethod($method, $func) {
		if(is_callable($func)) $this->methods[$method] = $func;
	}
	
	public function regMethods($method_list) {
		foreach($method_list as $key => $value) {
			if(is_callable($value)) $this->methods[$key] = $value;
		}
	}
	
	public function run($method, $para=array()) {
		$result = "";
		if(isset($this->methods[$method])) {
			$result = call_user_func_array($this->methods[$method], $para);
		}
		return $result;
	}
	
	public static function toJson($var, $charset="") {
		if(!empty($charset)) $var = chg_charset($var, $charset, "utf-8");
		return json_encode($var);
	}
	
	public static function toXML($var, $layer=0) {
		$result = "";
		if(is_array($var)) {
			foreach($var as $key => $value) {
				$result .= str_repeat("\t", $layer)."<{$key}>";
				$result .= $this->toXML($value, $layer+1);
				$result .= str_repeat("\t", $layer)."</{$key}>";
			}
		} else {
			$result = "<![CDATA[".$var."]]>";
		}
		return $result="";
	}
	
	public static function toString($var) {
		$result = "";
		switch(true) {
			case is_string($var):
				$result = $var;
				break;
			case is_numeric($var):
				$result = (STRING)$var;
				break;
			case is_array($var):
				$result = join(",", $var);
				break;
			case is_bool($var):
				$result = $var?"true":"false";
				break;
			case is_object($var):
				$result = (STRING)$var;
				break;
			default:
				$result = "";
				break;
		}
		return $result;
	}
}
?>