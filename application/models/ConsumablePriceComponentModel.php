<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConsumablePriceComponentModel extends App_Model
{
	protected $table = 'ref_consumable_price_components';

	/**
	 * Get base query of table.
	 *
	 * @return CI_DB_query_builder
	 */
	protected function getBaseQuery()
	{
		return parent::getBaseQuery()
			->select([
				'ref_components.component',
				'ref_components.service_section',
			])
			->join('ref_components', 'ref_components.id = ref_consumable_price_components.id_component');
	}
}
