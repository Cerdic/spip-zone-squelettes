function iPhoneAlert() {
if((navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.
match(/iPod/i))){
var question = confirm("Souhaitez-vous naviguer sur le site optimisé pour iPhone?")
if (question){
window.location = "http://iphone.monsite.com/";
}else{

}
}
}