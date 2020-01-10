<div class="modal fade" id="modal-filter" aria-labelledby="modalFilter">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= site_url(uri_string()) ?>" id="form-filter">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFilter">Filter <?= $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" name="search" id="search" value="<?= get_url_param('search') ?>" placeholder="Search a data">
                        <?= form_error('search'); ?>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="components">Components</label>
                                <select class="form-control select2" name="components" id="components" data-placeholder="Select component" style="width: 100%">
                                    <option value=""></option>
                                    <?php foreach ($components as $component) : ?>
                                        <option value="<?= $component['id'] ?>" <?= set_select('components', $component['id'], get_url_param('components') == $component['id']) ?>>
                                            <?= $component['component'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('components') ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="vendor">Vendor</label>
                                <select class="form-control select2" name="vendors" id="vendor" data-placeholder="Select vendor" style="width: 100%">
                                    <option value=""></option>
                                    <?php foreach ($vendors as $vendor) : ?>
                                        <option value="<?= $vendor['id'] ?>" <?= set_select('vendors', $vendor['id'], get_url_param('vendors') == $vendor['id']) ?>>
                                            <?= $vendor['vendor'] ?> - <?= $vendor['type'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('vendors') ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="location_origin">Location Origin</label>
                                <select class="form-control select2" name="location_origins" id="location_origin" data-placeholder="Select location origin" style="width: 100%">
                                    <option value=""></option>
                                    <?php foreach ($locations as $location) : ?>
                                        <option value="<?= $location['id'] ?>" <?= set_select('location_origins', $location['id'], get_url_param('location_origins') == $location['id']) ?>>
                                            <?= $location['location'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('location_origins') ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="location_destination">Location Destination</label>
                                <select class="form-control select2" name="location_destinations" id="location_destination" data-placeholder="Select location destination" style="width: 100%">
                                    <option value=""></option>
                                    <?php foreach ($locations as $location) : ?>
                                        <option value="<?= $location['id'] ?>" <?= set_select('location_destinations', $location['id'], get_url_param('location_destinations') == $location['id']) ?>>
                                            <?= $location['location'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('location_destinations') ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="port_origin">Port Origin</label>
                                <select class="form-control select2" name="port_origins" id="port_origin" data-placeholder="Select port origin" style="width: 100%">
                                    <option value=""></option>
                                    <?php foreach ($ports as $port) : ?>
                                        <option value="<?= $port['id'] ?>" <?= set_select('port_origins', $port['id'], get_url_param('port_origins') == $port['id']) ?>>
                                            <?= $port['port'] ?> - <?= $port['code'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('port_origins') ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="port_destination">Port Destination</label>
                                <select class="form-control select2" name="port_destinations" id="port_destination" data-placeholder="Select port destination" style="width: 100%">
                                    <option value=""></option>
                                    <?php foreach ($ports as $port) : ?>
                                        <option value="<?= $port['id'] ?>" <?= set_select('port_destinations', $port['id'], get_url_param('port_destinations') == $port['id']) ?>>
                                            <?= $port['port'] ?> - <?= $port['code'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('port_destinations') ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="container_size">Container Size</label>
                                <select class="form-control select2" name="container_sizes" id="container_size" data-placeholder="Select container size" style="width: 100%">
                                    <option value=""></option>
                                    <?php foreach ($containerSizes as $containerSize) : ?>
                                        <option value="<?= $containerSize['id'] ?>" <?= set_select('container_sizes', $containerSize['id'], get_url_param('container_sizes') == $containerSize['id']) ?>>
                                            <?= $containerSize['container_size'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('container_sizes') ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="container_type">Container Type</label>
                                <select class="form-control select2" name="container_types" id="container_type" data-placeholder="Select container type" style="width: 100%">
                                    <option value=""></option>
                                    <?php foreach ($containerTypes as $containerType) : ?>
                                        <option value="<?= $containerType['id'] ?>" <?= set_select('container_types', $containerType['id'], get_url_param('container_types') == $containerType['id']) ?>>
                                            <?= $containerType['container_type'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('container_types') ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 col-sm-6">
                            <div class="form-group">
                                <label for="sort_by">Sort By</label>
                                <select class="custom-select" name="sort_by" id="sort_by" required>
                                    <?php
                                    $columns = [
                                        'created_at' => 'CREATED AT',
                                        'component' => 'COMPONENT',
                                        'vendor' => 'VENDOR',
                                        'port' => 'PORT',
                                        'port_destination' => 'PORT DESTINATION',
                                        'location' => 'LOCATION',
                                        'container_size' => 'CONTAINER SIZE',
                                        'container_type' => 'CONTAINER TYPE',
                                        'sub_component' => 'SUB COMPONENT',
                                        'price' => 'PRICE',
                                        'description' => 'DESCRIPTION',
                                    ]
                                    ?>
                                    <?php foreach ($columns as $field => $label) : ?>
                                        <option value="<?= $field ?>" <?= set_select('sort_by', $field, get_url_param('sort_by') == $field) ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('sort_by'); ?>
                            </div>
                        </div>
                        <div class="col-4 col-sm-6">
                            <div class="form-group">
                                <label for="order_method">Order</label>
                                <select class="custom-select" name="order_method" id="order_method" required>
                                    <option value="desc" <?= set_select('order_method', 'desc', get_url_param('order_method') == 'desc') ?>>
                                        DESCENDING
                                    </option>
                                    <option value="asc" <?= set_select('order_method', 'asc', get_url_param('order_method') == 'asc') ?>>
                                        ASCENDING
                                    </option>
                                </select>
                                <?= form_error('order_method'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date_from">Date From</label>
                                <input type="text" class="form-control datepicker" name="date_from" id="date_from" autocomplete="off" value="<?= get_url_param('date_from') ?>" placeholder="Pick create date from">
                                <?= form_error('date_from'); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date_to">Date To</label>
                                <input type="text" class="form-control datepicker" name="date_to" id="date_to" autocomplete="off" value="<?= get_url_param('date_to') ?>" placeholder="Pick create date to">
                                <?= form_error('date_to'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= site_url(uri_string()) ?>" class="btn btn-sm btn-outline-danger">
                        RESET
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal">
                        CLOSE
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        APPLY FILTER
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>