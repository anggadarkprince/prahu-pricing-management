<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Create_table_settings
 * @property CI_DB_forge $dbforge
 */
class Migration_Create_table_settings extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'key' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'value' => ['type' => 'TEXT'],
            'description' => ['type' => 'VARCHAR', 'constraint' => '500', 'null' => TRUE],
            'updated_at' => ['type' => 'TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 'null' => TRUE],
            'updated_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('settings');
        echo 'Migrate Migration_Create_table_settings' . PHP_EOL;

		$this->db->insert_batch('settings', [
			[
				'key' => 'meta_keywords',
				'value' => 'transporter,pricing,shipping,report,management',
			],
			[
				'key' => 'meta_description',
				'value' => 'Pricing Management is the process of integrating all perspectives and information necessary to consistently arrive at optimal pricing decisions',
			],
			[
				'key' => 'meta_author',
				'value' => 'Prahu-hub developer',
			],
			[
				'key' => 'email_bug_report',
				'value' => 'bug@prahu-hub.com',
			],
			[
				'key' => 'email_support',
				'value' => 'support@prahu-hub.com',
			],
			[
				'key' => 'company_name',
				'value' => 'Prahu-hub',
			],
			[
				'key' => 'company_address',
				'value' => 'Avenue street',
			],
			[
				'key' => 'company_contact',
				'value' => '0000-000',
			],
			[
				'key' => 'company_logo',
				'value' => '',
			],
			[
				'key' => 'api_token',
				'value' => '',
			],
			[
				'key' => 'language',
				'value' => 'english',
			],
		]);
		echo '--Seeding Migration_Create_table_ref_settings' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_table('settings', TRUE);
        echo 'Rollback Migration_Create_table_settings' . PHP_EOL;
    }
}
