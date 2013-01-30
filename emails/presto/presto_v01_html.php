<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Rick Smolan: my new favorite gadget!</title>
</head>
<?php
$wd = 600;
$mg = 33;

echo ""
	."\n<body style=\"font-family:Verdana, Lucida Grande, Arial, sans-serif;color:#555555;font-size:12px;background-image:url(http://www.againstallodds.com/emails/presto/img/trans.gif);background-repeat:repeat-x;background-color:#eeeeee;\">"

	.'<div class="popup_box" style="position:relative; height:auto; left:0px; top:0px; background-color:transparent; border:none; visibility:hidden; z-index:0; padding:none; text-align:left;width:'.($wd+2*$mg).'px;left:0px;top:0px;visibility:visible;margin-left:auto;margin-right:auto;">'
		 .'<div class="brdr_t" style="width:'.$wd.'px;position:absolute; z-index:1; background-color:#e0e0e0; border:none; top:0px; left:33px; height:33px; border-top:solid 1px #909090;">'
		 	.'<div class="crnr_tl" style="position:absolute; width:33px; height:33px; z-index:1; top:0px;background-image:url(http://www.againstallodds.com/emails/presto/img/crnr_gr_tl.png); left:-33px;"></div>'
		 	.'<div class="crnr_tr" style="position:absolute; width:33px; height:33px; z-index:1; top:0px;left:'.($wd-1).'px;background-image:url(http://www.againstallodds.com/emails/presto/img/crnr_gr_tr.png);"></div>'
		 	.'<div class="brdr_line" style="position:absolute; z-index:0; height:100%; border:solid 1px #c0c0c0; background-color:transparent; width:100%; top:0px; left:0px; padding:none; margin:none;border-width:1px 0px 0px 0px;"></div>'
		 .'</div>'
		 
		.'<div class="inner" style="position:absolute;top:33px; left:0px; z-index:2; background-color:#e0e0e0; padding:0px 32px 0px 32px; height:auto; border-left:solid 1px #909090;border-right:solid 1px #909090;width:'.($wd+2*$mg-2).'px;padding-left:0px;padding-right:0px;">'
		 	.'<table style="width:100%;background-color:transparent;z-index:5;border:none;">'
		 		.'<tr>'
		 		.'<td style="width:'.$mg.'px;cursor:move;"></td><td>';



		ob_start(); require_once("presto_v01_text.txt"); $txt = ob_get_contents(); ob_end_clean();
		echo ''.
			str_replace("“","“<i>",
			str_replace("[unsubscribe]","PPS: As I said above, if you'd rather not receive any future ramblings from me about cool gadgets and technology just <unsubscribe>click here...</unsubscribe>",
			str_replace("”","”</i>",
			str_replace("There are some other cool features",'<a href="http://www.presto.com/?promo=RickSmolan09"><img src="http://www.againstallodds.com/emails/presto/img/presto_300.jpg" style="border:solid 1px gray;margin:0px 0px 12px 12px;float:right" /></a>There are some other cool features',
			str_replace("http://www.presto.com/?promo=RickSmolan09","<a href=\"http://www.presto.com/?promo=RickSmolan09\">http://www.presto.com/?promo=RickSmolan09</a>",
			str_replace("\n\n","<br /><br />",$txt)
			)
			)
			)
			)
			)
		;

echo 			'</td><td style="width:'.$mg.'px;cursor:move;"></td>'
		 		.'</tr>'
		 	.'</table>'
		 
			.'<div class="brdr_container" style="border:none;width:0px;height:0px;position:relative;z-index:4;">'
		 		.'<div class="brdr_b" style="top:0px;width:'.$wd.'px; z-index:1; background-color:#e0e0e0; border:none; left:0px; height:33px; border-bottom:solid 1px #909090;position:absolute;left:'.($mg-1).'px;">'
		 			.'<div class="crnr_bl" style="position:absolute; width:33px; height:33px; z-index:1; top:0px;background-image:url(http://www.againstallodds.com/emails/presto/img/crnr_gr_bl.png); left:-33px;"></div>'
		 			.'<div class="crnr_br" style="position:absolute; width:33px; height:33px; z-index:1; top:0px;left:'.($wd-1).'px;background-image:url(http://www.againstallodds.com/emails/presto/img/crnr_gr_br.png);"></div>'
		 			.'<div class="brdr_line" style="position:absolute; z-index:0; height:100%; border:solid 1px #c0c0c0; background-color:transparent; width:100%; top:0px; left:0px; padding:none; margin:none;border-width:0px 0px 1px 0px;"></div>'
		 		.'</div>'
		 	.'</div>'
		 .'</div>'
	.'</div>';
?>
</body>
</html>
