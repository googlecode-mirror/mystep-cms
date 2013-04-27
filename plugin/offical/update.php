<?php
include("info.php");
$sql_list = array(
	'alter table `{pre}plugin` modify `name` Char(40) NOT NULL',
);
$file_list = array(
	'info.php',
	'show.php',
	'class.php',
	'config.php',
	'index.php',
	'tpl/password.tpl',
	'tpl/rss.tpl',
	'language/chs.php',
	'language/default.php',
	'language/en.php',
);
?>