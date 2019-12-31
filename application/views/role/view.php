<?php $this->load->view('components/_breadcrumb', [
    'breadcrumbs' => [
        'role' => 'master/role',
        'view' => 'master/role/view/' . $role['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Role Information</p>

<form class="form-plaintext">
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="role">Role Name</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="role">
                <?= if_empty($role['role'], 'No role') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="description">Description</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="description">
                <?= if_empty($role['description'], 'No description') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="created_at">Created At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="created_at">
                <?= format_date($role['created_at'], 'd F Y H:i') ?>
            </p>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-lg-2 col-form-label" for="updated_at">Updated At</label>
        <div class="col-sm-9 col-lg-10">
            <p class="form-control-plaintext" id="updated_at">
                <?= if_empty(format_date($role['updated_at'], 'd F Y H:i'), '-') ?>
            </p>
        </div>
    </div>

    <p class="form-section-title mb-0">Permissions</p>

    <div class="form-group">
        <div class="row">
            <?php $lastGroup = '' ?>
            <?php $lastSubGroup = '' ?>
            <?php foreach ($permissions as $permission): ?>
                <?php
                $module = $permission['module'];
                $submodule = $permission['submodule'];
                ?>

                <?php if($lastGroup != $module): ?>
                    <?php
                    $lastGroup = $module;
                    $lastGroupName = preg_replace('/ /', '_', $lastGroup);
                    ?>
                    <div class="col-12">
                        <hr>
                        <h6 class="mt-2">
                            Module <?= ucwords($lastGroup) ?>
                        </h6>
                        <hr class="mb-0">
                    </div>
                <?php endif; ?>

                <?php if($lastSubGroup != $submodule): ?>
                    <?php $lastSubGroup = $submodule; ?>
                    <div class="col-12">
                        <div class="mb-2 mt-3">
                            <h6>
                                <?= ucwords(preg_replace('/\-/', ' ', $lastSubGroup)) ?>
                            </h6>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-sm-4">
                    <p class="mb-0">
                        <?= ucwords(preg_replace('/(_|\-)/', ' ', $permission['permission'])) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        <?= form_error('permissions[]'); ?>
    </div>

    <hr class="mt-5">

    <div class="d-flex justify-content-between mt-4">
		<button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
        <?php if(AuthorizationModel::isAuthorized(PERMISSION_ROLE_EDIT)): ?>
			<button type="submit" class="btn btn-primary">
				Edit Role<i class="mdi mdi-square-edit-outline ml-2"></i>
			</button>
        <?php endif; ?>
    </div>
</form>
