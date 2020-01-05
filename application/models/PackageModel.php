<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PackageModel extends App_Model
{
    protected $table = 'ref_packages';
	protected $filteredFields = ['*', 'ref_components.component'];
	protected $filteredMaps = [
		'components' => 'ref_components.id'
	];

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
				'COUNT(DISTINCT ref_sub_components.id) AS total_sub_component',
				'GROUP_CONCAT(ref_sub_components.sub_component) AS sub_components',
			])
			->join('ref_components', 'ref_components.id = ref_packages.id_component', 'left')
			->join('ref_package_sub_components', 'ref_package_sub_components.id_package = ref_packages.id', 'left')
			->join('ref_sub_components', 'ref_sub_components.id = ref_package_sub_components.id_sub_component', 'left')
			->group_by('ref_packages.id');
	}
}
