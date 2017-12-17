/******************************************************************************
*******************************************************************************

  Inspired by Bernard Blazin's (June 2007) rotative_js.html


  Noisette name : Rotative.js
  Version       : 1.0
  Author        : Patrice Guerlais paguerlais .at. free<dot>fr
  Licence       : BSD Licence
  Date          : 20150613

*******************************************************************************
USAGE
*******************************************************************************

Rotative object : animate the hiding and display of display elements grouped
                  in a container, e.g. rotate div.something contained in a
                  #scroll section.

Parameters :
container : the HTML object containing the objects to rotate e.g. "#scroll"
element   : the HTML object to rotate e.g. "div.something"
tempo     : rotate every "tempo" seconds
debug     : optional, activate logs to the console if set to a non-null value,
            e.g. 'yes' or 1. Warning : 'no' IS a non-null value...

Example :
$(document).ready(
  function()
  {
    new Rotative
    (
      {
        container : "#annonces_defilantes",
        element   : "div.annonce_defilante",
        tempo     : [(#CONFIG{escal/config/tempoannoncedefil, 8})],
        debug     : 'yes'
      }
    )
  }
) ;

*******************************************************************************
******************************************************************************/

function Rotative(options)
{
  //options.debug = 1 ;
  if (options.debug) console.log("Rotative.new options=", options) ;

  /////////////////////////////////////////////////////////////////////////////
  //
  // Methods definition
  //
  /////////////////////////////////////////////////////////////////////////////

  //
  // Relay method to hide the current element (the one which index is stored in
  // this.current). It is necessary because we need to access some properties
  // stored within the Rotative object when this method is used as a callback.
  // The speed of hiding can be passed as a parameter on call, defaulted to
  // "slow". This is useful to initialize a rotation : the initial hiding is
  // done with the speed set to 0 as this.hide_current(0), but for an actual
  // rotation the default speed is ok : this.hide_current().
  //
  this.hide_current = function(speed)
    {
      // Set speed to "slow" if it is undefined
      speed = speed || "slow" ;

      if (this.debug) console.log("hide_current element="+this.element+" current="+this.current+" height="+this.height) ;

      // Need to copy locally the height_px property because we'll use it in
      // the animate post-animation function which is executed in the element
      // context whereas this.height_px is accessed in Rotative context :-(
      var height_px = this.height_px ;
      $(this.element)
        .eq(this.current)
          .animate({top: -this.height}, speed,
		   // $(this).css : refers to an element item
		   // height_px   : must be accessed in a Rotative context thus
		   //               the relay variable.
		   function() { $(this).css('top', height_px) } ) ;
    }


  this.show_current = function(speed)
    {
      if (this.debug) console.log("show_current current="+this.current) ;

      // Set speed to "slow" if it is undefined
      speed = speed || "slow" ;

      $(this.element).eq(this.current).show().animate({top: 0}, speed) ;
    }


  //
  // Rotation method : scroll up the current element to hide it, progress to
  // the next one and scroll this new element up to show it.
  //
  this.rotate = function()
    {
      if (this.debug) console.log("rotate entry count="+this.count+" current="+this.current) ;

      // Hide the current element
      this.hide_current() ;

      // Next element : use an addition and a test rather than a modulo, it's
      // faster to compute.
      // To be noted : the test is >= rather than >. Indeed > should suit but
      // >= acts as a goal-keeper just in case the current index would have an
      // unattended value at entry.
      if (++this.current >= this.count) this.current = 0 ;
      this.show_current() ;
    }


  //
  // Callback to call when entering the container object : stop rotating.
  //
  this.HoverEnter = function()
    {
      if (this.debug) console.log("Hover enter "+this.container) ;
      clearInterval(this.interval) ;
    }


  // Callback to call when leaving the container object : rotate and
  // reinstantiate the automatic rotation
  this.HoverLeave = function()
    {
      if (this.debug) console.log("Hover leave "+this.container) ;
      this.rotate() ;
      this.interval = setInterval(this.rotate.bind(this), this.tempo) ;
    }


  /////////////////////////////////////////////////////////////////////////////
  //
  // Properties definition
  // Note : 'current' will be defined later to avoid an unuseful initialization
  //
  /////////////////////////////////////////////////////////////////////////////

  // Allocate the object with the received parameters
  this.container = options.container ||
    console.log("Missing 'container' parameter, options=", options) ;
  this.element   = options.element ||
    console.log("Missing 'element' parameter, options=", options) ;
  this.tempo     = options.tempo * 1000 ||
    console.log("Missing 'tempo' parameter, options=", options) ;
  this.height    = $(this.container).height() ;
  this.height_px = this.height+"px" ;
  this.debug     = options.debug || 0 ;

  // Add some computed properties
  // Number of instances of the document item
  this.count    = $(this.element).length ;

  if (this.debug) console.log("rotative constructor : this=", this) ;


  /////////////////////////////////////////////////////////////////////////////
  //
  // Instance initialization
  //
  /////////////////////////////////////////////////////////////////////////////

  // Nothing to do if there's no element to rotate
  if (!this.count)
    {
      if (this.debug) console.log(this.container+" : empty list of ["+this.element+"] elements") ;
      return ;
    }

  // Display the first (lower) element of the stack : index 0
  this.current = 0 ;
  this.show_current() ;

  // Set the callbacks and rotation temporisation if there's at least 2
  // elements : it would be dumb to rotate an element on itself ;-)
  if (this.count < 2)
    {
      if (this.debug) console.log("No callbacks nor rotation, there's only "+this.count+" elements") ;
      return ;
    }
  // The the callbacks on entry and leaving of the container
  $(this.container).hover(
			  this.HoverEnter.bind(this),
			  this.HoverLeave.bind(this)
			  ) ;
  // Set the rotation
  this.interval = setInterval(this.rotate.bind(this), this.tempo) ;
}
