<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Component
 * @property ComponentModel $component
 * @property SubComponentModel $subComponent
 * @property ComponentSubComponentModel $componentSubComponent
 * @property ServiceComponentModel $serviceComponent
 * @property PackageModel $package
 * @property PackageSubComponentModel $packageSubComponent
 * @property ComponentPriceModel $componentPrice
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
        $this->load->model('SubComponentModel', 'subComponent');
        $this->load->model('ComponentSubComponentModel', 'componentSubComponent');
        $this->load->model('ServiceComponentModel', 'serviceComponent');
        $this->load->model('PackageModel', 'package');
        $this->load->model('PackageSubComponentModel', 'packageSubComponent');
        $this->load->model('ComponentPriceModel', 'componentPrice');
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
        $subComponents = $this->subComponent->getBy(['ref_component_sub_components.id_component' => $id]);
        $serviceComponents = $this->serviceComponent->getBy(['ref_service_components.id_component' => $id]);
        $packages = $this->package->getBy(['ref_packages.id_component' => $id]);
        foreach($packages as &$package) {
            $package['sub_components'] = $this->packageSubComponent->getBy([
                'ref_package_sub_components.id_package' => $package['id']
            ]);
        }
        $componentPrices = $this->componentPrice->getComponentPriceList($id);

        if (empty($component)) {
            redirect('error404');
        }

        $this->render('component/view', compact('component', 'subComponents', 'serviceComponents', 'packages', 'componentPrices'));
    }

    /**
     * Show create component.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_CREATE);

        $subComponents = $this->subComponent->getAll();

        $this->render('component/create', compact('subComponents'));
    }

    /**
     * Save new component data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_COMPONENT_CREATE);

        if ($this->validate()) {
            $component = $this->input->post('component');
            $subComponents = $this->input->post('sub_components');
            $provider = $this->input->post('provider');
            $description = $this->input->post('description');

            $this->db->trans_start();

            $this->component->create([
                'component' => $component,
                'provider' => $provider,
                'description' => $description
            ]);
            $componentId = $this->db->insert_id();

            if (!empty($subComponents)) {
                foreach ($subComponents as $subComponentId) {
                    $this->componentSubComponent->create([
                        'id_component' => $componentId,
                        'id_sub_component' => $subComponentId
                    ]);
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
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
        $componentSubComponent = $this->componentSubComponent->getBy([
            'ref_component_sub_components.id_component' => $id
        ]);
        $subComponents = $this->subComponent->getAll();
        foreach ($subComponents as &$subComponent) {
            $subComponent['is_selected'] = in_array($subComponent['id'], array_column($componentSubComponent, 'id_sub_component'));
        }

        $this->render('component/edit', compact('component', 'subComponents'));
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
            $subComponents = $this->input->post('sub_components');
            $provider = $this->input->post('provider');
            $description = $this->input->post('description');

            $this->db->trans_start();

            $this->component->update([
                'component' => $component,
                'provider' => $provider,
                'description' => $description
            ], $id);

            $this->componentSubComponent->delete(['id_component' => $id]);
            if (!empty($subComponents)) {
                foreach ($subComponents as $subComponentId) {
                    $this->componentSubComponent->create([
                        'id_component' => $id,
                        'id_sub_component' => $subComponentId
                    ]);
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
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
