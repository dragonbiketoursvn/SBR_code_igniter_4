/* @Note: not sure e.pageX will work in IE8 */
(function(window){

  /* A full compatability script from MDN: */
  var supportPageOffset = window.pageXOffset !== undefined;
  var isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");

  /* Set up some variables  */
  var row1 = document.querySelectorAll(".row1");
  var row2 = document.querySelectorAll(".row2");
  var row3 = document.querySelectorAll(".row3");
  var row4 = document.querySelectorAll(".row4");
  var row5 = document.querySelectorAll(".row5");
  var row6 = document.querySelectorAll(".row6");
  var row7 = document.querySelectorAll(".row7");
  var row8 = document.querySelectorAll(".row8");
  var row9 = document.querySelectorAll(".row9");
  var row10 = document.querySelectorAll(".row10");
  var row11 = document.querySelectorAll(".row11");
  var row12 = document.querySelectorAll(".row12");
  var row13 = document.querySelectorAll(".row13");
  var row14 = document.querySelectorAll(".row14");
  var row15 = document.querySelectorAll(".row15");
  var row16 = document.querySelectorAll(".row16");
  var row17 = document.querySelectorAll(".row17");

  var column1 = document.querySelectorAll(".column1");
  var column2 = document.querySelectorAll(".column2");
  var column3 = document.querySelectorAll(".column3");
  var column4 = document.querySelectorAll(".column4");
  var column5 = document.querySelectorAll(".column5");
  var column6 = document.querySelectorAll(".column6");
  var column7 = document.querySelectorAll(".column7");
  var column8 = document.querySelectorAll(".column8");

  /* Add an event to the window.onscroll event */
  window.addEventListener("scroll", function(e) {

    /* A full compatability script from MDN for gathering the x and y values of scroll: */
    var x = supportPageOffset ? window.pageXOffset : isCSS1Compat ? document.documentElement.scrollLeft : document.body.scrollLeft;
    var y = supportPageOffset ? window.pageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;

    row2.forEach(function(e){
     e.style.top = -y + 142 + "px";
    })

    row3.forEach(function(e){
     e.style.top = -y + 184 + "px";
    })

    row4.forEach(function(e){
     e.style.top = -y + 226 + "px";
    })

    row5.forEach(function(e){
     e.style.top = -y + 268 + "px";
    })

    row6.forEach(function(e){
     e.style.top = -y + 310 + "px";
    })

    row7.forEach(function(e){
     e.style.top = -y + 352 + "px";
    })

    row8.forEach(function(e){
     e.style.top = -y + 394 + "px";
    })

    row9.forEach(function(e){
     e.style.top = -y + 436 + "px";
    })

    row10.forEach(function(e){
     e.style.top = -y + 478 + "px";
    })

    row11.forEach(function(e){
     e.style.top = -y + 520 + "px";
    })

    row12.forEach(function(e){
     e.style.top = -y + 562 + "px";
    })

    row13.forEach(function(e){
     e.style.top = -y + 604 + "px";
    })

    row14.forEach(function(e){
     e.style.top = -y + 646 + "px";
    })

    row15.forEach(function(e){
     e.style.top = -y + 688 + "px";
    })

    row16.forEach(function(e){
     e.style.top = -y + 730 + "px";
    })

    row17.forEach(function(e){
     e.style.top = -y + 772 + "px";
    })

    column2.forEach(function(e){
     e.style.left = -x + 104 + "px";
    })

    column3.forEach(function(e){
     e.style.left = -x + 206 + "px";
    })

    column4.forEach(function(e){
     e.style.left = -x + 308 + "px";
    })

    column5.forEach(function(e){
     e.style.left = -x + 410 + "px";
    })

    column6.forEach(function(e){
     e.style.left = -x + 512 + "px";
    })

    column7.forEach(function(e){
     e.style.left = -x + 614 + "px";
    })

    column8.forEach(function(e){
     e.style.left = -x + 716 + "px";
    })

  });

})(window);
