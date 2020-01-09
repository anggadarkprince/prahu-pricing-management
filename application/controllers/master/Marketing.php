<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Marketing
 * @property MarketingModel $marketing
 * @property Exporter $exporter
 */
class Marketing extends App_Controller
{
    /**
     * Marketing constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MarketingModel', 'marketing');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show marketing index page.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_MARKETING_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $marketings = $this->marketing->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Marketing', $marketings);
        }

        $this->render('marketing/index', compact('marketings'));
    }

    /**
     * Show marketing data.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_MARKETING_VIEW);

        $marketing = $this->marketing->getById($id);

        if (empty($marketing)) {
            redirect('error404');
        }

        $this->render('marketing/view', compact('marketing'));
    }

    /**
     * Show create marketing.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_MARKETING_CREATE);

        $this->render('marketing/create');
    }

    /**
     * Save new marketing data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_MARKETING_CREATE);

        if ($this->validate()) {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $contact = $this->input->post('contact');
            $description = $this->input->post('description');

            $save = $this->marketing->create([
                'name' => $name,
                'email' => $email,
                'contact' => $contact,
                'description' => $description
            ]);

            if ($save) {
                flash('success', "Marketing {$name} successfully created", 'master/marketing');
            } else {
                flash('danger', 'Create marketing failed, try again or contact administrator');
            }
        }
        $this->create();
    }

    /**
     * Show edit marketing form.
     *
     * @param $id
     */
    public function edit($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_MARKETING_EDIT);

        $marketing = $this->marketing->getById($id);

        $this->render('marketing/edit', compact('marketing'));
    }

    /**
     * Update data marketing by id.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_MARKETING_EDIT);

		if ($this->validate($this->_validation_rules($id))) {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $contact = $this->input->post('contact');
            $description = $this->input->post('description');

            $update = $this->marketing->update([
                'name' => $name,
                'email' => $email,
                'contact' => $contact,
                'description' => $description
            ], $id);

            if ($update) {
                flash('success', "Marketing {$name} successfully updated", 'master/marketing');
            } else {
                flash('danger', "Update marketing failed, try again or contact administrator");
            }
        }
        $this->edit($id);
    }

    /**
     * Perform deleting marketing data.
     *
     * @param $id
     */
    public function delete($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_MARKETING_DELETE);

        $marketing = $this->marketing->getById($id);

        if ($this->marketing->delete($id, true)) {
            flash('warning', "Marketing {$marketing['name']} successfully deleted");
        } else {
            flash('danger', 'Delete marketing failed, try again or contact administrator');
        }
        redirect('master/marketing');
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
			'name' => [
				'trim', 'required', 'max_length[50]', ['value_exists', function ($input) use ($id) {
					$this->form_validation->set_message('value_exists', 'The %s has been exist, try another');
					return empty($this->marketing->getBy([
						'ref_marketings.name' => $input,
						'ref_marketings.id!=' => $id
					]));
				}]
			],
            'email' => 'trim|max_length[50]',
            'contact' => 'trim|max_length[50]',
            'description' => 'max_length[500]',
        ];
    }
}
