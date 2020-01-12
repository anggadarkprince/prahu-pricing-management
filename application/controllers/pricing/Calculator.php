<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Calculator
 * @property MarketingModel $marketing
 * @property LoadingCategoryModel $loadingCategory
 * @property ConsumableModel $consumable
 * @property ConsumablePriceModel $consumablePrice
 * @property ConsumablePriceComponentModel $consumablePriceComponent
 * @property ComponentPriceModel $componentPrice
 * @property ComponentModel $component
 * @property SubComponentModel $subComponent
 * @property VendorModel $vendor
 * @property PortModel $port
 * @property LocationModel $location
 * @property ContainerSizeModel $containerSize
 * @property ContainerTypeModel $containerType
 * @property ServiceModel $service
 * @property ServicePaymentTypeModel $servicePaymentType
 * @property PaymentTypeModel $paymentType
 * @property PackageModel $package
 * @property QuotationModel $quotation
 * @property QuotationPackagingModel $quotationPackaging
 * @property QuotationSurchargeModel $quotationSurcharge
 * @property QuotationComponentModel $quotationComponent
 * @property QuotationSubComponentModel $quotationSubComponent
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
		$this->load->model('ConsumablePriceModel', 'consumablePrice');
		$this->load->model('ConsumablePriceComponentModel', 'consumablePriceComponent');
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
		$this->load->model('ServicePaymentTypeModel', 'servicePaymentType');
		$this->load->model('PackageModel', 'package');
		$this->load->model('QuotationModel', 'quotation');
		$this->load->model('QuotationComponentModel', 'quotationComponent');
		$this->load->model('QuotationPackagingModel', 'quotationPackaging');
		$this->load->model('QuotationSurchargeModel', 'quotationSurcharge');
		$this->load->model('QuotationSubComponentModel', 'quotationSubComponent');
		$this->load->model('modules/Exporter', 'exporter');

		$this->setFilterMethods([
			'ajax_get_component_price' => 'GET',
			'ajax_get_consumable_price' => 'GET',
			'ajax_get_margin' => 'GET',
		]);
	}

	/**
	 * View calculator page.
	 */
	public function index()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_PRICING_CALCULATE);

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
		$portOriginId = $this->input->post('port_origin');
		$portDestinationId = $this->input->post('port_destination');
		$locationOriginId = $this->input->post('location_origin');
		$locationDestinationId = $this->input->post('location_destination');
		$customerName = $this->input->post('customer_name');
		$company = $this->input->post('company');
		$marketingId = $this->input->post('marketing');
		$lodingCategoryId = $this->input->post('loading_category');
		$containerSizeId = $this->input->post('container_size');
		$containerTypeId = $this->input->post('container_type');
		$serviceId = $this->input->post('service');
		$paymentTypeId = $this->input->post('payment_type');
		$incomeTax = $this->input->post('income_tax');
		$insurance = $this->input->post('insurance');
		$goodsValue = $this->input->post('goods_value');
		$pricing = $this->input->post('pricing');
		$description = $this->input->post('description');

		$marketing = $this->marketing->getById($marketingId);
		$service = $this->service->getById($serviceId);
		$locationFrom = $this->location->getById($locationOriginId);
		$locationTo = $this->location->getById($locationDestinationId);
		$portFrom = $this->port->getById($portOriginId);
		$portTo = $this->port->getById($portDestinationId);
		$loadingCategory = $this->loadingCategory->getById($lodingCategoryId);
		$containerSize = $this->containerSize->getById($containerSizeId);
		$containerType = $this->containerType->getById($containerTypeId);
		$paymentType = $this->paymentType->getById($paymentTypeId);
		$paymentService = $this->servicePaymentType->getBy([
			'id_service' => $serviceId,
			'id_payment_type' => $paymentTypeId,
		], true);

		$this->db->trans_start();

		if (!empty($pricing)) {
			foreach ($pricing as $price) {
				$this->quotation->create([
					'customer' => $customerName,
					'company' => $company,
					'marketing' => $marketing['name'],
					'service' => $service['service'],
					'location_from' => get_if_exist($locationFrom, 'location', null),
					'location_from' => get_if_exist($locationTo, 'location', null),
					'port_from' => get_if_exist($portFrom, 'port', null),
					'port_to' => get_if_exist($portTo, 'port', null),
					'loading_category' => $loadingCategory['loading_category'],
					'container_size' => $containerSize['container_size'],
					'container_type' => $containerType['container_type'],
					'payment_type' => $paymentType['payment_type'],
					'payment_percent' => $paymentService['payment_percent'],
					'margin_percent' => $paymentService['margin_percent'],
					'goods_value' => extract_number($goodsValue),
					'insurance' => $insurance ? extract_number($price['insurance']) : 0,
					'tax_percent' => $incomeTax == 1 ? 2 : 0,
					'description' => $description,
				]);
				$quotationId = $this->db->insert_id();

				if (!empty($price['components'])) {
					foreach ($price['components'] as $componentId => $componentPrice) {
						if(!empty($componentPrice['package']) && !empty($componentPrice['partner'])) {
							$component = $this->component->getById($componentId);
							$vendor = $this->vendor->getById($componentPrice['partner']);
							$package = $this->package->getById($componentPrice['package']);
							$this->quotationComponent->create([
								'id_quotation' => $quotationId,
								'component' => $component['component'],
								'type' => $component['provider'],
								'vendor' => $vendor['vendor'],
								'package' => $package['package'],
								'term_payment' => $vendor['term_payment'],
							]);
							$quotationComponentId = $this->db->insert_id();

							$filters = [
								'component' => $componentId,
								'vendor' => $componentPrice['partner'],
								'port_origin' => $portOriginId,
								'port_destination' => $portDestinationId,
								'location_origin' => $locationOriginId,
								'location_destination' => $locationDestinationId,
								'container_size' => $containerSizeId,
								'container_type' => $containerTypeId,
								'package' => $componentPrice['package'],
								'detail' => true,
							];
							$subComponents = $this->componentPrice->getComponentPackagePrice($filters);
							foreach ($subComponents as $subComponent) {
								$this->quotationSubComponent->create([
									'id_quotation_component' => $quotationComponentId,
									'sub_component' => $subComponent['sub_component'],
									'price' => $subComponent['price'],
								]);
							}
						}
					}
				}

				if (!empty($price['packaging'])) {
					foreach ($price['packaging'] as $packaging) {
						if (!empty($packaging['package'])) {
							$consumable = $this->consumable->getById($packaging['package']);
							$this->quotationPackaging->create([
								'id_quotation' => $quotationId,
								'package' => $consumable['consumable'],
								'price' => extract_number($packaging['price'])
							]);
						}
					}
				}

				if (!empty($price['surcharges'])) {
					foreach ($price['surcharges'] as $surcharge) {
						if (!empty(trim($surcharge['surcharge']))) {
							$this->quotationSurcharge->create([
								'id_quotation' => $quotationId,
								'surcharge' => $surcharge['surcharge'],
								'price' => extract_number($surcharge['price'])
							]);
						}
					}
				}
			}
		}

		$this->db->trans_complete();

		if ($this->db->trans_status()) {
			flash('success', "Quotation price successfully created");
		} else {
			flash('danger', 'Create component price failed, try again or contact administrator');
		}
		redirect('pricing/calculator');
	}

	public function ajax_get_component_price()
	{
		$filters = [
			'component' => get_url_param('component'),
			'vendor' => get_url_param('vendor'),
			'port_origin' => get_url_param('port_origin'),
			'port_destination' => get_url_param('port_destination'),
			'location_origin' => get_url_param('location_origin'),
			'location_destination' => get_url_param('location_destination'),
			'container_size' => get_url_param('container_size'),
			'container_type' => get_url_param('container_type'),
			'package' => get_url_param('package'),
			'autoselect' => get_url_param('autoselect'),
		];

		$componentPrice = $this->componentPrice->getComponentPackagePrice($filters);

		$this->render_json($componentPrice);
	}

	public function ajax_get_consumable_price()
	{
		$componentPrice = $this->consumablePrice->getBy([
			'ref_consumables.type' => get_url_param('type'),
			'id_consumable' => get_url_param('consumable'),
			'id_container_size' => get_url_param('container_size')
		], true);

		if (!empty($componentPrice)) {
			$componentPrice['components'] = $this->consumablePriceComponent->getBy([
				'ref_consumable_price_components.id_consumable_price' => $componentPrice['id']
			]);
		}

		$this->render_json($componentPrice);
	}

	public function ajax_get_margin()
	{
		$payment = $this->servicePaymentType->getBy([
			'id_service' => get_url_param('service'),
			'id_payment_type' => get_url_param('payment_type'),
		], true);

		$this->render_json($payment);
	}
}
