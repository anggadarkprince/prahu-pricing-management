<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Alter_ref_component_prices_change_column_port
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_ref_component_prices_change_column_port extends CI_Migration
{
	public function up()
	{
		$this->dbforge->modify_column('ref_component_prices', [
			'id_port' => ['name' => 'id_port_origin', 'type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
			'id_location' => ['name' => 'id_location_origin', 'type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
		]);

		$this->dbforge->add_column('ref_component_prices', [
			'id_location_destination' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE, 'after' => 'id_location_origin'],
		]);
		echo 'Migrate Migration_Alter_ref_component_prices_change_column_port' . PHP_EOL;
	}

	public function down()
	{
		$this->dbforge->drop_column('ref_component_prices', 'id_location_destination');
		$this->dbforge->modify_column('ref_component_prices', [
			'id_port_origin' => ['name' => 'id_port', 'type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
			'id_location_origin' => ['name' => 'id_location', 'type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
		]);

		echo 'Rollback Migration_Alter_ref_component_prices_change_column_port' . PHP_EOL;
	}
}
