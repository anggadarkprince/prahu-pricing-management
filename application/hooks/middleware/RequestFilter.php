<?php

class RequestFilter
{
	/**
	 * Check if incoming request is match with method filters.
	 * see App_Controller method filterRequest()
	 */
	public function filterRequestMethod()
	{
		$CI = get_instance();
		if ($CI->db->table_exists('settings')) {
			$CI->lang->load('menu', get_setting('language'));
		}
		if (is_callable([$CI, 'filterRequest'])) {
			call_user_func([$CI, 'filterRequest']);
		}
	}
}
