<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PackageSubComponentModel extends App_Model
{
    protected $table = 'ref_package_sub_components';

	/**
	 * Get base query of table.
	 *
	 * @return CI_DB_query_builder
	 */
    protected function getBaseQuery()
	{
		return parent::getBaseQuery()
			->select([
				'ref_packages.package',
				'ref_sub_components.sub_component',
			])
			->join('ref_packages', 'ref_packages.id = ref_package_sub_components.id_package', 'left')
			->join('ref_sub_components', 'ref_sub_components.id =  ref_package_sub_components.id_sub_component', 'left');
	}
}
