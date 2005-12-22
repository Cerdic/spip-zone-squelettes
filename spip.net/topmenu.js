/**********************************************************************************   
TopMenu 
*   Copyright (C) 2001 Thomas Brattli
*   This script was released at DHTMLCentral.com
*   Visit for more great scripts!
*   This may be used and changed freely as long as this msg is intact!
*   We will also appreciate any links you could give us.
*
*   Made by Thomas Brattli
*
*   Script date: 09/23/2001 (keep this date to check versions) 
*********************************************************************************/
function lib_bwcheck(){ //Browsercheck (needed)
	this.ver=navigator.appVersion
	this.agent=navigator.userAgent
	this.dom=document.getElementById?1:0
	this.opera5=(navigator.userAgent.indexOf("Opera")>-1 && document.getElementById)?1:0
	this.ie5=(this.ver.indexOf("MSIE 5")>-1 && this.dom && !this.opera5)?1:0; 
	this.ie6=(this.ver.indexOf("MSIE 6")>-1 && this.dom && !this.opera5)?1:0;
	this.ie4=(document.all && !this.dom && !this.opera5)?1:0;
	this.ie=this.ie4||this.ie5||this.ie6
	this.mac=this.agent.indexOf("Mac")>-1
	this.ns6=(this.dom && parseInt(this.ver) >= 5) ?1:0; 
	this.ns4=(document.layers && !this.dom)?1:0;
	this.bw=(this.ie6 || this.ie5 || this.ie4 || this.ns4 || this.ns6 || this.opera5)
	return this
}
var bw=lib_bwcheck()
/* Set the variables below.
If you look at the init function you can see that you can also set
these variables different for each menu!

If you only want 1 menu just remove the lines marked with *
in the init function and the divs from the page.
*/

//How many pixels should it move every step? 
var tMove=10;

//At what speed (in milliseconds, lower value is more speed)
var tSpeed=40

//Do you want it to move with the page if the user scroll the page?
var tMoveOnScroll=false;

//How much of the menu should be visible in the in state?
var tShow=45;

/********************************************************************
Contructs the menuobjects -Object functions
*********************************************************************/
function makeMenu(obj,nest,show,move,speed){
    nest=(!nest) ? "":'document.'+nest+'.'
	this.el=bw.dom?document.getElementById(obj):bw.ie4?document.all[obj]:bw.ns4?eval(nest+'document.'+obj):0;
  	this.css=bw.dom?document.getElementById(obj).style:bw.ie4?document.all[obj].style:bw.ns4?eval(nest+'document.'+obj):0;		
	this.x=this.css.left||this.css.pixelLeft||this.el.offsetLeft||0
	this.y=this.css.top||this.css.pixelTop||this.el.offsetTop||0
	this.state=1; this.go=0; this.mup=b_mup; this.show=show; this.mdown=b_mdown; 
	this.height=bw.ns4?this.css.document.height:this.el.offsetHeight
	this.moveIt=b_moveIt; this.move=move; this.speed=speed
    this.obj = obj + "Object"; 	eval(this.obj + "=this")	
}

// A unit of measure that will be added when setting the position of a layer.
var px = bw.ns4||window.opera?"":"px";

function b_moveIt(x,y){this.x=x; this.y=y; this.css.left=this.x+px; this.css.top=this.y+px;}
//Menu in
function b_mup(){
	if(this.y>-this.height+this.show){
		this.go=1; this.moveIt(this.x,this.y-this.move)
		setTimeout(this.obj+".mup()",this.speed)
	}else{this.go=0; this.state=1}	
}
//Menu out
function b_mdown(){
	if(this.y<eval(scrolled)){
		this.go=1; this.moveIt(this.x,this.y+this.move)
		setTimeout(this.obj+".mdown()",this.speed)
	}else{this.go=0; this.state=0}	
}
/********************************************************************************
Deciding what way to move the menu (this is called onmouseover, onmouseout or onclick)
********************************************************************************/
function moveTopMenu(num){
	if(!oMenu[num].go){
		if(!oMenu[num].state)oMenu[num].mup()	
		else oMenu[num].mdown()
	}
	for(i=0;i<oMenu.length;i++){
		if(i!=num && !oMenu[i].state){ oMenu[i].mup()}
	}
}
/********************************************************************************
Checking if the page is scrolled, if it is move the menu after
********************************************************************************/
function checkScrolled(){
	for(i=0;i<oMenu.length;i++){
		if(!oMenu[i].go){
			y=!oMenu[i].state?eval(scrolled):eval(scrolled)-oMenu[i].height+oMenu[i].show
			oMenu[i].moveIt(oMenu[i].x,y)
		}
	}
	if(bw.ns4||bw.ns6) setTimeout('checkScrolled()',40)
}
/********************************************************************************
Inits the page, makes the menu object, moves it to the right place, 
show it
********************************************************************************/
function topMenuInit(){
	oMenu=new Array()
	oMenu[0]=new makeMenu('divMenu0',"",tShow,tMove,tSpeed) 
	oMenu[1]=new makeMenu('divMenu1',"",tShow,tMove,tSpeed) //*
	oMenu[2]=new makeMenu('divMenu2',"",tShow,tMove,tSpeed) //*
	oMenu[3]=new makeMenu('divMenu3',"",tShow,tMove,tSpeed) //*
	oMenu[4]=new makeMenu('divMenu4',"",tShow,tMove,tSpeed) //*

	
	scrolled=bw.ns4||bw.ns6?"window.pageYOffset":"document.body.scrollTop"
	//Placing and showing menus
	for(i=0;i<oMenu.length;i++){
		oMenu[i].moveIt(oMenu[i].x,-oMenu[i].height+oMenu[i].show)
		oMenu[i].css.visibility='visible'
	}
	if(tMoveOnScroll) bw.ns4||bw.ns6?checkScrolled():window.onscroll=checkScrolled;
}

//Initing menu on pageload
onload=topMenuInit;

/***************
Multiple Scripts
If you have two or more scripts that use the onload event, probably only one will run (the last one).
Here is a solution for starting multiple scripts onload:
   1. Delete or comment out all the onload assignments, onload=initScroll and things like that.
   2. Put the onload assignments in the body tag like in this example, note that they must have braces ().
   Example: <body onload="initScroll(); initTooltips(); initMenu();">
**************/