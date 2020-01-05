<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubComponentModel extends App_Model
{
    protected $table = 'ref_sub_components';
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
                'ref_components.component'
            ])
            ->join('ref_components', 'ref_components.id = ref_sub_components.id_component');
    }
}
