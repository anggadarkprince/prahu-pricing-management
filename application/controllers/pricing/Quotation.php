<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Quotation
 * @property QuotationModel $quotation
 * @property QuotationComponentModel $quotationComponent
 * @property QuotationSubComponentModel $quotationSubComponent
 * @property QuotationPackagingModel $quotationPackaging
 * @property QuotationSurchargeModel $quotationSurcharge
 * @property Exporter $exporter
 */
class Quotation extends App_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('QuotationModel', 'quotation');
		$this->load->model('QuotationComponentModel', 'quotationComponent');
		$this->load->model('QuotationSubComponentModel', 'quotationSubComponent');
		$this->load->model('QuotationPackagingModel', 'quotationPackaging');
		$this->load->model('QuotationSurchargeModel', 'quotationSurcharge');
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

		$export = $this->input->get('export');
		if ($export) unset($filters['page']);

		$quotations = $this->quotation->getAll($filters);

		if ($export) {
			$this->exporter->exportFromArray('Quotaions', $quotations);
		}

		$this->render('quotation/index', compact('quotations'));
	}

	/**
	 * Show quotation data.
	 *
	 * @param $id
	 */
	public function view($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_QUOTATION_VIEW);

		$quotation = $this->quotation->getById($id);
		$quotationComponents = $this->quotationComponent->getBy([
			'quotation_components.id_quotation' => $id
		]);
		foreach($quotationComponents as &$quotationComponent) {
			$quotationComponent['sub_components'] = $this->quotationSubComponent->getBy([
				'quotation_sub_components.id_quotation_component' => $quotationComponent['id']
			]);
		}
		$quotationPackaging = $this->quotationPackaging->getBy([
			'quotation_packaging.id_quotation' => $id
		]);
		$quotationSurcharges = $this->quotationSurcharge->getBy([
			'quotation_surcharges.id_quotation' => $id
		]);

		if (empty($quotation)) {
			redirect('error404');
		}

		$this->render('quotation/view', compact('quotation', 'quotationComponents', 'quotationPackaging', 'quotationSurcharges'));
	}

	/**
	 * Print quotation.
	 * @param $id
	 */
	public function print_quotation($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_QUOTATION_VIEW);

		$quotation = $this->quotation->getById($id);
		$quotationComponents = $this->quotationComponent->getBy([
			'quotation_components.id_quotation' => $id
		]);
		$quotationSubComponents = $this->quotationSubComponent->getBy([
			'quotation_components.id_quotation' => $id
		]);
		$quotationPackaging = $this->quotationPackaging->getBy([
			'quotation_packaging.id_quotation' => $id
		]);
		$quotationExcludes = [];
		if ($quotation['tax_percent'] <= 0) {
			$quotationExcludes[] = 'Pajak';
		}
		if ($quotation['insurance'] <= 0) {
			$quotationExcludes[] = 'Insurance';
		}
		if (empty($quotationPackaging)) {
			$quotationExcludes[] = 'Packaging';
		}
		$html = $this->load->view('quotation/print', compact('quotation', 'quotationSubComponents', 'quotationPackaging', 'quotationComponents', 'quotationExcludes'), true);

		$this->exporter->exportToPdf("quotation.pdf", $html);
	}

	/**
	 * Perform deleting quotation data.
	 *
	 * @param $id
	 */
	public function delete($id)
	{
		AuthorizationModel::mustAuthorized(PERMISSION_QUOTATION_DELETE);

		$quotation = $this->quotation->getById($id);

		if ($this->quotation->delete($id, true)) {
			flash('warning', "Port {$quotation['quotation']} successfully deleted");
		} else {
			flash('danger', 'Delete quotation failed, try again or contact administrator');
		}
		redirect('pricing/quotation');
	}
}
