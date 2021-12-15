<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Report</title>
    <style>
        #confirmInfo {
            width: 100%;
            height: auto;
            background-color: red;
            color: white;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        table {
            width: 100%;
            margin: 10px;
            margin-bottom: 20px;
            table-layout: fixed;

        }

        table,
        th,
        td {
            border: #444444 1px solid;
            border-collapse: collapse;
        }

        th,
        td {
            /* width: 150px; */
            text-align: center;
        }

        caption {
            background-color: blue;
            color: #eeeeee;
        }

        thead {
            background-color: yellow;
            color: #666666;
        }

        tbody tr:nth-child(even) {
            background-color: #bbbbbb;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div id="confirmInfo">
        <p>EVERYTHING LOOK OK?/</p>
        <p>TẤT CẢ CÁC THÔNG TIN NÀY CÓ ĐÚNG KO?</p>
    </div>
    <div id="bikes">
        <table>
            <caption>Bike Status Changes/Xe Chuyển Qua Nơi Mới</caption>
            <thead>
                <tr>
                    <th>Bike/Xe</th>
                    <th>New Status/Nơi Mới</th>
                    <th>Time/Giờ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($statusChanges as $statusChange) : ?>
                    <tr>
                        <td><?= $statusChange->plate_number ?></td>
                        <td><?= $statusChange->new_status ?></td>
                        <td><?= date('H:i:s', strtotime($statusChange->date_time)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="payments">
        <table>
            <caption>Rental Payments/Giao Dịch Trả Tiền Thuê</caption>
            <thead>
                <tr>
                    <th>Customer/Khách</th>
                    <th>Amount/Khoản Tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment) : ?>
                    <tr>
                        <td><?= $payment->customer_name ?></td>
                        <td><?= $payment->amount ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="newCustomers">
        <table>
            <caption>New Customers/Khách Mới</caption>
            <thead>
                <tr>
                    <th>Customer/Khách</th>
                    <th>Bike/Xe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($newCustomers as $newCustomer) : ?>
                    <tr>
                        <td><?= $newCustomer->customer_name ?></td>
                        <td><?= $newCustomer->current_bike ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="departingCustomers">
        <table>
            <caption>Departing Customers/Khách Trả Lại Xe</caption>
            <thead>
                <tr>
                    <th>Customer/Khách</th>
                    <th>Bike/Xe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departingCustomers as $departingCustomer) : ?>
                    <tr>
                        <td><?= $departingCustomer->customer_name ?></td>
                        <td><?= $departingCustomer->current_bike ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>