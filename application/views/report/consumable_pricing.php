<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'consumable' => 'master/consumable',
        'pricing' => 'report/consumable-pricing'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Consumable pricing</p>

<table class="table table-sm mt-3 table-hover responsive">
    <thead class="thead-dark">
        <tr class="bg-primary text-white">
            <th class="text-md-center">No</th>
            <th>Consumable</th>
            <th>Description</th>
            <?php foreach ($containerSizes as $containerSize) : ?>
                <th class="text-md-center"><?= $containerSize['container_size'] ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($consumables as $index => $consumable) : ?>
            <tr>
                <td class="text-md-center"><?= $index + 1 ?></td>
                <td class="font-weight-bold">
                    <a href="<?= site_url('master/consumable/view/' . $consumable['id']) ?>">
                        <?= $consumable['consumable'] ?>
                    </a>
                </td>
                <td><?= if_empty($consumable['description'], '-') ?></td>
                <?php foreach ($containerSizes as $containerSize) : ?>
                    <td class="text-md-center">
                        <?php foreach ($consumable['consumable_prices'] as $consumablePrice) : ?>
                            <?php if ($consumablePrice['id_container_size'] == $containerSize['id']) : ?>
                                <?php if ($consumable['type'] == ConsumableModel::TYPE_PACKAGING) : ?>
                                    Rp. <?= numerical($consumablePrice['price']) ?>
                                <?php else : ?>
                                    <?= numerical($consumablePrice['percent']) ?>%
                                    <?= implode(', ', array_column($consumablePrice['components'], 'component')) ?>
                                <?php endif; ?>
                            <?php endif ?>
                        <?php endforeach ?>
                    </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
        <?php if (empty($consumables)) : ?>
            <tr>
                <td colspan="<?= 3 + count($containerSizes) ?>">
                    No consumable data available
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>