<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceModel extends App_Model
{
    protected $table = 'ref_services';

	/**
	 * Get base query of table.
	 *
	 * @return CI_DB_query_builder
	 */
    protected function getBaseQuery()
	{
		return parent::getBaseQuery()
			->select([
				'GROUP_CONCAT(ref_components.component) AS components'
			])
			->join('ref_service_components', 'ref_service_components.id_service =  ref_services.id', 'left')
			->join('ref_components', 'ref_components.id = ref_service_components.id_component', 'left')
			->group_by('ref_services.id');
	}
}
