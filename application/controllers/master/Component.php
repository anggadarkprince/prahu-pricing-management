<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Component
 * @property ComponentModel $component
 * @property Exporter $exporter
 */
class Component extends App_Controller
{
    /**
     * Component constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ComponentModel', 'component');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show component index page.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $components = $this->component->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Components', $components);
        }

        $this->render('component/index', compact('components'));
    }

    /**
     * Show component data.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_VIEW);

        $component = $this->component->getById($id);

        if (empty($component)) {
            redirect('error404');
        }

        $this->render('component/view', compact('component'));
    }

    /**
     * Show create component.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_CREATE);

        $this->render('component/create');
    }

    /**
     * Save new component data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_CREATE);

        if ($this->validate()) {
            $component = $this->input->post('component');
            $description = $this->input->post('description');

            $save = $this->component->create([
                'component' => $component,
                'description' => $description
            ]);

            if ($save) {
                flash('success', "Component {$component} successfully created", 'master/component');
            } else {
                flash('danger', 'Create component failed, try again or contact administrator');
            }
        }
        $this->create();
    }

    /**
     * Show edit component form.
     *
     * @param $id
     */
    public function edit($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_EDIT);

        $component = $this->component->getById($id);

        $this->render('component/edit', compact('component'));
    }

    /**
     * Update data component by id.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_EDIT);

        if ($this->validate()) {
            $component = $this->input->post('component');
            $description = $this->input->post('description');

            $update = $this->component->update([
                'component' => $component,
                'description' => $description
            ], $id);

            if ($update) {
                flash('success', "Component {$component} successfully updated", 'master/component');
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
        AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_DELETE);

        $component = $this->component->getById($id);

        if ($this->component->delete($id, true)) {
            flash('warning', "Component {$component['component']} successfully deleted");
        } else {
            flash('danger', 'Delete component failed, try again or contact administrator');
        }
        redirect('master/component');
    }

    /**
     * Return general validation rules.
     *
     * @return array
     */
    protected function _validation_rules()
    {
        return [
            'component' => 'trim|required|max_length[50]',
            'description' => 'max_length[500]',
        ];
    }
}
