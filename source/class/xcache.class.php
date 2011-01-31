<?php
/********************************************
*                                           *
* Name    : xCache Manager                  *
* Author  : Windy2000                       *
* Time    : 2009-11-05                      *
* Email   : windy2006@gmail.com             *
* HomePage: None (Maybe Soon)               *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

class xCache extends class_common {
	function init(){
		return function_exists('xcache_get');
	}

	public function set($key, $value = "", $ttl = 600){
		if(empty($value)) {
			return xcache_unset($key);
		} else {
			return xcache_set($key, $value);
		}
	}
	
	public function get($key){
		if(xcache_isset($key)) {
			return xcache_get($key);
		} else {
			return false;
		}
	}

	public function remove($key) {
		return xcache_unset($key);
	}
	
	public function clean() {
		$max_count = xcache_count(XC_TYPE_VAR);
		for ($i=0; $i<$max_count; $i++) {
			xcache_clear_cache(XC_TYPE_VAR, $i);
		}
		$max_count = xcache_count(XC_TYPE_PHP);
		for ($i=0; $i<$max_count; $i++) {
			xcache_clear_cache(XC_TYPE_PHP, $i);
		}
		return;
	}
	
	public function add($key, $value=1, $ttl = 600) {
		$result = 0;
		if(is_numeric($value)) {
			$result = $value>0 ? xcache_inc($key, $value, $ttl) : xcache_dec($key, abs($value), $ttl);
		}
		return $result;
	}
}
?>