<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ComponentPriceModel extends App_Model
{
    protected $table = 'ref_component_prices';
    protected $filteredFields = [
        '*',
        'ref_components.component',
        'ref_vendors.vendor',
        'ref_ports.port',
        'ref_port_destinations.port',
        'ref_locations.location',
        'ref_container_sizes.container_size',
        'ref_container_types.container_type',
        'ref_sub_components.sub_component',
    ];
    protected $filteredMaps = [
        'components' => 'ref_components.id',
        'vendors' => 'ref_vendors.id',
        'ports' => 'ref_ports.id',
        'port_destinations' => 'ref_port_destinations.id',
        'locations' => 'ref_locations.id',
        'container_sizes' => 'ref_container_sizes.id',
        'container_types' => 'ref_container_types.id',
        'sub_components' => 'ref_sub_components.id',
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
                'ref_vendors.vendor',
                'ref_vendors.type AS vendor_type',
                'ref_ports.port',
                'port_destinations.port AS port_destination',
                'ref_locations.location',
                'ref_container_sizes.container_size',
                'ref_container_types.container_type',
                'ref_sub_components.sub_component',
            ])
            ->join('ref_components', 'ref_components.id = ref_component_prices.id_component')
            ->join('ref_vendors', 'ref_vendors.id = ref_component_prices.id_vendor')
            ->join('ref_ports', 'ref_ports.id = ref_component_prices.id_port')
            ->join('ref_ports AS port_destinations', 'port_destinations.id = ref_component_prices.id_port_destination', 'left')
            ->join('ref_locations', 'ref_locations.id = ref_component_prices.id_location', 'left')
            ->join('ref_container_sizes', 'ref_container_sizes.id = ref_component_prices.id_container_size', 'left')
            ->join('ref_container_types', 'ref_container_types.id = ref_component_prices.id_container_type', 'left')
            ->join('ref_sub_components', 'ref_sub_components.id = ref_component_prices.id_sub_component');
    }

    /**
     * Get component package
     */
    public function getComponentPriceList($componentId)
    {
        $selectList = [
            'ref_components.component',
            'ref_vendors.vendor',
            'ref_vendors.type AS vendor_type',
            'ref_ports.port',
            'port_destinations.port AS port_destination',
            'ref_locations.location',
            'ref_container_sizes.container_size',
            'ref_container_types.container_type',
        ];

        // build column subcomponent
        $subComponents = $this->subComponent->getBy([
            'ref_components.id' => $componentId,
        ]);
        foreach ($subComponents as $subComponent) {
            $selectList[] = "MAX(IF(ref_component_prices.id_sub_component = {$subComponent['id']}, ref_component_prices.price, 0)) AS `{$subComponent['sub_component']}`";
        }

        // build column package
        $packages = $this->package->getBy(['ref_packages.id_component' => $componentId]);
        foreach ($packages as $package) {
            $packageSubComponents = $this->packageSubComponent->getBy([
                'ref_package_sub_components.id_package' => $package['id']
            ]);
            $selectList[] = "SUM(IF(ref_component_prices.id_sub_component IN (" . if_empty(implode(',', array_column($packageSubComponents, 'id_sub_component')), '') . "), ref_component_prices.price, 0)) AS `{$package['package']}`";
        }

        $baseQuery = $this->db->select($selectList)
            ->from('ref_component_prices')
            ->join('ref_components', 'ref_components.id = ref_component_prices.id_component')
            ->join('ref_vendors', 'ref_vendors.id = ref_component_prices.id_vendor')
            ->join('ref_ports', 'ref_ports.id = ref_component_prices.id_port')
            ->join('ref_ports AS port_destinations', 'port_destinations.id = ref_component_prices.id_port_destination', 'left')
            ->join('ref_locations', 'ref_locations.id = ref_component_prices.id_location', 'left')
            ->join('ref_container_sizes', 'ref_container_sizes.id = ref_component_prices.id_container_size', 'left')
            ->join('ref_container_types', 'ref_container_types.id = ref_component_prices.id_container_type', 'left')
            ->join('ref_sub_components', 'ref_sub_components.id = ref_component_prices.id_sub_component')
            ->where('ref_components.id', $componentId)
            ->group_by('ref_components.id, ref_vendors.id, ref_ports.id, port_destinations.id, ref_locations.id, ref_container_sizes.id, ref_container_types.id');

        return $baseQuery->get()->result_array();
    }
}
