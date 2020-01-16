<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'location' => 'master/location',
        'create' => 'master/location/edit/' . $location['id']
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/location/update/' . $location['id']) ?>" method="POST" id="form-location" class="edit">
    <?= _csrf() ?>
    <?= _method('put') ?>

    <p class="form-section-title">Location Information</p>
    <div class="form-group">
        <label for="port">Port</label>
        <select class="form-control select2" name="port" id="port" required data-placeholder="Select port" style="width: 100%">
            <option value=""></option>
            <?php foreach ($ports as $port) : ?>
                <option value="<?= $port['id'] ?>" <?= set_select('port', $port['id'], $port['id'] == $location['id_port']) ?>>
                    <?= $port['port'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?= form_error('port') ?>
    </div>
    <div class="form-group">
        <label for="location">Location</label>
        <input type="text" class="form-control" id="location" name="location" required maxlength="100" value="<?= set_value('location', $location['location']) ?>" placeholder="Location title">
        <?= form_error('location') ?>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Location description"><?= set_value('description', $location['description']) ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <button type="submit" class="btn btn-primary" data-toggle="one-touch">
            Update Location<i class="mdi mdi-square-edit-outline ml-2"></i>
        </button>
    </div>
</form>