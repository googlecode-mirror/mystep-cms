<?php
/**************************************************
*                                                 *
* Name    : Functions 4 Encrypt & Decrypt         *
* Modifier: Windy2000                             *
* Time    : 2003-05-03                            *
* Email   : windy2006@gmail.com                   *
* HomePage: www.mysteps.cn                        *
* Notice  : U Can Use & Modify it freely,         *
*           BUT HOLD THIS ITEM PLEASE.            *
*                                                 *
**************************************************/


function keyED($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr=0;
	$tmp = "";
	for ($i=0;$i<strlen($txt);$i++) {
		if ($ctr==strlen($encrypt_key)) $ctr=0;
		$tmp.= substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1);
		$ctr++;
	}
	return $tmp;
}

function enc_str($txt, $key) {
	mt_srand((double)microtime()*1000000);
	$encrypt_key = md5(mt_rand(0,32000));
	$ctr=0;
	$tmp = "";
	for ($i=0;$i<strlen($txt);$i++) {
		if ($ctr==strlen($encrypt_key)) $ctr=0;
		$tmp.= substr($encrypt_key,$ctr,1) . (substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1));
		$ctr++;
	}
	return keyED($tmp,$key);
}

function enc_file($file, $key) {
	if(filesize($file)==0) {
		echo ("File $file Needn't Encrypt !");
		return;
	}
	$fp_r = fopen("$file","rb");
	$fp_w = fopen("enc_$file","wb");
	if(!$fp_r || !$fp_w) die("Cannot Read or Write File !");
	$enc_text = md5($key);
	fwrite($fp_w, $enc_text);
	while (!feof($fp_r)) {
		$data		= fread($fp_r, 1024);
		$enc_text	= enc_str($data, $key);
		fwrite($fp_w, $enc_text);
	}
	fclose($fp_r);
	fclose($fp_w);
	unlink($file);
	rename("enc_$file", $file);
	return;
}

function dec_str($txt,$key) {
	$txt = keyED($txt,$key);
	$tmp = "";
	for ($i=0;$i<strlen($txt);$i++) {
		$md5 = substr($txt,$i,1);
		$i++;
		$tmp.= (substr($txt,$i,1) ^ $md5);
	}
	return $tmp;
}

function dec_file($file, $key) {
	$fp_r = fopen("$file","rb");
	$fp_w = fopen("dec_$file","wb");
	if(!$fp_r || !$fp_w) die("Cannot Read or Write File !");
	$enc_key = md5($key);
	if($enc_key != fread($fp_r, strlen($enc_key))) {
		fclose($fp_r);
		fclose($fp_w);
		unlink("dec_$file");
		die("Wrong Decryption Key !");
	}
	while (!feof($fp_r)) {
		$data		= fread($fp_r, 1024);
		$dec_text	= dec_str($data, $key);
		fwrite($fp_w, $dec_text);
	}
	fclose($fp_r);
	fclose($fp_w);
	unlink($file);
	rename("dec_$file", $file);
	return;
}
?>