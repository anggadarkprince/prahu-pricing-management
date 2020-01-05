<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ComponentModel extends App_Model
{
    protected $table = 'ref_components';

    /**
     * Get base query of table.
     *
     * @return CI_DB_query_builder
     */
    protected function getBaseQuery()
    {
        return parent::getBaseQuery()
            ->select([
                'COUNT(DISTINCT ref_sub_components.id) AS total_sub_component',
                'COUNT(DISTINCT ref_service_components.id) AS total_service'
            ])
            ->join('ref_sub_components', 'ref_sub_components.id_component = ref_components.id')
            ->join('ref_service_components', 'ref_service_components.id_component =  ref_components.id', 'left')
            ->group_by('ref_components.id');
    }
}
