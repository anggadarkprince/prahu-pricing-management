<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Component_price
 * @property ComponentPriceModel $componentPrice
 * @property ComponentModel $component
 * @property SubComponentModel $subComponent
 * @property VendorModel $vendor
 * @property PortModel $port
 * @property LocationModel $location
 * @property ContainerSizeModel $containerSize
 * @property ContainerTypeModel $containerType
 * @property Exporter $exporter
 */
class Component_price extends App_Controller
{
	/**
	 * Component_price constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ComponentPriceModel', 'componentPrice');
		$this->load->model('SubComponentModel', 'subComponent');
		$this->load->model('ComponentModel', 'component');
		$this->load->model('VendorModel', 'vendor');
		$this->load->model('PortModel', 'port');
		$this->load->model('LocationModel', 'location');
		$this->load->model('ContainerSizeModel', 'containerSize');
		$this->load->model('ContainerTypeModel', 'containerType');
		$this->load->model('modules/Exporter', 'exporter');
	}

	/**
	 * Show component price index page.
	 */
	public function index()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_VIEW);

		$filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

		$export = $this->input->get('export');
		if ($export) unset($filters['page']);

		$components = $this->component->getAll();
		if (empty(get_if_exist($filters, 'components')) && !empty($components)) {
			$filters['components'] = $components[0]['id'];
			$componentActive = $this->component->getById($components[0]['id']);
			$componentActive['sub_components'] = $this->subComponent->getBy(['ref_component_sub_components.id_component' => $components[0]['id']]);
		} else {
			$componentActive = $this->component->getById($filters['components']);
			$componentActive['sub_components'] = $this->subComponent->getBy(['ref_component_sub_components.id_component' => $filters['components']]);
		}
		$componentPrices = $this->componentPrice->getAllGroup($filters);

		if ($export) {
			$this->exporter->exportFromArray('Component prices', $componentPrices);
		}
		$subComponents = $this->subComponent->getAll();
		$vendors = $this->vendor->getAll();
		$ports = $this->port->getAll();
		$locations = $this->location->getAll();
		$containerSizes = $this->containerSize->getAll();
		$containerTypes = $this->containerType->getAll();

		$this->render('component_price/index', compact('componentPrices', 'subComponents', 'components', 'componentActive', 'subComponents', 'vendors', 'ports', 'locations', 'containerSizes', 'containerTypes'));
	}

	/**
	 * Show component price data.
	 */
	public function view()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_VIEW);

		$componentPrice = $this->componentPrice->getAllGroup($_GET);

		if (empty($componentPrice)) {
			redirect('error404');
		}
		$componentPrice = end($componentPrice);
		$subComponentPrices = $this->componentPrice->getAll($_GET);

		$this->render('component_price/view', compact('componentPrice', 'subComponentPrices'));
	}

	/**
	 * Show create component price.
	 */
	public function create()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_CREATE);

		$components = $this->component->getAll();
		$subComponents = $this->subComponent->getBy([
			'ref_components.id' => $this->input->post('component'),
		]);
		$vendors = $this->vendor->getAll();
		$ports = $this->port->getAll();
		$locations = $this->location->getAll();
		$containerSizes = $this->containerSize->getAll();
		$containerTypes = $this->containerType->getAll();

		$this->render('component_price/create', compact('components', 'subComponents', 'vendors', 'ports', 'locations', 'containerSizes', 'containerTypes'));
	}

	/**
	 * Save new component price data.
	 */
	public function save()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_CREATE);

		if ($this->validate($this->_validation_rules(true))) {
			$componentId = $this->input->post('component');
			$vendorId = $this->input->post('vendor');
			$portOriginId = $this->input->post('port_origin');
			$portDestinationId = $this->input->post('port_destination');
			$locationOriginId = $this->input->post('location_origin');
			$locationDestinationId = $this->input->post('location_destination');
			$containerSizeId = $this->input->post('container_size');
			$containerTypeId = $this->input->post('container_type');
			$expiredDate = $this->input->post('expired_date');
			$prices = $this->input->post('prices');
			$description = $this->input->post('description');

			$this->db->trans_start();

			if (!empty($prices)) {
				foreach ($prices as $price) {
					$this->componentPrice->create([
						'id_component' => $componentId,
						'id_vendor' => $vendorId,
						'id_port_origin' => if_empty($portOriginId, null),
						'id_port_destination' => if_empty($portDestinationId, null),
						'id_location_origin' => if_empty($locationOriginId, null),
						'id_location_destination' => if_empty($locationDestinationId, null),
						'id_container_size' => $containerSizeId,
						'id_container_type' => $containerTypeId,
						'id_sub_component' => $price['id_sub_component'],
						'price' => extract_number($price['price']),
						'expired_date' => format_date($expiredDate),
						'description' => $description
					]);
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status()) {
				flash('success', "Component price successfully created", 'master/component-price');
			} else {
				flash('danger', 'Create component price failed, try again or contact administrator');
			}
		}
		$this->create();
	}

	/**
	 * Show edit component price form.
	 */
	public function edit()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_EDIT);

		$componentPrice = $this->componentPrice->getAllGroup($_GET);
		if (empty($componentPrice)) {
			redirect('error404');
		}
		$componentPrice = end($componentPrice);
		$subComponentPrices = $this->componentPrice->getAll($_GET);
		foreach ($subComponentPrices as &$subComponentPrice) {
			$subComponentPrice['price'] = 'Rp. ' . numerical($subComponentPrice['price']);
		}

		$components = $this->component->getAll();
		$subComponents = $this->subComponent->getBy([
			'ref_components.id' => $componentPrice['id_component'],
		]);
		$vendors = $this->vendor->getAll();
		$ports = $this->port->getAll();
		$locations = $this->location->getAll();
		$containerSizes = $this->containerSize->getAll();
		$containerTypes = $this->containerType->getAll();

		$this->render('component_price/edit', compact('componentPrice', 'subComponentPrices', 'components', 'subComponents', 'vendors', 'ports', 'locations', 'containerSizes', 'containerTypes'));
	}

	/**
	 * Update data component price by id.
	 */
	public function update()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_EDIT);

		if ($this->validate()) {
			$componentId = $this->input->post('component');
			$vendorId = $this->input->post('vendor');
			$portOriginId = $this->input->post('port_origin');
			$portDestinationId = $this->input->post('port_destination');
			$locationOriginId = $this->input->post('location_origin');
			$locationDestinationId = $this->input->post('location_destination');
			$containerSizeId = $this->input->post('container_size');
			$containerTypeId = $this->input->post('container_type');
			$expiredDate = $this->input->post('expired_date');
			$prices = $this->input->post('prices');
			$description = $this->input->post('description');

			$this->db->trans_start();

			$this->componentPrice->delete([
				'id_component' => get_url_param('components'),
				'id_vendor' => get_url_param('vendors'),
				'id_port_origin' => if_empty(get_url_param('port_origins'), null),
				'id_port_destination' => if_empty(get_url_param('port_destinations'), null),
				'id_location_origin' => if_empty(get_url_param('location_origins'), null),
				'id_location_destination' => if_empty(get_url_param('location_destinations'), null),
				'id_container_size' => get_url_param('container_sizes'),
				'id_container_type' => get_url_param('container_types'),
				'expired_date' => get_url_param('expired_dates'),
			]);

			if (!empty($prices)) {
				foreach ($prices as $price) {
					$this->componentPrice->create([
						'id_component' => $componentId,
						'id_vendor' => $vendorId,
						'id_port_origin' => if_empty($portOriginId, null),
						'id_port_destination' => if_empty($portDestinationId, null),
						'id_location_origin' => if_empty($locationOriginId, null),
						'id_location_destination' => if_empty($locationDestinationId, null),
						'id_container_size' => $containerSizeId,
						'id_container_type' => $containerTypeId,
						'id_sub_component' => $price['id_sub_component'],
						'price' => extract_number($price['price']),
						'expired_date' => format_date($expiredDate),
						'description' => $description
					]);
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status()) {
				flash('success', "Component price successfully updated", 'master/component-price');
			} else {
				flash('danger', "Update component price failed, try again or contact administrator");
			}
		}
		$this->edit();
	}

	/**
	 * Perform deleting component data.
	 */
	public function delete()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_DELETE);

		$delete = $this->componentPrice->delete([
			'id_component' => get_url_param('components'),
			'id_vendor' => get_url_param('vendors'),
			'id_port_origin' => if_empty(get_url_param('port_origins'), null),
			'id_port_destination' => if_empty(get_url_param('port_destinations'), null),
			'id_location_origin' => if_empty(get_url_param('location_origins'), null),
			'id_location_destination' => if_empty(get_url_param('location_destinations'), null),
			'id_container_size' => get_url_param('container_sizes'),
			'id_container_type' => get_url_param('container_types'),
			'expired_date' => get_url_param('expired_dates'),
		]);
		if ($delete) {
			flash('warning', "Component price successfully deleted");
		} else {
			flash('danger', 'Delete component price failed, try again or contact administrator');
		}
		redirect('master/component-price');
	}

	/**
	 * Return general validation rules.
	 *
	 * @param bool $validatePrice
	 * @return array
	 */
	protected function _validation_rules($validatePrice = false)
	{
		return [
			'component' => 'trim|required|max_length[20]',
			'vendor' => 'trim|required|max_length[20]',
			'port_origin' => 'trim|max_length[20]',
			'port_destination' => 'trim|max_length[20]',
			'location_origin' => 'trim|max_length[20]',
			'location_destination' => 'trim|max_length[20]',
			'container_size' => 'trim|required|max_length[20]',
			'container_type' => 'trim|required|max_length[20]',
			'prices[]' => [
				'trim', 'required', ['not_empty', function ($input) use($validatePrice) {
					$this->form_validation->set_message('not_empty', 'The {field} field must be exist at least one.');
					return !empty($input);
				}]
			],
			'expired_date' => [
				'trim', 'required', 'max_length[50]', ['back_date', function ($input) use ($validatePrice) {
					if (format_date($input) <= date('Y-m-d')) {
						$this->form_validation->set_message('back_date', 'The %s input back not allowed');
						return false;
					} else {
						if ($validatePrice) {
							$componentId = $this->input->post('component');
							$vendorId = $this->input->post('vendor');
							$portOriginId = $this->input->post('port_origin');
							$portDestinationId = $this->input->post('port_destination');
							$locationOriginId = $this->input->post('location_origin');
							$locationDestinationId = $this->input->post('location_destination');
							$containerSizeId = $this->input->post('container_size');
							$containerTypeId = $this->input->post('container_type');
							$expiredDate = $this->input->post('expired_date');
							$prices = $this->input->post('prices');

							$isValid = true;
							foreach ($prices as $price) {
								$priceData = $this->componentPrice->getBy([
									'ref_component_prices.id_component' => $componentId,
									'ref_component_prices.id_vendor' => $vendorId,
									'ref_component_prices.id_port_origin' => if_empty($portOriginId, null),
									'ref_component_prices.id_port_destination' => if_empty($portDestinationId, null),
									'ref_component_prices.id_location_origin' => if_empty($locationOriginId, null),
									'ref_component_prices.id_location_destination' => if_empty($locationDestinationId, null),
									'ref_component_prices.id_container_size' => $containerSizeId,
									'ref_component_prices.id_container_type' => $containerTypeId,
									'ref_component_prices.id_sub_component' => $price['id_sub_component'],
									'ref_component_prices.expired_date' => format_date($expiredDate),
								], true);

								if (!empty($priceData)) {
									$this->form_validation->set_message('back_date', 'The price data is exist with same date and combination');
									$isValid = false;
									break;
								}
							}
							return $isValid;
						}
					}
					return true;
				}]
			],
			'description' => 'max_length[500]',
		];
	}
}
