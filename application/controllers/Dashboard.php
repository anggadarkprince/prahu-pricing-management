<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Dashboard
 * @property PortModel $port
 * @property VendorModel $vendor
 * @property LocationModel $location
 */
class Dashboard extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('PortModel', 'port');
        $this->load->model('VendorModel', 'vendor');
        $this->load->model('LocationModel', 'location');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $totalPort = $this->port->getTotal();
        $totalVendor = $this->vendor->getTotal();
        $totalLocation = $this->location->getTotal();

        $this->render('dashboard/index', compact('totalPort', 'totalVendor', 'totalLocation'));
    }
}
