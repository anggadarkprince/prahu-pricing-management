<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_ref_consumable_price_components
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_ref_consumable_price_components extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'id_consumable_price' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'id_component' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'description' => ['type' => 'TEXT', 'null' => TRUE],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
        ])
            ->add_field('CONSTRAINT fk_consumable_price_component_consumable_price FOREIGN KEY (id_consumable_price) REFERENCES ref_consumable_prices(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_consumable_price_component_component FOREIGN KEY (id_component) REFERENCES ref_components(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ref_consumable_price_components');
        echo 'Migrating Migration_Create_table_ref_consumable_price_components' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('ref_consumable_price_components',TRUE);
        echo 'Rollback Migration_Create_table_ref_consumable_price_components' . PHP_EOL;
    }
}
