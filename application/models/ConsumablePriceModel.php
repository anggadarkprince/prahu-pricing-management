<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConsumablePriceModel extends App_Model
{
	protected $table = 'ref_consumable_prices';

	/**
	 * Get base query of table.
	 *
	 * @return CI_DB_query_builder
	 */
	protected function getBaseQuery()
	{
		return parent::getBaseQuery()
			->select([
				'ref_consumables.consumable',
				'ref_consumables.type',
				'ref_container_sizes.container_size'
			])
			->join('ref_consumables', 'ref_consumables.id = ref_consumable_prices.id_consumable')
			->join('ref_container_sizes', 'ref_container_sizes.id = ref_consumable_prices.id_container_size');
	}
}
