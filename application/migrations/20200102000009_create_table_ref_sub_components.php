<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_ref_sub_components
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_ref_sub_components extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'id_component' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11],
            'sub_component' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'description' => ['type' => 'TEXT', 'null' => TRUE],
            'is_deleted' => ['type' => 'INT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
            'updated_at' => ['type' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 'null' => TRUE],
            'updated_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
            'deleted_at' => ['type' => 'TIMESTAMP', 'null' => TRUE],
            'deleted_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE]
        ])
            ->add_field('CONSTRAINT fk_service_component_component FOREIGN KEY (id_component) REFERENCES ref_components(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ref_sub_components');
        echo 'Migrating Migration_Create_table_ref_sub_components' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('ref_sub_components',TRUE);
        echo 'Rollback Migration_Create_table_ref_sub_components' . PHP_EOL;
    }
}
