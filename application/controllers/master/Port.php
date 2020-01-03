<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Port
 * @property PortModel $port
 * @property Exporter $exporter
 */
class Port extends App_Controller
{
    /**
     * Port constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PortModel', 'port');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show port index page.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PORT_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $ports = $this->port->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Ports', $ports);
        }

        $this->render('port/index', compact('ports'));
    }

    /**
     * Show port data.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PORT_VIEW);

        $port = $this->port->getById($id);

        if (empty($port)) {
            redirect('error404');
        }

        $this->render('port/view', compact('port'));
    }

    /**
     * Show create port.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PORT_CREATE);

        $this->render('port/create');
    }

    /**
     * Save new port data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PORT_CREATE);

        if ($this->validate()) {
            $code = $this->input->post('code');
            $port = $this->input->post('port');
            $description = $this->input->post('description');

            $save = $this->port->create([
                'code' => $code,
                'port' => $port,
                'description' => $description
            ]);

            if ($save) {
                flash('success', "Port {$port} successfully created", 'master/port');
            } else {
                flash('danger', 'Create port failed, try again or contact administrator');
            }
        }
        $this->create();
    }

    /**
     * Show edit port form.
     *
     * @param $id
     */
    public function edit($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PORT_EDIT);

        $port = $this->port->getById($id);

        $this->render('port/edit', compact('port'));
    }

    /**
     * Update data port by id.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PORT_EDIT);

        if ($this->validate($this->_validation_rules($id))) {
            $code = $this->input->post('code');
            $port = $this->input->post('port');
            $description = $this->input->post('description');

            $update = $this->port->update([
				'code' => $code,
				'port' => $port,
                'description' => $description
            ], $id);

            if ($update) {
                flash('success', "Port {$port} successfully updated", 'master/port');
            } else {
                flash('danger', "Update port failed, try again or contact administrator");
            }
        }
        $this->edit($id);
    }

    /**
     * Perform deleting port data.
     *
     * @param $id
     */
    public function delete($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_PORT_DELETE);

        $port = $this->port->getById($id);

        if ($this->port->delete($id, true)) {
            flash('warning', "Port {$port['name']} successfully deleted");
        } else {
            flash('danger', 'Delete port failed, try again or contact administrator');
        }
        redirect('master/port');
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
			'code' => [
				'trim', 'required', 'max_length[20]', ['code_exists', function ($code) use ($id) {
					$this->form_validation->set_message('code_exists', 'The %s has been registered before, try another');
					return empty($this->port->getBy([
						'ref_ports.code' => $code,
						'ref_ports.id!=' => $id
					]));
				}]
			],
            'port' => 'trim|max_length[50]',
            'description' => 'max_length[500]',
        ];
    }
}
