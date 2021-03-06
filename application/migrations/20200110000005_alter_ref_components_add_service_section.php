<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Alter_ref_components_add_service_section
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_ref_components_add_service_section extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_column('ref_components', [
			'service_section' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE, 'after' => 'provider'],
		]);
		echo 'Migrate Migration_Alter_ref_components_add_service_section' . PHP_EOL;
	}

	public function down()
	{
		$this->dbforge->drop_column('ref_components', 'service_section');

		echo 'Rollback Migration_Alter_ref_components_add_service_section' . PHP_EOL;
	}
}
