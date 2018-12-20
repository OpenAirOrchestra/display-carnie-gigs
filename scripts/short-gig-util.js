// Three functions from http://www.openjs.com/scripts/dom/class_manipulation.php
//
function hasClass(ele,cls) 
{
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}
function addClass(ele,cls) 
{
	if (!this.hasClass(ele,cls)) ele.className += " "+cls;
}
function removeClass(ele,cls) 
{
	if (hasClass(ele,cls)) 
	{
		var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
		ele.className=ele.className.replace(reg,' ');
	}
}

function toggleClass(ele,cls) 
{
	if (hasClass(ele,cls)) 
	{
		removeClass(ele,cls);
	}
	else
	{
		addClass(ele,cls);
	}
}

function toggle_parent_collapsed(e) 
{
	var targ;
	if (!e) var e = window.event;
	if (e.target) targ = e.target;
	else if (e.srcElement) targ = e.srcElement;
	if (targ.nodeType == 3) // defeat Safari bug
		targ = targ.parentNode;

	toggleClass(targ.parentNode, "collapsed");
}


