<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
		foreach ($services as &$service) {
			$service['payment_types'] = $this->servicePaymentType->getBy([
				'id_service' => $service['id']
			]);
		}
		$paymentTypes = $this->paymentType->getAll();

		if ($this->input->get('export')) {
			$this->export($services, $paymentTypes);
		}

		$this->render('report/payment_margin', compact('services', 'paymentTypes'));
	}

	/**
	 * Export report to excel.
	 *
	 * @param $services
	 * @param $paymentTypes
	 */
	private function export($services, $paymentTypes)
	{
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator($this->config->item('app_name'))
			->setLastModifiedBy($this->config->item('app_name'))
			->setTitle('Service Combination');
		$excelWriter = new Xlsx($spreadsheet);
		try {
			$spreadsheet->setActiveSheetIndex(0);
			$activeSheet = $spreadsheet->getActiveSheet();

			$activeSheet->setCellValue('A1', 'No');
			$activeSheet->setCellValue('B1', 'Service');
			$activeSheet->setCellValue('C1', 'Margin / Payment');
			foreach ($paymentTypes as $index => $paymentType) {
				$activeSheet->setCellValueByColumnAndRow(3 + $index, 2, $paymentType['payment_type']);
			}
			$spreadsheet->getActiveSheet()->mergeCells('A1:A2');
			$spreadsheet->getActiveSheet()->mergeCells('B1:B2');
			$spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow('3', 1, 2 + count($paymentTypes), 1);

			$columnIterator = $spreadsheet->getActiveSheet()->getColumnIterator();
			foreach ($columnIterator as $column) {
				$spreadsheet->getActiveSheet()
					->getColumnDimension($column->getColumnIndex())
					->setAutoSize(true);

				$spreadsheet->getActiveSheet()
					->getStyle($column->getColumnIndex() . '1')
					->applyFromArray([
							'fill' => [
								'fillType' => Fill::FILL_SOLID,
								'color' => ['rgb' => '28a745']
							],
							'font' => [
								'bold' => true,
								'color' => ['rgb' => 'FFFFFF']
							]
						]
					);
			}

			$spreadsheet->getActiveSheet()
				->getStyle('A1')
				->getAlignment()
				->setVertical(Alignment::VERTICAL_CENTER);
			$spreadsheet->getActiveSheet()
				->getStyle('B1')
				->getAlignment()
				->setVertical(Alignment::VERTICAL_CENTER);
			$spreadsheet->getActiveSheet()
				->getStyle('C1')
				->getAlignment()
				->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()
				->getStyleByColumnAndRow('3', 2, 2 + count($paymentTypes), 2)
				->applyFromArray([
						'fill' => [
							'fillType' => Fill::FILL_SOLID,
							'color' => ['rgb' => '22b250']
						],
						'font' => [
							'bold' => true,
							'color' => ['rgb' => 'FFFFFF']
						]
					]
				)
				->getAlignment()
				->setHorizontal(Alignment::HORIZONTAL_CENTER);

			foreach ($services as $index => $service) {
				$activeSheet->setCellValue('A' . ($index + 3), $index + 1);
				$activeSheet->getStyle('A' . ($index + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$activeSheet->setCellValue('B' . ($index + 3), $service['service']);
				foreach ($paymentTypes as $innerIndex => $paymentType) {
					$column = $innerIndex + 3;
					$row = $index + 3;
					foreach ($service['payment_types'] as $servicePaymentType) {
						if ($servicePaymentType['id_payment_type'] == $paymentType['id']) {
							$activeSheet->setCellValueByColumnAndRow($column, $row, numerical($servicePaymentType['margin_percent']) . '% / ' . '(Payment ' . numerical($servicePaymentType['payment_percent']) . '%)');
							$spreadsheet->getActiveSheet()
								->getStyleByColumnAndRow($column, $row)
								->getAlignment()
								->setHorizontal(Alignment::HORIZONTAL_CENTER);
						}
					}
				}
			}

			$this->load->helper('download');
			$storeTo = './uploads/temp/Payment Margin.xlsx';
			$excelWriter->save($storeTo);
			force_download($storeTo, null, true);

		} catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
			show_error($e->getMessage());
		}
	}
}
