<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Alter_quotation_add_address
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_quotation_add_address extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_column('quotations', [
			'address_from' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'after' => 'location_from'],
			'address_to' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'after' => 'location_to'],
		]);
		echo 'Migrate Migration_Alter_quotation_add_address' . PHP_EOL;
	}

	public function down()
	{
		$this->dbforge->drop_column('quotations', 'address_from');
		$this->dbforge->drop_column('quotations', 'address_to');

		echo 'Rollback Migration_Alter_quotation_add_address' . PHP_EOL;
	}
}
