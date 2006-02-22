function hover(obj){
  if(document.all){
    UL = obj.getElementsByTagName('ul');
    if(UL.length > 0){
      sousMenu = UL[0].style;
      if(sousMenu.display == 'none' || sousMenu.display == ''){
        sousMenu.display = 'block';
        sousMenu.zIndex = 0;
        
      }else{
        sousMenu.display = 'none';
        sousMenu.zIndex = 99;
      }
    }
  }
}
