<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointment extends Migration
{
	public function up()
	{
		$this->forge->addField(
			[
        'id'          => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
                'auto_increment' => true
        ],
				'contract_number'          => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true
        ],
        'customer_name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100'
        ],
        'current_bike'      => [
                'type'           =>'VARCHAR',
                'constraint'     => 100
        ],
        'pay_rent' => [
                'type'           => 'BOOLEAN',
                'default'        => false,
        ],
				'full_service' => [
                'type'           => 'BOOLEAN',
                'default'        => false,
        ],
				'small_service' => [
                'type'           => 'BOOLEAN',
                'default'        => false,
        ],
        'appointment_time'      => [
                'type'           => 'DATETIME',
                'default'        => null,
        ],
				'building_name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100'
        ],
				'number'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100'
        ],
				'street_name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100'
        ],
				'ward'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100'
        ],
				'district'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100'
        ],
				'appointment_completed' => [
                'type'           => 'BOOLEAN',
                'default'        => false,
        ],
			]
		);

		$this->forge->addPrimaryKey('id');
		$this->forge->addKey('contract_number');
		$this->forge->addKey('customer_name');
		$this->forge->createTable('appointments');

	}

	public function down()
	{
		$this->forge->dropTable('appointments');
	}
}
