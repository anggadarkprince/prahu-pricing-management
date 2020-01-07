<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'component price' => 'master/component-price',
        'create' => 'master/component-price/create'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>

<form action="<?= site_url('master/component-price/save') ?>" method="POST" id="form-component-price">
    <?= _csrf() ?>

    <p class="form-section-title">Pricing Information</p>
    <div class="form-group">
        <label for="component">Component</label>
        <select class="form-control select2" name="component" id="component" data-placeholder="Select component" required style="width: 100%">
            <option value=""></option>
            <?php foreach ($components as $component) : ?>
                <option value="<?= $component['id'] ?>" <?= set_select('component', $component['id']) ?>>
                    <?= $component['component'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?= form_error('component') ?>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="vendor">Vendor</label>
                <select class="form-control select2" name="vendor" id="vendor" data-placeholder="Select vendor" required style="width: 100%">
                    <option value=""></option>
                    <?php foreach ($vendors as $vendor) : ?>
                        <option value="<?= $vendor['id'] ?>" <?= set_select('vendor', $vendor['id']) ?>>
                            <?= $vendor['vendor'] ?> - <?= $vendor['type'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('vendor') ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="location">Location</label>
                <select class="form-control select2" name="location" id="location" data-placeholder="Select location" required style="width: 100%">
                    <option value=""></option>
                    <?php foreach ($locations as $location) : ?>
                        <option value="<?= $location['id'] ?>" <?= set_select('location', $location['id']) ?>>
                            <?= $location['location'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('location') ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="port">Port</label>
                <select class="form-control select2" name="port" id="port" data-placeholder="Select port" required style="width: 100%">
                    <option value=""></option>
                    <?php foreach ($ports as $port) : ?>
                        <option value="<?= $port['id'] ?>" <?= set_select('port', $port['id']) ?>>
                            <?= $port['port'] ?> - <?= $port['code'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('port') ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="port_destination">Port Destination</label>
                <select class="form-control select2" name="port_destination" id="port_destination" data-placeholder="Select port destination" style="width: 100%">
                    <option value="0">No Port Destination</option>
                    <?php foreach ($ports as $port) : ?>
                        <option value="<?= $port['id'] ?>" <?= set_select('port_destination', $port['id']) ?>>
                            <?= $port['port'] ?> - <?= $port['code'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('port_destination') ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="container_size">Container Size</label>
                <select class="form-control select2" name="container_size" id="container_size" data-placeholder="Select container size" required style="width: 100%">
                    <option value=""></option>
                    <?php foreach ($containerSizes as $containerSize) : ?>
                        <option value="<?= $containerSize['id'] ?>" <?= set_select('container_size', $containerSize['id']) ?>>
                            <?= $containerSize['container_size'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('container_size') ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="container_type">Container Type</label>
                <select class="form-control select2" name="container_type" id="container_type" data-placeholder="Select container type" required style="width: 100%">
                    <option value=""></option>
                    <?php foreach ($containerTypes as $containerType) : ?>
                        <option value="<?= $containerType['id'] ?>" <?= set_select('container_type', $containerType['id']) ?>>
                            <?= $containerType['container_type'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('container_type') ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="sub_component">Sub Component</label>
                <select class="form-control select2" name="sub_component" id="sub_component" required data-placeholder="Select sub component" style="width: 100%">
                    <?php foreach ($subComponents as $subComponent) : ?>
                        <option value="<?= $subComponent['id'] ?>" <?= set_select('sub_component', $subComponent['id']) ?>>
                            <?= $subComponent['sub_component'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
                <?= form_error('sub_component') ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control currency" id="price" name="price" required maxlength="50" value="<?= set_value('price') ?>" placeholder="Price amount">
                <?= form_error('price') ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Price description"><?= set_value('description') ?></textarea>
        <?= form_error('description') ?>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center">
        <button onclick="history.back()" type="button" class="btn btn-outline-primary">
            <i class="mdi mdi-arrow-left mr-2"></i>Back
        </button>
        <button type="submit" class="btn btn-success" data-toggle="one-touch">
            Save Price<i class="mdi mdi-content-save-outline ml-2"></i>
        </button>
    </div>
</form>
