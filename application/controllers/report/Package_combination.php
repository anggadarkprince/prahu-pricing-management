<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Package_combination
 * @property ComponentModel $component
 * @property SubComponentModel $subComponent
 * @property PackageModel $package
 * @property PackageSubComponentModel $packageSubComponent
 * @property Exporter $exporter
 */
class Package_combination extends App_Controller
{
	/**
	 * Package_combination constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ComponentModel', 'component');
		$this->load->model('SubComponentModel', 'subComponent');
		$this->load->model('PackageModel', 'package');
		$this->load->model('PackageSubComponentModel', 'packageSubComponent');
		$this->load->model('modules/Exporter', 'exporter');
	}

	/**
	 * Show package combination result page.
	 */
	public function index()
	{
		$components = $this->component->getAll(['id' => $this->input->get('component')]);
		foreach ($components as &$component) {
			$component['sub_components'] = $this->subComponent->getBy([
				'ref_component_sub_components.id_component' => $component['id']
			]);
			$packages = $this->package->getBy(['ref_packages.id_component' => $component['id']]);
			foreach ($packages as &$package) {
				$package['sub_components'] = $this->packageSubComponent->getBy([
					'ref_package_sub_components.id_package' => $package['id']
				]);
			}
			$component['packages'] = $packages;
		}

		if ($this->input->get('export')) {
			$this->export(end($components));
		}

		$this->render('report/package_combination', compact('components'));
	}

	/**
	 * Export report to excel.
	 *
	 * @param $component
	 */
	private function export($component)
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
			$activeSheet->setCellValue('B1', 'Sub Component');
			foreach ($component['packages'] as $index => $package) {
				$activeSheet->setCellValueByColumnAndRow(3 + $index, 1, $package['package']);
			}

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
				->getStyleByColumnAndRow('3', 1, 2 + count($component['sub_components']), 1)
				->getAlignment()
				->setHorizontal(Alignment::HORIZONTAL_CENTER);

			foreach ($component['sub_components'] as $index => $subComponent) {
				$activeSheet->setCellValue('A' . ($index + 2), $index + 1);
				$activeSheet->getStyle('A' . ($index + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$activeSheet->setCellValue('B' . ($index + 2), $subComponent['sub_component']);
				foreach ($component['packages'] as $innerIndex => $package) {
					$result = in_array($subComponent['id'], array_column($package['sub_components'], 'id_sub_component')) ? 'YES' : 'NO';
					$column = $innerIndex + 3;
					$row = $index + 2;
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
			$activeSheet->setCellValueByColumnAndRow(2, 2 + count($component['sub_components']), 'Total');
			foreach ($component['packages'] as $innerIndex => $package) {
				$activeSheet->setCellValueByColumnAndRow($innerIndex + 3, 2 + count($component['sub_components']), count($package['sub_components']));
			}
			$spreadsheet->getActiveSheet()
				->getStyleByColumnAndRow(1, 2 + count($component['sub_components']), 2 + count($component['packages']), 2 + count($component['sub_components']))
				->applyFromArray([
						'fill' => [
							'fillType' => Fill::FILL_SOLID,
							'color' => ['rgb' => 'ffeeba']
						],
						'font' => [
							'bold' => true
						]
					]
				)
				->getAlignment()
				->setHorizontal(Alignment::HORIZONTAL_CENTER);

			$spreadsheet->getActiveSheet()
				->getStyleByColumnAndRow(2, 2 + count($component['sub_components']))
				->getAlignment()
				->setHorizontal(Alignment::HORIZONTAL_LEFT);

			$this->load->helper('download');
			$storeTo = './uploads/temp/Package Combination.xlsx';
			$excelWriter->save($storeTo);
			force_download($storeTo, null, true);

		} catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
			show_error($e->getMessage());
		}
	}
}
