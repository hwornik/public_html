 

function popup (url) {
 fenster = window.open(url, "fenster1", "width=600,height=400,status=yes,scrollbars=yes,resizable=yes, toolbar=yes");
 return false;
}


var timeout	= 500;
var closetimer	= 200;
var ddmenuitem	= 0;


function mopen(id)
{	
	mcancelclosetime();

	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}

function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}


function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}


function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}


document.onclick = mclose;
