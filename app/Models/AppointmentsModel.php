<?php

namespace App\Models;

class AppointmentsModel extends \CodeIgniter\Model
{
    protected $table = 'appointments';

    protected $allowedFields = ['contract_number', 'customer_name', 'current_bike', 'pay_rent', 'full_service', 'small_service', 'appointment_time',
                                'building_name', 'number', 'street_name', 'ward', 'district', 'appointment_completed', 'activation_hash'];

    protected $returnType = 'App\Entities\Appointment';

    protected $useTimestamps = true;

    protected $validationRules = [];

    protected $validationMessages = [];

    public function getScheduledAppointments() {

      return $this->where('appointment_time >', date('Y-m-d H:i:s'))->findAll();

    }

}
