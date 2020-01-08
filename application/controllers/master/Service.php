<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Service
 * @property ServiceModel $service
 * @property ServiceComponentModel $serviceComponent
 * @property ComponentModel $component
 * @property Exporter $exporter
 */
class Service extends App_Controller
{
	/**
	 * Service constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ServiceModel', 'service');
		$this->load->model('ServiceComponentModel', 'serviceComponent');
		$this->load->model('ComponentModel', 'component');
		$this->load->model('modules/Exporter', 'exporter');

		$this->setFilterMethods([
			'ajax_get_service' => 'GET'
		]);
	}

	/**
	 * Show service index page.
	 */
	public function index()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_SERVICE_VIEW);

		$filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

		$export = $this->input->get('export');
		if ($export) unset($filters['page']);

		$services = $this->service->getAll($filters);

		if ($export) {
			$this->exporter->exportFromArray('Components', $services);
		}

		$this->render('service/index', compact('services'));
	}

	/**
	 * Show service data.
	 *
	 * @param $id
	 */
	public function view($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_SERVICE_VIEW);

		$service = $this->service->getById($id);
		$serviceComponents = $this->serviceComponent->getBy([
			'id_service' => $service['id']
		]);

		if (empty($service)) {
			redirect('error404');
		}

		$this->render('service/view', compact('service', 'serviceComponents'));
	}

	/**
	 * Show create service.
	 */
	public function create()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_SERVICE_CREATE);

		$components = $this->component->getAll();

		$this->render('service/create', compact('components'));
	}

	/**
	 * Save new service data.
	 */
	public function save()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_SERVICE_CREATE);

		if ($this->validate()) {
			$service = $this->input->post('service');
			$components = $this->input->post('components');
			$description = $this->input->post('description');

			$this->db->trans_start();

			$this->service->create([
				'service' => $service,
				'description' => $description
			]);
			$serviceId = $this->db->insert_id();

			if (!empty($components)) {
				foreach ($components as $componentId) {
					$this->serviceComponent->create([
						'id_component' => $componentId,
						'id_service' => $serviceId
					]);
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status()) {
				flash('success', "Service {$service} successfully created", 'master/service');
			} else {
				flash('danger', 'Create service failed, try again or contact administrator');
			}
		}
		$this->create();
	}

	/**
	 * Show edit service form.
	 *
	 * @param $id
	 */
	public function edit($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_SERVICE_EDIT);

		$service = $this->service->getById($id);
		$components = $this->component->getAll();
		$serviceComponents = $this->serviceComponent->getBy(['id_service' => $service['id']]);

		foreach ($components as &$component) {
			$selected = array_search($component['id'], array_column($serviceComponents, 'id_component'));
			$component['is_selected'] = $selected !== false;
		}

		$this->render('service/edit', compact('service', 'components'));
	}

	/**
	 * Update data service by id.
	 *
	 * @param $id
	 */
	public function update($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_SERVICE_EDIT);

		if ($this->validate()) {
			$service = $this->input->post('service');
			$components = $this->input->post('components');
			$description = $this->input->post('description');

			$this->db->trans_start();

			$this->service->update([
				'service' => $service,
				'description' => $description
			], $id);

			$this->serviceComponent->delete(['id_service' => $id]);
			if (!empty($components)) {
				foreach ($components as $componentId) {
					$this->serviceComponent->create([
						'id_component' => $componentId,
						'id_service' => $id
					]);
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status()) {
				flash('success', "Service {$service} successfully updated", 'master/service');
			} else {
				flash('danger', "Update service failed, try again or contact administrator");
			}
		}
		$this->edit($id);
	}

	/**
	 * Perform deleting service data.
	 *
	 * @param $id
	 */
	public function delete($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_SERVICE_DELETE);

		$service = $this->service->getById($id);

		if ($this->service->delete($id, true)) {
			flash('warning', "Service {$service['service']} successfully deleted");
		} else {
			flash('danger', 'Delete service failed, try again or contact administrator');
		}
		redirect('master/service');
	}

	/**
	 * Return general validation rules.
	 *
	 * @return array
	 */
	protected function _validation_rules()
	{
		return [
			'service' => 'trim|required|max_length[50]',
			'description' => 'max_length[500]',
		];
	}

	/**
	 * Get service by service
	 *
	 * @return array
	 */
	public function ajax_get_service()
	{
		$serviceId = get_url_param('id_service');

		$service = $this->service->getById($serviceId);
		$serviceComponents = $this->serviceComponent->getBy([
			'id_service' => $service['id']
		]);

		$this->render_json([
			'service' => $service,
			'service_components' => $serviceComponents
		]);
	}
}
