<?php

namespace App\Controllers\Admin;

class Reports extends \App\Controllers\BaseController
{
    public function getTodaysReport()
    {
        $statusChangeModel = new \App\Models\BikeStatusChangeModel;
        $paymentsModel = new \App\Models\PaymentsModel;
        $customersModel = new \App\Models\CustomersModel;

        $todaysStatusChanges = $statusChangeModel->getTodaysRecords();
        $todaysPayments = $paymentsModel->getTodaysRecords();
        $todaysNewCustomers = $customersModel->getTodaysStartRecords();
        $todaysDepartingCustomers = $customersModel->getTodaysEndRecords();

        foreach ($todaysDepartingCustomers as $customer) {
            $customer->current_bike = $statusChangeModel->getCurrentStatus($customer->id)->plate_number;
        }

        return view('Admin/Reports/getTodaysReport', [
            'statusChanges' => $todaysStatusChanges,
            'payments' => $todaysPayments,
            'newCustomers' => $todaysNewCustomers,
            'departingCustomers' => $todaysDepartingCustomers,
        ]);
    }
}
