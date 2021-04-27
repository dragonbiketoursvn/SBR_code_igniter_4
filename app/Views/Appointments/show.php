<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Appointment Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php
  //Should these variables be in the controller?
  $time = new \DateTime('09:00');
  $date = new DateTime('2001-10-01');
  //$addInterval = new DateInterval('P10Y1M1D');
  //$date->add($addInterval);

  //dd($scheduledAppointments);

  $alreadyBookedArray = [];
  $currentUsersAppointment = null;

  //$check = !empty($scheduledAppointments);
  //dd($check);

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

  //dd($currentUsersAppointment->appointment_time);

?>

<table>
  <tr>
    <th>

    </th>
    <?php for($i = 1; $i < 8; $i++) {
      echo '<th>' . date('D, m-d', time() + $i * 24 *3600) . '</th>';
    }?>

  </tr>

  <?php
    $time = new \DateTime('08:30');
    $time2 = new \DateTime('09:00');
    $addInterval = new DateInterval('PT30M');

    for($i=0; $i < 16; $i++) {
    $time->add($addInterval);
    $time2->add($addInterval);

    echo "<tr> \r\n <td>" . $time->format('G:i') . ' - ' . $time2->format('G:i') . "</td> \r\n";

    for($j=1; $j < 8; $j++) {
      echo '<td><button';

            $dateString = date('Y-m-d', time() + $j * 24 *3600) . " " . $time->format('H:i:s');

            if($currentUsersAppointment !== null) {
              if($dateString == $currentUsersAppointment->appointment_time) {
                echo ' class="alreadyBooked" disabled';
              }
            }

            if((((date('l', time() + $j * 24 *3600) == 'Sunday'))) || (in_array($dateString, $alreadyBookedArray)) || ($currentUsersAppointment !== null)) {
              echo ' class="sunday" disabled';
            }

            if($currentUsersAppointment !== null) {
              if($dateString === $currentUsersAppointment->appointment_time) {
                echo '>BOOKED</button>
                </td>';
              } else {
                echo '>Select</button>
                </td>';
              }
            } else {
              echo '>Select</button></td>';
            }


    }

    echo "</tr>\r\n";
    }
  ?>

</table>

<?= $this->endSection() ?>
