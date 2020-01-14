<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Dashboard
 * @property PortModel $port
 * @property VendorModel $vendor
 * @property LocationModel $location
 * @property QuotationModel $quotation
 */
class Dashboard extends App_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('PortModel', 'port');
		$this->load->model('VendorModel', 'vendor');
		$this->load->model('LocationModel', 'location');
		$this->load->model('QuotationModel', 'quotation');
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		$totalPort = $this->port->getTotal();
		$totalVendor = $this->vendor->getTotal();
		$totalLocation = $this->location->getTotal();
		$totalQuotation = $this->quotation->getTotal();

		$movements = [];
		for ($i = 1; $i <= 12; $i++) {
			$movements[$i]['date'] = date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-01';
			$movements[$i]['month'] = format_date($movements[$i]['date'], 'F');
			$movements[$i]['total'] = $this->quotation->getBy([
				'DATE(quotations.created_at)>=' => date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-01',
				'DATE(quotations.created_at)<=' => date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-31',
			], 'COUNT');
		}

		$this->render('dashboard/index', compact('totalPort', 'totalVendor', 'totalLocation', 'totalQuotation', 'movements'));
	}
}
