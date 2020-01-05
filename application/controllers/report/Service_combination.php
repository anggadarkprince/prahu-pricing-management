<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Service_combination
 * @property ComponentModel $component
 * @property ServiceModel $service
 * @property ServiceComponentModel $serviceComponent
 * @property Exporter $exporter
 */
class Service_combination extends App_Controller
{
    /**
     * Service_combination constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ComponentModel', 'component');
        $this->load->model('ServiceModel', 'service');
        $this->load->model('ServiceComponentModel', 'serviceComponent');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show service combination result page.
     */
    public function index()
    {
        $services = $this->service->getAll();
        foreach($services as &$service) {
            $service['components'] = $this->serviceComponent->getBy([
                'id_service' => $service['id']
            ]);
        }
        $components = $this->component->getAll();

        $this->render('report/service_combination', compact('services', 'components'));
    }

}
