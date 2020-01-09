<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuotationSubComponentModel extends App_Model
{
    protected $table = 'quotation_sub_components';

    /**
     * Get base query of table.
     *
     * @return CI_DB_query_builder
     */
    protected function getBaseQuery()
    {
        return parent::getBaseQuery()
            ->select([
                'quotation_components.component',
            ])
            ->join('quotation_components', 'quotation_components.id = quotation_sub_components.id_quotation_component');
    }
}
