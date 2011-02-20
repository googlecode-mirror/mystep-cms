<?php
$flag = true;
if(isset($setting['gen']['language'])) {
	if(is_file(realpath(dirname(__FILE__))."/config/".$setting['gen']['language'].".php")) {
		include(realpath(dirname(__FILE__))."/config/".$setting['gen']['language'].".php");
		$flag = false;
	}
}
if($flag) include(realpath(dirname(__FILE__))."/config/default.php");
?>