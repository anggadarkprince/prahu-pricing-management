<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
		foreach ($services as &$service) {
			$service['components'] = $this->serviceComponent->getBy([
				'id_service' => $service['id']
			]);
		}
		$components = $this->component->getAll();

		if ($this->input->get('export')) {
			$this->export($services, $components);
		}

		$this->render('report/service_combination', compact('services', 'components'));
	}

	/**
	 * Export report to excel.
	 *
	 * @param $services
	 * @param $components
	 */
	private function export($services, $components)
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
			$activeSheet->setCellValue('C1', 'Components');
			foreach ($components as $index => $component) {
				$activeSheet->setCellValueByColumnAndRow(3 + $index, 2, $component['component']);
			}
			$spreadsheet->getActiveSheet()->mergeCells('A1:A2');
			$spreadsheet->getActiveSheet()->mergeCells('B1:B2');
			$spreadsheet->getActiveSheet()->mergeCellsByColumnAndRow('3', 1, 2 + count($components), 1);

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
				->getStyleByColumnAndRow('3', 2, 2 + count($components), 2)
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
				foreach ($components as $innerIndex => $component) {
					$result = in_array($component['id'], array_column($service['components'], 'id_component')) ? 'YES' : 'NO';
					$column = $innerIndex + 3;
					$row = $index + 3;
					$activeSheet->setCellValueByColumnAndRow($column, $row, $result);
					$spreadsheet->getActiveSheet()
						->getStyleByColumnAndRow($column, $row)
						->applyFromArray([
								'fill' => [
									'fillType' => Fill::FILL_SOLID,
									'color' => ['rgb' => $result == 'YES' ? 'c3e6cb' : 'f5c6cb']
								]
							]
						)
						->getAlignment()
						->setHorizontal(Alignment::HORIZONTAL_CENTER);
				}
			}

			$this->load->helper('download');
			$storeTo = './uploads/temp/Service Combination.xlsx';
			$excelWriter->save($storeTo);
			force_download($storeTo, null, true);

		} catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
			show_error($e->getMessage());
		}
	}

}
