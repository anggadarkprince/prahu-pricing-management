<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Payment_type
 * @property PaymentTypeModel $paymentType
 * @property ServiceModel $service
 * @property ServicePaymentTypeModel $servicePaymentType
 * @property Exporter $exporter
 */
class Payment_type extends App_Controller
{
	/**
	 * Payment_type constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('PaymentTypeModel', 'paymentType');
		$this->load->model('ServicePaymentTypeModel', 'servicePaymentType');
		$this->load->model('ServiceModel', 'service');
		$this->load->model('modules/Exporter', 'exporter');
	}

	/**
	 * Show payment type index page.
	 */
	public function index()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_PAYMENT_TYPE_VIEW);

		$filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

		$export = $this->input->get('export');
		if ($export) unset($filters['page']);

		$paymentTypes = $this->paymentType->getAll($filters);

		if ($export) {
			$this->exporter->exportFromArray('Payment types', $paymentTypes);
		}

		$this->render('payment_type/index', compact('paymentTypes'));
	}

	/**
	 * Show payment type data.
	 *
	 * @param $id
	 */
	public function view($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_PAYMENT_TYPE_VIEW);

		$paymentType = $this->paymentType->getById($id);

		if (empty($paymentType)) {
			redirect('error404');
		}
		$services = $this->service->getAll();
		foreach ($services as &$service) {
			$servicePayment = $this->servicePaymentType->getBy([
				'ref_service_payment_types.id_service' => $service['id'],
				'ref_service_payment_types.id_payment_type' => $id
			], true);

			$service['payment_percent'] = get_if_exist($servicePayment, 'payment_percent', 0);
			$service['margin_percent'] = get_if_exist($servicePayment, 'margin_percent', 0);
		}

		$this->render('payment_type/view', compact('paymentType', 'services'));
	}

	/**
	 * Show create payment type.
	 */
	public function create()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_PAYMENT_TYPE_CREATE);

		$services = $this->service->getAll();

		$this->render('payment_type/create', compact('services'));
	}

	/**
	 * Save new payment type data.
	 */
	public function save()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_PAYMENT_TYPE_CREATE);

		if ($this->validate()) {
			$paymentType = $this->input->post('payment_type');
			$description = $this->input->post('description');
			$services = $this->input->post('services');

			$this->db->trans_start();

			$this->paymentType->create([
				'payment_type' => $paymentType,
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
				flash('success', "Payment type {$paymentType} successfully created", 'master/payment-type');
			} else {
				flash('danger', 'Create payment type failed, try again or contact administrator');
			}
		}
		$this->create();
	}

	/**
	 * Show edit payment type form.
	 *
	 * @param $id
	 */
	public function edit($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_PAYMENT_TYPE_EDIT);

		$paymentType = $this->paymentType->getById($id);

		$services = $this->service->getAll();
		foreach ($services as &$service) {
			$servicePayment = $this->servicePaymentType->getBy([
				'ref_service_payment_types.id_service' => $service['id'],
				'ref_service_payment_types.id_payment_type' => $id
			], true);

			$service['payment_percent'] = get_if_exist($servicePayment, 'payment_percent', 0);
			$service['margin_percent'] = get_if_exist($servicePayment, 'margin_percent', 0);
		}

		$this->render('payment_type/edit', compact('paymentType', 'services'));
	}

	/**
	 * Update data payment type by id.
	 *
	 * @param $id
	 */
	public function update($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_PAYMENT_TYPE_EDIT);

		if ($this->validate($this->_validation_rules($id))) {
			$paymentType = $this->input->post('payment_type');
			$description = $this->input->post('description');
			$services = $this->input->post('services');

			$this->db->trans_start();

			$this->paymentType->update([
				'payment_type' => $paymentType,
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
				flash('success', "Payment type {$paymentType} successfully updated", 'master/payment-type');
			} else {
				flash('danger', "Update payment type failed, try again or contact administrator");
			}
		}
		$this->edit($id);
	}

	/**
	 * Perform deleting payment type data.
	 *
	 * @param $id
	 */
	public function delete($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_PAYMENT_TYPE_DELETE);

		$paymentType = $this->paymentType->getById($id);

		if ($this->paymentType->delete($id, true)) {
			flash('warning', "Payment type {$paymentType['payment_type']} successfully deleted");
		} else {
			flash('danger', 'Delete payment type failed, try again or contact administrator');
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
			'payment_type' => [
				'trim', 'required', 'max_length[50]', ['payment_exists', function ($input) use ($id) {
					$this->form_validation->set_message('payment_exists', 'The %s has been exist, try another');
					return empty($this->paymentType->getBy([
						'ref_payment_types.payment_type' => $input,
						'ref_payment_types.id!=' => $id
					]));
				}]
			],
			'description' => 'max_length[500]',
		];
	}
}
