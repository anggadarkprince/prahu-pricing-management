<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_ref_consumable_prices
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_ref_consumable_prices extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'id_consumable' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'id_container_size' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'percent' => ['type' => 'DECIMAL', 'unsigned' => TRUE, 'constraint' => '6,2', 'default' => 0],
            'price' => ['type' => 'DECIMAL', 'unsigned' => TRUE, 'constraint' => '20,2', 'default' => 0],
            'description' => ['type' => 'TEXT', 'null' => TRUE],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 'null' => TRUE],
            'updated_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
        ])
            ->add_field('CONSTRAINT fk_consumable_price_consumable FOREIGN KEY (id_consumable) REFERENCES ref_consumables(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_consumable_price_price_container_size FOREIGN KEY (id_container_size) REFERENCES ref_container_sizes(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ref_consumable_prices');
        echo 'Migrating Migration_Create_table_ref_consumable_prices' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('ref_consumable_prices',TRUE);
        echo 'Rollback Migration_Create_table_ref_consumable_prices' . PHP_EOL;
    }
}
