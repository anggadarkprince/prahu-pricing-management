<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuotationComponentModel extends App_Model
{
    protected $table = 'quotation_components';

    /**
     * Get base query of table.
     *
     * @return CI_DB_query_builder
     */
    protected function getBaseQuery()
    {
        return parent::getBaseQuery()
            ->select([
                'SUM(quotation_sub_components.price) AS total_price',
            ])
            ->join('quotation_sub_components', 'quotation_sub_components.id_quotation_component = quotation_components.id', 'left')
            ->group_by('quotation_components.id');
    }
}
