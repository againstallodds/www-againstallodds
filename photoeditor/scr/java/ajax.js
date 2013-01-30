// AJAX Universal Function (start)
var xmlHttp

function GetXmlHttpObject()
{	var xmlHttp=null;
	try { xmlHttp=new XMLHttpRequest(); }
	catch (e)
	{	try { xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); }
		catch (e) { xmlHttp=new ActiveXObject("Microsoft.XMLHTTP"); }
	}
	return xmlHttp;
}
// AJAX Universal Function (end)


// Apply Rating to Thumbnail
function req_rate(usr,wh)
{	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null) { alert ("Your browser does not support this feature."); return; }
		
	var url = 	"/scr/ajax/rate.php?usr="+usr+"&wh="+wh
				+"&rt="+document.getElementById('slct_'+usr+'_'+wh).options[document.getElementById('slct_'+usr+'_'+wh).selectedIndex].value
				+"&key="+Math.random();
				
	xmlHttp.onreadystatechange = stateChng_rate;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function stateChng_rate()
{	if (xmlHttp.readyState == 4)
	{	var xmlDoc=xmlHttp.responseXML.documentElement;
		var succ = parseInt(xmlDoc.getElementsByTagName("rate")[0].childNodes[0].nodeValue);
		if (succ != 1)	{ alert("The rating could not be saved. Please try again..."); }
	}
}

function confirm_delete(usr,wh,action)
{	if (action == 1)
	{	var r = confirm('Are you sure that you wish to move this photo to the trash?');
		if (r == true) { req_delete(usr,wh,1); }
	}
	else
	{	var r = confirm('Are you sure that you wish to remove this photo from the trash (it will reappear in any relevant albums as well)?');
		if (r == true) { req_delete(usr,wh,0); }
	}
}

// Delete/Undelete an Image
function req_delete(usr,wh,action)
{	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null) { alert ("Your browser does not support this feature."); return; }
		
	var url = 	"/scr/ajax/delete.php?usr="+usr+"&wh="+wh+"&do="+action+"&key="+Math.random();
				
	xmlHttp.onreadystatechange = stateChng_delete;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function stateChng_delete()
{	if (xmlHttp.readyState == 4)
	{	var xmlDoc=xmlHttp.responseXML.documentElement;
		var succ = parseInt(xmlDoc.getElementsByTagName("delete")[0].childNodes[0].nodeValue);
		if (succ != 1)	{ alert("The image could not be deleted. Please try again..."); }
		else { location.reload(); }
	}
}

// Apply Crops
function req_crop_save(url)
{	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null) { alert ("Your browser does not support this feature."); return; }
		
	xmlHttp.onreadystatechange = stateChng_crop_save;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function stateChng_crop_save()
{	if (xmlHttp.readyState == 4)
	{	var xmlDoc=xmlHttp.responseXML.documentElement;
		var succ = parseInt(xmlDoc.getElementsByTagName("crop")[0].childNodes[0].nodeValue);
		if (succ != 1)	{ alert("Your crop settings could not be saved. Please try again..."); }
	}
}

// Create Album
function req_create_album()
{	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null) { alert ("Your browser does not support this feature."); return; }
	var url = "/scr/ajax/random.php?ln=12&key="+Math.random();	
	xmlHttp.onreadystatechange = stateChng_create_album;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function stateChng_create_album()
{	if (xmlHttp.readyState == 4)
	{	var xmlDoc=xmlHttp.responseXML.documentElement;
		var rand = xmlDoc.getElementsByTagName("random")[0].childNodes[0].nodeValue;
		var val_name =  document.getElementById('create_album_name').value;
		req_value_list(1,'album',rand,val_name);
	}
}

// Manipulate Value Table
function req_value_list(action,tp,vl,nm)
{	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null) { alert ("Your browser does not support this feature."); return; }
		
	if ((action == 1) || (action == 2))
	{	var url = 	"/scr/ajax/value_lists.php?do="+action+"&tp="+escape(tp)
					+"&vl="+escape(vl)+"&nm="+escape(nm)+"&key="+Math.random();
		
//		window.open(url);
		
		xmlHttp.onreadystatechange = stateChng_value_list;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
}

function stateChng_value_list()
{	if (xmlHttp.readyState == 4)
	{	var xmlDoc=xmlHttp.responseXML.documentElement;
		var succ = parseInt(xmlDoc.getElementsByTagName("rate")[0].childNodes[0].nodeValue);
		if (succ == 0)	{ alert("The change could not be made. Please try again..."); }
		else { alert("The requested change was successfully implemented."); }		
	}
}

//Go to Album
function view_album()
{
//	var alb = document.getElementById('albm_slct').options[document.getElementById('view_slct').selectedIndex].value;

//	alert(alb);
	
	location = '?view=1&alb='+document.getElementById('albm_slct').options[document.getElementById('view_slct').selectedIndex].value;
}


// Create Album
function req_albm_itm(url)
{	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null) { alert ("Your browser does not support this feature."); return; }
	
//	if (	(document.getElementById('val_albm_slct').value == null)	
//		&&	(document.getElementById('albm_slct').options[document.getElementById('albm_slct').selectedIndex].value == '-')
//		)
//	{	alert('Please select an album first...');
//	}
//	else
//	{
		xmlHttp.onreadystatechange = stateChng_albm_itm;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
//	}
}

function stateChng_albm_itm()
{	if (xmlHttp.readyState == 4)
	{	var xmlDoc=xmlHttp.responseXML.documentElement;

		var action = xmlDoc.getElementsByTagName("do")[0].childNodes[0].nodeValue;	
		var nmbr = xmlDoc.getElementsByTagName("nmbr")[0].childNodes[0].nodeValue;
		var succ = xmlDoc.getElementsByTagName("succ")[0].childNodes[0].nodeValue;
		var fail = xmlDoc.getElementsByTagName("fail")[0].childNodes[0].nodeValue;
		var deja = xmlDoc.getElementsByTagName("deja")[0].childNodes[0].nodeValue;
				
		var albm = document.getElementById('albm_slct').options[document.getElementById('albm_slct').selectedIndex].text;

		if (action == 1)
		{	if (deja != 0)
			{ alert("The photos have been added. "+deja+" of the "+nmbr+" selected photo(s) were already in album '"+albm+"'."); }
			else if (fail == 0) { alert("The "+nmbr+" selected photo(s) have been added to the album '"+albm+"'."); }
		}
		else if (action == 2)
		{	if (succ == nmbr) { location.reload(); }
			
		}
	}
}


function gather_checked(action,id,info)
{
	var nmbr_sel = 0; var str = "";
	for (i = 0; i < nmbr_visible; i = i + 1)
	{	if (document.getElementById('slct_'+i).checked == true)
		{ str += "-"+document.getElementById('slct_'+i).value; nmbr_sel = nmbr_sel + 1; }
	}
	var send_str = nmbr_sel+str;
	
	if (nmbr_sel == 0) { alert("No photos have been selected. Please select one or more photos below and try again."); }
	else if ((action == 'alb_add') || (action == 'alb_rem'))
	{
		if (action == 'alb_add') { var alb_do = 1; var alb_id = document.getElementById('val_albm_slct').value; }
		else { var alb_do = 2; var alb_id = document.getElementById('val_albm_curr').value; }
		
		var url = "/scr/ajax/album.php?do=" + alb_do + "&id=" + id + "&send="+send_str + "&alb=" + alb_id;	

//		window.open(url);
		req_albm_itm(url);

	}
	else if (action == 'batch_apply')
	{	
		var url = "/scr/ajax/batch_apply.php?fld=" + info
				+ "&val=" + document.getElementById('batch_'+info).value
				+ "&id=" + id + "&send="+send_str;
		req_batch_apply(url);
	}
}

function req_batch_apply(url)
{	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null) { alert ("Your browser does not support this feature."); return; }
		
	xmlHttp.onreadystatechange = stateChng_batch_apply;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function stateChng_batch_apply()
{	if (xmlHttp.readyState == 4)
	{	var xmlDoc=xmlHttp.responseXML.documentElement;
	
		var field = xmlDoc.getElementsByTagName("batch")[0].getAttribute("field");
		var rtrn_value = xmlDoc.getElementsByTagName("batch")[0].getAttribute("value");
		var nmbr = xmlDoc.getElementsByTagName("batch")[0].getAttribute("nmbr");
		
		for (i = 0; i < xmlDoc.getElementsByTagName("rtrn").length; i++)
		{
			if (field == 'rating')
			{	document.getElementById('slct_'+xmlDoc.getElementsByTagName("rtrn")[i].getAttribute("usr")+'_'+xmlDoc.getElementsByTagName("rtrn")[i].getAttribute("wh")).selectedIndex = rtrn_value;
				document.getElementById('cell_'+xmlDoc.getElementsByTagName("rtrn")[i].getAttribute("usr")+'_'+xmlDoc.getElementsByTagName("rtrn")[i].getAttribute("wh")).style.backgroundColor = '#'+rate_clr_flat[document.getElementById('slct_'+xmlDoc.getElementsByTagName("rtrn")[i].getAttribute("usr")+'_'+xmlDoc.getElementsByTagName("rtrn")[i].getAttribute("wh")).options[document.getElementById('slct_'+xmlDoc.getElementsByTagName("rtrn")[i].getAttribute("usr")+'_'+xmlDoc.getElementsByTagName("rtrn")[i].getAttribute("wh")).selectedIndex].value];
			}
		}
		
	}
}

function slct_checkbox(action,i)
{
	if (action == 0) { var slct_chck = false; var cell_brdr = '#'+chck_clr_flat[0]; }
	else if (action == 1) { var slct_chck = true; var cell_brdr = '#'+chck_clr_flat[1];; }
	else if (action == 3) { if (document.getElementById('slct_'+i).checked == false) { var cell_brdr = '#'+chck_clr_flat[0]; } else { var cell_brdr = '#'+chck_clr_flat[1]; } }
	else if (action == 4) {		if (document.getElementById('slct_'+i).checked == false) { var slct_chck = true; var cell_brdr = '#'+chck_clr_flat[1]; }
								else { var slct_chck = false; var cell_brdr = '#'+chck_clr_flat[0]; } }
	
	if (action != 3) { document.getElementById('slct_'+i).checked = slct_chck; }
	document.getElementById('cell_'+document.getElementById('val_usr_'+i).value+'_'+document.getElementById('val_wh_'+i).value).style.border = '1px solid ' + cell_brdr;
}

function change_slct(action)
{
	for (i = 0; i < nmbr_visible; i = i + 1) { slct_checkbox(action,i); }
}


function download_full_album(alb)
{
	var r = confirm( 'If you click OK, your browser will open a separate window'
					+' and download a zipped file of all the photos in the album you are currently viewing.'
					+'\n\nPlease be patient, as it may take several moments (or even several minutes)'
					+' to generate the batch file...');
	if (r == true) { window.open('/scr/php/download.php?alb='+alb); }
	
	
	
}

