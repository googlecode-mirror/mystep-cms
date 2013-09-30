<?php
include("info.php");
$sql_list = array(
	'alter table `{pre}ticket` add `reply_date` Char(15) DEFAULT 0',
);
$file_list = array();
?>