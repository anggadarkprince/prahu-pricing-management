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

		$componentPrices = $this->componentPrice->getAll($filters);

		if ($export) {
			$this->exporter->exportFromArray('Component prices', $componentPrices);
		}
		$components = $this->component->getAll();
		$subComponents = $this->subComponent->getAll();
		$vendors = $this->vendor->getAll();
		$ports = $this->port->getAll();
		$locations = $this->location->getAll();
		$containerSizes = $this->containerSize->getAll();
		$containerTypes = $this->containerType->getAll();

		$this->render('component_price/index', compact('componentPrices', 'subComponents', 'components', 'subComponents', 'vendors', 'ports', 'locations', 'containerSizes', 'containerTypes'));
	}

	/**
	 * Show component price data.
	 *
	 * @param $id
	 */
	public function view($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_VIEW);

		$componentPrice = $this->componentPrice->getById($id);

		if (empty($componentPrice)) {
			redirect('error404');
		}

		$this->render('component_price/view', compact('componentPrice'));
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
	 *
	 * @param $id
	 */
	public function edit($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_EDIT);

		$componentPrice = $this->componentPrice->getById($id);
		$components = $this->component->getAll();
		$subComponents = $this->subComponent->getBy([
			'ref_components.id' => $componentPrice['id_component'],
		]);
		$vendors = $this->vendor->getAll();
		$ports = $this->port->getAll();
		$locations = $this->location->getAll();
		$containerSizes = $this->containerSize->getAll();
		$containerTypes = $this->containerType->getAll();

		$this->render('component_price/edit', compact('componentPrice', 'components', 'subComponents', 'vendors', 'ports', 'locations', 'containerSizes', 'containerTypes'));
	}

	/**
	 * Update data component price by id.
	 *
	 * @param $id
	 */
	public function update($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_EDIT);

		if ($this->validate($this->_validation_rules($id))) {
			$componentId = $this->input->post('component');
			$vendorId = $this->input->post('vendor');
			$portOriginId = $this->input->post('port_origin');
			$portDestinationId = $this->input->post('port_destination');
			$locationOriginId = $this->input->post('location_origin');
			$locationDestinationId = $this->input->post('location_destination');
			$containerSizeId = $this->input->post('container_size');
			$containerTypeId = $this->input->post('container_type');
			$subComponentId = $this->input->post('sub_component');
			$expiredDate = $this->input->post('expired_date');
			$price = $this->input->post('price');
			$description = $this->input->post('description');

			$update = $this->componentPrice->update([
				'id_component' => $componentId,
				'id_vendor' => $vendorId,
				'id_port_origin' => if_empty($portOriginId, null),
				'id_port_destination' => if_empty($portDestinationId, null),
				'id_location_origin' => if_empty($locationOriginId, null),
				'id_location_destination' => if_empty($locationDestinationId, null),
				'id_container_size' => $containerSizeId,
				'id_container_type' => $containerTypeId,
				'id_sub_component' => $subComponentId,
				'price' => extract_number($price),
				'expired_date' => format_date($expiredDate),
				'description' => $description
			], $id);

			if ($update) {
				flash('success', "Component price {$price} successfully updated", 'master/component-price');
			} else {
				flash('danger', "Update component price failed, try again or contact administrator");
			}
		}
		$this->edit($id);
	}

	/**
	 * Perform deleting component data.
	 *
	 * @param $id
	 */
	public function delete($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_PRICE_DELETE);

		$componentPrice = $this->subComponent->getById($id);

		if ($this->componentPrice->delete($id)) {
			flash('warning', "Component price " . numerical($componentPrice['price']) . " successfully deleted");
		} else {
			flash('danger', 'Delete component price failed, try again or contact administrator');
		}
		redirect('master/component-price');
	}

	/**
	 * Return general validation rules.
	 *
	 * @param array $params
	 * @return array
	 */
	protected function _validation_rules(...$params)
	{
		$id = isset($params[0]) ? $params[0] : 0;
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
				'trim', ['not_empty', function ($input) use ($id) {
					if (!empty($id)) {
						return true;
					}
					$this->form_validation->set_message('not_empty', 'The {field} field must be exist at least one.');
					return !empty($input);
				}]
			],
			'price' => [
				'trim', 'max_length[50]', ['value_exists', function ($input) use ($id) {
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
					$subComponentId = $this->input->post('sub_component');

					if (empty($id)) {
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
								$this->form_validation->set_message('value_exists', 'The %s is exist with same date and combination');
								$isValid = false;
								break;
							}
						}
						return $isValid;
					}

					$priceData = $this->componentPrice->getBy([
						'ref_component_prices.id_component' => $componentId,
						'ref_component_prices.id_vendor' => $vendorId,
						'ref_component_prices.id_port_origin' => if_empty($portOriginId, null),
						'ref_component_prices.id_port_destination' => if_empty($portDestinationId, null),
						'ref_component_prices.id_location_origin' => if_empty($locationOriginId, null),
						'ref_component_prices.id_location_destination' => if_empty($locationDestinationId, null),
						'ref_component_prices.id_container_size' => $containerSizeId,
						'ref_component_prices.id_container_type' => $containerTypeId,
						'ref_component_prices.id_sub_component' => $subComponentId,
						'ref_component_prices.expired_date' => format_date($expiredDate),
						'ref_component_prices.id!=' => $id
					], true);
					if (!empty($priceData)) {
						$linkEdit = '<a href="' . site_url('master/component-price/edit/' . $priceData['id']) . '">Click here</a>';
						$this->form_validation->set_message('value_exists', 'The %s combination already exists, edit data instead, ' . $linkEdit);
					}
					return empty($priceData);
				}]
			],
			'expired_date' => [
				'trim', 'required', 'max_length[50]', ['back_date', function ($input) {
					if (format_date($input) <= date('Y-m-d')) {
						$this->form_validation->set_message('back_date', 'The %s input back not allowed');
						return false;
					}
					return true;
				}]
			],
			'description' => 'max_length[500]',
		];
	}
}
