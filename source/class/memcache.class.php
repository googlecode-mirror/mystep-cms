<?php
/********************************************
*                                           *
* Name    : Memory Cache Manager            *
* Author  : Windy2000                       *
* Time    : 2009-11-05                      *
* Email   : windy2006@gmail.com             *
* HomePage: www.mysteps.cn                  *
* Notice  : U Can Use & Modify it freely,   *
*           BUT HOLD THIS ITEM PLEASE.      *
*                                           *
********************************************/

/*--------------------------------------------------------------------------------------------------------------------

  How To Use:
	$mc = new MemoryCache($options)											// Set the Memory Cache Class
	$mc->addServ($servs)																// Add a new memcache server to the pool
	$mc->setServPara($server, $options, $makedefault)		// Set of Reset one or all servers' status
	$mc->set($key, $value, $ttl)													// Put some content to the server
	$mc->get($key)																			// Get some content to the server
	$mc->remove($key)																		// remove some content to the server
	$mc->add($key, $value)															// Increment of decrement some number store in server
	$mc->check($key)																		// Check if some content exists on the server
	$mc->flush()																				// Flush all existing items at the server
	$mc->getStat()																			// Get version and status of the service
	$mc->getServStat($server)														// Get memcache servers' infomation
	$mc->close()																				// Close memcached server connection
	$mc->callback_failure($host, $port)									// Callback function

example:
$mc_opt = array (
			'server' => '127.0.0.1:18888',
			'weight' => '2',
			'persistant' => false,
			'timeout' => '1',
			'retry_interval' => 30,
			'status' => 1,
			'expire' => 60*60*24,
			'threshold' => 10240,
			'min_savings' => 0.5,
);
$mc = new MemoryCache;
$mc->($mc_opt);
$mc_srvs = array(
			array('host'=>'10.10.10.1', 'port'=>18888, 'persistent'=>true, 'weight'=>5),
			array('host'=>'10.10.10.2', 'port'=>18888, 'persistent'=>true, 'weight'=>5),
);
$mc->addServ($mc_srvs);

--------------------------------------------------------------------------------------------------------------------*/

class MemoryCache extends class_common {
	protected
		$mc = null,
		$mc_expire = 259200,
		$mc_cnnopt = array(),
		$mc_servers = array();

	public function __construct() {
		$argList = func_get_args();
		if(count($argList)>0){
			call_user_func_array(array($this, "init"), $argList);
		}
		return;
	}
	
	public function init($options) {
		if(!function_exists('memcache_get')) return false;
		$this->mc = new Memcache;
		$this->mc_expire = isset($options['expire']) ? $options['expire'] : 259200;
		$this->mc_cnnopt['persistant'] = isset($options['persistant']) ? $options['persistant'] :  true;
		$this->mc_cnnopt['weight'] = isset($options['weight']) ? $options['weight'] : 5;
		$this->mc_cnnopt['timeout'] = isset($options['timeout']) ? $options['timeout'] : 1;
		$this->mc_cnnopt['retry_interval'] = isset($options['retry_interval']) ? $options['retry_interval'] : 15;
		$this->mc_cnnopt['status'] = isset($options['status']) ? $options['status'] : true;
		$this->mc_cnnopt['callback'] = isset($options['callback']) ? $options['callback'] : array(&$this, 'callback_failure');
		$server = explode(":", $options['server']);
		if(count($server)==1) $server[1] = "11211";
		if($this->mc_cnnopt['persistant']) {
			$conn = $this->mc->pconnect($server[0], $server[1], $this->mc_cnnopt['timeout']);
		} else {
			$conn = $this->mc->connect($server[0], $server[1], $this->mc_cnnopt['timeout']);
		}
		if(isset($options['threshold'])) {
			$this->mc->setCompressThreshold((INT)$options['threshold'], (isset($options['min_savings']) ? (FLOAT)$options['min_savings'] : 0.2));
			$this->mc_cnnopt['compress'] = true;
		} else {
			$this->mc_cnnopt['compress'] = false;
		}
		if($conn) {
			$this->mc_servers[] = array($server[0], $server[1]);
		} else {
			$this->callback_failure($server[0], $server[1]);
		}
		return true;
	}
	
	public function addServ($servs) {
		for($i=0,$n=count($servs); $i<$n; $i++) {
			$server = $servs[$i];
			if(!isset($server['host'])) continue;
			if(!isset($server['port'])) $server['port'] = 11211;
			if(!isset($server['persistent'])) $server['persistent'] = $this->mc_cnnopt['persistant'];
			if(!isset($server['weight'])) $server['weight'] = $this->mc_cnnopt['weight'];
			if(!isset($server['timeout'])) $server['timeout'] = $this->mc_cnnopt['timeout'];
			if(!isset($server['retry_interval'])) $server['retry_interval'] = $this->mc_cnnopt['retry_interval'];
			if(!isset($server['status'])) $server['status'] = $this->mc_cnnopt['status'];
			if(!isset($server['callback'])) $server['callback'] = $this->mc_cnnopt['callback'];
			if($this->mc->addServer($server['host'], $server['port'], $server['persistent'], $server['weight'], $server['timeout'], $server['retry_interval'], $server['status'], $server['callback'])) {
				$this->mc_servers[] = array($server['host'], $server['port']);
			}
		}
		return;
	}
	
	public function setServPara($server = "", $options = array(), $makedefault = false) {
		switch(true) {
			case empty($server):
				$servs = $this->mc_servers;
				break;
			case is_string($server):
				$server = explode(":", $server);
				if(count($server)==1) $server[1] = "11211";
			case count($server)==2:
				$servs = array(array($server[0], $server[1]));
				break;
			default:
				$this->Error("Cannot set server parameter!");
				return;
		}
		if(!isset($options['timeout'])) $options['timeout'] = $this->mc_cnnopt['timeout'];
		if(!isset($options['retry_interval'])) $options['retry_interval'] = $this->mc_cnnopt['retry_interval'];
		if(!isset($options['status'])) $options['status'] = $this->mc_cnnopt['status'];
		if(!isset($options['callback'])) $options['callback'] = $this->mc_cnnopt['callback'];
		for($i=0,$n=count($servs); $i<$n; $i++) {
			$server = $servs[$i];
			$this->mc->setServerParams($server[0], $server[1], $options['timeout'], $options['retry_interval'], $options['status'], $options['callback']);
		}
		if($makedefault) {
			foreach($this->mc_cnnopt as $key) {
				if(isset($options[$key])) $this->mc_cnnopt[$key] = $options[$key];
			}
		}
		return;
	}
	
	public function set($key, $value = "", $ttl = 0) {
		if(empty($value)) {
			$this->mc->delete($key, 0);
		} else {
			if($ttl===0) $ttl = $this->mc_expire;
			$flag = $this->mc_cnnopt['compress'] && (is_array($value) || is_object($value));
			return $this->mc->set($key, $value, $flag, $ttl);
		}
	}
	
	public function get($key) {
		return $this->mc->get($key);
	}
	
	public function remove($key, $timeout = 0) {
		return $this->mc->delete($key, $timeout);
	}
	
	public function add($key, $value=1) {
		$result = 0;
		if(is_numeric($value)) {
			$result = $value>0 ? $this->mc->increment($key, $value) : $this->mc->decrement($key, abs($value));
		}
		return $result;
	}
	
	public function check($key) {
		$flag = $this->mc->add($key, "check it");
		if($flag) $this->mc->delete($key);
		return !$flag;
	}
	
	public function clean() {
		return $this->mc->flush();
	}

	public function getStat() {
		return array($this->mc->getVersion(), $this->mc->getStats(), $this->mc->getExtendedStats(), memory_get_usage(), memory_get_peak_usage());
	}

	public function getServStat($server = "") {
		switch(true) {
			case empty($server):
				$servs = $this->mc_servers;
				break;
			case is_string($server):
				$server = explode(":", $server);
				if(count($server)==1) $server[1] = "11211";
			case count($server)==2:
				$servs = array(array($server[0], $server[1]));
				break;
			default:
				$this->Error("Cannot get server status!");
				return;
		}
		
		$result = array();
		for($i=0,$n=count($servs); $i<$n; $i++) {
			$server = $servs[$i];
			$result[] = $this->mc->getServerStatus($server[0], $server[1]);
		}
		return $result;
	}

	public function close() {
		return $this->mc->close();
	}
	
	public function callback_failure($host, $port) {
		$this->Error("memcache '$host:$port' failed");
		return;    
	}
}
?>