<?php

header('Content-Type: image/png');

require_once("inc/var.inc.php");

$default = 1;
$quality = 2;

if 	( 	!empty($url_dir[(count($url_dir)-1)]) 
	&& 	($url_dir[(count($url_dir)-1)] != "1111111")
	&& 	($url_dir[(count($url_dir)-1)] != "2222222")
	&& 	($connection=@mysql_connect($srvr,$user,$pswd))
	)
{
	
	$id = mysqlclean($url_dir,(count($url_dir)-1),7,$connection);
	
	$chck = mysql_fetch_array(@mysql_query("SELECT user_id, images FROM nike.brightroom WHERE signmeup_id='{$id}' LIMIT 1",$connection));
	
	if (empty($chck['user_id']))
	{	$default = 1;
	}
	else
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
		
		$mini_cover_wd = 256;
		$mini_cover_ht = 376;

		$tang_tp = (tan(4.50/57.2957795));
		$tang_bt = (tan(3.8/57.2957795));

		$rot_rat['x'] = (329/$mini_cover_wd);
		$rot_rat['y'] = (422/$mini_cover_ht);		

		if (!file_exists("/cluster/bambi/web/nike/us/temp/work_0/"
						.date("Y_m_d",$img[$ind]['time'])."/{$chck['user_id']}.".dechex($img[$ind]['time']).".work_0.jpg"))
		{
			$default = 1;
		}
		else
		{
			$inter_img = ImageCreateTrueColor($mini_cover_wd,$mini_cover_ht);
			$red[0] = ImageColorAllocate( $inter_img, 139, 16, 21 );
		
			ImageCopyResampled(	$inter_img
									, ImageCreateFromJPEG("/cluster/bambi/web/nike/us/temp/work_0/"
									.date("Y_m_d",$img[$ind]['time'])."/{$chck['user_id']}.".dechex($img[$ind]['time']).".work_0.jpg")
								, 0, 0, $work[$ind]['lf'], $work[$ind]['tp']
								, $mini_cover_wd, $mini_cover_ht, $work[$ind]['wd'], $work[$ind]['ht']
								);		
		
			$final_img = ImageCreateTrueColor(265,192);
			$red[1] = ImageColorAllocate( $final_img, 139, 16, 21 );
			ImageFill( $final_img, 0, 0, $red[1] );
//			ImageColorTransparent($final_img, $red[1]);
		



			$second_img = ImageCreateTrueColor($mini_cover_wd,$mini_cover_ht);
			$red[2] = ImageColorAllocate($second_img, 139, 16, 21);
			ImageFill($second_img , 0,0 , $red[2]);
//			ImageColorTransparent($second_img, $red[2]);

		
			for ($i = 1; $i <= $mini_cover_wd; $i++)
			{		ImageCopyResampled( $second_img,$inter_img
										,$i,$i*$tang_tp,$i,0
										,1,round($mini_cover_ht-($i*$tang_tp)-($i*$tang_bt)),1,$mini_cover_ht);
			}
		
		
			ImageDestroy($inter_img);
			
			
//			ImagePNG(ImageRotate($second_img,12,$red[1],1),"",3);die();
			
			$test_wd = 102;
			
			ImageCopyResampled( $final_img, ImageRotate($second_img,12,$red[1],1)
							, 21, 3, 0, 0
							, $test_wd*$rot_rat['x'], round($test_wd*($mini_cover_ht/$mini_cover_wd)*$rot_rat['y']), $mini_cover_wd*$rot_rat['x'], $mini_cover_ht*$rot_rat['y']
							);
			
		
			ImageDestroy($second_img);
		
							
			ImageCopyResampled( $final_img, ImageCreateFromPNG("inc/customize_template.png")
								, 0, 0, 0, 0
								, 265, 232, 265, 232
								);

			
			ImageColorTransparent($final_img, $red[1]);
			ImagePNG($final_img,"",$quality);
		
			ImageDestroy($final_img);
		}		
	}
mysql_close($connection);
}
elseif ($url_dir[(count($url_dir)-1)] == "2222222")
{		
	$tag = fopen('inc/bttn_2222222.png', 'rb');
	fpassthru($tag);
}

if ( ($url_dir[(count($url_dir)-1)] == "1111111") || ($default == 1) || empty($url_dir[(count($url_dir)-1)]) )
{		
	$tag = fopen('inc/bttn_1111111.png', 'rb');
	fpassthru($tag);
}




require_once("inc/stats.inc.php"); stat_rec("img_bttn",$_SERVER['REMOTE_ADDR']);

?>