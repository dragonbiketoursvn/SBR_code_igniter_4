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

//We need these objects to generate values for the left column
$time = new \DateTime('08:30');
$addInterval = new DateInterval('PT30M');

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


<div class="container">
    <div class="month">
      <span><?= strtoupper(date('F', time() + 24 * 3600)) ?> <span class="year"><?= date('Y', time() + 24 * 3600) ?></span></span>
    </div>
    <div class="week">
    <div class="date">
        <?= date('D', time()) ?>
        <br>
        <b><?= date('j', time()) ?></b>
      </div>
      <div class="date">
        <?= date('D', time() + 1 * 24 * 3600) ?>
        <br>
        <b><?= date('j', time() + 1 * 24 * 3600) ?></b>
      </div>
      <div class="date">
        <?= date('D', time() + 2 * 24 * 3600) ?>
        <br>
        <b><?= date('j', time() + 2 * 24 * 3600) ?></b>
      </div>
      <div class="date">
        <?= date('D', time() + 3 * 24 * 3600) ?>
        <br>
        <b><?= date('j', time() + 3 * 24 * 3600) ?></b>
      </div>
      <div class="date">
        <?= date('D', time() + 4 * 24 * 3600) ?>
        <br>
        <b><?= date('j', time() + 4 * 24 * 3600) ?></b>
      </div>
      <div class="date">
        <?= date('D', time() + 5 * 24 * 3600) ?>
        <br>
        <b><?= date('j', time() + 5 * 24 * 3600) ?></b>
      </div>
      <div class="date">
        <?= date('D', time() + 6 * 24 * 3600) ?>
        <br>
        <b><?= date('j', time() + 6 * 24 * 3600) ?></b>
      </div>
    </div>
    
    <div class="right">
      <?php
     
        //Now, generate the buttons
        for($i=0; $i<16; $i++) {

          //Increment time by 30 minutes
          $time->add($addInterval);

          //Display the select buttons for this time block on the date given at the top of the column
          for($j=0;$j<7;$j++){

            $dateString = date('Y-m-d', time() + $j * 24 *3600) . " " . $time->format('H:i:s');

            //Check if this time block has an appointment booked
            if( (in_array($dateString, $appointmentTimes))  && ( ! in_array($dateString, $completedAppointmentTimes))  ) {
              //If yes, open the form to send to the Appointment/details controller
              //echo form_open("Admin/Appointments/getDetails/{$dateString}");
              echo "<a href='showDetails/{$dateString}'>";
              //Add the appropriate button and close the form
              //echo "<div class='demo-item row{$i} column{$j}'><button class='row{$i} column{$j} button-booked'>Booked</button></div></form>";
              echo "<div class='cellDashed'><button class='booked'>Booked</button></div></a>";
            } elseif(in_array($dateString, $completedAppointmentTimes)) {
              //If yes, open the form to send to the Appointment/details controller
              //echo form_open("Admin/Appointments/getDetails/{$dateString}");
              echo "<a href='showDetails/{$dateString}'>";
              //Add the appropriate button and close the form
              //echo "<div class='cellDashed'><button class='row{$i} column{$j} button-booked'>Booked</button></div></form>";
              echo "<div class='cellDashed'><button class='completed' disabled>Done</button></div></a>";
            }

            //Otherwise it's available
            else {
              //Maybe add form to allow admin to add apointments by clicking on button but for now just show the button
              echo "<div class='cellDashed'><button class='styled'>" . $time->format('G:i') . "</button></div>";
          }

  			}

      }

  		?>

    </div>
</div>
<script src="<?= base_url('js/select.js') ?>"></script>

</body>
</html>
