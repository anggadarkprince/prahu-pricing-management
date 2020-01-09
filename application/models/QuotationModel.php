<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QuotationModel extends App_Model
{
	protected $table = 'quotations';

	protected function getBaseQuery()
	{
		/*
		$baseQuery = parent::getBaseQuery()
			->select([
				'SUM(quotation_components.total_sub_component_price) AS total_sub_component',
				'SUM(quotation_components.total_component_price) AS total_component',
				'SUM(quotation_packaging.price) AS total_packaging',
				'SUM(quotation_surcharges.price) AS total_surcharge',
				'SUM(quotation_components.total_component_price)
					+ SUM(quotation_packaging.price)
					+ SUM(quotation_packaging.price)
					+ SUM(quotation_surcharges.price)
					+ insurance
					AS base_amount'
			])
			->join('(
				SELECT
					quotation_components.id,
					quotation_components.id_quotation,
					SUM(quotation_sub_components.price) AS total_sub_component_price,
					SUM(quotation_sub_components.price) + (duration_charge_percent/100 * SUM(quotation_sub_components.price)) AS total_component_price
				FROM quotation_components
				LEFT JOIN quotation_sub_components ON quotation_sub_components.id_quotation_component = quotation_components.id
				GROUP BY quotation_components.id
			) AS quotation_components', 'quotation_components.id_quotation = quotations.id', 'left')
			->join('quotation_packaging', 'quotation_packaging.id_quotation = quotations.id', 'left')
			->join('quotation_surcharges', 'quotation_surcharges.id_quotation = quotations.id', 'left')
			->group_by('quotations.id')
			->get_compiled_select();
		*/
		return $this->db
			->select([
				'quotations.*',
				'(margin_percent/100 * quotations.base_amount) AS total_margin',
				'quotations.base_amount + (margin_percent/100 * quotations.base_amount) AS total_price',
				'tax_percent/100 * (quotations.base_amount + (margin_percent/100 * quotations.base_amount)) AS total_tax',
				'(tax_percent/100 * (quotations.base_amount + (margin_percent/100 * quotations.base_amount))) + quotations.base_amount + (margin_percent/100 * quotations.base_amount) AS total_price_after_tax',
				'payment_percent/100 * ((tax_percent/100 * (quotations.base_amount + (margin_percent/100 * quotations.base_amount))) + quotations.base_amount + (margin_percent/100 * quotations.base_amount)) AS total_payment',
			])
			->from("(
				SELECT 
					quotations.*,
					IFNULL(SUM(quotation_components.total_sub_component_price), 0) AS total_sub_component,
					IFNULL(SUM(quotation_components.total_component_price), 0) AS total_component,
					IFNULL(SUM(quotation_packaging.price), 0) AS total_packaging,
					IFNULL(SUM(quotation_surcharges.price), 0) AS total_surcharge,
					IFNULL(SUM(quotation_components.total_component_price), 0) 
						+ IFNULL(SUM(quotation_packaging.price), 0) 
						+ IFNULL(SUM(quotation_packaging.price), 0) 
						+ IFNULL(SUM(quotation_surcharges.price), 0) 
						+ IFNULL(insurance, 0) AS base_amount
				FROM quotations
				LEFT JOIN (
					SELECT 
						id_quotation,
						SUM(total_sub_component_price) AS total_sub_component_price,
						SUM(total_component_price) AS total_component_price
					FROM (
						SELECT 
							quotation_components.id,
							quotation_components.id_quotation,
							SUM(quotation_sub_components.price) AS total_sub_component_price,
							SUM(quotation_sub_components.price) + (duration_charge_percent/100 * SUM(quotation_sub_components.price)) AS total_component_price
						FROM quotation_components
						LEFT JOIN quotation_sub_components ON quotation_sub_components.id_quotation_component = quotation_components.id
						GROUP BY quotation_components.id
					) AS components
					GROUP BY id_quotation
				) AS quotation_components ON quotation_components.id_quotation = quotations.id
				LEFT JOIN (
					SELECT id_quotation, SUM(price) AS price 
					FROM quotation_packaging
					GROUP BY id_quotation
				) AS quotation_packaging ON quotation_packaging.id_quotation = quotations.id
				LEFT JOIN (
					SELECT id_quotation, SUM(price) AS price 
					FROM quotation_surcharges
					GROUP BY id_quotation
				) AS quotation_surcharges ON quotation_surcharges.id_quotation = quotations.id
				GROUP BY quotations.id
			) AS quotations");
	}
}
