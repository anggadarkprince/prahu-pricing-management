<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Container_type
 * @property ContainerTypeModel $containerType
 * @property Exporter $exporter
 */
class Container_type extends App_Controller
{
    /**
     * Container_type constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ContainerTypeModel', 'containerType');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show container type index page.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_TYPE_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $containerTypes = $this->containerType->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Container type', $containerTypes);
        }

        $this->render('container_type/index', compact('containerTypes'));
    }

    /**
     * Show container type data.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_TYPE_VIEW);

        $containerType = $this->containerType->getById($id);

        if (empty($containerType)) {
            redirect('error404');
        }

        $this->render('container_type/view', compact('containerType'));
    }

    /**
     * Show create container type.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_TYPE_CREATE);

        $this->render('container_type/create');
    }

    /**
     * Save new container type data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_TYPE_CREATE);

        if ($this->validate()) {
            $containerType = $this->input->post('container_type');
            $description = $this->input->post('description');

            $save = $this->containerType->create([
                'container_type' => $containerType,
                'description' => $description
            ]);

            if ($save) {
                flash('success', "Container type {$containerType} successfully created", 'master/container-type');
            } else {
                flash('danger', 'Create container type failed, try again or contact administrator');
            }
        }
        $this->create();
    }

    /**
     * Show edit container type form.
     *
     * @param $id
     */
    public function edit($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_TYPE_EDIT);

        $containerType = $this->containerType->getById($id);

        $this->render('container_type/edit', compact('containerType'));
    }

    /**
     * Update data container type by id.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_TYPE_EDIT);

		if ($this->validate($this->_validation_rules($id))) {
            $containerType = $this->input->post('container_type');
            $description = $this->input->post('description');

            $update = $this->containerType->update([
                'container_type' => $containerType,
                'description' => $description
            ], $id);

            if ($update) {
                flash('success', "Container type {$containerType} successfully updated", 'master/container-type');
            } else {
                flash('danger', "Update container type failed, try again or contact administrator");
            }
        }
        $this->edit($id);
    }

    /**
     * Perform deleting container type data.
     *
     * @param $id
     */
    public function delete($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_TYPE_DELETE);

        $containerType = $this->containerType->getById($id);

        if ($this->containerType->delete($id, true)) {
            flash('warning', "Container type {$containerType['container_type']} successfully deleted");
        } else {
            flash('danger', 'Delete container type failed, try again or contact administrator');
        }
        redirect('master/container-type');
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
			'container_type' => [
				'trim', 'required', 'max_length[50]', ['value_exists', function ($value) use ($id) {
					$this->form_validation->set_message('value_exists', 'The %s has been registered before, try another');
					return empty($this->containerType->getBy([
						'ref_container_types.container_type' => $value,
						'ref_container_types.id!=' => $id
					]));
				}]
			],
            'description' => 'max_length[500]',
        ];
    }
}
