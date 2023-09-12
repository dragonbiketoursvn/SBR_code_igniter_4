<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Current Customers</title>
    <style>
        table {
            border: 2px solid black;
            border-collapse: collapse;
            margin-bottom: 4%;
            width: 90%;
        }

        tr:nth-child(2n + 1) {
            background-color: #eee;
        }

        td,
        th {
            border: 1px solid black;
            padding: 0.2em;
        }

        body {
            position: relative;
        }

        .hidden {
            display: none;
        }

        .filterOptions {
            position: absolute;
            top: 20%;
            left: 10%;
            margin: auto;
            height: 200px;
            width: 400px;
            background: yellow;
        }

        input[name="min"] {
            top: 5%;
            position: absolute;
        }

        input[name="max"] {
            top: 20%;
            position: absolute;
        }

        .apply {
            left: 2em;
            bottom: 10%;
            position: absolute;
        }

        .cancel {
            left: 10em;
            bottom: 10%;
            position: absolute;
        }

        .removeFilters {
            position: fixed;
            width: 50%;
            height: 5%;
            margin: auto;
            bottom: 2%;
        }

        .remove {
            width: 90%;
            height: 3em;
            background-color: red;
            color: #eeeeee;
        }

        .backToMain {
            width: 90%;
            height: 5em;
            background-color: green;
            color: #eeeeee;
            font-size: 2em;
        }
    </style>
</head>

<body>
    <div class="filterOptions hidden">
        <label for="min">Low</label>
        <input type="text" name="min" id="min">
        <label for="max">High</label>
        <input type="text" name="max" id="max">
        <input type="hidden" id="hiddenInput">
        <button class="apply">Apply Filter</button>
        <button class="cancel">Cancel</button>
    </div>

    <div class="removeFilters hidden">
        <button class="remove">Remove Filters</button>
    </div>

    <table id="displayTable">
        <tr id="filterRow">
            <th data-column="column1">Name</th>
            <th data-column="column2">Nationality</th>
            <th data-column="column3">Rent</th>
            <th data-column="column4" class="date">Start Date</th>
            <th data-column="column5" class="date">Finish Date</th>
            <th data-column="column6" class="date">Paid Up to</th>
            <th data-column="column7" class="date">Last Payment</th>
            <th data-column="column8">Profile</th>
        </tr>

        <?php foreach ($customers as $customer) : ?>
            <tr <?php if ($customer->finish_date > '2000-01-01') {
                    echo 'class="hidden"';
                } ?>>
                <td class="column1"><?= $customer->customer_name; ?></td>
                <td class="column2"><?= $customer->nationality; ?></td>
                <td class="column3"><?= $customer->rent; ?></td>
                <td class="column4"><?= $customer->start_date; ?></td>
                <td class="column5"><?= $customer->finish_date; ?></td>
                <td class="column6"><?= $customer->paid_up_to; ?></td>
                <td class="column7"><?= $customer->last_payment ?? '0000-00-00'; ?></td>
                <td>
                    <?= form_open(site_url('Admin/Customers/viewInfo')); ?>
                    <input type="hidden" name="customer_name" value="<?= $customer->customer_name; ?>">
                    <input type="hidden" name="id" value="<?= $customer->id; ?>">
                    <button>Profile</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>


    </table>

    <a href="<?= site_url('Admin/Home') ?>"><button class="backToMain">Main Menu</button></a>

    <script>
        const displayTable = document.querySelector('#displayTable');
        const tableRows = displayTable.getElementsByTagName('tr');
        const filterRow = document.querySelector('#filterRow');
        const filters = filterRow.getElementsByTagName('select');
        const filterOptions = document.querySelector('.filterOptions');
        const applyFilter = document.querySelector('.apply');
        const cancel = document.querySelector('.cancel');
        const inputMin = document.querySelector('input[name="min"]');
        const inputMax = document.querySelector('input[name="max"]');
        const inputColumn = document.querySelector('#hiddenInput');
        const removeFilters = document.querySelector('.removeFilters');



        filterRow.addEventListener('click', function(event) {

            // Change our input types to 'date' if the column contains a date value
            if (event.target.classList.contains('date')) {
                inputMin.type = 'date';
                inputMax.type = 'date';
            }

            // Set the inputColumn value if filterOptions is currently hidden
            if (filterOptions.classList.contains('hidden')) {
                inputColumn.value = event.target.dataset.column;
            }

            // Show our filter inputs if they're hidden or hide them if they're visible
            filterOptions.classList.remove("hidden");
        });


        // Set click event listener on Apply Filter button
        applyFilter.addEventListener('click', function(event) {

            // Get the min and max values selected plus the column, setting default text and date values
            if (inputMin.type == 'text') {
                inputMin.value = (inputMin.value == '') ? 'a' : inputMin.value;
                inputMax.value = (inputMax.value == '') ? 'z' : inputMax.value;
            } else if (inputMin.type == 'date') {
                inputMin.value = (inputMin.value == '') ? '0001-01-01' : inputMin.value;
                inputMax.value = (inputMax.value == '') ? new Date().toISOString().substr(0, 10) : inputMax.value;
            }

            const minValue = inputMin.value;
            const maxValue = inputMax.value;
            const column = inputColumn.value;

            // Iterate over the rows below the header 
            for (i = 1; i < tableRows.length; i++) {
                // Set a variable to check for a match and initalize to zero
                let match = 0;

                // Get cells in row as an HTML collection so we can iterate over them
                const cells = tableRows[i].getElementsByTagName('td');

                // IT WOULD BE FASTER TO JUST CHECK THE CELL IN THE CORRECT COLUMN -MAYBE REDO THIS LATER??
                // Iterate over the cells in each row
                for (j = 0; j < cells.length; j++) {

                    // If we get a matching value in the correct column then set match = 1
                    if ((cells[j].textContent.toUpperCase() >= minValue.toUpperCase()) && (cells[j].textContent.toUpperCase() <= maxValue.toUpperCase()) && cells[j].className == column) {
                        match = 1;
                    }
                }

                // If we didn't get a match we hide this row and check the next
                if (match != 1) {
                    tableRows[i].classList.add('hidden');
                } else if (match == 1) {
                    tableRows[i].classList.remove('hidden');
                }

                // We only want to show inactive renters if user filters by finish_date AND selects a value later than the founding
                // of the business
                if ((cells[4].textContent > '2000-01-01') && (column != 'column5')) {
                    tableRows[i].classList.add('hidden');
                } else if ((cells[4].textContent < '2000-01-01') && (column == 'column5')) {
                    tableRows[i].classList.remove('hidden');
                }
            }

            // Finally we need to make the removeFilters button visible
            removeFilters.classList.remove('hidden');
        });

        applyFilter.addEventListener('click', function(e) {

            // Hide our filter options since we're done
            filterOptions.classList.add('hidden');

            // Set input type attributes back to text
            inputMin.type = 'text';
            inputMax.type = 'text';

            // And reset input values to empty string
            inputMin.value = '';
            inputMax.value = '';
        });

        cancel.addEventListener('click', function(e) {
            // Hide our filter options
            filterOptions.classList.add('hidden');

            // Set input type attributes back to text
            inputMin.type = 'text';
            inputMax.type = 'text';
        });

        removeFilters.addEventListener('click', function(e) {
            // Iterate over the rows below the header 
            for (i = 1; i < tableRows.length; i++) {

                // Get cells in row as an HTML collection so we can iterate over them
                const cells = tableRows[i].getElementsByTagName('td');

                // We only want to re-show active renters so we check whether finish_date is nonexistent
                if (cells[4].textContent < '2000-01-01') {
                    tableRows[i].classList.remove('hidden');
                } else {
                    tableRows[i].classList.add('hidden');
                }
            }

            // And finally hide the remove filters button
            removeFilters.classList.add('hidden');
        });
    </script>
</body>

</html>