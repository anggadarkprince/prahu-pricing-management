<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Service_combination
 * @property ComponentModel $component
 * @property SubComponentModel $package
 * @property PackageModel $package
 * @property PackageSubComponentModel $packageSubComponent
 * @property Exporter $exporter
 */
class Package_combination extends App_Controller
{
    /**
     * Service_combination constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ComponentModel', 'component');
        $this->load->model('SubComponentModel', 'subComponent');
        $this->load->model('PackageModel', 'package');
        $this->load->model('PackageSubComponentModel', 'packageSubComponent');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show service combination result page.
     */
    public function index()
    {
        $components = $this->component->getAll();
        foreach ($components as &$component) {
            $component['sub_components'] = $this->subComponent->getBy([
                'ref_component_sub_components.id_component' => $component['id']
            ]);
            $packages = $this->package->getBy(['ref_packages.id_component' => $component['id']]);
            foreach ($packages as &$package) {
                $package['sub_components'] = $this->packageSubComponent->getBy([
                    'ref_package_sub_components.id_package' => $package['id']
                ]);
            }
            $component['packages'] = $packages;
        }

        $this->render('report/package_combination', compact('components'));
    }
}
