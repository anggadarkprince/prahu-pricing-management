<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Calculator
 * @property MarketingModel $marketing
 * @property LoadingCategoryModel $loadingCategory
 * @property ConsumableModel $consumable
 * @property ComponentPriceModel $componentPrice
 * @property ComponentModel $component
 * @property SubComponentModel $subComponent
 * @property VendorModel $vendor
 * @property PortModel $port
 * @property LocationModel $location
 * @property ContainerSizeModel $containerSize
 * @property ContainerTypeModel $containerType
 * @property ServiceModel $service
 * @property PaymentTypeModel $paymentType
 * @property PackageModel $package
 * @property Exporter $exporter
 */
class Calculator extends App_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MarketingModel', 'marketing');
		$this->load->model('LoadingCategoryModel', 'loadingCategory');
		$this->load->model('ConsumableModel', 'consumable');
		$this->load->model('ComponentPriceModel', 'componentPrice');
		$this->load->model('SubComponentModel', 'subComponent');
		$this->load->model('ComponentModel', 'component');
		$this->load->model('VendorModel', 'vendor');
		$this->load->model('PortModel', 'port');
		$this->load->model('LocationModel', 'location');
		$this->load->model('ContainerSizeModel', 'containerSize');
		$this->load->model('ContainerTypeModel', 'containerType');
		$this->load->model('PaymentTypeModel', 'paymentType');
		$this->load->model('ServiceModel', 'service');
		$this->load->model('PackageModel', 'package');
		$this->load->model('modules/Exporter', 'exporter');
	}

	/**
	 * View calculator page.
	 */
	public function index()
	{
		$components = $this->component->getAll();
		foreach ($components as &$component) {
			$component['packages'] = $this->package->getBy(['ref_packages.id_component' => $component['id']]);
		}
		$ports = $this->port->getAll();
		$locations = $this->location->getAll();
		$services = $this->service->getAll();
		$loadingCategories = $this->loadingCategory->getAll();
		$consumables = $this->consumable->getAll();
		$marketings = $this->marketing->getAll();
		$containerSizes = $this->containerSize->getAll();
		$containerTypes = $this->containerType->getAll();
		$paymentTypes = $this->paymentType->getAll();
		$vendors = $this->vendor->getAll();

		$this->render('calculator/index', compact('components', 'ports', 'locations', 'services', 'loadingCategories', 'consumables', 'marketings', 'containerSizes', 'containerTypes', 'paymentTypes', 'vendors'));
	}

	public function save()
	{
		print_debug($_POST);
	}
}
