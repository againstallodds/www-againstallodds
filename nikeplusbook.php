<?php

header('Content-Type: image/jpeg');

require_once("nike/inc/var.inc.php");

$default = 1;
$quality = 90;

if 	( 	!empty($url_dir[(count($url_dir)-1)]) 
	&& 	($url_dir[(count($url_dir)-1)] != "1111111")
	&& 	($connection=@mysql_connect($srvr,$user,$pswd))
	)
{
	
	$id = mysqlclean($url_dir,(count($url_dir)-1),7,$connection);
	
	$chck = mysql_fetch_array(@mysql_query("SELECT user_id, images FROM nike.brightroom WHERE signmeup_id='{$id}' LIMIT 1",$connection));
	
	if (!empty($chck['user_id']))
	{	
		$default = 0;

//	should later remove		
		$num = mysql_fetch_array(@mysql_query("SELECT COUNT(*) AS cnt FROM nike.img WHERE brightroom=1 AND user_id='{$chck['user_id']}'",$connection));
		
		
		$get_qu = @mysql_query(	"SELECT time, res_wd, res_ht, (res_wd/res_ht) AS rat"
								." FROM nike.img WHERE brightroom=1 AND user_id='{$chck['user_id']}'"
							//	." AND (res_wd/res_ht)<=1"
								." ORDER BY rat,time ASC LIMIT {$num['cnt']}",$connection);
		
		$vertical_count = 0;
		
		
		
		for ($i = 0; $i < $num['cnt']; $i++)
		{	
			$img[$i] = mysql_fetch_array($get_qu);
	
			if ($img[$i]['rat'] <= 1) 	{ $work[$i] = array(
													'wd'=>round(1024*$img[$i]['rat']), 'ht'=>round((12/10)*1024*$img[$i]['rat'])
													,'lf'=> 0 , 'tp'=> round((1024-((12/10)*1024*$img[$i]['rat']))/4)
													); $vertical_count++; }
			else 						{ $work[$i] = array(
													'wd'=>round((10/12)*1024/$img[$i]['rat']), 'ht'=>round(1024/$img[$i]['rat'])
													,'lf'=> round((1024-((10/12)*1024/$img[$i]['rat']))/2) , 'tp'=> 0
													); }
				
		}
		
		$ind = rand(0,$vertical_count-1);
		
		$mini_cover_wd = 173*3;
		$mini_cover_ht = $mini_cover_wd / ($cover_wd_inches / $cover_ht_inches);

		$rot_rat['x'] = (591/519);
		$rot_rat['y'] = (681/623);		

		if (!file_exists("/cluster/bambi/web/nike/us/temp/work_0/"
						.date("Y_m_d",$img[$ind]['time'])."/{$chck['user_id']}.".dechex($img[$ind]['time']).".work_0.jpg"))
		{
			$default = 1;
		}
		else
		{
			$inter_img = ImageCreateTrueColor($mini_cover_wd,$mini_cover_ht);
			$red[0] = ImageColorAllocate( $inter_img, 255, 0, 0 );
		
			ImageCopyResampled(	$inter_img
									, ImageCreateFromJPEG("/cluster/bambi/web/nike/us/temp/work_0/"
									.date("Y_m_d",$img[$ind]['time'])."/{$chck['user_id']}.".dechex($img[$ind]['time']).".work_0.jpg")
								, 0, 0, $work[$ind]['lf'], $work[$ind]['tp']
								, $mini_cover_wd, $mini_cover_ht, $work[$ind]['wd'], $work[$ind]['ht']
								);		
		
			$final_img = ImageCreateFromJPEG("nike/inc/main_image_bg.jpg");
		
			ImageCopyResampled( $final_img, ImageRotate($inter_img,7,$red[0])
							, 25, 5, 0, 0
							, 200, 232, round($mini_cover_wd*$rot_rat['x']), round($mini_cover_ht*$rot_rat['y'])
							);
		
			ImageDestroy($inter_img);
							
			ImageCopyResampled( $final_img, ImageCreateFromPNG("nike/inc/cover_trans_sm.png")
								, 0, 0, 0, 0
								, 231, 262, 231, 261
								);
			
//			require_once("/Library/WebServer/inc/imgtxt.inc.php");
//			$mkImg = new putTxtOnImg();
//			$mkImg->Message("testing");
//			$mkImg->Font("/Library/WebServer/inc/fonts/gotham_rounded_medium.otf");
//			$mkImg->FontSize(14);
//			$mkImg->Coordinate($txt['x'],$txt['y']);
//			$mkImg->Colors($txt['clr']);
//			$msg = $mkImg->WriteTXT(40,231,$txt['bgc'],$imgQual);
			
			ImageJPEG($final_img,"",$quality);
		
			ImageDestroy($final_img);
		}		
	}
mysql_close($connection);
}

if ($default == 1)
{		
	$tag = fopen('nike/inc/email_1111111.jpg', 'rb');
	fpassthru($tag);
}

require_once("nike/inc/stats.inc.php"); stat_rec("img_email",$_SERVER['REMOTE_ADDR']);

?>