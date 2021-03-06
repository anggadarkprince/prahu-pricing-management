<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Package
 * @property ComponentModel $component
 * @property SubComponentModel $subComponent
 * @property PackageModel $package
 * @property PackageSubComponentModel $packageSubComponent
 * @property Exporter $exporter
 */
class Package extends App_Controller
{
    /**
     * Package constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PackageModel', 'package');
        $this->load->model('ComponentModel', 'component');
        $this->load->model('SubComponentModel', 'subComponent');
        $this->load->model('PackageSubComponentModel', 'packageSubComponent');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show package index page.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PACKAGE_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $packages = $this->package->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Packages', $packages);
        }
        $components = $this->component->getAll();

        $this->render('package/index', compact('packages', 'components'));
    }

    /**
     * Show component data.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PACKAGE_VIEW);

        $package = $this->package->getById($id);
        $packageSubComponents = $this->packageSubComponent->getBy([
            'ref_package_sub_components.id_package' => $id
        ]);

        if (empty($package)) {
            redirect('error404');
        }

        $this->render('package/view', compact('package', 'packageSubComponents'));
    }

    /**
     * Show create component.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PACKAGE_CREATE);

        $components = $this->component->getAll();
        $subComponents = $this->subComponent->getBy([
            'ref_components.id' => $this->input->post('component'),
        ]);

        $this->render('package/create', compact('components', 'subComponents'));
    }

    /**
     * Save new package data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PACKAGE_CREATE);

        if ($this->validate()) {
            $componentId = $this->input->post('component');
            $package = $this->input->post('package');
            $description = $this->input->post('description');
            $subComponents = $this->input->post('sub_components');

            $this->db->trans_start();

            $this->package->create([
                'id_component' => $componentId,
                'package' => $package,
                'description' => $description
            ]);
            $packageId = $this->db->insert_id();

            if (!empty($subComponents)) {
                foreach ($subComponents as $subComponentId) {
                    $this->packageSubComponent->create([
                        'id_package' => $packageId,
                        'id_sub_component' => $subComponentId
                    ]);
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                flash('success', "Package {$package} successfully created", 'master/package');
            } else {
                flash('danger', 'Create package failed, try again or contact administrator');
            }
        }
        $this->create();
    }

    /**
     * Show edit package form.
     *
     * @param $id
     */
    public function edit($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PACKAGE_EDIT);

        $package = $this->package->getById($id);
        $packageSubComponents = $this->packageSubComponent->getBy([
            'ref_package_sub_components.id_package' => $id
        ]);
        $components = $this->component->getAll();
        $subComponents = $this->subComponent->getBy([
            'ref_components.id' => $package['id_component'],
        ]);
        foreach ($subComponents as &$subComponent) {
            $subComponent['is_selected'] = in_array($subComponent['id'], array_column($packageSubComponents, 'id_sub_component'));
        }

        $this->render('package/edit', compact('package', 'components', 'subComponents'));
    }

    /**
     * Update data package by id.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PACKAGE_EDIT);

		if ($this->validate($this->_validation_rules($id))) {
            $componentId = $this->input->post('component');
            $package = $this->input->post('package');
            $description = $this->input->post('description');
            $subComponents = $this->input->post('sub_components');

            $this->db->trans_start();

            $this->package->update([
                'id_component' => $componentId,
                'package' => $package,
                'description' => $description
            ], $id);

            $this->packageSubComponent->delete(['id_package' => $id]);
            if (!empty($subComponents)) {
                foreach ($subComponents as $subComponentId) {
                    $this->packageSubComponent->create([
                        'id_package' => $id,
                        'id_sub_component' => $subComponentId
                    ]);
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                flash('success', "Package {$package} successfully updated", 'master/package');
            } else {
                flash('danger', "Update component failed, try again or contact administrator");
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
        AuthorizationModel::mustAuthorized(PERMISSION_PACKAGE_DELETE);

        $package = $this->package->getById($id);

        if ($this->package->delete($id, true)) {
            flash('warning', "Package {$package['package']} successfully deleted");
        } else {
            flash('danger', 'Delete package failed, try again or contact administrator');
        }
        redirect('master/package');
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
            'component' => 'trim|required',
			'package' => [
				'trim', 'required', 'max_length[50]', ['value_exists', function ($value) use ($id) {
					$this->form_validation->set_message('value_exists', 'The %s has been registered before, try another');
					return empty($this->package->getBy([
						'ref_packages.package' => $value,
						'ref_packages.id!=' => $id
					]));
				}]
			],
			'sub_components[]' => [
				'trim', 'required', ['not_empty', function ($input) {
					$this->form_validation->set_message('not_empty', 'The {field} field must be selected at least one.');
					return !empty($input);
				}]
			],
            'description' => 'max_length[500]',
        ];
    }
}
