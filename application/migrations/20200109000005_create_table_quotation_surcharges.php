<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_quotation_surcharges
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_quotation_surcharges extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
			'id_quotation' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'surcharge' => ['type' => 'VARCHAR', 'constraint' => '100'],
			'price' => ['type' => 'DECIMAL', 'constraint' => '20,2', 'null' => TRUE],
            'description' => ['type' => 'TEXT', 'null' => TRUE],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
        ])
			->add_field('CONSTRAINT fk_quotation_surcharge_quotation FOREIGN KEY (id_quotation) REFERENCES quotations(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('quotation_surcharges');
        echo 'Migrating Migration_Create_table_quotation_surcharges' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('quotation_surcharges',TRUE);
        echo 'Rollback Migration_Create_table_quotation_surcharges' . PHP_EOL;
    }
}
