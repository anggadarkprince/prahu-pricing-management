<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_ref_component_prices
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_ref_component_prices extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'id_component' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'id_vendor' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'id_port' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'id_port_destination' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'id_location' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'id_container_size' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'id_container_type' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'id_sub_component' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
            'price' => ['type' => 'DECIMAL', 'unsigned' => TRUE, 'constraint' => '20,2', 'default' => 0],
            'description' => ['type' => 'TEXT', 'null' => TRUE],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 'null' => TRUE],
            'updated_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
        ])
            ->add_field('CONSTRAINT fk_component_price_component FOREIGN KEY (id_component) REFERENCES ref_components(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_component_price_vendor FOREIGN KEY (id_vendor) REFERENCES ref_vendors(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_component_price_port FOREIGN KEY (id_port) REFERENCES ref_ports(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_component_price_port_destination FOREIGN KEY (id_port_destination) REFERENCES ref_ports(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_component_price_location FOREIGN KEY (id_location) REFERENCES ref_locations(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_component_price_container_size FOREIGN KEY (id_container_size) REFERENCES ref_container_sizes(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_component_price_container_type FOREIGN KEY (id_container_type) REFERENCES ref_container_types(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_component_price_sub_component FOREIGN KEY (id_sub_component) REFERENCES ref_sub_components(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ref_component_prices');
        echo 'Migrating Migration_Create_table_ref_component_prices' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('ref_component_prices',TRUE);
        echo 'Rollback Migration_Create_table_ref_component_prices' . PHP_EOL;
    }
}
