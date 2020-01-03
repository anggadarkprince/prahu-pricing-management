<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Sub_component
 * @property SubComponentModel $subComponent
 * @property Exporter $exporter
 */
class Sub_component extends App_Controller
{
    /**
     * Sub_component constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SubComponentModel', 'subComponent');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show sub component index page.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_SUB_COMPONENT_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $subComponents = $this->subComponent->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Sub components', $subComponents);
        }

        $this->render('sub_component/index', compact('subComponents'));
    }

    /**
     * Show component data.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_SUB_COMPONENT_VIEW);

        $subComponent = $this->subComponent->getById($id);

        if (empty($subComponent)) {
            redirect('error404');
        }

        $this->render('sub_component/view', compact('subComponent'));
    }

    /**
     * Show create component.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_SUB_COMPONENT_CREATE);

        $this->render('sub_component/create');
    }

    /**
     * Save new sub component data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_SUB_COMPONENT_CREATE);

        if ($this->validate()) {
            $subComponent = $this->input->post('sub_component');
            $description = $this->input->post('description');

            $save = $this->subComponent->create([
                'sub_component' => $subComponent,
                'description' => $description
            ]);

            if ($save) {
                flash('success', "Sub component {$subComponent} successfully created", 'master/sub-component');
            } else {
                flash('danger', 'Create sub component failed, try again or contact administrator');
            }
        }
        $this->create();
    }

    /**
     * Show edit sub component form.
     *
     * @param $id
     */
    public function edit($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_SUB_COMPONENT_EDIT);

        $subComponent = $this->subComponent->getById($id);

        $this->render('sub_component/edit', compact('subComponent'));
    }

    /**
     * Update data sub component by id.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_SUB_COMPONENT_EDIT);

        if ($this->validate()) {
            $subComponent = $this->input->post('sub_component');
            $description = $this->input->post('description');

            $update = $this->subComponent->update([
                'sub_component' => $subComponent,
                'description' => $description
            ], $id);

            if ($update) {
                flash('success', "Sub component {$subComponent} successfully updated", 'master/sub-component');
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
        AuthorizationModel::mustAuthorized(PERMISSION_SUB_COMPONENT_DELETE);

        $subComponent = $this->subComponent->getById($id);

        if ($this->subComponent->delete($id, true)) {
            flash('warning', "Sub component {$subComponent['sub_component']} successfully deleted");
        } else {
            flash('danger', 'Delete sub component failed, try again or contact administrator');
        }
        redirect('master/sub-component');
    }

    /**
     * Return general validation rules.
     *
     * @return array
     */
    protected function _validation_rules()
    {
        return [
            'sub_component' => 'trim|required|max_length[50]',
            'description' => 'max_length[500]',
        ];
    }
}
