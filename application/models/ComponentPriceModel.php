<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ComponentPriceModel extends App_Model
{
    protected $table = 'ref_component_prices';
    protected $filteredFields = [
        '*',
        'ref_components.component',
        'ref_vendors.vendor',
        'port_origins.port',
        'port_destinations.port',
        'ref_locations.location',
        'ref_container_sizes.container_size',
        'ref_container_types.container_type',
        'ref_sub_components.sub_component',
    ];
    protected $filteredMaps = [
        'components' => 'ref_components.id',
        'vendors' => 'ref_vendors.id',
        'port_origins' => 'port_origins.id',
        'port_destinations' => 'port_destinations.id',
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
                'port_origins.port AS port_origin',
                'port_destinations.port AS port_destination',
                'location_origins.location AS location_origin',
                'location_destinations.location AS location_destination',
                'ref_container_sizes.container_size',
                'ref_container_types.container_type',
                'ref_sub_components.sub_component',
            ])
            ->join('ref_components', 'ref_components.id = ref_component_prices.id_component')
            ->join('ref_vendors', 'ref_vendors.id = ref_component_prices.id_vendor')
			->join('ref_ports AS port_origins', 'port_origins.id = ref_component_prices.id_port_origin')
            ->join('ref_ports AS port_destinations', 'port_destinations.id = ref_component_prices.id_port_destination', 'left')
            ->join('ref_locations AS location_origins', 'location_origins.id = ref_component_prices.id_location_origin', 'left')
            ->join('ref_locations AS location_destinations', 'location_destinations.id = ref_component_prices.id_location_destination', 'left')
            ->join('ref_container_sizes', 'ref_container_sizes.id = ref_component_prices.id_container_size', 'left')
            ->join('ref_container_types', 'ref_container_types.id = ref_component_prices.id_container_type', 'left')
            ->join('ref_sub_components', 'ref_sub_components.id = ref_component_prices.id_sub_component');
    }

	/**
	 * Get component package
	 * @param $componentId
	 * @return array
	 */
    public function getComponentPriceList($componentId)
    {
        $selectList = [
            'ref_components.component',
            'ref_vendors.vendor',
            'ref_vendors.type AS vendor_type',
            'port_origins.port AS port_origin',
            'port_destinations.port AS port_destination',
            'location_origins.location AS location_origin',
            'location_destinations.location AS location_destination',
            'ref_container_sizes.container_size',
            'ref_container_types.container_type',
            'ref_component_prices.expired_date',
        ];

        // build column sub component
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
            $selectList[] = "SUM(IF(ref_component_prices.id_sub_component IN (" . if_empty(implode(',', array_column($packageSubComponents, 'id_sub_component')), '""') . "), ref_component_prices.price, 0)) AS `{$package['package']}`";
        }

        $baseQuery = $this->db->select($selectList)
            ->from("
            	(SELECT ref_component_prices.* FROM ref_component_prices
				INNER JOIN (
				    SELECT id_component, id_vendor, id_port_origin, id_port_destination, id_location_origin, id_location_destination, 
						id_container_size, id_container_type, id_sub_component, MIN(expired_date) AS expired_date
					FROM ref_component_prices
					WHERE expired_date > CURDATE()
					GROUP BY id_component, id_vendor, id_port_origin, id_port_destination, id_location_origin, id_location_destination, 
					id_container_size, id_container_type, id_sub_component
				) AS active_prices ON active_prices.id_component = ref_component_prices.id_component
					AND active_prices.id_vendor = ref_component_prices.id_vendor
					AND IFNULL(active_prices.id_port_origin, 0) = IFNULL(ref_component_prices.id_port_origin, 0)
					AND IFNULL(active_prices.id_port_destination, 0) = IFNULL(ref_component_prices.id_port_destination, 0)
					AND IFNULL(active_prices.id_location_origin, 0) = IFNULL(ref_component_prices.id_location_origin, 0)
					AND IFNULL(active_prices.id_location_destination, 0) = IFNULL(ref_component_prices.id_location_destination, 0)
					AND active_prices.id_container_size = ref_component_prices.id_container_size
					AND active_prices.id_container_type = ref_component_prices.id_container_type
					AND active_prices.id_sub_component = ref_component_prices.id_sub_component
					AND active_prices.expired_date = ref_component_prices.expired_date) AS ref_component_prices
            ")
            ->join('ref_components', 'ref_components.id = ref_component_prices.id_component')
            ->join('ref_vendors', 'ref_vendors.id = ref_component_prices.id_vendor')
			->join('ref_ports AS port_origins', 'port_origins.id = ref_component_prices.id_port_origin')
            ->join('ref_ports AS port_destinations', 'port_destinations.id = ref_component_prices.id_port_destination', 'left')
			->join('ref_locations AS location_origins', 'location_origins.id = ref_component_prices.id_location_origin', 'left')
			->join('ref_locations AS location_destinations', 'location_destinations.id = ref_component_prices.id_location_destination', 'left')
            ->join('ref_container_sizes', 'ref_container_sizes.id = ref_component_prices.id_container_size', 'left')
            ->join('ref_container_types', 'ref_container_types.id = ref_component_prices.id_container_type', 'left')
            ->join('ref_sub_components', 'ref_sub_components.id = ref_component_prices.id_sub_component')
            ->where('ref_components.id', $componentId)
            ->group_by('ref_components.id, ref_vendors.id, port_origins.id, port_destinations.id, location_origins.id, location_destinations.id, ref_container_sizes.id, ref_container_types.id, ref_component_prices.expired_date');

        return $baseQuery->get()->result_array();
    }

	/**
	 * Get component package price
	 * @param $filters
	 */
    public function getComponentPackagePrice($filters)
	{
		$baseQuery = $this->db->from('ref_component_prices')
			->select([
				'ref_component_prices.id_component',
				'ref_component_prices.id_vendor',
				'ref_component_prices.id_port',
				'ref_component_prices.id_port_destination',
				'ref_component_prices.id_location_origin',
				'ref_component_prices.id_location_destination',
				'ref_component_prices.id_container_size',
				'ref_component_prices.id_container_type',
				'ref_component_prices.id_container_type',
				'ref_package_sub_components.id_package',
				'SUM(ref_component_prices.price) AS price'
			])
			->join('ref_components', 'ref_components.id = ref_component_prices.id_component')
			->join('ref_vendors', 'ref_vendors.id = ref_component_prices.id_vendor')
			->join('ref_ports AS port_origins', 'port_origins.id = ref_component_prices.id_port_origin')
			->join('ref_ports AS port_destinations', 'port_destinations.id = ref_component_prices.id_port_destination', 'left')
			->join('ref_locations AS location_origins', 'location_origins.id = ref_component_prices.id_location_origin', 'left')
			->join('ref_locations AS location_destinations', 'location_destinations.id = ref_component_prices.id_location_destination', 'left')
			->join('ref_container_sizes', 'ref_container_sizes.id = ref_component_prices.id_container_size', 'left')
			->join('ref_container_types', 'ref_container_types.id = ref_component_prices.id_container_type', 'left')
			->join('ref_sub_components', 'ref_sub_components.id = ref_component_prices.id_sub_component')
			->join('ref_package_sub_components', 'ref_package_sub_components.id_sub_component = ref_component_prices.id_sub_component')
			->group_by('id_component, id_vendor, id_port, id_port_destination, id_location_origin, id_location_destination, id_container_size, id_container_type');

		if (key_exists('component', $filters) && !empty($filters['component'])) {
			$baseQuery->where_in('ref_component_prices.id_component', $filters['component']);
		}

		if (key_exists('vendor', $filters) && !empty($filters['vendor'])) {
			$baseQuery->where_in('ref_component_prices.id_vendor', $filters['vendor']);
		}

		if (key_exists('port_origin', $filters) && !empty($filters['port_origin'])) {
			$baseQuery->where_in('ref_component_prices.id_port_origin', $filters['port_origin']);
		}

		if (key_exists('port_destination', $filters) && !empty($filters['port_destination'])) {
			$baseQuery->where_in('ref_component_prices.id_port_destination', $filters['port_destination']);
		}

		if (key_exists('location_origin', $filters) && !empty($filters['location_origin'])) {
			$baseQuery->where_in('ref_component_prices.id_location_origin', $filters['location_origin']);
		}

		if (key_exists('location_destination', $filters) && !empty($filters['location_destination'])) {
			$baseQuery->where_in('ref_component_prices.id_location_destination', $filters['location_destination']);
		}

		if (key_exists('container_size', $filters) && !empty($filters['container_size'])) {
			$baseQuery->where_in('ref_component_prices.id_container_size', $filters['container_size']);
		}

		if (key_exists('container_type', $filters) && !empty($filters['container_type'])) {
			$baseQuery->where_in('ref_component_prices.id_container_type', $filters['container_type']);
		}

		if (key_exists('package', $filters) && !empty($filters['package'])) {
			$baseQuery->where_in('ref_package_sub_components.id_package', $filters['package']);
		}
	}
}
