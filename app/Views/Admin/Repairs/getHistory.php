<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Status Change<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div id="input-and-button">
  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="plate_number">Biển Số Xe</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autofocus autocomplete="off" list="current_bikes" class="input is-success" id="plate_number" name="plate_number">
          <?php if (isset($currentBikes)) {
            echo '<datalist id="current_bikes">';
            foreach ($currentBikes as $currentBike) {
              echo  '<option value="' . $currentBike->plate_number . '">';
            }
            echo '</datalist>';
          } else {
            echo '<input type="hidden" autocomplete="off" class="input is-success" 
          id="plate_number" name="plate_number" value="' . $plateNumber['plate_number'] . '">';
          }
          ?>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal">
    <div class="field-label">
      <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
      <div class="field">
        <div class="control">
          <button class="button is-available is-large is-fullwidth sendButton">
            Xem Lịch Sự Sửa Chữa
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- This remains hidden until user enters a plate number -->
<table class="table">
  <thead>
    <tr>
      <th>Date</th>
      <th>Repaired By</th>
      <th>Odometer</th>
      <th>Total Cost</th>
      <th>Labor</th>
      <th>Nhớt</th>
      <th>Item 1</th>
      <th>Item 2</th>
      <th>Item 3</th>
      <th>Item 4</th>
      <th>Item 5</th>
      <th>Item 6</th>
      <th>Item 7</th>
      <th>Item 8</th>
      <th>Item 9</th>
      <th>Item 10</th>
    </tr>
  </thead>

  <tbody class="repairHistory">

  </tbody>
</table>


<!-- <script>
  // Create consts for the input and button. Then add an event listener to the button which will:
  // 1) POST the plate number asyncrhonously to a controller which will return the full repair history as json
  // 2) Create and append to the table body one row for each repair record
  const sendButton = document.querySelector('.sendButton');
  const plateNumber = document.querySelector('#plate_number');
  const repairHistory = document.querySelector('.repairHistory');
  const table = document.querySelector('.table');

  window.addEventListener('load', function(e) {
    table.classList.add('hidden');
  })

  sendButton.addEventListener('click', function(e) {

    table.classList.remove('hidden');

    // Remember to get rid of any existing rows in the table body!!!
    const tableBody = document.querySelector('tbody');
    tableBody.querySelectorAll('tr').forEach(function(e) {
      e.remove();
    })

    const formData = new FormData();
    formData.append('plate_number', plateNumber.value);

    fetch("<?= site_url('Admin/Repairs/showHistory') ?>", {
      method: 'POST',
      body: formData
    }).then(response => response.json().then(
        function(json) {

          let fragment = new DocumentFragment(); // to hold all the rows until they're ready to append
          for (x in json) {
            let row = document.createElement('tr'); // create a row for each numbered index of json (equal to one record)
            if (new Date(json[x]['repair_date']) < new Date('2023-01-01')) {
              let cell1 = document.createElement('td');
              cell1.setAttribute('colspan', 5);
              cell1.innerText = 'dick';
              row.append(cell1);
              let cell2 = document.createElement('td');
              cell2.innerText = 'balls';
              row.append(cell2);
              let cell3 = document.createElement('td');
              cell3.innerText = 'dick';
              row.append(cell3);
            } else {
              let cell1 = document.createElement('td');
              let cell2 = document.createElement('td');
              let cell3 = document.createElement('td');
              let cell4 = document.createElement('td');
              let cell5 = document.createElement('td');
              let cell6 = document.createElement('td');
              let cell7 = document.createElement('td');
              let cell8 = document.createElement('td');
              let cell9 = document.createElement('td');
              let cell10 = document.createElement('td');
              let cell11 = document.createElement('td');
              let cell12 = document.createElement('td');
              let cell13 = document.createElement('td');
              let cell14 = document.createElement('td');
              let cell15 = document.createElement('td');
              let cell16 = document.createElement('td');
              cell1.innerText = json[x]['repair_date'];
              row.append(cell1);
              cell2.innerText = json[x]['repaired_by'];
              row.append(cell2);
              cell3.innerText = json[x]['odometer'];
              row.append(cell3);
              cell4.innerText = json[x]['total_cost'];
              row.append(cell4);
              cell5.innerText = json[x]['labor_cost'];
              row.append(cell5);
              cell6.innerText = json[x]['nhot'];
              row.append(cell6);
              cell7.innerText = json[x]['item_1'];
              row.append(cell7);
              cell8.innerText = json[x]['item_2'];
              row.append(cell8);
              cell9.innerText = json[x]['item_3'];
              row.append(cell9);
              cell10.innerText = json[x]['item_4'];
              row.append(cell10);
              cell11.innerText = json[x]['item_5'];
              row.append(cell11);
              cell12.innerText = json[x]['item_6'];
              row.append(cell12);
              cell13.innerText = json[x]['item_7'];
              row.append(cell13);
              cell14.innerText = json[x]['item_8'];
              row.append(cell14);
              cell15.innerText = json[x]['item_9'];
              row.append(cell15);
              cell16.innerText = json[x]['item_10'];
              row.append(cell16);
            }
            fragment.append(row);
          }
          repairHistory.append(fragment);
        }
      )
      .catch(error => console.log(error)));

    fetch("<?= site_url('Admin/BikeStatusChanges/fetchByPlateNumber') ?>", {
        method: 'POST',
        body: formData
      })
      .then(response => response.json()
        .then(result => console.log(result))
        .catch(error => console.log(error)));
  });
</script> -->

<script>
  // Create consts for the input and button. Then add an event listener to the button which will:
  // 1) POST the plate number asyncrhonously to a controller which will return the full repair history as json
  // 2) Create and append to the table body one row for each repair record
  const sendButton = document.querySelector('.sendButton');
  const plateNumber = document.querySelector('#plate_number');
  const repairHistory = document.querySelector('.repairHistory');
  const table = document.querySelector('.table');

  window.addEventListener('load', function(e) {
    table.classList.add('hidden');
    // this code runs if we've accessed this view from the parked_in_garage profile button
    if (document.querySelector('input[type="hidden"]') !== null) {
      const inputAndButton = document.querySelector('#input-and-button');
      sendButton.click();
      // inputAndButton.remove();
    }
  });

  sendButton.addEventListener('click', function(e) {

    table.classList.remove('hidden');

    // Remember to get rid of any existing rows in the table body!!!
    const tableBody = document.querySelector('tbody');
    tableBody.querySelectorAll('tr').forEach(function(e) {
      e.remove();
    })
    const formData = new FormData();
    let hiddenPlateNumber = document.querySelector('input[type="hidden"]');
    let actualPlateNumber = plateNumber.value === '' ? hiddenPlateNumber.value : plateNumber.value;

    formData.append('plate_number', actualPlateNumber);

    (async function() {

      try {
        const response = await fetch("<?= site_url('Admin/Repairs/showHistory') ?>", {
          method: 'POST',
          body: formData
        });

        const parsedJson = await response.json();

        const bikeStatusChangesJSON = await fetch("<?= site_url('Admin/BikeStatusChanges/fetchByPlateNumber') ?>", {
          method: 'POST',
          body: formData
        });

        const bikeStatusChanges = await bikeStatusChangesJSON.json();
        const combinedRecordsArray = parsedJson.concat(bikeStatusChanges);

        combinedRecordsArray.sort((a, b) => {
          return (new Date(b.repair_date ?? b.date_time) - new Date(a.repair_date ?? a.date_time));
        });

        let fragment = new DocumentFragment(); // to hold all the rows until they're ready to append

        combinedRecordsArray.forEach(record => {
          let row = document.createElement('tr'); // create a row for each numbered index of json (equal to one record)

          if ('date_time' in record) {
            let colorTheme = record.new_status === 'Saigon Bike Rentals' ? 'is-success' : 'is-danger'
            let cell1 = document.createElement('td');
            cell1.innerText = record.date_time.split(' ')[0];
            cell1.classList.add(colorTheme);
            row.append(cell1);
            let cell2 = document.createElement('td');
            cell2.setAttribute('colspan', 15)
            cell2.innerText = record.new_status;
            cell2.classList.add(colorTheme);
            row.append(cell2);
            // if (record.new_status === 'Saigon Bike Rentals') {
            //   row.classList.add('is-success');
            // } else {
            //   row.classList.add('is-danger');
            // }
          } else {
            let cell1 = document.createElement('td');
            let cell2 = document.createElement('td');
            let cell3 = document.createElement('td');
            let cell4 = document.createElement('td');
            let cell5 = document.createElement('td');
            let cell6 = document.createElement('td');
            let cell7 = document.createElement('td');
            let cell8 = document.createElement('td');
            let cell9 = document.createElement('td');
            let cell10 = document.createElement('td');
            let cell11 = document.createElement('td');
            let cell12 = document.createElement('td');
            let cell13 = document.createElement('td');
            let cell14 = document.createElement('td');
            let cell15 = document.createElement('td');
            let cell16 = document.createElement('td');
            cell1.innerText = record['repair_date'];
            row.append(cell1);
            cell2.innerText = record['repaired_by'];
            row.append(cell2);
            cell3.innerText = record['odometer'];
            row.append(cell3);
            cell4.innerText = record['total_cost'];
            row.append(cell4);
            cell5.innerText = record['labor_cost'];
            row.append(cell5);
            cell6.innerText = record['nhot'];
            row.append(cell6);
            cell7.innerText = record['item_1'];
            row.append(cell7);
            cell8.innerText = record['item_2'];
            row.append(cell8);
            cell9.innerText = record['item_3'];
            row.append(cell9);
            cell10.innerText = record['item_4'];
            row.append(cell10);
            cell11.innerText = record['item_5'];
            row.append(cell11);
            cell12.innerText = record['item_6'];
            row.append(cell12);
            cell13.innerText = record['item_7'];
            row.append(cell13);
            cell14.innerText = record['item_8'];
            row.append(cell14);
            cell15.innerText = record['item_9'];
            row.append(cell15);
            cell16.innerText = record['item_10'];
            row.append(cell16);
          }
          fragment.append(row);
        });
        repairHistory.append(fragment);
        console.log(repairHistory.childElementCount);
      } catch (error) {
        console.log(error)
      }
    })();

    // fetch("<?= site_url('Admin/BikeStatusChanges/fetchByPlateNumber') ?>", {
    //     method: 'POST',
    //     body: formData
    //   })
    //   .then(response => response.json()
    //     .then(result => console.log(result))
    //     .catch(error => console.log(error)));
  });
</script>
<?= $this->endSection() ?>