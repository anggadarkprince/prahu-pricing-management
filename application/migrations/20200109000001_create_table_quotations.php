<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_quotations
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_quotations extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'customer' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'company' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE],
            'marketing' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'service' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'location_from' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE],
            'location_to' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE],
            'port_from' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE],
            'port_to' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE],
			'loading_category' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE],
            'container_size' => ['type' => 'INT', 'constraint' => 4, 'null' => TRUE],
            'container_type' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => TRUE],
            'loading_date' => ['type' => 'DATE', 'null' => TRUE],
			'payment_type' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE],
			'payment_percent' => ['type' => 'DECIMAL', 'unsigned' => TRUE, 'constraint' => '6,2'],
			'margin_percent' => ['type' => 'DECIMAL', 'unsigned' => TRUE, 'constraint' => '6,2'],
			'goods_value' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'null' => TRUE],
			'insurance' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'null' => TRUE],
			'tax_percent' => ['type' => 'DECIMAL', 'unsigned' => TRUE, 'constraint' => '6,2'],
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
        $this->dbforge->create_table('quotations');
        echo 'Migrating Migration_Create_table_quotations' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('quotations',TRUE);
        echo 'Rollback Migration_Create_table_quotations' . PHP_EOL;
    }
}
