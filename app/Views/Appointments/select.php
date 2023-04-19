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


//Check whether there are any scheduled appointments and add to $alreadyBooked array so we can disable time slots that are already taken
if (!empty($scheduledAppointments)) {

  foreach ($scheduledAppointments as $scheduledAppointment) {

    if ($scheduledAppointment->activation_hash === hash_hmac('sha256', $token, $_ENV['HASH_SECRET_KEY'])) {
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
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="<?= site_url('css/select.css') ?>">

  <title>
    Appointment Selector
  </title>

</head>

<body>

  <div class="container">
    <div class="month">
      <span><?= strtoupper(date('F', time() + 24 * 3600)) ?> <span class="year"><?= date('Y', time() + 24 * 3600) ?></span></span>
    </div>
    <div class="week">
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
      <div class="date">
        <?= date('D', time() + 7 * 24 * 3600) ?>
        <br>
        <b><?= date('j', time() + 7 * 24 * 3600) ?></b>
      </div>
    </div>

    <div class="right">
      <?php
      for ($i = 0; $i < 16; $i++) {

        //Increment time by 30 minutes
        $time->add($addInterval);

        for ($j = 0; $j < 7; $j++) {

          //Get full datetime string
          $dateString = date('Y-m-d', time() + ($j + 1) * 24 * 3600) . " " . $time->format('H:i:s');

          //Open the form and add hidden input with appropriate value
          echo form_open(site_url('/appointments/chooseTime/' . $token)) . $inputOpen . $dateString . '">';

          //Check to see if this time block is on a Sunday or has already been booked by another user
          if ((date('l', time() + ($j + 1) * 24 * 3600) == 'Sunday')  || (in_array($dateString, $alreadyBookedArray))) {

            //Open the div to get correct layout positon and open inactive button
            echo '<div class="cellDashed"><button disabled class="inactive"></button></div></form>';
          } else {

            //Otherwise it's available
            echo '<div class="cellDashed"><button class="styled">' . $time->format('G:i') .  '</button></div></form>';
          }
        }
      }
      ?>
    </div>
  </div>
</body>

</html>