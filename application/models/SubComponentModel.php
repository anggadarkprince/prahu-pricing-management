<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubComponentModel extends App_Model
{
    protected $table = 'ref_sub_components';
    protected $filteredFields = ['*', 'ref_components.component'];
    protected $filteredMaps = [
        'components' => 'ref_components.id',
        'packages' => 'ref_packages.id',
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
                'GROUP_CONCAT(DISTINCT ref_components.component) AS components',
                'GROUP_CONCAT(DISTINCT ref_packages.package) AS packages',
            ])
            ->join('ref_component_sub_components', 'ref_component_sub_components.id_sub_component = ref_sub_components.id', 'left')
            ->join('ref_components', 'ref_components.id = ref_component_sub_components.id_component', 'left')
            ->join('ref_package_sub_components', 'ref_package_sub_components.id_sub_component = ref_sub_components.id', 'left')
            ->join('ref_packages', 'ref_packages.id = ref_package_sub_components.id_package', 'left')
            ->group_by('ref_sub_components.id');
    }
}
