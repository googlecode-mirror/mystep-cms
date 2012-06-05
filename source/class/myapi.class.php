<?php
/********************************************
*                                           *
* Name    : My Api                          *
* Author  : Windy2000                       *
* Time    : 2010-12-12                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$Api->init()						// Set the Template Class
	$Api->run($method)			// run registered function
--------------------------------------------------------------------------------------------------------------------*/

class MyApi extends class_common {
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
	
	public function run($method, $para=array(), $return="", $charset="utf-8") {
		$result = "";
		if(isset($this->methods[$method])) {
			$result = call_user_func_array($this->methods[$method], $para);
		}
		switch($return) {
			case "j":
			case "json":
				$result = toJson($result, $charset);
				break;
			case "x":
			case "xml":
				$result = '<?xml version="1.0" encoding="'.$charset.'"?>'."\n<mystep>\n".toXML($result)."</mystep>";
				header('Content-Type: application/xml; charset='.$charset);
				break;
			case "s":
			case "string":
				$result = toString($result);
				break;
			default:
				break;
		}
		return $result;
	}
}
?>