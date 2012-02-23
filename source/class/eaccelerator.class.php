<?php
/********************************************
*                                           *
* Name    : eAccelerator Manager            *
* Author  : Windy2000                       *
* Time    : 2009-11-05                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

class eAccelerator extends class_common {
	public function init() {
		if(function_exists("eaccelerator_get")) {
			eaccelerator_caching(true);
			eaccelerator_optimizer(true);
			return true;
		} else {
			return false;
		}
	}
 
	public function set($key, $value = "", $ttl = 300, $mode = 0) {
		if(empty($value)) {
			return eaccelerator_rm($key);
		} else {
			eaccelerator_lock($key);
			switch($mode) {
				case 1:
					return eaccelerator_cache_output($key, $value, $ttl);
					break;
				case 2:
					return eaccelerator_cache_result($key, $value, $ttl);
					break;
				default:
					return eaccelerator_put($key, $value, $ttl);
			}
			eaccelerator_unlock($key);
		}
	}
	
	public function get($key) {
		return eaccelerator_get($key);
	}

	public function remove($key) {
		return eaccelerator_rm($key);
	}
	
	public function clean() {
		eaccelerator_clean();
		eaccelerator_clear();
		eaccelerator_gc();
		eaccelerator_purge();
		return;
	}
	
	public function cache($ttl = 0) {
		if($ttl==0) {
			eaccelerator_rm_page($_SERVER['PHP_SELF'].'?GET='.serialize($_GET));
		} else {
			eaccelerator_cache_page($_SERVER['PHP_SELF'].'?GET='.serialize($_GET), $ttl);
		}
	}
	
	public function compile($file, $mode = 1) {
		switch($mode) {
			case 1:
				return eaccelerator_encode($file);
				break;
			case 2:
				return eaccelerator_dasm_file($file);
				break;
			default:
				return eaccelerator_encode($file);
		}
	}
	
	public function load($file, $path) {
		$file = $path."/".$file;
		if(is_file($file)) {
			$encoded_str = getFile($file);
		} else {
			$encoded_str = eaccelerator_encode(basename($_SERVER["PHP_SELF"]));
			writeFile($encoded_str, "wb");
		}
		eaccelerator_load($encoded_str);
	}
	
	public function info() {
		$info = array();
		$info['info'] = eaccelerator_info();
		$info['keys'] = eaccelerator_list_keys();
		$info['script'] = eaccelerator_cached_scripts();
		$info['script_remove'] = eaccelerator_removed_scripts();
		return $info;
	}
}
?>