<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_ref_service_payemnt_types
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_ref_service_payemnt_types extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'id_service' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11],
            'id_payment_type' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11],
            'payment_percent' => ['type' => 'DECIMAL', 'unsigned' => TRUE, 'constraint' => '6,2'],
            'margin_percent' => ['type' => 'DECIMAL', 'unsigned' => TRUE, 'constraint' => '6,2'],
            'created_at' => ['type' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE],
        ])
            ->add_field('CONSTRAINT fk_service_payment_type_service FOREIGN KEY (id_service) REFERENCES ref_services(id) ON DELETE CASCADE ON UPDATE CASCADE')
            ->add_field('CONSTRAINT fk_service_payment_type_payment_type FOREIGN KEY (id_payment_type) REFERENCES ref_payment_types(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('ref_service_payment_types');
        echo 'Migrating Migration_Create_table_ref_service_payemnt_types' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('ref_service_payment_types',TRUE);
        echo 'Rollback Migration_Create_table_ref_service_payemnt_types' . PHP_EOL;
    }
}
