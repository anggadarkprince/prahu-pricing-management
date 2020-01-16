<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LocationModel extends App_Model
{
    protected $table = 'ref_locations';
    protected $filteredFields = ['*', 'ref_ports.port'];
    protected $filteredMaps = [
        'ports' => 'ref_ports.id'
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
                'ref_ports.port'
            ])
            ->join('ref_ports', 'ref_ports.id = ref_locations.id_port', 'left');
    }
}
