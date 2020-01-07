<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Component_pricing
 * @property ComponentModel $component
 * @property SubComponentModel $package
 * @property PackageModel $package
 * @property PackageSubComponentModel $packageSubComponent
 * @property ComponentPriceModel $componentPrice
 * @property Exporter $exporter
 */
class Component_pricing extends App_Controller
{
    /**
     * Component_pricing constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ComponentModel', 'component');
        $this->load->model('SubComponentModel', 'subComponent');
        $this->load->model('PackageModel', 'package');
        $this->load->model('PackageSubComponentModel', 'packageSubComponent');
        $this->load->model('ComponentPriceModel', 'componentPrice');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show service combination result page.
     */
    public function index()
    {
        $components = $this->component->getAll();
        foreach ($components as &$component) {
            $component['sub_components'] = $this->subComponent->getBy(['ref_component_sub_components.id_component' => $component['id']]);
            $component['packages'] = $this->package->getBy(['ref_packages.id_component' => $component['id']]);
            $component['component_prices'] = $this->componentPrice->getComponentPriceList($component['id']);
        }

        $this->render('report/component_pricing', compact('components'));
    }
}
