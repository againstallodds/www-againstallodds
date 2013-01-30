<?php

// MySQL Info - start

$srvr = "george";
$user = "nike";
$pswd = "ky0yI3hqeIbB";


require_once("/Library/WebServer/inc/mysql_sess.inc.php");








$is_brightroom_on = 0;

$cover_wd_inches = 10;
$cover_ht_inches = 12;

$minumum_allowable_dpi = 75;

$upl_photo_wd = 440;

$work_photo_box = 1024;

$border = 2;

$offset = 20+$border;

$crnr_dot_wd = 7;
$dot_offset = ($crnr_dot_wd+1)/2;

$url_dir = explode("/",substr($_SERVER["REQUEST_URI"],1));

?>