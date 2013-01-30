#!/usr/bin/php -q
<?php

$start = mktime()+microtime();

$srvr = "localhost";
$user = "home";
$pswd = "ky0yI3hqeIbB";
require_once("/liz/www/inc/mysql_sess.inc.php");
$connection = @mysql_connect($srvr,$user,$pswd);
$l = mysql_query("SELECT * FROM home.amateur_usa_users",$connection);

for ($i = 0; $i < mysql_num_rows($l); $i++)
{	$arr = mysql_fetch_array($l);
	$em[$i] = strtolower(str_replace("\n","",str_replace(" ","",$arr['email'])));
	$nm[$i] = ucwords($arr['firstname'])." ".ucwords($arr['lastname']);
}

$api_key = "2315b0b80488023ce589c4684a689390";
$client_id = "5863d72cb36bfb6d62180fd63b5cf589";
$list_id = "fe8a5b7e47b7fa3e327b54cac46a65b0";

require_once("/liz/www/inc/cm/CMBase.php"); $CMobj = new CampaignMonitor( $api_key , $client_id , 0 , $list_id ); $CMobj->method = 'soap';

$customs = array( "project_name"=>"AMERICA AT HOME" );

foreach ($em as $in=>$vl)
{
	echo "\n".(round((mktime()+microtime()-$start)*1000)/1000)." - {$nm[$in]}, {$vl}";
	$CMobj->subscriberAddWithCustomFields( $vl, $nm[$in], $customs , $list_id, true);
	echo " -> added...";
	usleep(1000*rand(3500,7000));
	$CMobj->subscriberUnsubscribe( $vl, $list_id );
	echo " -> removed...";
	usleep(1000*rand(3500,7000));
}


?>