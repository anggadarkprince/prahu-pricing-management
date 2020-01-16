<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Setting
 * @property SettingModel $setting
 * @property Uploader $uploader
 */
class Setting extends App_Controller
{
	/**
	 * Setting constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('SettingModel', 'setting');
		$this->load->model('modules/Uploader', 'uploader');
	}

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
		AuthorizationModel::mustAuthorized(PERMISSION_SETTING_EDIT);

		if (_is_method('put')) {
			if ($this->validate()) {
				$settings = $this->input->post();

				$uploadedLogoPath = get_setting('company_logo');
				if (!empty($_FILES['company_logo']['name'])) {
					$uploadLogo = $this->uploader->uploadTo('company_logo', [
						'destination' => 'logo/' . date('Y/m')
					]);
					if ($uploadLogo) {
						$uploadedData = $this->uploader->getUploadedData();
						$uploadedLogoPath = $uploadedData['uploaded_path'];
					} else {
						flash('warning', $this->uploader->getDisplayErrors());
					}
				} else {
					$uploadLogo = true;
				}

				if ($uploadLogo) {
					$this->db->trans_start();

					if (key_exists('_method', $settings)) {
						unset($settings['_method']);
					}

					foreach ($settings as $key => $value) {
						$this->setting->update(['value' => $value], $key);
					}

					$this->setting->update(['value' => $uploadedLogoPath], 'company_logo');

					$this->db->trans_complete();

					if ($this->db->trans_status()) {
						flash('success', 'Settings successfully updated', 'setting');
					} else {
						flash('danger', 'Update setting failed, try again or contact administrator');
					}
				}
			}
		}

		$setting = $this->setting->getAll();

		$this->render('setting/index', compact('setting'));
	}

	/**
	 * General validation rule.
	 *
	 * @return array
	 */
	protected function _validation_rules()
	{
		return [
			'meta_keywords' => 'trim|required|max_length[300]|regex_match[/^[a-zA-Z0-9\-, ]+$/]',
			'meta_description' => 'trim|required|max_length[300]',
			'meta_author' => 'trim|required|max_length[50]',
			'language' => 'trim|required|in_list[english,indonesia]',
			'email_bug_report' => 'trim|required|valid_email|max_length[50]',
			'email_support' => 'trim|required|valid_email|max_length[50]',
			'company_name' => 'trim|required|max_length[50]',
			'company_address' => 'trim|required|max_length[200]',
			'company_contact' => 'trim|required|max_length[100]',
			'api_token' => 'trim|max_length[100]',
		];
	}
}
