<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'component price' => 'master/component-price',
        'combination' => 'report/component-pricing'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Component pricing</p>

<?php foreach ($components as $component) : ?>
    <h5 class="text-primary"><?= $component['component'] ?> Component</h5>
    <div class="table-responsive mb-4">
        <table class="table table-sm mb-0 table-hover text-nowrap">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" style="width: 60px">No</th>
                    <th>Vendor</th>
                    <th>Port</th>
                    <th>Port destination</th>
                    <th>Location</th>
                    <th>Container size</th>
                    <th>Container type</th>
                    <?php foreach ($component['sub_components'] as $subComponent) : ?>
                        <th><?= $subComponent['sub_component'] ?></th>
                    <?php endforeach ?>
                    <?php foreach ($component['packages'] as $package) : ?>
                        <th><?= $package['package'] ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($component['component_prices'] as $index => $componentPrice) : ?>
                    <tr>
                        <td class="text-md-center"><?= $index + 1 ?></td>
                        <td><?= $componentPrice['vendor'] ?></td>
                        <td><?= $componentPrice['port'] ?></td>
                        <td><?= $componentPrice['port_destination'] ?></td>
                        <td><?= $componentPrice['location'] ?></td>
                        <td><?= $componentPrice['container_size'] ?></td>
                        <td><?= $componentPrice['container_type'] ?></td>
                        <?php foreach ($component['sub_components'] as $subComponent) : ?>
                            <td>Rp. <?= numerical($componentPrice[$subComponent['sub_component']]) ?></td>
                        <?php endforeach ?>
                        <?php foreach ($component['packages'] as $package) : ?>
                            <td class="table-success px-2"><strong>Rp. <?= numerical($componentPrice[$package['package']]) ?></strong></td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
                <?php if (empty($component['component_prices'])) : ?>
                    <tr>
                        <td colspan="<?= 7 + count($component['sub_components']) + count($component['packages']) ?>">
                            No component price data available
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endforeach ?>