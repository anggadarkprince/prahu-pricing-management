<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'service' => 'master/service',
        'combination' => 'report/service-combination'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Service combination</p>

<table class="table table-sm mt-3 table-hover responsive">
    <thead>
        <tr class="bg-success text-white">
            <td rowspan="2" class="text-center" style="width: 60px"><strong>No</strong></th>
            <td rowspan="2"><strong>Service</strong></th>
            <td colspan="<?= count($components) ?>" class="text-center"><strong>Component</strong></th>
        </tr>
        <tr class="bg-primary text-white">
            <th class="d-sm-none">No</th>
            <th class="d-sm-none">Service</th>
            <?php foreach ($components as $component) : ?>
                <th class="text-md-center"><?= $component['component'] ?></th>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($services as $index => $service) : ?>
            <tr>
                <td class="text-md-center"><?= $index + 1 ?></td>
                <td class="font-weight-bold">
                    <a href="<?= site_url('master/service/view/' . $service['id']) ?>">
                        <?= $service['service'] ?>
                    </a>
                </td>
                <?php foreach ($components as $component) : ?>
                    <td class="text-md-center<?= in_array($component['id'], array_column($service['components'], 'id_component')) ? ' table-success' : ' table-danger' ?>">
                        <?= in_array($component['id'], array_column($service['components'], 'id_component')) ? 'YES' : 'NO' ?>
                    </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
        <?php if (empty($services)) : ?>
            <tr>
                <td colspan="<?= 2 + count($components) ?>">
                    No combination data available
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>