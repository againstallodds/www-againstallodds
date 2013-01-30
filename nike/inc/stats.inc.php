<?php
function stat_rec($pg,$ip_str)
{	$ip = explode(".",$ip_str);
	if (!empty($pg) && !empty($ip) && ($con=@mysql_connect("192.168.200.202","nike","ky0yI3hqeIbB")))
  	{	@mysql_query(	"INSERT INTO nike_stats.stats SET page='{$pg}', time=". mktime()
						.", rem_ip_1='{$ip[0]}', rem_ip_2='{$ip[1]}', rem_ip_3='{$ip[2]}', rem_ip_4='{$ip[3]}'",$con);
		mysql_close($con);
}	}
?>