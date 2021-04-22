<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Appointment Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>


<?php

  $time = new \DateTime('09:00');
  $date = new DateTime('2001-10-01');
  $addInterval = new DateInterval('P10Y1M1D');
  $date->add($addInterval);

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
      echo '<td>' .
              form_open(site_url('/Appointments/create/' . $token))
              .  '<input type="hidden" name="appointment_start" value="' .
                date('Y-m-d', time() + $j * 24 *3600) . " " . $time->format('H:i')
                . '"><button';

            if(date('l', time() + $j * 24 *3600) == 'Sunday') {
              echo ' class="sunday" disabled';
            }

        echo '>Select</button>
            </form>
            </td>';
    }

    echo "</tr>\r\n";
    }
  ?>

</table>

<?= $this->endSection() ?>
