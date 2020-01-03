<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Container_size
 * @property ContainerSizeModel $containerSize
 * @property Exporter $exporter
 */
class Container_size extends App_Controller
{
    /**
     * Container_size constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ContainerSizeModel', 'containerSize');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show container size index page.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_SIZE_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $containerSizes = $this->containerSize->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Container size', $containerSizes);
        }

        $this->render('container_size/index', compact('containerSizes'));
    }

    /**
     * Show container size data.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_SIZE_VIEW);

        $containerSize = $this->containerSize->getById($id);

        if (empty($containerSize)) {
            redirect('error404');
        }

        $this->render('container_size/view', compact('containerSize'));
    }

    /**
     * Show create container size.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_SIZE_CREATE);

        $this->render('container_size/create');
    }

    /**
     * Save new container size data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_SIZE_CREATE);

        if ($this->validate()) {
            $containerSize = $this->input->post('container_size');
            $description = $this->input->post('description');

            $save = $this->containerSize->create([
                'container_size' => $containerSize,
                'description' => $description
            ]);

            if ($save) {
                flash('success', "Container size {$containerSize} successfully created", 'master/container-size');
            } else {
                flash('danger', 'Create container size failed, try again or contact administrator');
            }
        }
        $this->create();
    }

    /**
     * Show edit container size form.
     *
     * @param $id
     */
    public function edit($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_SIZE_EDIT);

        $containerSize = $this->containerSize->getById($id);

        $this->render('container_size/edit', compact('containerSize'));
    }

    /**
     * Update data container size by id.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_SIZE_EDIT);

        if ($this->validate()) {
            $containerSize = $this->input->post('container_size');
            $description = $this->input->post('description');

            $update = $this->containerSize->update([
                'container_size' => $containerSize,
                'description' => $description
            ], $id);

            if ($update) {
                flash('success', "Container size {$containerSize} successfully updated", 'master/container-size');
            } else {
                flash('danger', "Update container size failed, try again or contact administrator");
            }
        }
        $this->edit($id);
    }

    /**
     * Perform deleting container size data.
     *
     * @param $id
     */
    public function delete($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_CONTAINER_SIZE_DELETE);

        $containerSize = $this->containerSize->getById($id);

        if ($this->containerSize->delete($id, true)) {
            flash('warning', "Container size {$containerSize['container_size']} successfully deleted");
        } else {
            flash('danger', 'Delete container size failed, try again or contact administrator');
        }
        redirect('master/container-size');
    }

    /**
     * Return general validation rules.
     *
     * @return array
     */
    protected function _validation_rules()
    {
        return [
            'container_size' => 'trim|required|max_length[50]',
            'description' => 'max_length[500]',
        ];
    }
}
