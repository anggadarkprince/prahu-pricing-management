<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Alter_ref_locations_add_id_port
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_ref_locations_add_id_port extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_column('ref_locations', [
			'id_port' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE, 'after' => 'id'],
		]);
		echo 'Migrate Migration_Alter_ref_locations_add_id_port' . PHP_EOL;
	}

	public function down()
	{
		$this->dbforge->drop_column('ref_locations', 'id_port');

		echo 'Rollback Migration_Alter_ref_locations_add_id_port' . PHP_EOL;
	}
}
