<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Payment_margin
 * @property PaymentTypeModel $paymentType
 * @property ServiceModel $service
 * @property ServicePaymentTypeModel $servicePaymentType
 * @property Exporter $exporter
 */
class Payment_margin extends App_Controller
{
    /**
     * Payment_margin constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PaymentTypeModel', 'paymentType');
        $this->load->model('ServiceModel', 'service');
        $this->load->model('ServicePaymentTypeModel', 'servicePaymentType');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show payment margin page.
     */
    public function index()
    {
        $services = $this->service->getAll();
        foreach($services as &$service) {
            $service['payment_types'] = $this->servicePaymentType->getBy([
                'id_service' => $service['id']
            ]);
        }
        $paymentTypes = $this->paymentType->getAll();

        $this->render('report/payment_margin', compact('services', 'paymentTypes'));
    }

}
