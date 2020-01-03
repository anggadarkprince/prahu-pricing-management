<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'role' => 'master/role',
        'edit' => 'master/role/edit/' . $role['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/role/update/' . $role['id']) ?>" method="POST" id="form-role" class="edit">
    <?= _csrf() ?>
    <?= _method('put') ?>

    <p class="form-section-title">Role Information</p>
    <div class="form-group">
        <label for="role">Role Name</label>
        <input type="text" class="form-control" id="role" name="role" required maxlength="50"
               value="<?= set_value('role', $role['role']) ?>" placeholder="Enter a role name">
        <?= form_error('role') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500"
                  placeholder="Enter role description"><?= set_value('description', $role['description']) ?></textarea>
        <?= form_error('description') ?>
    </div>

    <p class="form-section-title">Permissions</p>
    <p class="text-muted mb-0">Role at least must has one permission</p>

    <div class="form-group">
        <div class="row">
            <?php $lastGroup = '' ?>
            <?php $lastSubGroup = '' ?>
            <?php foreach ($permissions as $permission): ?>
                <?php
                $hasPermission = false;
                foreach ($rolePermissions as $rolePermission) {
                    if ($permission['id'] == $rolePermission['id_permission']) {
                        $hasPermission = true;
                        break;
                    }
                }
                ?>

                <?php
                $module = $permission['module'];
                $submodule = $permission['submodule'];
                ?>

                <?php if($lastGroup != $module): ?>
                    <?php
                    $lastGroup = $module;
                    $lastGroupName = preg_replace('/ /', '_', $lastGroup);
                    ?>
                    <div class="col-12 mt-3">
                        <hr>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input check_all"
                                   id="check_all_<?= $lastGroupName ?>" name="check_all_<?= $lastGroupName ?>"
                                   value="<?= $lastGroupName ?>"<?= set_checkbox('check_all_'.$lastGroupName, $lastGroupName) ?>>
                            <label class="custom-control-label" for="check_all_<?= $lastGroupName ?>">
                                Module <?= ucwords($lastGroup) ?> (Check All)
                            </label>
                        </div>
                        <hr>
                    </div>
                <?php endif; ?>

                <?php if($lastSubGroup != $submodule): ?>
                    <?php $lastSubGroup = $submodule; ?>
                    <div class="col-12">
                        <div class="mb-2 mt-2">
                            <h6>
                                <?= ucwords(preg_replace('/\-/', ' ', $lastSubGroup)) ?>
                            </h6>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input <?= $lastGroupName ?>"
                                   id="permission_<?= $permission['id'] ?>" name="permissions[]"
                                   value="<?= $permission['id'] ?>"<?= set_checkbox('permissions[]', $permission['id'], $hasPermission) ?>>
                            <label class="custom-control-label" for="permission_<?= $permission['id'] ?>">
                                <?= ucwords(preg_replace('/(_|\-)/', ' ', $permission['permission'])) ?>
                            </label>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?= form_error('permissions[]'); ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
			<i class="mdi mdi-arrow-left mr-2"></i>Back
		</button>
        <button type="submit" class="btn btn-primary" data-toggle="one-touch">
			Update Role<i class="mdi mdi-square-edit-outline ml-2"></i>
		</button>
    </div>
</form>
