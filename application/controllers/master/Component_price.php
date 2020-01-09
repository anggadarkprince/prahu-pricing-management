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
			$portId = $this->input->post('port');
			$portDestinationId = $this->input->post('port_destination');
			$locationId = $this->input->post('location');
			$containerSizeId = $this->input->post('container_size');
			$containerTypeId = $this->input->post('container_type');
			$subComponentId = $this->input->post('sub_component');
			$price = $this->input->post('price');
			$description = $this->input->post('description');

			$save = $this->componentPrice->create([
				'id_component' => $componentId,
				'id_vendor' => $vendorId,
				'id_port' => $portId,
				'id_port_destination' => if_empty($portDestinationId, null),
				'id_location' => $locationId,
				'id_container_size' => $containerSizeId,
				'id_container_type' => $containerTypeId,
				'id_sub_component' => $subComponentId,
				'price' => extract_number($price),
				'description' => $description
			]);

			if ($save) {
				flash('success', "Component price {$price} successfully created", 'master/component-price');
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
			$portId = $this->input->post('port');
			$portDestinationId = $this->input->post('port_destination');
			$locationId = $this->input->post('location');
			$containerSizeId = $this->input->post('container_size');
			$containerTypeId = $this->input->post('container_type');
			$subComponentId = $this->input->post('sub_component');
			$price = $this->input->post('price');
			$description = $this->input->post('description');

			$update = $this->componentPrice->update([
				'id_component' => $componentId,
				'id_vendor' => $vendorId,
				'id_port' => $portId,
				'id_port_destination' => if_empty($portDestinationId, null),
				'id_location' => $locationId,
				'id_container_size' => $containerSizeId,
				'id_container_type' => $containerTypeId,
				'id_sub_component' => $subComponentId,
				'price' => extract_number($price),
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
			'port' => 'trim|required|max_length[20]',
			'port_destination' => 'trim|max_length[20]',
			'location' => 'trim',
			'container_size' => 'trim|required|max_length[20]',
			'container_type' => 'trim|required|max_length[20]',
			'sub_component' => 'trim|required|max_length[20]',
			'price' => [
				'trim', 'required', 'max_length[50]', ['value_exists', function ($input) use ($id) {
					$componentId = $this->input->post('component');
					$vendorId = $this->input->post('vendor');
					$portId = $this->input->post('port');
					$portDestinationId = $this->input->post('port_destination');
					$locationId = $this->input->post('location');
					$containerSizeId = $this->input->post('container_size');
					$containerTypeId = $this->input->post('container_type');
					$subComponentId = $this->input->post('sub_component');

					$priceData = $this->componentPrice->getBy([
						'ref_component_prices.id_component' => $componentId,
						'ref_component_prices.id_vendor' => $vendorId,
						'ref_component_prices.id_port' => $portId,
						'id_port_destination' => if_empty($portDestinationId, null),
						'ref_component_prices.id_location' => $locationId,
						'ref_component_prices.id_container_size' => $containerSizeId,
						'ref_component_prices.id_container_type' => $containerTypeId,
						'ref_component_prices.id_sub_component' => $subComponentId,
						'ref_component_prices.id!=' => $id
					], true);

					if (!empty($priceData)) {
						$linkEdit = '<a href="' . site_url('master/component-price/edit/' . $priceData['id']) . '">Click here</a>';
						$this->form_validation->set_message('value_exists', 'The %s combination already exists, edit data instead, ' . $linkEdit);
					}
					return empty($this->componentPrice->getBy([
						'ref_component_prices.id_component' => $componentId,
						'ref_component_prices.id_vendor' => $vendorId,
						'ref_component_prices.id_port' => $portId,
						'id_port_destination' => if_empty($portDestinationId, null),
						'ref_component_prices.id_location' => $locationId,
						'ref_component_prices.id_container_size' => $containerSizeId,
						'ref_component_prices.id_container_type' => $containerTypeId,
						'ref_component_prices.id_sub_component' => $subComponentId,
						'ref_component_prices.id!=' => $id
					]));
				}]
			],
			'description' => 'max_length[500]',
		];
	}

}
