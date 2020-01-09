<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Quotation
 * @property QuotationModel $quotation
 * @property Exporter $exporter
 */
class Quotation extends App_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('QuotationModel', 'quotation');
		$this->load->model('modules/Exporter', 'exporter');

		$this->setFilterMethods([
			'print_quotation' => 'GET'
		]);
	}

	/**
	 * Show quotation index page.
	 */
	public function index()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_QUOTATION_VIEW);

		$filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

		$quotations = $this->quotation->getAll($filters);

		$export = $this->input->get('export');
		if ($export) unset($filters['page']);

		$this->render('quotation/index', compact('quotations'));
	}

	/**
	 * Print quotation.
	 */
	public function print_quotation()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_QUOTATION_VIEW);

		$html = $this->load->view('quotation/print', [], true);

		$this->exporter->exportToPdf("quotation.pdf", $html);
	}
}
