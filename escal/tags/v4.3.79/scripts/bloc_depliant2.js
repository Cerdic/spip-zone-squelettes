// Andy Langton's show/hide/mini-accordion - updated 23/11/2009
// Latest version @ http://andylangton.co.uk/jquery-show-hide

// this tells jquery to run the function below once the DOM is ready
$(document).ready(function() {

// choose text for the show/hide link - can contain HTML (e.g. an image)
var showText='Voir les réponses';
var hideText='Masquer les réponses';

// initialise the visibility check
var is_visible = false;

// append show/hide links to the element directly preceding the element with a class of "toggle"
$('.forum-article > .toggle2').prev().append(' <a href="#" class="toggleLink2">'+showText+'</a>');

// hide all of the elements with a class of 'toggle'
$(".forum-article > .toggle2").hide();

// capture clicks on the toggle links
$('a.toggleLink2').click(function() {

// switch visibility
is_visible = !is_visible;

// change the link depending on whether the element is shown or hidden
$(this).html( ($(this).html() == hideText) ? showText : hideText);

// toggle the display - uncomment the next line for a basic "accordion" style
//$('.toggle').hide();$('a.toggleLink').html(showText);
$(this).parent().next('.toggle2').toggle('slow');

// return false so any link destination is not followed
return false;

});
});