<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class ComponentPriceModel
 * @property SubComponentModel $subComponent
 * @property PackageModel $package
 * @property PackageSubComponentModel $packageSubComponent
 */
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
        'location_origins' => 'location_origins.id',
        'location_destinations' => 'location_destinations.id',
        'container_sizes' => 'ref_container_sizes.id',
        'container_types' => 'ref_container_types.id',
        'sub_components' => 'ref_sub_components.id',
        'expired_dates' => 'ref_component_prices.expired_date',
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
            ->join('ref_vendors', 'ref_vendors.id = ref_component_prices.id_vendor', 'left')
			->join('ref_ports AS port_origins', 'port_origins.id = ref_component_prices.id_port_origin', 'left')
            ->join('ref_ports AS port_destinations', 'port_destinations.id = ref_component_prices.id_port_destination', 'left')
            ->join('ref_locations AS location_origins', 'location_origins.id = ref_component_prices.id_location_origin', 'left')
            ->join('ref_locations AS location_destinations', 'location_destinations.id = ref_component_prices.id_location_destination', 'left')
            ->join('ref_container_sizes', 'ref_container_sizes.id = ref_component_prices.id_container_size', 'left')
            ->join('ref_container_types', 'ref_container_types.id = ref_component_prices.id_container_type', 'left')
            ->join('ref_sub_components', 'ref_sub_components.id = ref_component_prices.id_sub_component', 'left');
    }

	/**
	 * Get all data model.
	 *
	 * @param array $filters
	 * @param bool $withTrashed
	 * @return mixed
	 */
	public function getAllGroup($filters = [], $withTrashed = false)
	{
		if(empty(get_if_exist($filters, 'components'))) {
			return [];
		}

		$this->load->model('SubComponentModel', 'subComponent');
		$this->load->model('PackageModel', 'package');
		$this->load->model('PackageSubComponentModel', 'packageSubComponent');

		$selectList = [
			'ref_component_prices.id_component',
			'ref_component_prices.id_vendor',
			'ref_component_prices.id_port_origin',
			'ref_component_prices.id_port_destination',
			'ref_component_prices.id_location_origin',
			'ref_component_prices.id_location_destination',
			'ref_component_prices.id_container_size',
			'ref_component_prices.id_container_type',
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
			'ref_components.id' => $filters['components'],
		]);
		foreach ($subComponents as $subComponent) {
			$selectList[] = "MAX(IF(ref_component_prices.id_sub_component = {$subComponent['id']}, ref_component_prices.price, 0)) AS `{$subComponent['sub_component']}`";
		}

		// build column package
		$packages = $this->package->getBy(['ref_packages.id_component' => $filters['components']]);
		foreach ($packages as $package) {
			$packageSubComponents = $this->packageSubComponent->getBy([
				'ref_package_sub_components.id_package' => $package['id']
			]);
			$selectList[] = "SUM(IF(ref_component_prices.id_sub_component IN (" . if_empty(implode(',', array_column($packageSubComponents, 'id_sub_component')), '""') . "), ref_component_prices.price, 0)) AS `{$package['package']}`";
		}

		$this->db->start_cache();

		$baseQuery = $this->db->select($selectList)
			->from($this->table)
			->join('ref_components', 'ref_components.id = ref_component_prices.id_component')
			->join('ref_vendors', 'ref_vendors.id = ref_component_prices.id_vendor')
			->join('ref_ports AS port_origins', 'port_origins.id = ref_component_prices.id_port_origin', 'left')
			->join('ref_ports AS port_destinations', 'port_destinations.id = ref_component_prices.id_port_destination', 'left')
			->join('ref_locations AS location_origins', 'location_origins.id = ref_component_prices.id_location_origin', 'left')
			->join('ref_locations AS location_destinations', 'location_destinations.id = ref_component_prices.id_location_destination', 'left')
			->join('ref_container_sizes', 'ref_container_sizes.id = ref_component_prices.id_container_size', 'left')
			->join('ref_container_types', 'ref_container_types.id = ref_component_prices.id_container_type', 'left')
			->join('ref_sub_components', 'ref_sub_components.id = ref_component_prices.id_sub_component', 'left')
			->where('ref_components.id', $filters['components'])
			->group_by('ref_components.id, id_port_origin, id_port_destination, id_location_origin, id_location_destination, id_container_size, id_container_type, ref_vendors.id, port_origins.id, port_destinations.id, location_origins.id, location_destinations.id, ref_container_sizes.id, ref_container_types.id, ref_component_prices.expired_date');

		if (!$withTrashed && $this->db->field_exists('is_deleted', $this->table)) {
			$baseQuery->where($this->table . '.is_deleted', false);
		}

		if (!empty($filters)) {
			if (key_exists('query', $filters) && $filters['query']) {
				return $baseQuery;
			}

			if (key_exists('search', $filters) && !empty($filters['search'])) {
				foreach ($this->filteredFields as $filteredField) {
					if ($filteredField == '*') {
						$fields = $this->db->list_fields($this->table);
						foreach ($fields as $field) {
							$baseQuery->or_having($this->table . '.' . $field . ' LIKE', '%' . trim($filters['search']) . '%');
						}
					} else {
						$baseQuery->or_having($filteredField . ' LIKE', '%' . trim($filters['search']) . '%');
					}
				}
			}

			if (key_exists('status', $filters) && !empty($filters['status'])) {
				if ($this->db->field_exists('status', $this->table)) {
					$baseQuery->where_in($this->table . '.status', explode(',', $filters['status']));
				}
			}

			if (key_exists('users', $filters) && !empty($filters['users'])) {
				if ($this->db->field_exists('id_user', $this->table)) {
					$baseQuery->where_in($this->table . '.id_user', $filters['users']);
				}
			}

			if (key_exists('employees', $filters) && !empty($filters['employees'])) {
				if ($this->db->field_exists('id_employee', $this->table)) {
					$baseQuery->where_in($this->table . '.id_employee', $filters['employees']);
				}
			}

			if (key_exists('date_from', $filters) && !empty($filters['date_from'])) {
				if ($this->db->field_exists('created_at', $this->table)) {
					$baseQuery->where($this->table . '.created_at>=', format_date($filters['date_from']));
				}
			}

			if (key_exists('date_to', $filters) && !empty($filters['date_to'])) {
				if ($this->db->field_exists('created_at', $this->table)) {
					$baseQuery->where($this->table . '.created_at<=', format_date($filters['date_to']));
				}
			}

			if (!empty($this->filteredMaps)) {
				foreach ($this->filteredMaps as $filterKey => $filterField) {
					if (key_exists($filterKey, $filters) && !empty($filters[$filterKey])) {
						$baseQuery->where_in($filterField, $filters[$filterKey]);
					}
				}
			}
		}
		$this->db->stop_cache();

		if (key_exists('per_page', $filters) && !empty($filters['per_page'])) {
			$perPage = $filters['per_page'];
		} else {
			$perPage = 25;
		}

		if (key_exists('page', $filters) && !empty($filters['page'])) {
			$currentPage = $filters['page'];

			$queryTax = $this->db->get_compiled_select();
			$totalQuery = $this->db->query("SELECT COUNT(*) AS total_record FROM ({$queryTax}) AS report");
			$totalRows = $totalQuery->row_array();
			if (!empty($totalRows)) {
				$totalData = $totalRows['total_record'];
			} else {
				$totalData = 0;
			}

			if (key_exists('sort_by', $filters) && !empty($filters['sort_by'])) {
				if (key_exists('order_method', $filters) && !empty($filters['order_method'])) {
					$baseQuery->order_by($filters['sort_by'], $filters['order_method']);
				} else {
					$baseQuery->order_by($filters['sort_by'], 'asc');
				}
			} else {
				$baseQuery->order_by('expired_date', $this->defaultSortMethod);
			}
			$pageData = $baseQuery->limit($perPage, ($currentPage - 1) * $perPage)->get()->result_array();

			$this->db->flush_cache();

			return [
				'_paging' => true,
				'total_data' => $totalData,
				'total_page_data' => count($pageData),
				'total_page' => ceil($totalData / $perPage),
				'per_page' => $perPage,
				'current_page' => $currentPage,
				'data' => $pageData
			];
		}

		if (key_exists('sort_by', $filters) && !empty($filters['sort_by'])) {
			if (key_exists('order_method', $filters) && !empty($filters['order_method'])) {
				$baseQuery->order_by($filters['sort_by'], $filters['order_method']);
			} else {
				$baseQuery->order_by($filters['sort_by'], 'asc');
			}
		} else {
			$baseQuery->order_by('expired_date', $this->defaultSortMethod);
		}

		$data = $baseQuery->get()->result_array();

		$this->db->flush_cache();

		return $data;
	}

	/**
	 * Get active price before expired.
	 *
	 * @return string
	 */
    private function getQueryActivePrice()
	{
		return "SELECT ref_component_prices.* FROM ref_component_prices
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
					AND active_prices.expired_date = ref_component_prices.expired_date";
	}

	/**
	 * Get component package
	 * @param $componentId
	 * @param array $filters
	 * @return array|int
	 */
    public function getComponentPriceList($componentId, $filters = [])
    {
		$this->load->model('SubComponentModel', 'subComponent');
		$this->load->model('PackageModel', 'package');
		$this->load->model('PackageSubComponentModel', 'packageSubComponent');

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

        $queryActivePrice = $this->getQueryActivePrice();
        $baseQuery = $this->db->select($selectList)
            ->from("({$queryActivePrice}) AS ref_component_prices")
            ->join('ref_components', 'ref_components.id = ref_component_prices.id_component')
            ->join('ref_vendors', 'ref_vendors.id = ref_component_prices.id_vendor')
			->join('ref_ports AS port_origins', 'port_origins.id = ref_component_prices.id_port_origin', 'left')
            ->join('ref_ports AS port_destinations', 'port_destinations.id = ref_component_prices.id_port_destination', 'left')
			->join('ref_locations AS location_origins', 'location_origins.id = ref_component_prices.id_location_origin', 'left')
			->join('ref_locations AS location_destinations', 'location_destinations.id = ref_component_prices.id_location_destination', 'left')
            ->join('ref_container_sizes', 'ref_container_sizes.id = ref_component_prices.id_container_size', 'left')
            ->join('ref_container_types', 'ref_container_types.id = ref_component_prices.id_container_type', 'left')
            ->join('ref_sub_components', 'ref_sub_components.id = ref_component_prices.id_sub_component', 'left')
            ->where('ref_components.id', $componentId)
            ->group_by('ref_components.id, ref_vendors.id, port_origins.id, port_destinations.id, location_origins.id, location_destinations.id, ref_container_sizes.id, ref_container_types.id, ref_component_prices.expired_date');

		if (key_exists('vendor', $filters) && !empty($filters['vendor'])) {
			$baseQuery->where_in('ref_vendors.id', $filters['vendor']);
		}

		if (key_exists('total', $filters) && $filters['total']) {
			return $baseQuery->count_all_results();
		}

        return $baseQuery->get()->result_array();
    }

	/**
	 * Get component package price.
	 *
	 * @param $filters
	 * @return array
	 */
    public function getComponentPackagePrice($filters)
	{
		if (key_exists('component', $filters) && !empty($filters['component'])) {
			$component = $this->component->getById($filters['component']);
			if ($component['service_section'] == 'ORIGIN') {
				unset($filters['location_destination']);
				unset($filters['port_destination']);
				if ($component['provider'] == 'SHIPPING LINE') {
					unset($filters['location_origin']);
				}
			} else if ($component['service_section'] == 'DESTINATION') {
				unset($filters['location_origin']);
				unset($filters['port_origin']);
				if ($component['provider'] == 'SHIPPING LINE') {
					unset($filters['location_destination']);
				}
			} else if ($component['service_section'] === 'SHIPPING') {
				if ($component['provider'] === 'SHIPPING LINE') {
					unset($filters['location_origin']);
					unset($filters['location_destination']);
				} else {
					unset($filters['port_origin']);
					unset($filters['port_destination']);
				}
			}
		}

		$packageName = '';
		if (key_exists('package', $filters) && !empty($filters['package'])) {
			$currentPackage = $this->package->getById($filters['package']);
			if(!empty($currentPackage)) {
				$packageName = $currentPackage['package'];
			}
		}

		$queryActivePrice = $this->getQueryActivePrice();
		$baseQuery = $this->db
			->select([
				'ref_component_prices.id_component',
				'ref_component_prices.id_vendor',
				'port_origins.port AS port_origin',
				'port_destinations.port AS port_destination',
				'location_origins.location AS location_origin',
				'location_destinations.location AS location_destination',
				'ref_component_prices.id_container_size',
				'ref_component_prices.id_container_type',
				'ref_component_prices.id_container_type',
				'ref_package_sub_components.id_package',
			])
			->from("({$queryActivePrice}) AS ref_component_prices")
			->join('ref_components', 'ref_components.id = ref_component_prices.id_component')
			->join('ref_vendors', 'ref_vendors.id = ref_component_prices.id_vendor')
			->join('ref_ports AS port_origins', 'port_origins.id = ref_component_prices.id_port_origin', 'left')
			->join('ref_ports AS port_destinations', 'port_destinations.id = ref_component_prices.id_port_destination', 'left')
			->join('ref_locations AS location_origins', 'location_origins.id = ref_component_prices.id_location_origin', 'left')
			->join('ref_locations AS location_destinations', 'location_destinations.id = ref_component_prices.id_location_destination', 'left')
			->join('ref_container_sizes', 'ref_container_sizes.id = ref_component_prices.id_container_size', 'left')
			->join('ref_container_types', 'ref_container_types.id = ref_component_prices.id_container_type', 'left')
			->join('ref_sub_components', 'ref_sub_components.id = ref_component_prices.id_sub_component', 'left')
			->join('ref_package_sub_components', 'ref_package_sub_components.id_sub_component = ref_component_prices.id_sub_component');

		if (key_exists('detail', $filters) && $filters['detail']) {
			$baseQuery->select(['ref_sub_components.sub_component', 'ref_component_prices.price']);
			$baseQuery->where_in('ref_component_prices.id_component', $filters['component']);
		} else {
			$baseQuery->select(['SUM(ref_component_prices.price) AS price']);
			$baseQuery->group_by('id_component, id_vendor, id_port_origin, id_port_destination, id_location_origin, id_location_destination, id_container_size, id_container_type, id_package');
		}

		if (key_exists('component', $filters) && !empty($filters['component'])) {
			$baseQuery->where_in('ref_component_prices.id_component', $filters['component']);
		}

		if (key_exists('port_origin', $filters)) {
			$baseQuery->where_in('ref_component_prices.id_port_origin', $filters['port_origin']);
		}

		if (key_exists('port_destination', $filters)) {
			$baseQuery->where_in('ref_component_prices.id_port_destination', $filters['port_destination']);
		}

		if (key_exists('location_origin', $filters)) {
			$baseQuery->where_in('ref_component_prices.id_location_origin', $filters['location_origin']);
		}

		if (key_exists('location_destination', $filters)) {
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

		if (key_exists('autoselect', $filters) && !empty($filters['autoselect'])) {
			if(strtolower($packageName) == 'c101' || strtolower($packageName) == 'c101') {
				$filters['vendor'] = $filters['vendor_reference'];
			} else {
				unset($filters['vendor']);
			}
			$baseQuery->limit(1);
		}

		if (key_exists('vendor', $filters) && !empty($filters['vendor'])) {
			$baseQuery->where_in('ref_component_prices.id_vendor', $filters['vendor']);
		}

		$baseQuery->order_by('price', 'asc');

		return $baseQuery->get()->result_array();
	}
}
