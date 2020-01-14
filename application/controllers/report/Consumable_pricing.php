<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Consumable_pricing
 * @property ConsumableModel $consumable
 * @property ConsumablePriceModel $consumablePrice
 * @property ConsumablePriceComponentModel $consumablePriceComponent
 * @property ContainerSizeModel $containerSize
 * @property Exporter $exporter
 */
class Consumable_pricing extends App_Controller
{
    /**
     * Consumable_pricing constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ConsumableModel', 'consumable');
        $this->load->model('ConsumablePriceModel', 'consumablePrice');
        $this->load->model('ConsumablePriceComponentModel', 'consumablePriceComponent');
        $this->load->model('ContainerSizeModel', 'containerSize');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show consumable pricing page.
     */
    public function index()
    {
        $consumables = $this->consumable->getAll();
        foreach ($consumables as &$consumable) {
            $consumable['consumable_prices'] = $this->consumablePrice->getBy([
                'ref_consumable_prices.id_consumable' => $consumable['id'],
            ]);
            foreach ($consumable['consumable_prices'] as &$consumablePrice) {
                $consumablePrice['components'] = $this->consumablePriceComponent->getBy([
                    'ref_consumable_price_components.id_consumable_price' => $consumablePrice['id']
                ]);
            }
        }
        $containerSizes = $this->containerSize->getAll();

		if ($this->input->get('export')) {
			$this->export($consumables, $containerSizes);
		}

        $this->render('report/consumable_pricing', compact('consumables', 'containerSizes'));
    }

	/**
	 * Export report to excel.
	 *
	 * @param $consumables
	 * @param $containerSizes
	 */
	private function export($consumables, $containerSizes)
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
			$activeSheet->setCellValue('B1', 'Consumable');
			$activeSheet->setCellValue('C1', 'Description');
			foreach ($containerSizes as $index => $containerSize) {
				$activeSheet->setCellValueByColumnAndRow(4 + $index, 1, $containerSize['container_size']);
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
				->getStyleByColumnAndRow('4', 1, 3 + count($containerSizes), 1)
				->getAlignment()
				->setHorizontal(Alignment::HORIZONTAL_CENTER);

			foreach ($consumables as $index => $consumable) {
				$activeSheet->setCellValue('A' . ($index + 2), $index + 1);
				$activeSheet->getStyle('A' . ($index + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$activeSheet->setCellValue('B' . ($index + 2), $consumable['consumable']);
				$activeSheet->setCellValue('C' . ($index + 2), $consumable['description']);
				foreach ($containerSizes as $innerIndex => $containerSize) {
					$column = $innerIndex + 4;
					$row = $index + 2;
					foreach ($consumable['consumable_prices'] as $consumablePrice) {
						if ($consumablePrice['id_container_size'] == $containerSize['id']) {
							if ($consumable['type'] == ConsumableModel::TYPE_PACKAGING) {
								$activeSheet->setCellValueByColumnAndRow($column, $row, 'Rp. ' . numerical($consumablePrice['price']));
							} else {
								$activeSheet->setCellValueByColumnAndRow($column, $row, numerical($consumablePrice['percent']) . '% ' . implode(', ', array_column($consumablePrice['components'], 'component')));
							}
							$spreadsheet->getActiveSheet()
								->getStyleByColumnAndRow($column, $row)
								->getAlignment()
								->setHorizontal(Alignment::HORIZONTAL_CENTER);
						}
					}
				}
			}

			$this->load->helper('download');
			$storeTo = './uploads/temp/Consumable Pricing.xlsx';
			$excelWriter->save($storeTo);
			force_download($storeTo, null, true);

		} catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
			show_error($e->getMessage());
		}
	}
}
