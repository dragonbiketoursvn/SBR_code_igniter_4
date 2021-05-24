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

<link rel="stylesheet" href="<?= site_url('css/select.css') ?>">

    <title>
      Appointment Selector
    </title>

</head>

<body>

<!-- Check if current user has already booked an appointment before displaying banner -->

    <?php if($currentUsersAppointment === null): ?>

      <div class="banner">
        <p>When Can We Meet?</p>
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


          //Check to see if this time block is on a Sunday or has already been booked by another user
          if((((date('l', time() + ($j - 1) * 24 *3600) == 'Sunday'))) || (in_array($dateString, $alreadyBookedArray)) || ($currentUsersAppointment !== null)) {
            //echo 'Unavailable';

            //Open the div to get correct layout positon and open disabled button
            echo $divOpen . $i . $column . $j . $buttonOpen . $i . $column . $j . $buttonClassDisabled . 'Select'

            //Now close out the button, the div, and the form
            . $buttonClose . $divClose . '</form>';
          }

          //Otherwise it's available
          else {
            //echo 'Select';

            //Open the div to get correct layout positon and open button
            echo $divOpen . $i . $column . $j . $buttonOpen . $i . $column . $j . $buttonClass . 'Select'

            //Now close out the button, the div, and the form
            . $buttonClose . $divClose . '</form>';
          }

  			}

      }

  		?>

    </div>

<script src="<?= base_url('js/select.js') ?>"></script>

</body>
</html>
