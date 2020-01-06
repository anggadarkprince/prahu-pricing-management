<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Quotation
 * @property Exporter $exporter
 */
class Quotation extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
		$this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Print quotation.
     */
    public function print_quotation()
    {
		$html = $this->load->view('quotation/print', [], true);

		$this->exporter->exportToPdf("quotation.pdf", $html);
    }
}
