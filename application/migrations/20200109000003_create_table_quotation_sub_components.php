<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_quotation_sub_components
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_quotation_sub_components extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
			'id_quotation_component' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'sub_component' => ['type' => 'VARCHAR', 'constraint' => '100'],
			'price' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'null' => TRUE],
			'description' => ['type' => 'TEXT', 'null' => TRUE],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
        ])
			->add_field('CONSTRAINT fk_quotation_sub_component_component FOREIGN KEY (id_quotation_component) REFERENCES quotation_components(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('quotation_sub_components');
        echo 'Migrating Migration_Create_table_quotation_sub_components' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('quotation_sub_components',TRUE);
        echo 'Rollback Migration_Create_table_quotation_sub_components' . PHP_EOL;
    }
}
