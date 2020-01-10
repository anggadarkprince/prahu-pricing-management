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
                <option value="<?= $component['id'] ?>" <?= set_select('component', $component['id']) ?> data-service-section="<?= $component['service_section'] ?>" data-provider="<?= $component['provider'] ?>">
                    <?= $component['component'] ?> &nbsp; (<?= $component['service_section'] ?> - <?= $component['provider'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <?= form_error('component') ?>
    </div>
    <div class="form-group">
        <label for="vendor">Vendor</label>
        <select class="form-control select2" name="vendor" id="vendor" data-placeholder="Select vendor" required style="width: 100%">
            <option value=""></option>
            <?php foreach ($vendors as $vendor) : ?>
                <option value="<?= $vendor['id'] ?>" <?= set_select('vendor', $vendor['id']) ?> data-type="<?= $vendor['type'] ?>">
                    <?= $vendor['vendor'] ?> - <?= $vendor['type'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?= form_error('vendor') ?>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="location_origin">Location Origin</label>
                <select class="form-control select2" name="location_origin" id="location_origin" data-placeholder="Select origin area" required style="width: 100%">
                    <option value=""></option>
                    <?php foreach ($locations as $location) : ?>
                        <option value="<?= $location['id'] ?>" <?= set_select('location_origin', $location['id']) ?>>
                            <?= $location['location'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('location_origin') ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="location_destination">Location Destination</label>
                <select class="form-control select2" name="location_destination" id="location_destination" data-placeholder="Select destination area" required style="width: 100%">
                    <option value=""></option>
                    <?php foreach ($locations as $location) : ?>
                        <option value="<?= $location['id'] ?>" <?= set_select('location_destination', $location['id']) ?>>
                            <?= $location['location'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('location_destination') ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="port_origin">Port Origin</label>
                <select class="form-control select2" name="port_origin" id="port_origin" data-placeholder="Select port origin" required style="width: 100%">
                    <option value=""></option>
                    <?php foreach ($ports as $port) : ?>
                        <option value="<?= $port['id'] ?>" <?= set_select('port_origin', $port['id']) ?>>
                            <?= $port['port'] ?> - <?= $port['code'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?= form_error('port_origin') ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="port_destination">Port Destination</label>
                <select class="form-control select2" name="port_destination" id="port_destination" data-placeholder="Select port destination" required style="width: 100%">
                    <option value=""></option>
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
        <div class="col-sm-6 col-md-3">
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
        <div class="col-sm-6 col-md-3">
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
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="expired_date">Expired Date</label>
                <input type="text" class="form-control datepicker" id="expired_date" name="expired_date" autocomplete="off" required maxlength="50" value="<?= set_value('expired_date') ?>" placeholder="Price will expired">
                <?= form_error('expired_date') ?>
            </div>
        </div>
    </div>
    <table class="table table-sm responsive mt-3" id="table-sub-component-price">
        <thead>
            <tr>
                <th class="text-md-center">No</td>
                <th>Sub Component</td>
                <th>Price</td>
            </tr>
        </thead>
        <tbody>
            <?php $prices = set_value('prices') ?>
            <?php if (empty($prices)) : ?>
                <tr>
                    <td colspan="3">Select component first</td>
                </tr>
            <?php else : ?>
                <?php foreach ($prices as $index => $price) : ?>
                    <tr>
                        <td class="text-md-center"><?= $index + 1 ?></td>
                        <td><?= $price['sub_component'] ?></td>
                        <td>
                            <input type="hidden" name="prices[<?= $index ?>][id_sub_component]" value="<?= $price['id_sub_component'] ?>" required>
                            <input type="hidden" name="prices[<?= $index ?>][sub_component]" value="<?= $price['sub_component'] ?>" required>
                            <input type="text" class="form-control currency" name="prices[<?= $index ?>][price]" value="<?= $price['price'] ?>" placeholder="<?= $price['sub_component'] ?> price" required>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>

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