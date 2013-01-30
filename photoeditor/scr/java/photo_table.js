function thbhvr(usr,wh,action)
{	
	if (action == 1)
	{
		
		document.getElementById('cell_'+usr+'_'+wh).style.backgroundColor = '#'+rate_clr_hovr[document.getElementById('slct_'+usr+'_'+wh).options[document.getElementById('slct_'+usr+'_'+wh).selectedIndex].value];
		document.getElementById('opt1_'+usr+'_'+wh).style.visibility = 'visible';
		document.getElementById('opt2_'+usr+'_'+wh).style.visibility = 'visible';
	}
	
	else if (action == 2)
	{
		document.getElementById('cell_'+usr+'_'+wh).style.backgroundColor = '#'+rate_clr_flat[document.getElementById('slct_'+usr+'_'+wh).options[document.getElementById('slct_'+usr+'_'+wh).selectedIndex].value];
		document.getElementById('opt1_'+usr+'_'+wh).style.visibility = 'hidden';
		document.getElementById('opt2_'+usr+'_'+wh).style.visibility = 'hidden';
	}
	
	thmb_bulge(0,usr,wh,action);
}

function opthvr(usr,wh,opt,action)
{	
	var img1 = document.getElementById('opt'+opt+'_img_'+usr+'_'+wh).src;
	
	if (action == 1)
	{
 		var minus = 4;
		var addition = "_"; 
	}
	
	else if (action == 2)
	{
		var minus = 5;
		var addition = "";
	}
	
	document.getElementById('opt'+opt+'_img_'+usr+'_'+wh).src =
		img1.substring(0,(img1.length-minus))
				+ addition + '.' + img1.substring((img1.length-3),(img1.length));
}

function thmb_bulge(nm,usr,wh,action)
{	
	var nxt = nm + 1;
	
	if (action == 2) { var oper_size = (0-(2*nxt)); var oper_pos = nxt; }
	if (action == 1) { var oper_size = (2*nxt); var oper_pos = (0-nxt); }
	
	document.getElementById('thmb_'+usr+'_'+wh).style.left = (parseInt(document.getElementById('thmb_'+usr+'_'+wh).style.left)+oper_pos) + "px";
	document.getElementById('thmb_'+usr+'_'+wh).style.top = (parseInt(document.getElementById('thmb_'+usr+'_'+wh).style.top)+oper_pos) + "px";
	document.getElementById('thmb_'+usr+'_'+wh).style.width = (parseInt(document.getElementById('thmb_'+usr+'_'+wh).style.width)+oper_size) + "px";
	document.getElementById('thmb_'+usr+'_'+wh).style.height = (parseInt(document.getElementById('thmb_'+usr+'_'+wh).style.height)+oper_size) + "px";

	if (nm < thmb_bulge_magnitude) { var t = setTimeout("thmb_bulge("+ nxt +",'"+ usr +"','" + wh + "'," + action + ");",33); }
	
}