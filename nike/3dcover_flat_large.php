<?php

header('Content-Type: image/jpeg');

require_once("inc/var.inc.php");


if ($connection = @mysql_connect($srvr,$user,$pswd))
{
	$id = intval($url_dir[(count($url_dir)-1)]);
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM nike.orders WHERE order_number={$id}",$connection));

mysql_close($connection);
}

$mini_cover_wd = 965;
$mini_cover_ht = 1175;

$pos_x = 195;
$pos_y = 36;

$first_img = ImageCreateTrueColor(1200,1381);
$white = ImageColorAllocate($first_img, 255,255,255);
ImageFill($first_img , 0,0 , $white);

if (intval($info['rot_cw']) == 0)
{	ImageCopyResampled($first_img,
						ImageCreateFromJPEG("/cluster/bambi/web/nike/us/orig/". date("Y_m_d",$info['time']) ."/{$info['user_id']}.". dechex($info['time']) .".orig_0.jpg"),
						$pos_x,$pos_y,round($info['pos_x']),round($info['pos_y']),$mini_cover_wd,$mini_cover_ht,round($info['width']),round($info['height']));
}
else
{	
	ImageCopyResampled($first_img,
						imagerotate(
							ImageCreateFromJPEG("/cluster/bambi/web/nike/us/orig/". date("Y_m_d",$info['time']) ."/{$info['user_id']}.". dechex($info['time']) .".orig_0.jpg"),
								(-90)*intval($info['rot_cw']),-1),
						$pos_x,$pos_y,round($info['pos_x']),round($info['pos_y']),$mini_cover_wd,$mini_cover_ht,round($info['width']),round($info['height']));
}


ImageCopyResampled( $first_img,
						ImageCreateFromPNG("inc/img/flat_large.png"),
						0,0,0,0,1200,1381,1200,1381);

ImageJPEG($first_img,"",100);			
ImageDestroy($first_img);


?>
