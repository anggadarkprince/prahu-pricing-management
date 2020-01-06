<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Consumable
 * @property ConsumableModel $consumable
 * @property ConsumablePriceModel $consumablePrice
 * @property ConsumablePriceComponentModel $consumablePriceComponent
 * @property ComponentModel $component
 * @property ContainerSizeModel $containerSize
 * @property Exporter $exporter
 */
class Consumable extends App_Controller
{
	/**
	 * Consumable constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ConsumableModel', 'consumable');
		$this->load->model('ConsumablePriceModel', 'consumablePrice');
		$this->load->model('ConsumablePriceComponentModel', 'consumablePriceComponent');
		$this->load->model('ComponentModel', 'component');
		$this->load->model('ContainerSizeModel', 'containerSize');
		$this->load->model('modules/Exporter', 'exporter');
	}

	/**
	 * Show consumable index page.
	 */
	public function index()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_VIEW);

		$filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

		$export = $this->input->get('exporter');
		if ($export) unset($filters['page']);

		$consumables = $this->consumable->getAll($filters);

		if ($export) {
			$this->exporter->exportFromArray('Consumables', $consumables);
		}

		$this->render('consumable/index', compact('consumables'));
	}

	/**
	 * Show consumable data.
	 *
	 * @param $id
	 */
	public function view($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_VIEW);

		$consumable = $this->consumable->getById($id);

		if (empty($consumable)) {
			redirect('error404');
		}

		$this->render('consumable/view', compact('consumable'));
	}

	/**
	 * Show create consumable.
	 */
	public function create()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_CREATE);

		$components = $this->component->getAll();
		$containerSizes = $this->containerSize->getAll();

		$this->render('consumable/create', compact('components', 'containerSizes'));
	}

	/**
	 * Save new consumable data.
	 */
	public function save()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_CREATE);

		if ($this->validate()) {
			$consumable = $this->input->post('consumable');
			$description = $this->input->post('description');
			$services = $this->input->post('services');

			$this->db->trans_start();

			$this->consumable->create([
				'consumable' => $consumable,
				'description' => $description
			]);
			$paymentTypeId = $this->db->insert_id();

			if (!empty($services)) {
				foreach ($services as $serviceId => $service) {
					$this->servicePaymentType->create([
						'id_service' => $serviceId,
						'id_payment_type' => $paymentTypeId,
						'payment_percent' => $service['payment_percent'],
						'margin_percent' => $service['margin_percent'],
					]);
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status()) {
				flash('success', "Payment type {$consumable} successfully created", 'master/payment-type');
			} else {
				flash('danger', 'Create consumable failed, try again or contact administrator');
			}
		}
		$this->create();
	}

	/**
	 * Show edit consumable form.
	 *
	 * @param $id
	 */
	public function edit($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_EDIT);

		$consumable = $this->consumable->getById($id);

		$services = $this->service->getAll();
		foreach ($services as &$service) {
			$servicePayment = $this->servicePaymentType->getBy([
				'ref_service_payment_types.id_service' => $service['id'],
				'ref_service_payment_types.id_payment_type' => $id
			], true);

			$service['payment_percent'] = get_if_exist($servicePayment, 'payment_percent', 0);
			$service['margin_percent'] = get_if_exist($servicePayment, 'margin_percent', 0);
		}

		$this->render('consumable/edit', compact('consumable', 'services'));
	}

	/**
	 * Update data consumable by id.
	 *
	 * @param $id
	 */
	public function update($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_EDIT);

		if ($this->validate($this->_validation_rules($id))) {
			$consumable = $this->input->post('consumable');
			$description = $this->input->post('description');
			$services = $this->input->post('services');

			$this->db->trans_start();

			$this->consumable->update([
				'consumable' => $consumable,
				'description' => $description
			], $id);

			if (!empty($services)) {
				$this->servicePaymentType->delete(['id_payment_type' => $id]);
				foreach ($services as $serviceId => $service) {
					$this->servicePaymentType->create([
						'id_service' => $serviceId,
						'id_payment_type' => $id,
						'payment_percent' => $service['payment_percent'],
						'margin_percent' => $service['margin_percent'],
					]);
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status()) {
				flash('success', "Payment type {$consumable} successfully updated", 'master/payment-type');
			} else {
				flash('danger', "Update consumable failed, try again or contact administrator");
			}
		}
		$this->edit($id);
	}

	/**
	 * Perform deleting consumable data.
	 *
	 * @param $id
	 */
	public function delete($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_DELETE);

		$consumable = $this->consumable->getById($id);

		if ($this->consumable->delete($id, true)) {
			flash('warning', "Payment type {$consumable['consumable']} successfully deleted");
		} else {
			flash('danger', 'Delete consumable failed, try again or contact administrator');
		}
		redirect('master/payment-type');
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
			'consumable' => [
				'trim', 'required', 'max_length[50]', ['payment_exists', function ($input) use ($id) {
					$this->form_validation->set_message('payment_exists', 'The %s has been exist, try another');
					return empty($this->consumable->getBy([
						'ref_payment_types.consumable' => $input,
						'ref_payment_types.id!=' => $id
					]));
				}]
			],
			'description' => 'max_length[500]',
		];
	}
}
