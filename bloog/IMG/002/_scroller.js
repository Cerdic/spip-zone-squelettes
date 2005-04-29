timSpeed=50
contHeight=210

//If you want it to move faster you can set this lower:
var speed=5

//Sets variables to keep track of what's happening
var loop, timer

//Object constructor
function scrollObj(obj,nest)
{
	this.el=document.getElementById(obj);
	this.css=this.el.style;
	this.scrollWidth=this.el.offsetWidth
	this.scrollHeight=this.el.offsetHeight
	this.clipWidth=this.el.offsetWidth
	this.clipHeight=this.el.offsetHeight
	this.left=goLeft;
        this.right=goRight;	
        this.up=goUp;
        this.down=goDown;
	this.top=goTop;
        this.bottom=goBottom;
	this.moveIt=moveIt;
	this.obj = obj + "Object"
	eval(this.obj + "=this")
	return this
}

function moveIt(x,y)
{
		  this.x=x;
		  this.y=y
		  this.css.left=this.x + 'px';
		  this.css.top=this.y + 'px';
}

//Makes the object go up
function goDown(move){
        scrollInit();
	if(this.y>-this.scrollHeight+oCont.clipHeight)
	{
		this.moveIt(0,this.y-move)
		if(loop) setTimeout(this.obj+".down("+move+")",speed)
	}
}
//Makes the object go down
function goUp(move)
{
        scrollInit();
	if(this.y<0)
	{
		this.moveIt(0,this.y-move)
		if(loop) setTimeout(this.obj+".up("+move+")",speed)
	}
}

//Makes the object go left
function goLeft(move)
{
        scrollInit();
	if(this.x<0)
	{
		this.moveIt(this.x-move,0)
		if(loop) setTimeout(this.obj+".left("+move+")",speed)
	}
}

//Makes the object go right
function goRight(move)
{
        scrollInit();
	if(this.x>-this.scrollWidth+oCont.clipWidth)
	{
		this.moveIt(this.x-move,0)
		if(loop) setTimeout(this.obj+".right("+move+")",speed)
	}
}

//Makes the object go bottom
function goBottom() 
{
        scrollInit();
	this.moveIt(0,oCont.clipHeight-this.clipHeight) ;
}

function goTop() 
{
        scrollInit();
	this.moveIt(0,0) ;
}

//Calls the scrolling functions. Also checks whether the page is loaded or not.
function scroll(speed)
{
        scrollInit();
	if(loaded)
	{
		loop=true;
		if(speed>0) 
			oScroll.down(speed)
		else 
			oScroll.up(speed)
	}
}

function scrollH(speed)
{
	if(loaded)
	{
		loop=true;
		if(speed>0) 
			oScroll.right(speed)
		else 
			oScroll.left(speed)
	}
}

function jumpTop() 
{
         oScroll.top();
         //goTop();
}

function jumpBottom() 
{
	oScroll.bottom();
	// goBottom();
}

//Stops the scrolling (called on mouseout)
function noScroll()
{
	loop=false
	if(timer) clearTimeout(timer)
}
//Makes the object
var loaded;
var scroll_loaded = false;
function scrollInit()
{
	if (scroll_loaded) 
	{
		return;
	}
              
	document.getElementById('BlocScroll').style.height = 'auto';

	oCont=new scrollObj('divCont')
	oScroll=new scrollObj('BlocScroll','divCont')
	oScroll.moveIt(0,0)
	oCont.css.visibility='visible'
	loaded=true;
        scroll_loaded = true;
}
