<?php

header('Content-Type: image/jpeg');

require_once("inc/var.inc.php");

if ($connection = @mysql_connect($srvr,$user,$pswd))
{
	$id = intval($url_dir[(count($url_dir)-1)]);
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM nike.orders WHERE order_number={$id}",$connection));

mysql_close($connection);
}

$mini_cover_wd = 90;
$mini_cover_ht = $mini_cover_wd / ($cover_wd_inches / $cover_ht_inches);


if ($info['res_wd'] >= $info['res_ht'])	{	$conv = $info['res_wd'] / $upl_photo_wd;	}
else 									{	$conv = $info['res_ht'] / $upl_photo_wd;	}


$final_img = ImageCreateTrueColor($mini_cover_wd,$mini_cover_ht);
ImageCopyResampled(		$final_img
					,	ImageCreateFromJPEG(	"/cluster/bambi/web/nike/us/temp/edit_{$info['rot_cw']}/"
												.date("Y_m_d",$info['time']) ."/{$info['user_id']}."
												.dechex($info['time']) .".edit_{$info['rot_cw']}.jpg")
					,0,0,round($info['pos_x']/$conv),round($info['pos_y']/$conv)
					,$mini_cover_wd,$mini_cover_ht,round($info['width']/$conv),round($info['height']/$conv)
					);


ImageCopyResampled($final_img,ImageCreateFromPNG("inc/img/cover_prev.png"),0,0,0,0,$mini_cover_wd,$mini_cover_ht,70,84);

ImageJPEG($final_img,"",75);			

ImageDestroy($final_img);



?>
