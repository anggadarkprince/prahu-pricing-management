<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_ref_locations
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_ref_locations extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_field([
			'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
			'location' => ['type' => 'VARCHAR', 'constraint' => '50'],
			'description' => ['type' => 'TEXT', 'null' => TRUE],
			'is_deleted' => ['type' => 'INT', 'constraint' => 1, 'default' => 0],
			'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
			'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
			'updated_at' => ['type' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 'null' => TRUE],
			'updated_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
			'deleted_at' => ['type' => 'TIMESTAMP', 'null' => TRUE],
			'deleted_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE]
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ref_locations');
		echo 'Migrating Migration_Create_table_ref_locations' . PHP_EOL;
	}

	public function down()
	{
		$this->dbforge->drop_table('ref_locations',TRUE);
		echo 'Rollback Migration_Create_table_ref_locations' . PHP_EOL;
	}
}
