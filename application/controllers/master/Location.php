<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Location
 * @property LocationModel $location
 * @property Exporter $exporter
 */
class Location extends App_Controller
{
    /**
     * Location constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LocationModel', 'location');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show location index page.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $locations = $this->location->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Locations', $locations);
        }

        $this->render('location/index', compact('locations'));
    }

    /**
     * Show location data.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_VIEW);

        $location = $this->location->getById($id);

        if (empty($location)) {
            redirect('error404');
        }

        $this->render('location/view', compact('location'));
    }

    /**
     * Show create location.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_CREATE);

        $this->render('location/create');
    }

    /**
     * Save new location data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_CREATE);

        if ($this->validate()) {
            $location = $this->input->post('location');
            $description = $this->input->post('description');

            $save = $this->location->create([
                'location' => $location,
                'description' => $description
            ]);

            if ($save) {
                flash('success', "Location {$location} successfully created", 'master/location');
            } else {
                flash('danger', 'Create location failed, try again or contact administrator');
            }
        }
        $this->create();
    }

    /**
     * Show edit location form.
     *
     * @param $id
     */
    public function edit($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_EDIT);

        $location = $this->location->getById($id);

        $this->render('location/edit', compact('location'));
    }

    /**
     * Update data location by id.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_EDIT);

        if ($this->validate($this->_validation_rules($id))) {
            $location = $this->input->post('location');
            $description = $this->input->post('description');

            $update = $this->location->update([
				'location' => $location,
                'description' => $description
            ], $id);

            if ($update) {
                flash('success', "Location {$location} successfully updated", 'master/location');
            } else {
                flash('danger', "Update location failed, try again or contact administrator");
            }
        }
        $this->edit($id);
    }

    /**
     * Perform deleting location data.
     *
     * @param $id
     */
    public function delete($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOCATION_DELETE);

        $location = $this->location->getById($id);

        if ($this->location->delete($id, true)) {
            flash('warning', "Location {$location['location']} successfully deleted");
        } else {
            flash('danger', 'Delete location failed, try again or contact administrator');
        }
        redirect('master/location');
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
			'location' => [
				'trim', 'required', 'max_length[50]', ['value_exists', function ($value) use ($id) {
					$this->form_validation->set_message('value_exists', 'The %s has been registered before, try another');
					return empty($this->location->getBy([
						'ref_locations.location' => $value,
						'ref_locations.id!=' => $id
					]));
				}]
			],
            'description' => 'max_length[500]',
        ];
    }
}
