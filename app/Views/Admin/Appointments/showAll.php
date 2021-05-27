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
$buttonClassDisabled = ' button-disabled" disabled>';
$buttonClose = ' </button>';

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no"/>

<link rel="stylesheet" href="<?= site_url('css/select.css') ?>">

    <title>
      Appointment View
    </title>

</head>

<body>

      <div class="banner">
        <p>This Week's Appointments</p>
      </div>

<!-- This is where the grid of select buttons goes -->

    <div id="main">

      <?php

      //First, get the month to display in top-left corner
  		echo $divOpen . 1 . $column . 1 . $idMonth . date('M', time() + 24 * 3600) . $divClose;

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

          //Check if this time block has an appointment booked
          if( in_array($dateString, $appointmentTimes) ) {
            //If yes, open the form to send to the Appointment/details controller
            echo form_open("Admin/Appointments/getDetails/{$dateString}");

            //Add the appropriate button and close the form
            echo "<div class='demo-item row{$i} column{$j}'><button class='row{$i} column{$j} button-booked'>Booked</button></div></form>";
          }

          //Otherwise it's available
          else {
            //echo 'Select';

            //Open the div to get correct layout positon and open button
            echo form_open("Admin/Appointments/new/{$dateString}") .
            "<div class='demo-item row{$i} column{$j}'><button class='row{$i} column{$j} button-open'>Open</button></div></form>";
          }

  			}

      }

  		?>

    </div>

<script src="<?= base_url('js/select.js') ?>"></script>

</body>
</html>
