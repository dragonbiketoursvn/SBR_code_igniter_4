<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Appointment Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>


<?php

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

<div class="container">
  <table class="table is-fullwidth">
    <caption><b><?= date('M, Y'); ?></b></caption>
    <tr>
      <th>

      </th>
      <?php for($i = 1; $i < 8; $i++) {
        echo '<th>' . date('D', time() + $i * 24 *3600) . '<br>' . date('d', time() + $i * 24 *3600) . '</th>';
      }?>

    </tr>

    <?php
      $time = new \DateTime('08:30');
      //$time2 = new \DateTime('09:00');
      $addInterval = new DateInterval('PT30M');
      $buttonAvailable = '<button style="border-radius: 10px;" class="button is-link is-fullwidth">Available</button>';
      $buttonUnavailable = '<button style="border-radius: 10px;" class="button is-link is-fullwidth" disabled>Available</button>';
      $buttonUserBooked = '<button style="border-radius: 10px;" class="button is-success is-fullwidth" disabled>Selected</button>';

      for($i=0; $i < 16; $i++) {
      $time->add($addInterval);
      //$time2->add($addInterval);

      //Open the row and add a cell to display the time slot
      echo "<tr> \r\n <td>" . $time->format('G:i') . "</td> \r\n";

      //Create 7 cells for the next 7 days
      for($j=1; $j < 8; $j++) {
        echo '<td>' . form_open(site_url('/appointments/chooseTime/' . $token))
                .  '<input type="hidden" name="appointment_start" value="' . date('Y-m-d', time() + $j * 24 *3600) . " "
                . $time->format('H:i:s') . '">';

              $dateString = date('Y-m-d', time() + $j * 24 *3600) . " " . $time->format('H:i:s');

              //Check to see if this time block was booked by the current user
              if(($currentUsersAppointment !== null) && ($dateString == $currentUsersAppointment->appointment_time)) {

                echo $buttonUserBooked;

              }

              //Check to see if this time block is on a Sunday, has already been booked by another user, or the current user has already booked another block
              elseif((((date('l', time() + $j * 24 *3600) == 'Sunday'))) || (in_array($dateString, $alreadyBookedArray)) || ($currentUsersAppointment !== null)) {
                echo $buttonUnavailable;
              }

              //If it doesn't match any of the above conditions then I guess it must be available right???
              else {
                echo $buttonAvailable;
              }

              //Remember to close out the cell and form!
              echo '</td></form>';
      }

      echo "</tr>\r\n";
      }
    ?>

  </table>

  <?php


    if($currentUsersAppointment !== null) {
      echo form_open(site_url('/appointments/chooseTime/' . $token)) .


      '<input type="hidden" name="appointment_start" value=""><button>Cancel and Reschedule Current Appointment</button></form>';
    }
  ?>
</div>



<?= $this->endSection() ?>
