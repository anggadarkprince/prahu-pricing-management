<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'package' => 'master/package',
        'combination' => 'report/package-combination'
    ]
]) ?>

<h4 class="text-primary mb-0"><?= $title ?></h4>
<p class="form-section-title">Package combination</p>

<?php foreach ($components as $component) : ?>
	<div class="d-flex justify-content-between align-items-center">
		<h5 class="text-primary mb-0"><?= $component['component'] ?> Component</h5>
		<a href="<?= base_url(uri_string()) ?>?component=<?= $component['id'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
			<i class="mdi mdi-file-download-outline"></i> Export
		</a>
	</div>
    <table class="table table-sm mt-3 mb-4 table-hover responsive">
        <thead class="thead-dark">
            <tr>
                <th class="text-center" style="width: 60px">No</th>
                <th>Sub Component</th>
                <?php foreach ($component['packages'] as $package) : ?>
                    <th class="text-md-center"><?= $package['package'] ?></th>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($component['sub_components'] as $index => $subComponent) : ?>
                <tr>
                    <td class="text-md-center"><?= $index + 1 ?></td>
                    <td class="font-weight-bold">
                        <a href="<?= site_url('master/sub-component/view/' . $subComponent['id']) ?>">
                            <?= $subComponent['sub_component'] ?>
                        </a>
                    </td>
                    <?php foreach ($component['packages'] as $package) : ?>
                        <td class="text-md-center<?= in_array($subComponent['id'], array_column($package['sub_components'], 'id_sub_component')) ? ' table-success' : ' table-danger' ?>">
                            <?= in_array($subComponent['id'], array_column($package['sub_components'], 'id_sub_component')) ? 'YES' : 'NO' ?>
                        </td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
            <?php if (empty($component['sub_components'])) : ?>
                <tr>
                    <td colspan="<?= 2 + count($component['packages']) ?>">
                        No combination data available
                    </td>
                </tr>
            <?php else : ?>
                <tr class="table-warning">
                    <td></td>
                    <td><strong>Total</strong></td>
                    <?php foreach ($component['packages'] as $package) : ?>
                        <td class="text-md-center">
                            <strong><?= count($package['sub_components']) ?></strong>
                        </td>
                    <?php endforeach ?>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php endforeach ?>
