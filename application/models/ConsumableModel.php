<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConsumableModel extends App_Model
{
    protected $table = 'ref_consumables';

    const TYPE_PACKAGING = 'PACKAGING';
    const TYPE_ACTIVITY_DURATION = 'ACTIVITY DURATION';

    protected function getBaseQuery()
	{
		return parent::getBaseQuery()
			->select([
				'MAX(ref_consumable_prices.expired_date) AS expired_date'
			])
			->join('ref_consumable_prices', 'ref_consumable_prices.id_consumable = ref_consumables.id')
			->group_by('ref_consumables.id');
	}
}
