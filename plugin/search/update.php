<?php
include("info.php");
$sql_list = array(
	'alter table `{pre}search_keyword` add `amount` INT DEFAULT 0',
);
$file_list = array(
	'search.php',
	'show.php',
	'class.php',
	'tpl/keyword.tpl',
);
?>