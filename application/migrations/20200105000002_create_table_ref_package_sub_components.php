<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_ref_package_sub_components
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_ref_package_sub_components extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'id_package' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11],
            'id_sub_component' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
        ])
            ->add_field('CONSTRAINT fk_package_sub_component_package FOREIGN KEY (id_package) REFERENCES ref_packages(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_package_sub_component_component FOREIGN KEY (id_sub_component) REFERENCES ref_sub_components(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ref_package_sub_components');
        echo 'Migrating Migration_Create_table_ref_package_sub_components' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('ref_package_sub_components',TRUE);
        echo 'Rollback Migration_Create_table_ref_package_sub_components' . PHP_EOL;
    }
}
