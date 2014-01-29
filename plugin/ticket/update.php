<?php
include("info.php");
$sql_list = array(
	'alter table `{pre}ticket` add `reply_date` Char(15) DEFAULT 0',
);
$file_list = array(
	'class.php',
	'list.php',
	'show.php',
	'ticket.php',
	'tpl/check.tpl',
	'tpl/input.tpl',
	'tpl/show.tpl',
	'tpl/topic.tpl',
);
?>