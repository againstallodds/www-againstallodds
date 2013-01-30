<?php

header('Content-Type: image/jpeg');

require_once("inc/var.inc.php");


if ($connection = @mysql_connect($srvr,$user,$pswd))
{
	$id = intval($url_dir[(count($url_dir)-1)]);
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM nike.orders WHERE order_number={$id}",$connection));

mysql_close($connection);
}


$first_img = ImageCreateTrueColor($info['width'],$info['height']);

if (intval($info['rot_cw']) == 0)
{	ImageCopyResampled($first_img,
						ImageCreateFromJPEG("/cluster/bambi/web/nike/us/orig/". date("Y_m_d",$info['time']) ."/{$info['user_id']}.". dechex($info['time']) .".orig_0.jpg"),
						0,0,$info['pos_x'],$info['pos_y'],$info['width'],$info['height'],$info['width'],$info['height']);
}
else
{	
	ImageCopyResampled($first_img,
						imagerotate(
							ImageCreateFromJPEG("/cluster/bambi/web/nike/us/orig/". date("Y_m_d",$info['time']) ."/{$info['user_id']}.". dechex($info['time']) .".orig_0.jpg"),
								(-90)*intval($info['rot_cw']),-1),
						0,0,$info['pos_x'],$info['pos_y'],$info['width'],$info['height'],$info['width'],$info['height']);
}

ImageJPEG($first_img,"",75);			
ImageDestroy($first_img);


?>
