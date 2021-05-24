<?php

//Create string variables to use generating HTML (so as to avoid a time-sucking clusterfuck)

$divOpen = '<div class="demo-item row';
$column = ' column';
$idMonth = '" id="month">';
$idDay = '" id="day">';
$idTime = '" id="time">';
$divClose = '</div>';
$inputOpen = '<input type="hidden" name="appointment_start" value="';
$buttonOpen = '"><button class="row';
$buttonClass = ' button">';
$buttonClose = ' </button>';

//Check whether there are any scheduled appointments and add to $alreadyBooked array so we can disable time slots that are already taken
if(!empty($scheduledAppointments)) {

  foreach($scheduledAppointments as $scheduledAppointment) {

      if($scheduledAppointment->activation_hash === hash_hmac('sha256', $token, $_ENV['HASH_SECRET_KEY'])) {
        $currentUsersAppointment = $scheduledAppointment;
      }

      $alreadyBooked = new \DateTime($scheduledAppointment->appointment_time);
      $addInterval = new DateInterval('PT30M');


      $alreadyBooked->sub($addInterval);
      $alreadyBookedArray[] = $alreadyBooked->format('Y-m-d H:i:s');
      $alreadyBooked->add($addInterval);
      $alreadyBookedArray[] = $alreadyBooked->format('Y-m-d H:i:s');
      $alreadyBooked->add($addInterval);
      $alreadyBookedArray[] = $alreadyBooked->format('Y-m-d H:i:s');
  }

}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no"/>

<style>

#month {
  z-index: 10;
  background-color: tomato;
  border-radius: 1px;
  font-size: 18px;
}

#day {
  z-index: 8;
  background-color: green;
  border-radius: 1px;
}

#time {
  z-index: 8;
  background-color: rebeccapurple;
  border-radius: 1px;
}

.button {
    width: 100px;
    height: 40px;
    background: tomato;
    color: #fff;
    border-radius: 15px;
    font-size: 15px;
}​

.column1 {
  left: 2px;
  z-index: 3;
}

.column2 {
  left: 104px;
  z-index: 1;
}

.column3 {
  left: 206px;
  z-index: 1;
}

.column4 {
  left: 308px;
  z-index: 1;
}

.column5 {
  left: 410px;
  z-index: 1;
}

.column6 {
  left: 512px;
  z-index: 1;
}

.column7 {
  left: 614px;
  z-index: 1;
}

.column8 {
  left: 716px;
  z-index: 1;
}

.row1 {
  top: 100px;
  z-index: 2;
}

.row2 {
  top: 142px;
}

.row3 {
  top: 184px;
}

.row4 {
  top: 226px;
}

.row5 {
  top: 268px;
}

.row6 {
  top: 310px;
}

.row7 {
  top: 352px;
}

.row8 {
  top: 394px;
}

.row9 {
  top: 436px;
}

.row10 {
  top: 478px;
}

.row11 {
  top: 520px;
}

.row12 {
  top: 562px;
}

.row13 {
  top: 604px;
}

.row14 {
  top: 646px;
}

.row15 {
  top: 688px;
}

.row16 {
  top: 730px;
}

.row17 {
  top: 772px;
}

.demo-item {
  position: fixed;
  width: 100px;
  height: 40px;
  border-radius: 15px;
  /*  background: #1f1f1f;
  padding: 20px; */
  color: #fff;
  /*
  border: 1px solid #444;
  border-left: 1px solid #444;
  border-right: 1px solid #111;
  border-bottom: 1px solid #111;
  */
  box-sizing: border-box;
  z-index: 2;
  display: flex;
  align-items: center;
  justify-content: center;
}

#main {
  width: 818px;
  height: 814px;
  background-color: yellow;
  margin: 0px;
}

body {
  margin: 0px;
  padding: 0px;
  overflow-y: scroll;
  -webkit-overflow-scrolling: touch;
}

    .scroller {
      display: flex;
      flex-wrap: nowrap;
      overflow-x: scroll;
      scroll-snap-type: x mandatory;
    }



    .scroller section {
      display: inline;
      scroll-snap-align: start;

    }

    /*
    button {z-index: 1;}

    .table th {
        background: #20e5e8;
        color: #ffffff;
        z-index: 2;
    }

    .table.sticky th {
        position: sticky;
        top: 0;
    }

    /* The code below will vertically scroll any div content exceeding 90vh*/
    /*
      div.scroll {
      margin:4px, 4px;
      padding:4px;
      height: 90vh;
      overflow-x: hidden;
      overflow-y: auto;
      text-align:justify;
    }
    */

    /*
    @media screen and (max-width: 900px) {
      .demo-item {
        height: 15%;
        width: 32%;
      }
      .column1 {
        left: 1%;
      }
    }

    @media screen and (max-width: 600px) {
      .demo-item {
        width: 120px;
        height: 80px;
      }

      .column1 {
        left: 2px;
      }

      .column2 {
        left: 124px;
      }

      .column3 {
        left: 246px;
      }

      .row1 {
        top: 160px;
        z-index: 2;
      }

      .row2 {
        top: 242px;
      }

      .row3 {
        top: 324px;
      }

    }

    p {
        top: 0%;
        height: 100%;
        line-height: 0%;
        text-align: center;
        border: 3px dashed #1c87c9;
        font-size: 30px;
      }
    */

    </style>


    <title>
      Appointment Selector
    </title>

</head>

<body>

<!-- Check if current user has already booked an appointment before displaying banner -->

    <?php if($currentUsersAppointment === null): ?>

      <div style="background-color: #11b1d1; color: #f7fafa; width: 100%; height: 100px; top: 0px;
      position: fixed; z-index: 10; display: flex; align-items: center; justify-content: center;">
        <p style="font-size: 30px;">When Can We Meet?</p>
      </div>

    <?php endif; ?>

<!-- This is where the grid of select buttons goes -->

    <div id="main">

      <?php

      //First, get the month to display in top-left corner
  		echo $divOpen . 1 . $column . 1 . $idMonth . date('M') . $divClose;

      //Then, generate rest of top row
      for($j=2; $j<9; $j++) {
  			echo $divOpen . 1 . $column . $j . $idDay . date('D', time() + ($j -1) * 24 *3600) . '<br>' . date('d', time() + ($j -1) * 24 *3600)
         . $divClose;
  		}

      //We need these objects to generate values for the left column
      $time = new \DateTime('08:30');
      $addInterval = new DateInterval('PT30M');

      //Now, generate the left-column and rows of selector buttons
      for($i=2; $i<18; $i++) {

        //Increment time by 30 minutes
        $time->add($addInterval);

        //Display current time in left-most row element
        echo $divOpen . $i . $column . 1 . $idTime . $time->format('G:i') . $divClose;

        //Display the select buttons for this time block on the date given at the top of the column
        for($j=2;$j<9;$j++){

          $dateString = date('Y-m-d', time() + ($j - 1) * 24 *3600) . " " . $time->format('H:i:s');

          //Open the form and add hidden input with appropriate value
          echo form_open(site_url('/appointments/chooseTime/' . $token)) . $inputOpen . $dateString . '">';

          //Open the div to get correct layout positon and open button
          echo $divOpen . $i . $column . $j . $buttonOpen . $i . $column . $j . $buttonClass;

          //Check to see if this time block is on a Sunday or has already been booked by another user
          if((((date('l', time() + ($j - 1) * 24 *3600) == 'Sunday'))) || (in_array($dateString, $alreadyBookedArray)) || ($currentUsersAppointment !== null)) {
            echo 'Unavailable';
          }

          //Otherwise it's available
          else {
            echo 'Select';
          }

          //Now close out the button, the div, and the form
          echo $buttonClose . $divClose . '</form>';
  			}

      }

  		?>

    </div>


<!--

<div class="demo-item column1 row2" id="time">
  9:00
</div>
<div class="demo-item column2 row2">
  Select
</div>
<div class="demo-item column3 row2">
  Select
</div>
<div class="demo-item column1 row3" id="time">
9:30
</div>
<div class="demo-item column2 row3">
Select
</div>
<form>
<div class="demo-item column3 row3">
  <button class="row3 column3 button">Select</button>
</div>
</form>

-->




<script>
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





</script>

</body>
</html>
