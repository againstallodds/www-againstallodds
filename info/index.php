<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

function mysqlclean($array,$index,$maxlength,$connection)
{	if (isset($array["{$index}"]))
	{	$input = substr($array["{$index}"],0,$maxlength);
		$input = mysql_real_escape_string($input,$connection);
		return ($input);
	}
	return NULL;
}

$tablename = "misc.remote_access";

if ($con=@mysql_connect("localhost","misc","sunsh1ne"))
{
	$remote_ip = $_SERVER['REMOTE_ADDR']; if (!empty($_GET['ip'])) { $remote_ip = mysqlclean($_GET,"ip",15,$con); }

	$loc = mysqlclean($_GET,'loc',25,$con);
	$id = ""; if (!empty($_GET['id'])) { $id = ", computer='".mysqlclean($_GET,'id',10,$con)."'"; }
	$time = mktime();


	if ($_GET['do'] != 'record')
	{	
		header('Content-type: text/html');
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">"
			."\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">"
			."\n<head>"
			."\n<meta name=\"viewport\" content=\"width=device-width; initial-scale=1.0; maximum-scale=1.0;\">"
			."\n<title>IP DB</title>"
			."\n</head>"
			."\n<body style=\"font-family:arial;font-size:18px;\">"
			."\n<div id=\"content\" style=\"text-align:middle;\">"
			;
		
		if (!empty($_GET['loc']))
		{	
			$return = mysql_fetch_array(mysql_query("SELECT * FROM {$tablename} WHERE description='{$loc}' ORDER BY time DESC LIMIT 1",$con));
			
			$sel[$_GET['loc']] = " selected=\"selected\"";
		
			
			echo "<p>last ip for <b>{$loc}</b> by <b>{$return['computer']}</b></p>"
				."<p>".date("D, M j, Y, H:i",$return['time']) ." PST</p>"
		//	."<p><pre>{$return['remote_ip']}</pre></p>"
			."<p><input type=\"text\" value=\"{$return['remote_ip']}\" size=\"".strlen($return['remote_ip'])."\" style=\"border:none;font-size:18px;font-family:courier;background-color:transparent;\" /></p>"
			."<p><input type=\"button\" value=\"copy to clipboard\" onClick=\"window.clipboardData.setData('text','{$return['remote_ip']}');\" style=\"cursor:pointer;\" /></p>"
			."<p><a href=\"https://dcc.godaddy.com/DomainDetailsKH.aspx?activeview=domain&domain=19235646&khpath=domains\" target=\"_blank\">edit againstallodds.com at godaddy.com</a></p>"
			;
		}
		
		
		echo ""
			."<p>"
			."location: <select id=\"loc\" style=\"font-size:18px;\" onChange=\""
				."location='/info/?do=display&loc=' + "
				."document.getElementById('loc').options[document.getElementById('loc').selectedIndex].value"
				." + '&hash={$time}';\">"
				."<option value=\"\">choose one</option>";
		
		$previous_days = 60;
		
		$vals = mysql_query("SELECT DISTINCT description AS des FROM {$tablename} WHERE time > ".($time-86400*$previous_days),$con);
		
		for ($i = 0; $i < mysql_num_rows($vals); $i++)
		{	$val = mysql_fetch_array($vals);
			echo "<option value=\"{$val['des']}\"{$sel[$val['des']]}>{$val['des']}</option>";
		}
			echo "</select>"
				."</p>"
				."\n<input type=\"hidden\" id=\"\""
				." value=\"curl --insecure 'https://www.againstallodds.com/info/?do=record&loc=LOCATION_NAME&id=SERVER_NAME' > /dev/null 2>&1\""
				." />"
				;
				
		echo "\n</div>\n</body>\n</html>";
		
		// garbage collection
		@mysql_query("DELETE FROM {$tablename} WHERE time < ".($time-86400*$previous_days),$con);
	}

	else
	{
		$last = mysql_fetch_array(mysql_query("SELECT * FROM {$tablename} WHERE description='{$loc}' ORDER BY time DESC LIMIT 1",$con));
		
		if ($last['remote_ip'] != $remote_ip)
		{
			$CampMon = array(	"api_key" 	=>	"cff3622c991202e2adfd7df3a82de109"
							,	"client_id" =>	"3aa363385bb2e2908ccb472987ce774a"
							,	"list_id"	=>	"bb0462a126deb4c9b540b6258a5041e8"
							);
							
			$CMdata = array( 'email' => 'topherwhite@gmail.com'
							,'fullname' => 'Topher White'
							,'location_name' => $loc
							,'new_ip_address' => $remote_ip
							,'old_ip_address' => $last['remote_ip']
							);
			require_once("/liz/www/inc/cm/CMBase.php");
			$CM = new CampaignMonitor( $CampMon['api_key'] , $CampMon['client_id'] , 0, $CampMon['list_id'] );
			$CM->method = 'soap';
			$CM -> subscriberAddWithCustomFields( $CMdata['email'], $CMdata['fullname'], $CMdata, $CampMon['list_id'], true );
			$CM -> subscriberUnsubscribe( $CMdata['email'], $CampMon['list_id'] );
		}
		
		@mysql_query("INSERT INTO {$tablename} SET"
					." description='{$loc}'"
					.", time={$time}"
					.", remote_ip='{$remote_ip}'{$id}"
					,$con);
		
		$garbage_collection = mysql_fetch_array(mysql_query(
							"SELECT COUNT(*) AS cnt FROM {$tablename} WHERE description='{$loc}' AND time < ".($time-86400*$previous_days)
							,$con));
		
		header('Content-type: text/xml');
		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
			."\n<xml>"
				."\n<ip_addr"
					." loc=\"{$loc}\""
					." id=\"{$_GET['id']}\""
					." ip=\"{$remote_ip}\""
					." time=\"".date("Y-m-j-H:i:s",$time)."\""
					." />"
			."\n</xml>";
	}
	
mysql_close($con);
}

?>