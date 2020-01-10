<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Alter_ref_consumable_prices_add_expired_date
 * @property CI_DB_forge $dbforge
 */
class Migration_Alter_ref_consumable_prices_add_expired_date extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('ref_consumable_prices', [
			'expired_date' => ['type' => 'DATE', 'after' => 'price', 'null' => TRUE],
        ]);

        echo 'Migrate Migration_Alter_ref_consumable_prices_add_expired_date' . PHP_EOL;
    }

    public function down()
    {
        $this->dbforge->drop_column('ref_consumable_prices', 'expired_date');
        echo 'Rollback Migration_Alter_ref_consumable_prices_add_expired_date' . PHP_EOL;
    }
}
