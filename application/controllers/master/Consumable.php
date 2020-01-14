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
		AuthorizationModel::mustAuthorized(PERMISSION_CONSUMABLE_VIEW);

		$filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

		$export = $this->input->get('export');
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
		AuthorizationModel::mustAuthorized(PERMISSION_CONSUMABLE_VIEW);

		$consumable = $this->consumable->getById($id);
		$consumablePrices = $this->consumablePrice->getBy([
			'ref_consumable_prices.id_consumable' => $id,
		]);
		foreach ($consumablePrices as &$consumablePrice) {
			$consumablePrice['components'] = $this->consumablePriceComponent->getBy([
				'ref_consumable_price_components.id_consumable_price' => $consumablePrice['id']
			]);
		}

		if (empty($consumable)) {
			redirect('error404');
		}

		$this->render('consumable/view', compact('consumable', 'consumablePrices'));
	}

	/**
	 * Show create consumable.
	 */
	public function create()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_CONSUMABLE_CREATE);

		$components = $this->component->getBy(['service_section!=' => 'SHIPPING']);
		$containerSizes = $this->containerSize->getAll();

		$this->render('consumable/create', compact('components', 'containerSizes'));
	}

	/**
	 * Save new consumable data.
	 */
	public function save()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_CONSUMABLE_CREATE);

		if ($this->validate()) {
			$consumable = $this->input->post('consumable');
			$type = $this->input->post('type');
			$expiredDate = $this->input->post('expired_date');
			$description = $this->input->post('description');
			$containerSizes = $this->input->post('container_sizes');

			$this->db->trans_start();

			$this->consumable->create([
				'consumable' => $consumable,
				'type' => $type,
				'description' => $description
			]);
			$consumableId = $this->db->insert_id();

			if (!empty($containerSizes)) {
				if ($type == ConsumableModel::TYPE_PACKAGING) {
					foreach ($containerSizes as $containerSizeId => $price) {
						$this->consumablePrice->create([
							'id_consumable' => $consumableId,
							'id_container_size' => $containerSizeId,
							'price' => extract_number($price['price']),
							'expired_date' => format_date($expiredDate),
						]);
					}
				} else {
					foreach ($containerSizes as $containerSizeId => $price) {
						$this->consumablePrice->create([
							'id_consumable' => $consumableId,
							'id_container_size' => $containerSizeId,
							'percent' => $price['percent'],
							'expired_date' => format_date($expiredDate),
						]);
						$consumablePriceId = $this->db->insert_id();
						if (isset($price['components']) && !empty($price['components'])) {
							foreach ($price['components'] as $consumableComponent) {
								$this->consumablePriceComponent->create([
									'id_consumable_price' => $consumablePriceId,
									'id_component' => $consumableComponent
								]);
							}
						}
					}
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status()) {
				flash('success', "Consumable {$consumable} successfully created", 'master/consumable');
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
		AuthorizationModel::mustAuthorized(PERMISSION_CONSUMABLE_EDIT);

		$consumable = $this->consumable->getById($id);
		$components = $this->component->getBy(['service_section!=' => 'SHIPPING']);
		$containerSizes = $this->containerSize->getAll();

		foreach ($containerSizes as &$containerSize) {
			$consumablePrice = $this->consumablePrice->getBy([
				'ref_consumable_prices.id_consumable' => $id,
				'ref_consumable_prices.id_container_size' => $containerSize['id'],
			], true);
			if (empty($consumablePrice)) {
				$containerSize['price'] = 0;
				$containerSize['percent'] = 0;
				$containerSize['components'] = [];
			} else {
				$containerSize['price'] = $consumablePrice['price'];
				$containerSize['percent'] = $consumablePrice['percent'];

				$containerSize['components'] = $this->consumablePriceComponent->getBy([
					'ref_consumable_price_components.id_consumable_price' => $consumablePrice['id']
				]);
			}
		}

		$this->render('consumable/edit', compact('consumable', 'components', 'containerSizes'));
	}

	/**
	 * Update data consumable by id.
	 *
	 * @param $id
	 */
	public function update($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_CONSUMABLE_EDIT);

		if ($this->validate($this->_validation_rules($id))) {
			$consumable = $this->input->post('consumable');
			$type = $this->input->post('type');
			$expiredDate = $this->input->post('expired_date');
			$description = $this->input->post('description');
			$containerSizes = $this->input->post('container_sizes');

			$this->db->trans_start();

			$this->consumable->update([
				'consumable' => $consumable,
				'type' => $type,
				'description' => $description
			], $id);

			$this->consumablePrice->delete(['id_consumable' => $id]);
			if (!empty($containerSizes)) {
				if ($type == ConsumableModel::TYPE_PACKAGING) {
					foreach ($containerSizes as $containerSizeId => $price) {
						$this->consumablePrice->create([
							'id_consumable' => $id,
							'id_container_size' => $containerSizeId,
							'price' => extract_number($price['price']),
							'expired_date' => format_date($expiredDate),
						]);
					}
				} else {
					foreach ($containerSizes as $containerSizeId => $price) {
						$this->consumablePrice->create([
							'id_consumable' => $id,
							'id_container_size' => $containerSizeId,
							'percent' => $price['percent'],
							'expired_date' => format_date($expiredDate),
						]);
						$consumablePriceId = $this->db->insert_id();
						if (isset($price['components']) && !empty($price['components'])) {
							foreach ($price['components'] as $consumableComponent) {
								$this->consumablePriceComponent->create([
									'id_consumable_price' => $consumablePriceId,
									'id_component' => $consumableComponent
								]);
							}
						}
					}
				}
			}

			$this->db->trans_complete();

			if ($this->db->trans_status()) {
				flash('success', "Consumable {$consumable} successfully updated", 'master/consumable');
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
		AuthorizationModel::mustAuthorized(PERMISSION_CONSUMABLE_DELETE);

		$consumable = $this->consumable->getById($id);

		if ($this->consumable->delete($id, true)) {
			flash('warning', "Consumable {$consumable['consumable']} successfully deleted");
		} else {
			flash('danger', 'Delete consumable failed, try again or contact administrator');
		}
		redirect('master/consumable');
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
				'trim', 'required', 'max_length[50]', ['consumable_exists', function ($input) use ($id) {
					$this->form_validation->set_message('consumable_exists', 'The %s has been exist, try another');
					return empty($this->consumable->getBy([
						'ref_consumables.consumable' => $input,
						'ref_consumables.id!=' => $id
					]));
				}]
			],
			'type' => 'max_length[50]|in_list[PACKAGING,ACTIVITY DURATION]',
			'description' => 'max_length[500]',
		];
	}
}
