<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceComponentModel extends App_Model
{
    protected $table = 'ref_service_components';

	/**
	 * Get base query of table.
	 *
	 * @return CI_DB_query_builder
	 */
    protected function getBaseQuery()
	{
		return parent::getBaseQuery()
			->select([
				'ref_components.component'
			])
			->join('ref_components', 'ref_components.id = ref_service_components.id_component');
	}
}
