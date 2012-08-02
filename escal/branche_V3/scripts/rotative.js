// JavaScript Document
// Copyright Bernard Blazin - Juin 2007
// Ne rien Modifier en-dessous


// pour la noisette inc-actus
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


// pour la noisette inc-photos
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
 

// pour la noisette inc-annonce_defilant
 var headline3_count;
 var headline3_interval;
 var old_headline3 = 0;
 var current_headline3 = 0;

 $(document).ready(function(){
   headline3_count = $("div.headline3").size();
   $("div.headline3:eq("+current_headline3+")").css('top','5px');

   headline3_interval = setInterval(headline3_rotate,8000); //temps en millisecondes
   $('#scrollup3').hover(function() {
     clearInterval(headline3_interval);
   }, function() {
     headline3_interval = setInterval(headline3_rotate,8000); //temps en millisecondes
     headline3_rotate();
   });
 });

 function headline3_rotate() {
   current_headline3 = (old_headline3 + 1) % headline3_count;
   $("div.headline3:eq(" + old_headline3 + ")").animate({top: -205},"slow", function() {
     $(this).css('top','210px');
   });
   $("div.headline3:eq(" + current_headline3 + ")").show().animate({top: 5},"slow");
   old_headline3 = current_headline3;
 }

 
 // pour la noisette inc-sites_favoris
 var headline4_count;
 var headline4_interval;
 var old_headline4 = 0;
 var current_headline4 = 0;

 $(document).ready(function(){
   headline4_count = $("div.headline4").size();
   $("div.headline4:eq("+current_headline4+")").css('top','5px');

   headline4_interval = setInterval(headline4_rotate,8000); //temps en millisecondes
   $('#scrollup4').hover(function() {
     clearInterval(headline4_interval);
   }, function() {
     headline4_interval = setInterval(headline4_rotate,8000); //temps en millisecondes
     headline4_rotate();
   });
 });

 function headline4_rotate() {
   current_headline4 = (old_headline4 + 1) % headline4_count;
   $("div.headline4:eq(" + old_headline4 + ")").animate({top: -205},"slow", function() {
     $(this).css('top','210px');
   });
   $("div.headline4:eq(" + current_headline4 + ")").show().animate({top: 5},"slow");
   old_headline4 = current_headline4;
 }