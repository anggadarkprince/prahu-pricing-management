<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Alter_quotation_components_add_package
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_quotation_components_add_package extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_column('quotation_components', [
			'package' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE, 'after' => 'vendor'],
		]);
		echo 'Migrate Migration_Alter_quotation_components_add_package' . PHP_EOL;
	}

	public function down()
	{
		$this->dbforge->drop_column('quotation_components', 'package');

		echo 'Rollback Migration_Alter_quotation_components_add_package' . PHP_EOL;
	}
}
