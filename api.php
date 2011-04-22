<?php
include("inc.php");
$api = $mystep->getInstance("MyApi");
$para = explode("|", $req->getServer("QUERY_STRING"));
for($i=0;$i<3;$i++) {
	if(!isset($para[$i])) $para[$i] = "";
}
$result = $api->run($para[0], explode(",", $para[1]));
$para[2] = strtolower($para[2]);
switch($para[2]) {
	case "j":
	case "json":
		$result = toJson($result, $setting['db']['charset']);
		if(get_magic_quotes_gpc()) {
			$result = str_replace('\r', "\r", $result);
			$result = str_replace('\n', "\n", $result);
			$result = stripslashes($result);
		}
		break;
	case "x":
	case "xml":
		$result = '<?xml version="1.0" encoding="'.$setting['gen']['charset'].'"?>'."\n<mystep>\n".toXML($result)."</mystep>";
		header('Content-Type: application/xml; charset='.$setting['gen']['charset']);
		break;
	case "s":
	case "string":
		$result = toString($result);
		break;
	default:
		break;
}

echo $result;
$mystep->pageEnd(false);
?>