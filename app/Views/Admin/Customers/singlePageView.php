<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://sbr_code_igniter_4.localhost/css/customers.css">
    <link rel="stylesheet" href="http://sbr_code_igniter_4.localhost/css/photo-box.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Hairline&family=Bungee+Outline&family=Geo&family=Montserrat+Alternates:wght@100;400;700&family=Nova+Mono&family=Poppins:wght@500&family=Quantico&display=swap" rel="stylesheet">

    <title>Single Page View</title>
</head>

<body data-user="<?= session()->get('user_id') ?>">
    <div id="initial-view">
        <div class="banner">
            Customers / Khách
        </div>
        <div class="menu-inputs">
            <button id="start-interaction" class="initial-view-buttons forward">Start Interaction</button>
            <button id="new-contract" class="initial-view-buttons forward">New Contract</button>

            <?php if (session()->get('user_level') === 'super') : ?>
                <button id="profiles" class="initial-view-buttons forward">Profiles</button>
                <button id="incidents" class="initial-view-buttons forward">Incidents</button>
                <button id="send-message" class="initial-view-buttons forward">Send Message</button>
            <?php endif; ?>

            <button id="main-menu" class="initial-view-buttons backward">Main Menu</button>
        </div>
    </div>

    <div id="interaction-view">
        <div id="interaction-view-state-1">
            <div class="banner">
                Chọn Khách
            </div>
            <div class="menu-inputs">
                <input id="interaction-view-renter-select-input" type="text" list="interaction-view-renters-list">
                <datalist id="interaction-view-renters-list"></datalist>
                <button id="interaction-view-start-process-button" class="start-meeting-button forward">Start</button>
                <button id="interaction-view-cancel-button" class="start-meeting-button backward">Go Back</button>
            </div>
        </div>
        <div id="interaction-view-state-2">
            <div class="banner">
                Khách Trả Tiền Ko?
            </div>
            <div class="menu-inputs">
                <button id="customer-is-paying-button" class="start-meeting-button forward">Có</button>
                <button id="customer-not-paying-button" class="start-meeting-button backward">Ko</button>
            </div>
        </div>
        <div id="interaction-view-state-2a">
            <div class="banner">
                Phiếu Thu Tiền
            </div>
            <form id="payment-form">
                <input id="payment-form-user-input" class="col-3" type="hidden" name="user">
                <input id="payment-form-customer-id-input" class="col-3" type="hidden" name="customer_id">
                <input id="payment-form-name-input" class="col-3" type="text" name="customer_name" readonly>
                <input id="payment-form-amount-input" class="col-3" autocomplete="off" type="number" name="amount" placeholder="Khoản Tiền (x1000 đồng)">
                <input id="payment-form-months-input" class="col-3" autocomplete="off" type="number" name="months_paid" placeholder="Trả Mấy Tháng">
                <input id="payment-form-date-input" class="col-3" required autocomplete="off" readonly type="hidden" name="payment_date" value="<?= date('Y-m-d') ?>">

                <?php if (session()->get('user_level') == 'super') : ?>

                    <!-- <label class="radio">
                        <input type="radio" name="payment_method" value="cash" checked>
                        Cash
                    </label>
                    <label class="radio">
                        <input type="radio" name="payment_method" value="bank_transfer">
                        Bank Transfer
                    </label>
                    <label class="radio">
                        <input type="radio" name="payment_method" value="paypal">
                        PayPal
                    </label> -->
                    <input class="col-3" type="text" autocomplete="off" name="payment_method" value="bank_transfer" list="payment-options-list" placeholder="Payment Method">
                    <datalist id="payment-options-list">
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash">Cash</option>
                        <option value="paypal">PayPal</option>
                    </datalist>


                <?php endif; ?>

                <input id="payment-form-notes-input" class="col-3" autocomplete="off" name="notes" placeholder="Notes">
            </form>
            <div class="button-box">
                <button id="payment-form-submit-button" form="payment-form" class="start-meeting-button forward">Nộp</button>
                <button id="payment-form-cancel-button" class="start-meeting-button backward">Hủy</button>
            </div>


        </div>
        <div id="interaction-view-state-3">
            <div class="banner">
                Khách Đổi Xe Ko?
            </div>
            <div class="menu-inputs">
                <button id="customer-is-exchanging-button" class="start-meeting-button forward">Có</button>
                <button id="customer-not-exchanging-button" class="start-meeting-button backward">Ko</button>
            </div>
        </div>
        <div id="interaction-view-state-3a">
            <div class="banner">
                Phiếu Đổi Xe
            </div>
            <div class="menu-inputs">
                <input id="exchange-form-bike-out-input" autocomplete="off" type="text" placeholder="Khách Nhận Xe Nào?" list="interaction-view-bike-list">
                <input id="exchange-form-bike-in-input" autocomplete="off" type="text" placeholder="Khách Trả Xe Nào?" list="interaction-view-bike-list">
                <datalist id="interaction-view-bike-list">
                </datalist>

                <button id="exchange-form-submit-button" class="start-meeting-button forward">Nộp</button>
                <button id="exchange-form-cancel-button" class="start-meeting-button backward">Hủy</button>
            </div>
        </div>
        <div id="interaction-view-state-3b">
            <div class="banner">
                Chọn Câu Đúng
            </div>
            <div class="menu-inputs">
                <button id="open-repair-and-return-ticket-button" class="start-meeting-button forward long-word">Khách Đưa Xe <br> Để Sữa</button>
                <button id="close-repair-and-return-ticket-button" class="start-meeting-button backward long-word">Khách Nhận Lại Xe</button>

            </div>
        </div>
        <div id="interaction-view-state-4">
            <div class="menu-inputs">
                <input autocomplete="off" type="text" id="customer-interaction-notes-input" placeholder="Ghi thêm thông tin nếu có">
                <button id="submit-customer-interaction-note-button" class="lone-button forward">Nộp Và Xuất</button>
            </div>
        </div>
    </div>

    <div id="new-contract-view">

        <form id="new-contract-form">
            <fieldset>
                <legend>Renter Info</legend>
                <input required autocomplete="off" id="contract-first-name-input" class="col-4" name="first_name" placeholder="First Name/Tên">
                <input required autocomplete="off" id="contract-surname-input" class="col-4" name="surname" placeholder="Surname/Họ">
                <input type="hidden" id="contract-customer-name-input" name="customer_name" value>
                <input required autocomplete="off" id="contract-nationality-input" class="col-4" list="contract-nationalities-list" name="nationality" placeholder="Nationality/Quốc Tịch">
                <datalist id="contract-nationalities-list"></datalist>
                <input required type="email" autocomplete="off" id="contract-email-input" class="col-4" name="email_address" placeholder="Email">
                <input required type="tel" autocomplete="off" id="contract-phone-number-input" class="col-4" name="phone_number" placeholder="Phone Number/Số ĐT">
                <input autocomplete="off" id="contract-building-name-input" class="col-4" name="building_name" placeholder="Building/Chung Cư">
                <input autocomplete="off" id="contract-building-number-input" class="col-4" name="building_number" placeholder="House Number/Số Nhà">
                <input autocomplete="off" id="contract-street-name-input" class="col-4" name="street_name" placeholder="Street/Dường">
                <input autocomplete="off" id="contract-ward-input" class="col-4" name="ward" placeholder="Ward/Phường">
                <input autocomplete="off" id="contract-district-input" class="col-4" name="district" placeholder="District/Quận">
            </fieldset>

            <fieldset>
                <legend>Bike Details</legend>
                <input type="hidden" id="contract-start-date-input" class="col-4" name="start_date" value="<?= date('Y-m-d') ?>">
                <input required autocomplete="off" list="contract-plate-numbers-list" id="contract-current-bike-input" class="col-4" name="current_bike" placeholder="Plate Number/Biển Số Xe">
                <input id="contract-model-input" class="col-4" name="model" type="hidden">
                <datalist id="contract-plate-numbers-list"></datalist>
                <input autocomplete="off" id="contract-deposit-type-input" class="col-4" name="deposit_type" placeholder="Deposit/Tiền Cọc">
                <input required type="number" autocomplete="off" id="contract-rent-input" class="col-4" name="rent" placeholder="Rent/Thuê">
                <input autocomplete="off" id="contract-notes-input" class="col-4" name="notes" placeholder="Notes/Thông Tin Thêm">
            </fieldset>

            <fieldset class="renter-docs">
                <legend>Renter Docs</legend>
                <div class="photo-box new-record" data-image="unloaded">
                    <img class="photo-image" src="">
                    <div class="delete-button"><span>Delete</span></div>
                    <div class="remove-button"><span>Remove</span></div>
                    <div class="place-holder"><i class="far fa-image"></i></div>
                    <div class="select-photo-wrapper">
                        <label class="select-photo" for="new-contract-passport-input">
                            <i class="fas fa-camera"></i>
                            <span>Passport / Hộ Chiếu</span>
                        </label>
                        <input autocomplete="off" type="file" class="photo-input" id="new-contract-passport-input" name="passport" accept="image/png, image/jpg">
                    </div>
                </div>
                <div class="photo-box new-record" data-image="unloaded">
                    <img class="photo-image" src="">
                    <div class="delete-button"><span>Delete</span></div>
                    <div class="remove-button"><span>Remove</span></div>
                    <div class="place-holder"><i class="far fa-image"></i></div>
                    <div class="select-photo-wrapper">
                        <label class="select-photo" for="new-contract-TRC-or-visa-input">
                            <i class="fas fa-camera"></i>
                            <span>TRC / Visa</span>
                        </label>
                        <input autocomplete="off" type="file" class="photo-input" id="new-contract-TRC-or-visa-input" name="TRC_or_visa" accept="image/png, image/jpg">
                    </div>
                </div>
                <div class="photo-box new-record" data-image="unloaded">
                    <img class="photo-image" src="">
                    <div class="delete-button"><span>Delete</span></div>
                    <div class="remove-button"><span>Remove</span></div>
                    <div class="place-holder"><i class="far fa-image"></i></div>
                    <div class="select-photo-wrapper">
                        <label class="select-photo" for="new-contract-license-front-input">
                            <i class="fas fa-camera"></i>
                            <span>License Front (Trước)</span>
                        </label>
                        <input autocomplete="off" type="file" class="photo-input" id="new-contract-license-front-input" name="license_front" accept="image/png, image/jpg">
                    </div>
                </div>
                <div class="photo-box new-record" data-image="unloaded">
                    <img class="photo-image" src="">
                    <div class="delete-button"><span>Delete</span></div>
                    <div class="remove-button"><span>Remove</span></div>
                    <div class="place-holder"><i class="far fa-image"></i></div>
                    <div class="select-photo-wrapper">
                        <label class="select-photo" for="new-contract-license-back-input">
                            <i class="fas fa-camera"></i>
                            <span>License Front (Sau)</span>
                        </label>
                        <input autocomplete="off" type="file" class="photo-input" id="new-contract-license-back-input" name="license_back" accept="image/png, image/jpg">
                    </div>
                </div>
            </fieldset>
        </form>
        <div class="button-box">
            <button id="contract-submit-button" form="new-contract-form" class="start-meeting-button forward">Nộp</button>
            <button id="contract-cancel-button" class="start-meeting-button backward">Hủy</button>
        </div>

    </div>

    <div id="profiles-view">
        <div id="profiles-view-desktop-state-1">
            <div class="banner">
                Choose an Option
            </div>
            <div class="menu-inputs single-row">
                <button id="profiles-view-current-renters-button" class="initial-view-buttons forward">Current Renters</button>
                <button id="profiles-view-all-renters-button" class="initial-view-buttons forward">All Renters</button>
                <button id="profiles-view-back-button" class="initial-view-buttons backward">Back</button>
            </div>
        </div>
        <div id="profiles-view-mobile-state-1">
            <input type="text" id="profiles-view-name-input">
            <button id="profiles-view-mobile-get-profile-button">Get Profile</button>
            <button id="profiles-view-mobile-back-button">Back</button>
        </div>
        <div id="profiles-view-desktop-state-2">
            <table id="profiles-view-renter-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Nationality</th>
                        <th>Rent</th>
                        <th>Plate Number</th>
                        <th>Model</th>
                        <th>Start Date</th>
                        <th>Finish Date</th>
                        <th>Paid Up To</th>
                        <th>Last Payment</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td><button class="profiles-view-filter-button backward" data-column="0" data-filter="number-range">filter</button></td>
                        <td><button class="profiles-view-filter-button backward" data-column="1" data-filter="exact-match">filter</button></td>
                        <td><button class="profiles-view-filter-button backward" data-column="2" data-filter="exact-match">filter</button></td>
                        <td><button class="profiles-view-filter-button backward" data-column="3" data-filter="number-range">filter</button></td>
                        <td><button class="profiles-view-filter-button backward" data-column="4" data-filter="exact-match">filter</button></td>
                        <td><button class="profiles-view-filter-button backward" data-column="5" data-filter="exact-match">filter</button></td>
                        <td><button class="profiles-view-filter-button backward" data-column="6" data-filter="date-range">filter</button></td>
                        <td><button class="profiles-view-filter-button backward" data-column="7" data-filter="date-range">filter</button></td>
                        <td><button class="profiles-view-filter-button backward" data-column="8" data-filter="date-range">filter</button></td>
                        <td><button class="profiles-view-filter-button backward" data-column="9" data-filter="date-range">filter</button></td>
                        <td><button id="profiles-view-remove-filters-button" disabled>remove filters</button></td>
                    </tr>
                </thead>
            </table>
            <div id="profiles-view-current-filter-window">
                <div id="profiles-view-current-filter-inputs"></div>
                <div class="filter-buttons">
                    <button id="profiles-view-current-apply-filter-button" class="forward">Apply</button>
                    <button id="profiles-view-current-cancel-filter-button" class="backward">Close</button>
                </div>
                <div class=" filter-buttons">
                    <button id="profiles-view-sort-ascending-button" class="sort">Sort <span style="color: blue;">A</span> -> <span style="color: red;">Z</span></button>
                    <button id="profiles-view-sort-descending-button" class="sort">Sort <span style="color: red;">Z</span> -> <span style="color: blue;">A</span></button>
                </div>
            </div>
            <button id="profiles-view-table-back-button" class="bottom-button">Back</button>
        </div>
        <div id="profiles-view-state-3">
            <ul id="individual-profile-navbar">
                <li id="individual-profile-renter-details">Renter Details</li>
                <li id="individual-profile-payment-history">Payment History</li>
            </ul>

            <div id="individual-profile">
                <section id="renter-details-section">
                    <form id="renter-update-form">
                        <fieldset>
                            <legend>Renter Info</legend>
                            <input type="hidden" id="renter-update-customer-id-input" name="id">
                            <input disabled required autocomplete="off" id="renter-update-customer-name-input" class="col-4" name="customer_name">
                            <input disabled required autocomplete="off" id="renter-update-nationality-input" class="col-4" list="renter-update-nationalities-list" name="nationality">
                            <datalist id="renter-update-nationalities-list"></datalist>
                            <input disabled required type="email" autocomplete="off" id="renter-update-email-input" class="col-4" name="email_address">
                            <input disabled required type="tel" autocomplete="off" id="renter-update-phone-number-input" class="col-4" name="phone_number">
                            <input disabled autocomplete="off" id="renter-update-building-name-input" class="col-4" name="building_name" placeholder="Building/Chung Cư">
                            <input disabled autocomplete="off" id="renter-update-building-number-input" class="col-4" name="building_number" placeholder="House Number/Số Nhà">
                            <input disabled autocomplete="off" id="renter-update-street-name-input" class="col-4" name="street_name" placeholder="Street/Dường">
                            <input disabled autocomplete="off" id="renter-update-ward-input" class="col-4" name="ward" placeholder="Ward/Phường">
                            <input disabled autocomplete="off" id="renter-update-district-input" class="col-4" name="district" placeholder="District/Quận">
                        </fieldset>

                        <fieldset>
                            <legend>Bike Details</legend>
                            <input disabled required autocomplete="off" id="renter-update-start-date-input" class="col-4" name="start_date">
                            <input disabled required autocomplete="off" list="renter-update-plate-numbers-list" id="renter-update-current-bike-input" class="col-4" name="current_bike" placeholder="Plate Number/Biển Số Xe">
                            <input disabled required autocomplete="off" id="renter-update-model-input" class="col-4" name="model" placeholder="Model">
                            <datalist id="renter-update-plate-numbers-list"></datalist>
                            <input disabled autocomplete="off" id="renter-update-deposit-type-input" class="col-4" name="deposit_type" placeholder="Deposit/Tiền Cọc">
                            <input disabled required type="number" autocomplete="off" id="renter-update-rent-input" class="col-4" name="rent" placeholder="Rent/Thuê">
                            <input disabled autocomplete="off" id="renter-update-notes-input" class="col-4" name="notes" placeholder="Notes/Thông Tin Thêm">
                        </fieldset>

                        <fieldset class="renter-docs">
                            <legend>Renter Docs</legend>
                            <div class="photo-box" data-image="unloaded">
                                <img id="passport-image" class="photo-image" src="">
                                <div class="delete-button"><span>Delete</span></div>
                                <div class="remove-button"><span>Remove</span></div>
                                <div class="place-holder"><i class="far fa-image"></i></div>
                                <div class="select-photo-wrapper">
                                    <label class="select-photo" for="renter-update-passport-input">
                                        <i class="fas fa-camera"></i>
                                        <span>Passport / Hộ Chiếu</span>
                                    </label>
                                    <input disabled autocomplete="off" type="file" class="photo-input" id="renter-update-passport-input" name="passport" accept="image/png, image/jpg">
                                </div>
                            </div>

                            <div class="photo-box" data-image="unloaded">
                                <img id="visa-image" class="photo-image" src="">
                                <div class="delete-button"><span>Delete</span></div>
                                <div class="remove-button"><span>Remove</span></div>
                                <div class="place-holder"><i class="far fa-image"></i></div>
                                <div class="select-photo-wrapper">
                                    <label class="select-photo" for="renter-update-TRC-or-visa-input">
                                        <i class="fas fa-camera"></i>
                                        <span>TRC / Visa</span>
                                    </label>
                                    <input disabled autocomplete="off" type="file" class="photo-input" id="renter-update-TRC-or-visa-input" name="TRC_or_visa" accept="image/png, image/jpg">
                                </div>
                            </div>

                            <div class="photo-box" data-image="unloaded">
                                <img id="license-front-image" class="photo-image" src="">
                                <div class="delete-button"><span>Delete</span></div>
                                <div class="remove-button"><span>Remove</span></div>
                                <div class="place-holder"><i class="far fa-image"></i></div>
                                <div class="select-photo-wrapper">
                                    <label class="select-photo" for="renter-update-license-front-input">
                                        <i class="fas fa-camera"></i>
                                        <span>License (Front)</span>
                                    </label>
                                    <input disabled autocomplete="off" type="file" class="photo-input" id="renter-update-license-front-input" name="license_front" accept="image/png, image/jpg">
                                </div>
                            </div>

                            <div class="photo-box" data-image="unloaded">
                                <img id="license-back-image" class="photo-image" src="">
                                <div class="delete-button"><span>Delete</span></div>
                                <div class="remove-button"><span>Remove</span></div>
                                <div class="place-holder"><i class="far fa-image"></i></div>
                                <div class="select-photo-wrapper">
                                    <label class="select-photo" for="renter-update-license-back-input">
                                        <i class="fas fa-camera"></i>
                                        <span>License (Back)</span>
                                    </label>
                                    <input disabled autocomplete="off" type="file" class="photo-input" id="renter-update-license-back-input" name="license_back" accept="image/png, image/jpg">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                    <div class="button-box">
                        <button id="renter-update-edit-button" class="start-meeting-button forward">
                            Edit
                        </button>
                        <button id="renter-update-submit-button" form="renter-update-form" class="start-meeting-button forward">
                            Update
                        </button>
                        <button id="individual-profile-back-button" class="start-meeting-button backward">
                            Back
                        </button>
                    </div>
                    <!-- <form id="renter-update-form">
                        <input type="hidden" id="renter-update-customer-id-input" name="id">
                        <input disabled id="renter-update-customer-name-input" name="customer_name">
                        <input disabled id="renter-update-start-date-input" name="start_date">
                        <input disabled required autocomplete="off" id="renter-update-nationality-input" list="renter-update-nationalities-list" name="nationality">
                        <datalist id="renter-update-nationalities-list"></datalist>
                        <input disabled required type="email" autocomplete="off" id="renter-update-email-input" name="email_address">
                        <input disabled required type="tel" autocomplete="off" id="renter-update-phone-number-input" name="phone_number">
                        <input disabled required autocomplete="off" list="renter-update-plate-numbers-list" id="renter-update-current-bike-input" name="current_bike">
                        <input disabled id="renter-update-model-input" name="model" placeholder="Model">
                        <datalist id="renter-update-plate-numbers-list"></datalist>
                        <input disabled autocomplete="off" id="renter-update-deposit-type-input" name="deposit_type" placeholder="Deposit/Tiền Cọc">
                        <input disabled required type="number" autocomplete="off" id="renter-update-rent-input" name="rent">
                        <input disabled autocomplete="off" id="renter-update-notes-input" name="notes" placeholder="Notes/Thông Tin Thêm">
                        <input disabled autocomplete="off" id="renter-update-building-name-input" name="building_name" placeholder="Building/Chung Cư">
                        <input disabled autocomplete="off" id="renter-update-building-number-input" name="building_number" placeholder="House Number/Số Nhà">
                        <input disabled autocomplete="off" id="renter-update-street-name-input" name="street_name" placeholder="Street/Dường">
                        <input disabled autocomplete="off" id="renter-update-ward-input" name="ward" placeholder="Ward/Phường">
                        <input disabled autocomplete="off" id="renter-update-district-input" name="district" placeholder="Districts/Quận">

                        <div class="photo-box" data-image="unloaded">
                            <img id="passport-image" class="photo-image" src="">
                            <div class="delete-button"><span>Delete</span></div>
                            <div class="remove-button"><span>Remove</span></div>
                            <div class="place-holder"><i class="far fa-image"></i></div>
                            <div class="select-photo-wrapper">
                                <label class="select-photo" for="renter-update-passport-input">
                                    <i class="fas fa-camera"></i>
                                    <span>Passport / Hộ Chiếu</span>
                                </label>
                                <input disabled autocomplete="off" type="file" class="photo-input" id="renter-update-passport-input" name="passport" accept="image/png, image/jpg">
                            </div>
                        </div>

                        <div class="photo-box" data-image="unloaded">
                            <img id="visa-image" class="photo-image" src="">
                            <div class="delete-button"><span>Delete</span></div>
                            <div class="remove-button"><span>Remove</span></div>
                            <div class="place-holder"><i class="far fa-image"></i></div>
                            <div class="select-photo-wrapper">
                                <label class="select-photo" for="renter-update-TRC-or-visa-input">
                                    <i class="fas fa-camera"></i>
                                    <span>TRC / Visa</span>
                                </label>
                                <input disabled autocomplete="off" type="file" class="photo-input" id="renter-update-TRC-or-visa-input" name="TRC_or_visa" accept="image/png, image/jpg">
                            </div>
                        </div>

                        <div class="photo-box" data-image="unloaded">
                            <img id="license-front-image" class="photo-image" src="">
                            <div class="delete-button"><span>Delete</span></div>
                            <div class="remove-button"><span>Remove</span></div>
                            <div class="place-holder"><i class="far fa-image"></i></div>
                            <div class="select-photo-wrapper">
                                <label class="select-photo" for="renter-update-license-front-input">
                                    <i class="fas fa-camera"></i>
                                    <span>License (Front)</span>
                                </label>
                                <input disabled autocomplete="off" type="file" class="photo-input" id="renter-update-license-front-input" name="license_front" accept="image/png, image/jpg">
                            </div>
                        </div>

                        <div class="photo-box" data-image="unloaded">
                            <img id="license-back-image" class="photo-image" src="">
                            <div class="delete-button"><span>Delete</span></div>
                            <div class="remove-button"><span>Remove</span></div>
                            <div class="place-holder"><i class="far fa-image"></i></div>
                            <div class="select-photo-wrapper">
                                <label class="select-photo" for="renter-update-license-back-input">
                                    <i class="fas fa-camera"></i>
                                    <span>License (Back)</span>
                                </label>
                                <input disabled autocomplete="off" type="file" class="photo-input" id="renter-update-license-back-input" name="license_back" accept="image/png, image/jpg">
                            </div>
                        </div>

                        <button id="renter-update-edit-button">
                            Edit
                        </button>
                        <button id="renter-update-submit-button">
                            Update
                        </button>
                    </form> -->
                </section>

                <section id="payment-history-section">
                    <table id="payment-history-customer-info">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Start Date</th>
                            <th>Paid Up To</th>
                        </tr>
                    </table>
                    <table id="payment-history-table">
                        <thead>
                            <tr>
                                <th>Recorded By</th>
                                <th>Amount</th>
                                <th>Months Paid</th>
                                <th>Date</th>
                                <th>Notes</th>
                                <th>Payment Method</th>
                                <th>Payment ID</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </section>
                <!-- <button id="individual-profile-back-button" class="bottom-button">
                    Back
                </button> -->
            </div>
        </div>
    </div>

    <div id="incident-view">
        <div id="incident-view-state-1">
            <div class="banner">
                Incidents
            </div>
            <div class="menu-inputs single-row">
                <button id="create-incident-record-button" class="initial-view-buttons forward">Create Record</button>
                <button id="view-incident-record-button" class="initial-view-buttons forward">View Records</button>
                <button id="incident-view-back-button" class="initial-view-buttons backward">Back</button>
            </div>
        </div>
        <div id="incident-view-state-2">
            <div class="banner">
                Incident Report
            </div>
            <form id="new-incident-form">
                <input class="col-3" autocomplete="off" required type="text" name="type" list="incident-form-type-list" placeholder="Incident Type">
                <datalist id="incident-form-type-list">
                    <option value="BREAKDOWN">
                    <option value="ACCIDENT">
                    <option value="THEFT BY 3RD PARTY">
                    <option value="THEFT BY RENTER">
                    <option value="POLICE INCIDENT">
                </datalist>
                <input class="col-3" autocomplete="off" required type="text" name="customer_name" placeholder="Customer Name" id="incident-form-customer-name-input" list="incident-form-renter-list">
                <datalist id="incident-form-renter-list"></datalist>
                <input class="col-3" type="hidden" name="customer_id" id="incident-form-customer-id-input">
                <input class="col-3" autocomplete="off" required type="text" name="plate_number" list="incident-form-plate-number-list" placeholder="Plate Number">
                <datalist id="incident-form-plate-number-list"></datalist>
                <input class="col-3" autocomplete="off" required type="date" name="date">
                <input class="col-3" type="num" name="cost_incurred" placeholder="Cost Incurred">
                <input class="col-3" type="text" name="resolution" placeholder="Resolution">
            </form>
            <div class="button-box">
                <button id="incident-form-submit-button" form="new-incident-form" class="start-meeting-button forward">Submit</button>
                <button id="incident-form-cancel-button" class="start-meeting-button backward">Cancel</button>
            </div>
        </div>
        <div id="incident-view-state-3">
            <table id="incident-view-record-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Incident Type</th>
                        <th>Customer Name</th>
                        <th>Plate Number</th>
                        <th>Cost Incurred</th>
                        <th>Resolution</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button class="incident-view-filter-button backward" data-column="1" data-filter="date-range">filter</button></td>
                        <td><button class="incident-view-filter-button backward" data-column="2" data-filter="exact-match">filter</button></td>
                        <td><button class="incident-view-filter-button backward" data-column="3" data-filter="exact-match">filter</button></td>
                        <td><button class="incident-view-filter-button backward" data-column="4" data-filter="exact-match">filter</button></td>
                        <td><button class="incident-view-filter-button backward" data-column="5" data-filter="number-range">filter</button></td>
                        <td><button class="incident-view-filter-button backward" data-column="6" data-filter="exact-match">filter</button></td>
                        <td><button id="incident-view-remove-filters-button" disabled>Remove Filters</button></td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <datalist id="incident-view-plate-list"></datalist>
            <div id="incident-view-current-filter-window">
                <div id="incident-view-current-filter-inputs"></div>
                <div class="filter-buttons">
                    <button id="incident-view-current-apply-filter-button" class="forward">Apply</button>
                    <button id="incident-view-current-cancel-filter-button" class="backward">Close</button>
                </div>
                <div class="filter-buttons">
                    <button id="incident-view-sort-ascending-button" class="sort">Sort <span style="color: blue;">A</span> -> <span style="color: red;">Z</span></button>
                    <button id="incident-view-sort-descending-button" class="sort">Sort <span style="color: red;">Z</span> -> <span style="color: blue;">A</span></button>
                </div>
            </div>
            <button id="incident-view-table-back-button" class="bottom-button">Back</button>
        </div>
    </div>

    <div id="message-view">
        <form id="mail-form">
            <div id="select-customer">
                <label for="names">Select Customer</label>
                <input autocomplete="off" name="names" id="names" list="name-list" placeholder="renter name">
                <datalist id="name-list">
                    <option value="ALL">
                    </option>
                </datalist>
            </div>
            <input autocomplete="off" id="message-subject" name="subject" placeholder="subject">
            <textarea name="message" id="message-body" cols="30" rows="10"></textarea>
            <!-- <input id="message-body" autocomplete="off" wrap="hard" rows="10" cols="2" name="message" placeholder="message"> -->
        </form>
        <div class="menu-inputs">
            <div id="mail-form-buttons">
                <button id="send-message-button" class="start-meeting-button forward" form="mail-form">Send</button>
                <button id="cancel-message-button" class="start-meeting-button backward">Back</button>
            </div>
        </div>
    </div>

    <!-- <script id="pristine" src="http://sbr_code_igniter_4.localhost/js/node_modules/pristinejs/dist/pristine.js"></script> -->
    <script src="http://sbr_code_igniter_4.localhost/js/Customers/singlePage.js"></script>

    <script>
        document.querySelectorAll('input[type="number"]').forEach(input => {
            if (input.name !== 'notes') {
                input.addEventListener('keyup', () => {
                    input.value = input.value.trim();
                })
            }
        });

        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => {
                const inputs = form.querySelectorAll('input');

                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].value.trim();
                }
            })
        });
    </script>
</body>

</html>