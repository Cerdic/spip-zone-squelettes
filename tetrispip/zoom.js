var	var_PosArray=new Array();
var	var_ZoomArray=new Array();
var var_Normal=100;
var var_Zoom=140;
var var_Anim=30;
var var_Delai=15;
var var_Factor=105;
var var_Marg=2;
var	animLocks=new Array();
var	animValues=new Array();
var	animArray=new Array();
var	animOnArray=new Array();
var	animOffArray=new Array();
var screen_size='100%';
function largescreen(){
 	lDivZoom=document.getElementById('sq_conteneur');
	if (lDivZoom){
		if (lDivZoom.style.width!='100%') 
		{
			screen_size=lDivZoom.style.width;
			lDivZoom.style.width='100%';
		}
		else {
			lDivZoom.style.width=screen_size;
		}
	}
}

function addAnim(name,anim){
	animArray[name]=anim;
}
function addAnimOnOff(name,animOn,animOff){
	animOnArray[name]=animOn;
	animOffArray[name]=animOff;
}
function initAnim(groupe){
	animLocks[groupe]=0;
	animValues[groupe]='';
}

function init(normal,zoom,anim,delai,factor,marg){
	var_Normal=normal;
	var_Zoom=zoom;
	var_Anim=anim;
	var_Delai=delai;
	var_Factor=factor;
	var_Marg=marg;
}

function setDefaultZoom(normal,zoom){
	var_Normal=normal;
	var_Zoom=zoom;
}
function setDefaultZoom(normal,zoom){
	var_Normal=normal;
	var_Zoom=zoom;
}
function setDefaultZoom(anim,delai){
	var_Anim=anim;
	var_Delai=delai;
}
function setFactor(factor,mmarg,zoom){
	var_Factor=factor;
	var_Marg=marg;
}

function anim(groupe,name,timeout){
	if (animLocks[groupe]==0){
		if (animValues[groupe]==''){
			animLocks[groupe]=2;
			lAnim=animArray[name]+'animValues[\''+groupe+'\']=\''+name+'\';animLocks[\''+groupe+'\']=0;';
			window.setTimeout(lAnim,timeout);
		}
		else{
			if (animValues[groupe]==name){
				animLocks[groupe]=5;
				lAnim=animArray[name]+'animValues[\''+groupe+'\']=\'\';animLocks[\''+groupe+'\']=0;';
				window.setTimeout(lAnim,timeout);
			}
			else {
				lAnimOff=animArray[animValues[groupe]];
				lAnim=animArray[name]+'animValues[\''+groupe+'\']=\''+name+'\';animLocks[\''+groupe+'\']=0;';
				animLocks[groupe]=2;
				window.setTimeout(lAnimOff,timeout);
				window.setTimeout(lAnim,(timeout+var_Delai*var_Factor));
			}
		}
	}
}

/*
1:on demande
2:on en cours
3:on
4:off demande
5:off en cours
*/

function anim_on(name,timeout){
	if (animLocks[name]<2){
		animLocks[name]=2;
		window.setTimeout(animOnArray[name]+'anim_checkOff(\''+name+'\');',timeout);
	}else{
		if (animLocks[name]>3){
			animLocks[name]=1;
		}
	}
}

function anim_off(name,timeout){
	if (animLocks[name]==3){
		animLocks[name]=5;
		window.setTimeout(animOffArray[name]+'anim_checkOn(\''+name+'\');',timeout);
	}else{
			if (animLocks[name]==2){
				animLocks[name]=4;
			}
	}
}

function anim_checkOff(name){
	if (animLocks[name]==2){
		animLocks[name]=3;
	}
	else {
		if (animLocks[name]==4) {
			animLocks[name]=5;
			window.setTimeout(animOffArray[name]+'animLocks[\''+name+'\']=0;',0);
		}
	}
}

function anim_checkOn(name){
	if (animLocks[name]==1){
		animLocks[name]=2;
		window.setTimeout(animOnArray[name]+'anim_checkOff(\''+name+'\');',timeout);
	}
	else {
			animLocks[name]=0;
	}
}

function move_zoom(x,y,w,h,zx,zy,zw,zh){
	__move_zoom(x,y,w,h,var_Normal,zx,zy,zw,zh,var_Zoom,var_Anim,var_Delai,var_Factor,var_Marg,'','');
}
function move_zoomx(x,y,w,h,zx,zy,zw,zh,zoom){
	__move_zoom(x,y,w,h,var_Normal,zx,zy,zw,zh,zoom,var_Anim,var_Delai,var_Factor,var_Marg,'','');
}
function _move_zoom(x,y,w,h,zx,zy,zw,zh,zoom,anim,delai){
	__move_zoom(x,y,w,h,normal,zx,zy,zw,zh,zoom,anim,delai,factor,marg,'','');
}
function move_zoomit(x,y,w,h,zx,zy,zw,zh,div_size){
	__move_zoom(x,y,w,h,var_Normal,zx,zy,zw,zh,var_Zoom,var_Anim,var_Delai,var_Factor,var_Marg,div_size,'');
}
function move_zoomxit(x,y,w,h,zx,zy,zw,zh,zoom,div_size){
	__move_zoom(x,y,w,h,var_Normal,zx,zy,zw,zh,zoom,var_Anim,var_Delai,var_Factor,var_Marg,div_size,'');
}
function move_zoomxit(x,y,w,h,zx,zy,zw,zh,zoom,div_size){
	__move_zoom(x,y,w,h,var_Normal,zx,zy,zw,zh,zoom,var_Anim,var_Delai,var_Factor,var_Marg,div_size,'');
}
function move_zoomxyit(x,y,w,h,normal,zx,zy,zw,zh,zoom,div_size){
	__move_zoom(x,y,w,h,normal,zx,zy,zw,zh,zoom,var_Anim,var_Delai,var_Factor,var_Marg,div_size,'');
}
function _move_zoomit(x,y,w,h,zx,zy,zw,zh,zoom,anim,delai,div_size){
	__move_zoom(x,y,w,h,normal,zx,zy,zw,zh,zoom,anim,delai,factor,marg,div_size,'');
}

function move(x,y,zx,zy){
	__move(x,y,zx,zy,var_Anim,var_Delai,var_Factor,var_Marg,'');
}
function moveon(x,y,zx,zy){
	__moveon(x,y,zx,zy,var_Anim,var_Delai,var_Factor,var_Marg,'');
}
function moveoff(x,y,zx,zy){
	__moveoff(x,y,zx,zy,var_Anim,var_Delai,var_Factor,var_Marg,'');
}

function _move(x,y,zx,zy,anim,delai){
	__move(x,y,zx,zy,anim,delai,var_Factor,var_Marg,'');
}
function _moveon(x,y,zx,zy,anim,delai){
	__moveon(x,y,zx,zy,anim,delai,var_Factor,var_Marg,'');
}
function _moveoff(x,y,zx,zy,anim,delai){
	__move(x,y,zx,zy,anim,delai,var_Factor,var_Marg,'');
}

function moveit(x,y,zx,zy,div_pos){
	__move(x,y,zx,zy,var_Anim,var_Delai,var_Factor,var_Marg,div_pos);
}
function moveiton(x,y,zx,zy,div_pos){
	__moveon(x,y,zx,zy,var_Anim,var_Delai,var_Factor,var_Marg,div_pos);
}
function moveitoff(x,y,zx,zy,div_pos){
	__moveoff(x,y,zx,zy,var_Anim,var_Delai,var_Factor,var_Marg,div_pos);
}

function _moveit(x,y,zx,zy,anim,delai,div_pos){
	__move(x,y,zx,zy,anim,delai,var_Factor,var_Marg,div_pos);
}
function _moveiton(x,y,zx,zy,anim,delai,div_pos){
	__moveon(x,y,zx,zy,anim,delai,var_Factor,var_Marg,div_pos);
}
function _moveitoff(x,y,zx,zy,anim,delai,div_pos){
	__moveoff(x,y,zx,zy,anim,delai,var_Factor,var_Marg,div_pos);
}

function __move(x,y,zx,zy,anim,delai,factor,marg,div_pos){
	if (div_pos=='') div_pos='pos_'+x+'_'+y;
	lDivPos=document.getElementById(div_pos);
	_x=zoom_pos(x,factor,marg);
	_y=zoom_pos(y,factor,marg);
	_zx=zoom_pos(zx,factor,marg);
	_zy=zoom_pos(zy,factor,marg);
	if ((lDivPos.style.top==(_zy+'px'))
	&& (lDivPos.style.left==(_zx+'px'))){
		transition_pos(lDivPos,_zx,_zy,_x,_y,anim,delai);
	}else{
		transition_pos(lDivPos,_x,_y,_zx,_zy,anim,delai);
	}
}
function __moveon(x,y,zx,zy,anim,delai,factor,marg,div_pos){
	if (div_pos=='') div_pos='pos_'+x+'_'+y;
	lDivPos=document.getElementById(div_pos);
	_x=zoom_pos(x,factor,marg);
	_y=zoom_pos(y,factor,marg);
	_zx=zoom_pos(zx,factor,marg);
	_zy=zoom_pos(zy,factor,marg);
	transition_pos(lDivPos,_x,_y,_zx,_zy,anim,delai);
}
function __moveoff(x,y,zx,zy,anim,delai,factor,marg,div_pos){
	if (div_pos=='') div_pos='pos_'+x+'_'+y;
	lDivPos=document.getElementById(div_pos);
	_x=zoom_pos(x,factor,marg);
	_y=zoom_pos(y,factor,marg);
	_zx=zoom_pos(zx,factor,marg);
	_zy=zoom_pos(zy,factor,marg);
	transition_pos(lDivPos,_zx,_zy,_x,_y,anim,delai);
}
function __move_zoom(x,y,w,h,normal,zx,zy,zw,zh,zoom,anim,delai,factor,marg,div_size,div_pos){
 	if (div_size=='') div_size='zoom';
	lDivZoom=document.getElementById(div_size);
	if (lDivZoom){
		if (div_pos=='') div_pos='pos_'+x+'_'+y;
		lDivPos=document.getElementById(div_pos);
		_x=zoom_pos(x,factor,marg);
		_y=zoom_pos(y,factor,marg);
		_w=zoom_size(w,factor,marg);
		_h=zoom_size(h,factor,marg);
		_zx=zoom_pos(zx,factor,marg);
		_zy=zoom_pos(zy,factor,marg);
		_zw=zoom_size(zw,factor,marg);
		_zh=zoom_size(zh,factor,marg);
		if ((lDivPos.style.top==(_zy+'px'))
		&& (lDivPos.style.left==(_zx+'px'))
		&& (lDivZoom.style.height==(_zh+'px'))
		&& (lDivZoom.style.width==(_zw+'px'))){
			transition(lDivPos,lDivZoom,_zx,_zy,_zw,_zh,zoom,_x,_y,_w,_h,normal,anim,delai);
		}else{
			transition(lDivPos,lDivZoom,_x,_y,_w,_h,normal,_zx,_zy,_zw,_zh,zoom,anim,delai);
		}
	}
}

function zoom_pos(x,factor,marg){
	return (x-1)*(factor+(2*marg));
}

function zoom_size(x,factor,marg){
	return x*(factor)+(x-1)*2*marg;
}

function transition_zoom(lDivZoom,w,h,normal,zw,zh,zoom,anim,delai){
	zoomName=lDivZoom.id;
	var_ZoomArray[zoomName]=lDivZoom;
	anim=anim+1;
	action='';
	pas_w=(zw-w)/anim;
	pas_h=(zh-h)/anim;
	pas_zoom=(zoom-normal)/anim;
		
	for(i=1;i<=anim;i++){	
		_w=Math.round(w+i*pas_w);
		_h=Math.round(h+i*pas_h);
		_zoom=Math.round(normal+i*pas_zoom);
		action='var_ZoomArray[\''+zoomName+'\'].style.width=\''+_w+'px\';var_ZoomArray[\''+zoomName+'\'].style.height=\''+_h+'px\';var_ZoomArray[\''+zoomName+'\'].style.fontSize=\''+_zoom+'%\';';
		window.setTimeout(action,i*delai);
	}
	return false;
}

function transition_pos(lDivPos,x,y,zx,zy,anim,delai){
	posName=lDivPos.id;
	var_PosArray[posName]=lDivPos;
	anim=anim+1;
	action='';
	pas_x=(zx-x)/anim;
	pas_y=(zy-y)/anim;
		
	for(i=1;i<=anim;i++){	
		_x=Math.round(x+i*pas_x);
		_y=Math.round(y+i*pas_y);
		action='var_PosArray[\''+posName+'\'].style.top=\''+_y+'px\';var_PosArray[\''+posName+'\'].style.left=\''+_x+'px\';';
		window.setTimeout(action,i*delai);
	}
	return false;
}

function transition(lDivPos,lDivZoom,x,y,w,h,normal,zx,zy,zw,zh,zoom,anim,delai){
	transition_zoom(lDivZoom,w,h,normal,zw,zh,zoom,anim,delai);
	transition_pos(lDivPos,x,y,zx,zy,anim,delai);
	return false;
}
