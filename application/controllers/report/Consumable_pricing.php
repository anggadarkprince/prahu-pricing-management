<?php
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

        $this->render('report/consumable_pricing', compact('consumables', 'containerSizes'));
    }
}
