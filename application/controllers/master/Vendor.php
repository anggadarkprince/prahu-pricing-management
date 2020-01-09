<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Vendor
 * @property VendorModel $vendor
 * @property Exporter $exporter
 */
class Vendor extends App_Controller
{
    /**
     * Vendor constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('VendorModel', 'vendor');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show vendor index page.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_VENDOR_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $vendors = $this->vendor->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Vendors', $vendors);
        }

        $this->render('vendor/index', compact('vendors'));
    }

    /**
     * Show vendor data.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_VENDOR_VIEW);

        $vendor = $this->vendor->getById($id);

        if (empty($vendor)) {
            redirect('error404');
        }

        $this->render('vendor/view', compact('vendor'));
    }

    /**
     * Show create vendor.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_VENDOR_CREATE);

        $this->render('vendor/create');
    }

    /**
     * Save new vendor data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_VENDOR_CREATE);

        if ($this->validate()) {
            $vendor = $this->input->post('vendor');
            $type = $this->input->post('type');
            $termPayment = $this->input->post('term_payment');
            $description = $this->input->post('description');

            $save = $this->vendor->create([
                'vendor' => $vendor,
                'type' => $type,
                'term_payment' => $termPayment,
                'description' => $description
            ]);

            if ($save) {
                flash('success', "Vendor {$vendor} successfully created", 'master/vendor');
            } else {
                flash('danger', 'Create vendor failed, try again or contact administrator');
            }
        }
        $this->create();
    }

    /**
     * Show edit vendor form.
     *
     * @param $id
     */
    public function edit($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_VENDOR_EDIT);

        $vendor = $this->vendor->getById($id);

        $this->render('vendor/edit', compact('vendor'));
    }

    /**
     * Update data vendor by id.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_VENDOR_EDIT);

		if ($this->validate($this->_validation_rules($id))) {
            $vendor = $this->input->post('vendor');
            $type = $this->input->post('type');
            $termPayment = $this->input->post('term_payment');
            $description = $this->input->post('description');

            $update = $this->vendor->update([
                'vendor' => $vendor,
                'type' => $type,
                'term_payment' => $termPayment,
                'description' => $description
            ], $id);

            if ($update) {
                flash('success', "Vendor {$vendor} successfully updated", 'master/vendor');
            } else {
                flash('danger', "Update vendor failed, try again or contact administrator");
            }
        }
        $this->edit($id);
    }

    /**
     * Perform deleting vendor data.
     *
     * @param $id
     */
    public function delete($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_VENDOR_DELETE);

        $vendor = $this->vendor->getById($id);

        if ($this->vendor->delete($id, true)) {
            flash('warning', "Vendor {$vendor['vendor']} successfully deleted");
        } else {
            flash('danger', 'Delete vendor failed, try again or contact administrator');
        }
        redirect('master/vendor');
    }

	/**
	 * Return general validation rules.
	 *
	 * @param array $params
	 * @return array
	 */
    protected function _validation_rules(...$params)
	{
		$id = isset($params[0]) ? $params[0] : 0;
		return [
			'vendor' => [
				'trim', 'required', 'max_length[100]', ['value_exists', function ($input) use ($id) {
					$this->form_validation->set_message('value_exists', 'The %s has been exist, try another');
					return empty($this->vendor->getBy([
						'ref_vendors.vendor' => $input,
						'ref_vendors.id!=' => $id
					]));
				}]
			],
            'type' => 'trim|required|max_length[50]',
            'description' => 'max_length[500]',
        ];
    }
}
