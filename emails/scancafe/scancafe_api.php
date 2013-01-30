#!/usr/bin/php -q
<?php

$do = 1;

$start = mktime()+microtime();

$srvr = "localhost";
$user = "home";
$pswd = "ky0yI3hqeIbB";
require_once("/liz/www/inc/mysql_sess.inc.php");
$connection = @mysql_connect($srvr,$user,$pswd);

$n = 0;

$l = mysql_query("SELECT * FROM home.home_photog_reg_photog_uk_reg",$connection);
for ($i = 0; $i < mysql_num_rows($l); $i++)
{	$arr = mysql_fetch_array($l);
	$em[$n] = strtolower(str_replace("\n","",str_replace(" ","",$arr['address_email'])));
	$nm[$n] = ucwords($arr['name_first'])." ".ucwords($arr['name_last']);
	$n++;
}

$l = mysql_query("SELECT * FROM home.home_photog_reg_photog_reg",$connection);
for ($i = 0; $i < mysql_num_rows($l); $i++)
{	$arr = mysql_fetch_array($l);
	$em[$n] = strtolower(str_replace("\n","",str_replace(" ","",$arr['address_email'])));
	$nm[$n] = ucwords($arr['name_first'])." ".ucwords($arr['name_last']);
	$n++;
}

$l = mysql_query("SELECT * FROM home.amateur_usa_users",$connection);
for ($i = 0; $i < mysql_num_rows($l); $i++)
{	$arr = mysql_fetch_array($l);
	$em[$n] = strtolower(str_replace("\n","",str_replace(" ","",$arr['email'])));
	$nm[$n] = ucwords($arr['firstname'])." ".ucwords($arr['lastname']);
	$n++;
}

$l = mysql_query("SELECT * FROM home.amateur_uk_users",$connection);
for ($i = 0; $i < mysql_num_rows($l); $i++)
{	$arr = mysql_fetch_array($l);
	$em[$n] = strtolower(str_replace("\n","",str_replace(" ","",$arr['email'])));
	$nm[$n] = ucwords($arr['firstname'])." ".ucwords($arr['lastname']);
	$n++;
}

$api_key = "2315b0b80488023ce589c4684a689390";
$client_id = "5863d72cb36bfb6d62180fd63b5cf589";
$list_id = "9b15fc79f9d4941fb139c2a9790f5d6f";

require_once("/liz/www/inc/cm/CMBase.php"); $CMobj = new CampaignMonitor( $api_key , $client_id , 0 , $list_id ); $CMobj->method = 'soap';

$customs = array( 
//	"project_name"=>"AMERICA AT HOME"
);

/*
unset($em); $in = 0;
$em[0] = strtolower(str_replace("\n","",str_replace(" ","","topherwhite@gmail.com")));
$nm[0] = ucwords("Topher")." ".ucwords("White");
$vl = $em[0];
*/

$cnt = count($em);

foreach ($em as $in=>$vl)
{
	echo (round((mktime()+microtime()-$start)*10)/10)." (".($in+1)."/{$cnt}) - {$nm[$in]}, {$vl}";
	if ($do == 1) { $CMobj->subscriberAddWithCustomFields( $vl, $nm[$in], $customs , $list_id, true); }
	$wait = 1000*rand(3500,7000); echo " -> added, wait ".(intval($wait/100000)/10)."s";
	usleep($wait);
	if ($do == 1) { $CMobj->subscriberUnsubscribe( $vl, $list_id ); }
	$wait = 1000*rand(3500,7000); echo " -> removed, wait ".(intval($wait/100000)/10)."s";
	usleep($wait);
	echo "\n";
}


//echo count($em) . " - {$n}\n\n";

//foreach ($em as $in=>$vl) { echo "<br />{$vl} - {$nm[$in]}"; }

?>