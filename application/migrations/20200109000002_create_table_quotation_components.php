<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_quotation_components
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_quotation_components extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
			'id_quotation' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'component' => ['type' => 'VARCHAR', 'constraint' => '100'],
			'type' => ['type' => 'VARCHAR', 'constraint' => '50'],
			'vendor' => ['type' => 'VARCHAR', 'constraint' => '100'],
			'term_payment' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 4, 'default' => 100],
			'duration_charge_percent' => ['type' => 'DECIMAL', 'unsigned' => TRUE, 'constraint' => '6,2', 'default' => 0],
			'description' => ['type' => 'TEXT', 'null' => TRUE],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
        ])
			->add_field('CONSTRAINT fk_quotation_component_quotation FOREIGN KEY (id_quotation) REFERENCES quotations(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('quotation_components');
        echo 'Migrating Migration_Create_table_quotation_components' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('quotation_components',TRUE);
        echo 'Rollback Migration_Create_table_quotation_components' . PHP_EOL;
    }
}
