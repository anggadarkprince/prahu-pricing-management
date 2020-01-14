<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Loading_category
 * @property LoadingCategoryModel $loadingCategory
 * @property Exporter $exporter
 */
class Loading_category extends App_Controller
{
    /**
     * Loading_category constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LoadingCategoryModel', 'loadingCategory');
        $this->load->model('modules/Exporter', 'exporter');
    }

    /**
     * Show loading category index page.
     */
    public function index()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOADING_CATEGORY_VIEW);

        $filters = array_merge($_GET, ['page' => get_url_param('page', 1)]);

        $export = $this->input->get('export');
        if ($export) unset($filters['page']);

        $loadingCategories = $this->loadingCategory->getAll($filters);

        if ($export) {
            $this->exporter->exportFromArray('Loading Categories', $loadingCategories);
        }

        $this->render('loading_category/index', compact('loadingCategories'));
    }

    /**
     * Show loading category data.
     *
     * @param $id
     */
    public function view($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOADING_CATEGORY_VIEW);

        $loadingCategory = $this->loadingCategory->getById($id);

        if (empty($loadingCategory)) {
            redirect('error404');
        }

        $this->render('loading_category/view', compact('loadingCategory'));
    }

    /**
     * Show create loading category.
     */
    public function create()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOADING_CATEGORY_CREATE);

        $this->render('loading_category/create');
    }

    /**
     * Save new loading category data.
     */
    public function save()
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOADING_CATEGORY_CREATE);

        if ($this->validate()) {
            $loadingCategory = $this->input->post('loading_category');
            $description = $this->input->post('description');

            $save = $this->loadingCategory->create([
                'loading_category' => $loadingCategory,
                'description' => $description
            ]);

            if ($save) {
                flash('success', "Loading category {$loadingCategory} successfully created", 'master/loading-category');
            } else {
                flash('danger', 'Create loading category failed, try again or contact administrator');
            }
        }
        $this->create();
    }

    /**
     * Show edit loading category form.
     *
     * @param $id
     */
    public function edit($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOADING_CATEGORY_EDIT);

        $loadingCategory = $this->loadingCategory->getById($id);

        $this->render('loading_category/edit', compact('loadingCategory'));
    }

    /**
     * Update data loading category by id.
     *
     * @param $id
     */
    public function update($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOADING_CATEGORY_EDIT);

        if ($this->validate($this->_validation_rules($id))) {
            $loadingCategory = $this->input->post('loading_category');
            $description = $this->input->post('description');

            $update = $this->loadingCategory->update([
				'loading_category' => $loadingCategory,
                'description' => $description
            ], $id);

            if ($update) {
                flash('success', "Location {$loadingCategory} successfully updated", 'master/loading-category');
            } else {
                flash('danger', "Update loading category failed, try again or contact administrator");
            }
        }
        $this->edit($id);
    }

    /**
     * Perform deleting loading category data.
     *
     * @param $id
     */
    public function delete($id)
    {
        AuthorizationModel::mustAuthorized(PERMISSION_LOADING_CATEGORY_DELETE);

        $loadingCategory = $this->loadingCategory->getById($id);

        if ($this->loadingCategory->delete($id, true)) {
            flash('warning', "Loading category {$loadingCategory['loading_category']} successfully deleted");
        } else {
            flash('danger', 'Delete loading category failed, try again or contact administrator');
        }
        redirect('master/loading-category');
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
			'loading_category' => [
				'trim', 'required', 'max_length[100]', ['value_exists', function ($input) use ($id) {
					$this->form_validation->set_message('value_exists', 'The %s has been exist, try another');
					return empty($this->loadingCategory->getBy([
						'ref_loading_categories.loading_category' => $input,
						'ref_loading_categories.id!=' => $id
					]));
				}]
			],
            'description' => 'max_length[500]',
        ];
    }
}
