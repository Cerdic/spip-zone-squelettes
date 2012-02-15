// JavaScript Document
// Copyright Bernard Blazin - Juin 2007
// Ne rien Modifier en-dessous
var headline_count;
 var headline_interval;
 var old_headline = 0;
 var current_headline = 0;
 
 $(document).ready(function(){
   headline_count = $("div.headline").size();
   $("div.headline:eq("+current_headline+")").css('top','5px');
 
   headline_interval = setInterval(headline_rotate,5000); //temps en millisecondes
   $('#scrollup').hover(function() {
     clearInterval(headline_interval);
   }, function() {
     headline_interval = setInterval(headline_rotate,5000); //temps en millisecondes
     headline_rotate();
   });
 });
 
 function headline_rotate() {
   current_headline = (old_headline + 1) % headline_count; 
   $("div.headline:eq(" + old_headline + ")").animate({top: -205},"slow", function() {
     $(this).css('top','210px');
   });
   $("div.headline:eq(" + current_headline + ")").show().animate({top: 5},"slow");  
   old_headline = current_headline;
 }



 var headline2_count;
 var headline2_interval;
 var old_headline2 = 0;
 var current_headline2 = 0;
 
 $(document).ready(function(){
   headline2_count = $("div.headline2").size();
   $("div.headline2:eq("+current_headline2+")").css('top','5px');
 
   headline2_interval = setInterval(headline2_rotate,8000); //temps en millisecondes
   $('#scrollup2').hover(function() {
     clearInterval(headline2_interval);
   }, function() {
     headline2_interval = setInterval(headline2_rotate,8000); //temps en millisecondes
     headline2_rotate();
   });
 });
 
 function headline2_rotate() {
   current_headline2 = (old_headline2 + 1) % headline2_count; 
   $("div.headline2:eq(" + old_headline2 + ")").animate({top: -205},"slow", function() {
     $(this).css('top','210px');
   });
   $("div.headline2:eq(" + current_headline2 + ")").show().animate({top: 5},"slow");  
   old_headline2 = current_headline2;
 }