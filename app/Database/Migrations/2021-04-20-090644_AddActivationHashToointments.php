<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActivationHashToAppointments extends Migration
{
	public function up()
	{
		$this->forge->addColumn('appointments', [
			'activation_hash' => [
				'type' => 'VARCHAR',
				'constraint' => 64,
				'unique' => true
			]
		]);
	}

	public function down()
	{
		$this->forge->dropColumn('appointments', 'activation_hash');
	}
}
