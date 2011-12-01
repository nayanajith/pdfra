/**
 * Geometry.js: portable functions for querying window and document geometry
 * 
 * This module defines functions for querying window and document geometry.
 * 
 * getWindowX/Y( ): return the position of the window on the screen
 * getViewportWidth/Height( ): return the size of the browser viewport area
 * getDocumentWidth/Height( ): return the size of the document
 * getHorizontalScroll( ): return the position of the horizontal scrollbar
 * getVerticalScroll( ): return the position of the vertical scrollbar
 * 
 * Note that there is no portable way to query the overall size of the browser
 * window, so there are no getWindowWidth/Height( ) functions.
 * 
 * IMPORTANT: This module must be included in the <documentElement> of a document instead
 * of the <head> of the document.
 */
var Geometry = {};


if (window.screenLeft) { // IE and others
   Geometry.getWindowX = function() {
      return window.screenLeft;
   };
   Geometry.getWindowY = function() {
      return window.screenTop;
   };
} else if (window.screenX) { // Firefox and others
   Geometry.getWindowX = function() {
      return window.screenX;
   };
   Geometry.getWindowY = function() {
      return window.screenY;
   };
}

if (window.innerWidth) { // All browsers but IE
   Geometry.getViewportWidth = function() {
      return window.innerWidth;
   };
   Geometry.getViewportHeight = function() {
      return window.innerHeight;
   };
   Geometry.getHorizontalScroll = function() {
      return window.pageXOffset;
   };
   Geometry.getVerticalScroll = function() {
      return window.pageYOffset;
   };
} else if (document.documentElement && document.documentElement.clientWidth) {
   // These functions are for IE 6 when there is a DOCTYPE
   Geometry.getViewportWidth = function() {
      return document.documentElement.clientWidth;
   };
   Geometry.getViewportHeight = function() {
      return document.documentElement.clientHeight;
   };
   Geometry.getHorizontalScroll = function() {
      return document.documentElement.scrollLeft;
   };
   Geometry.getVerticalScroll = function() {
      return document.documentElement.scrollTop;
   };
} else if (document.documentElement.clientWidth) {
   // These are for IE4, IE5, and IE6 without a DOCTYPE
   Geometry.getViewportWidth = function() {
      return document.documentElement.clientWidth;
   };
   Geometry.getViewportHeight = function() {
      return document.documentElement.clientHeight;
   };
   Geometry.getHorizontalScroll = function() {
      return document.documentElement.scrollLeft;
   };
   Geometry.getVerticalScroll = function() {
      return document.documentElement.scrollTop;
   };
}

// These functions return the size of the document. They are not window
// related, but they are useful to have here anyway.
if (document.documentElement && document.documentElemnet.scrollWidth) {
   Geometry.getDocumentWidth = function() {
      return document.documentElement.scrollWidth;
   };
   Geometry.getDocumentHeight = function() {
      return document.documentElement.scrollHeight;
   };
} else if (document.documentElement.scrollWidth) {
   Geometry.getDocumentWidth = function() {
      return document.documentElement.scrollWidth;
   };
   Geometry.getDocumentHeight = function() {
      return document.documentElement.scrollHeight;
   };
}

/**
 * Tooltip.js: simple CSS tool tips with drop shadows.
 * 
 * This module defines a Tooltip class. Create a Tooltip object with the
 * Tooltip() constructor. Then make it visible with the show() method. When
 * done, hide it with the hide() method.
 * 
 * Note that this module must be used with appropriate CSS class definitions to
 * display correctly. The following are examples:
 * 
 * .tooltipShadow { background: url(shadow.png); /* translucent shadow * / }
 * 
 * .tooltipContent { left: -4px; top: -4px; /* how much of the shadow shows * /
 * background-color: #ff0; /* yellow background * / border: solid black 1px; /*
 * thin black border * / padding: 5px; /* spacing between text and border * /
 * font: bold 10pt sans-serif; /* small bold font * / }
 * 
 * In browsers that support translucent PNG images, it is possible to display
 * translucent drop shadows. Other browsers must use a solid color or simulate
 * transparency with a dithered GIF image that alternates solid and transparent
 * pixels.
 */
function Tooltip() { // The constructor function for the Tooltip class
   this.tooltip = document.createElement("div"); // create div for shadow
   this.tooltip.style.position = "absolute"; // absolutely positioned
   this.tooltip.style.visibility = "hidden"; // starts off hidden
   this.tooltip.className = "tooltipShadow"; // so we can style it

   this.content = document.createElement("div"); // create div for content
   this.content.style.position = "relative"; // relatively positioned
   this.content.className = "tooltipContent"; // so we can style it

   this.tooltip.appendChild(this.content); // add content to shadow
}

// Set the content and position of the tool tip and display it
Tooltip.prototype.show = function(text, x, y) {
   this.content.innerHTML = text; // Set the text of the tool tip.
   this.tooltip.style.left = x + "px"; // Set the position.
   this.tooltip.style.top = y + "px";
   this.tooltip.style.visibility = "visible"; // Make it visible.

   // Add the tool tip to the document if it has not been added before
   if (this.tooltip.parentNode != document.documentElement)
      document.documentElement.appendChild(this.tooltip);
};

// Hide the tool tip
Tooltip.prototype.hide = function() {
   this.tooltip.style.visibility = "hidden"; // Make it invisible.
};
/**
 * linkdetails.js
 * 
 * This unobtrusive JavaScript module adds event handlers to links in a document
 * so that they display tool tips when the mouse hovers over them for half a
 * second. If the link points to a document on the same server as the source
 * document, the tool tip includes type, size, and date information obtained
 * with an XMLHttpRequest HEAD request.
 * 
 * This module requires the Tooltip.js, HTTP.js, and Geometry.js modules
 */
(function() { // Anonymous function to hold all our symbols
   // Create the tool tip object we'll use
   var tooltip = new Tooltip();

   // Arrange to have the init() function called on document load
   if (window.addEventListener)
      window.addEventListener("load", init, false);
   else if (window.attachEvent)
      window.attachEvent("onload", init);

   // To be called when the document loads
   function init() {
      var links = document.getElementsByTagName('a');
      // Loop through all the links, adding event handlers to them
      for ( var i = 0; i < links.length; i++)
         if (links[i].href)
            addTooltipToLink(links[i]);
   }

   // This is the function that adds event handlers
   function addTooltipToLink(link) {
      // Add event handlers
      if (link.addEventListener) { // Standard technique
         link.addEventListener("mouseover", mouseover, false);
         link.addEventListener("mouseout", mouseout, false);
      } else if (link.attachEvent) { // IE-specific technique
         link.attachEvent("onmouseover", mouseover);
         link.attachEvent("onmouseout", mouseout);
      }

      var timer; // Used with setTimeout/clearTimeout

      function mouseover(event) {
         var e = event || window.event;
         // Get mouse position, convert to document coordinates, add offset
         var x = e.clientX + Geometry.getHorizontalScroll() + 25;
         var y = e.clientY + Geometry.getVerticalScroll() + 15;

         // If a tool tip is pending, cancel it
         if (timer)
            window.clearTimeout(timer);

         // Schedule a tool tip to appear in half a second
         timer = window.setTimeout(showTooltip, 500);

         function showTooltip() {
            // If it is an HTTP link, and if it is from the same host
            // as this script is, we can use XMLHttpRequest
            // to get more information about it.
            if (link.protocol == "http:" && link.host == location.host) {
               // Make an XMLHttpRequest for the headers of the link
               HTTP.getHeaders(link.href, function(headers) {
                  // Use the headers to build a string of text
                  var tip = "URL: " + link.href + "<br>" + "Type: "
                        + headers["Content-Type"] + "<br>" + "Size: "
                        + headers["Content-Length"] + "<br>" + "Date: "
                        + headers["Last-Modified"];
                  // And display it as a tool tip
                  tooltip.show(tip, x, y);
               });

            } else {
               // Otherwise, if it is an off-site link, the
               // tool tip is just the URL of the link
               tooltip.show("URL: " + link.href, x, y);
            }
         }
      }

      function mouseout(e) {
         // When the mouse leaves a link, clear any
         // pending tool tips or hide it if it is shown
         if (timer)
            window.clearTimeout(timer);
         timer = null;
         tooltip.hide();
      }
   }
})();
