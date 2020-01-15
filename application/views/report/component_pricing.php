<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'component price' => 'master/component-price',
        'combination' => 'report/component-pricing'
    ]
]) ?>

<h4 class="text-primary mb-0"><?= $title ?></h4>
<p class="form-section-title">Component pricing</p>

<?php foreach ($components as $component) : ?>
	<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
		<h5 class="text-primary mb-0"><?= $component['component'] ?> Component</h5>
		<a href="<?= base_url(uri_string()) ?>?component=<?= $component['id'] ?>&export=true" class="btn btn-sm btn-outline-primary pr-2 pl-2">
			<i class="mdi mdi-file-download-outline"></i> Export
		</a>
	</div>
	<table class="table table-sm mt-3 mb-4 table-hover responsive data-table">
		<thead class="thead-dark">
		<tr>
			<th class="text-md-center" style="width: 60px">No</th>
			<th class="text-nowrap">Vendor</th>
			<th class="text-nowrap">Port Origin</th>
			<th class="text-nowrap">Port Destination</th>
			<th class="text-nowrap">Location Origin</th>
			<th class="text-nowrap">Location Destination</th>
			<th class="text-nowrap">Container Size</th>
			<th class="text-nowrap">Container Type</th>
			<th class="text-nowrap">Expired Date</th>
			<?php foreach ($component['sub_components'] as $subComponent) : ?>
				<th class="text-nowrap"><?= $subComponent['sub_component'] ?></th>
			<?php endforeach ?>
			<?php foreach ($component['packages'] as $package) : ?>
				<th class="text-nowrap"><?= $package['package'] ?></th>
			<?php endforeach ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($component['component_prices'] as $index => $componentPrice) : ?>
			<tr>
				<td class="text-md-center"><?= $index + 1 ?></td>
				<td class="text-nowrap"><?= $componentPrice['vendor'] ?></td>
				<td class="text-nowrap"><?= if_empty($componentPrice['port_origin'], '-') ?></td>
				<td class="text-nowrap"><?= if_empty($componentPrice['port_destination'], '-') ?></td>
				<td class="text-nowrap"><?= if_empty($componentPrice['location_origin'], '-') ?></td>
				<td class="text-nowrap"><?= if_empty($componentPrice['location_destination'], '-') ?></td>
				<td class="text-nowrap"><?= if_empty($componentPrice['container_size'], '-') ?></td>
				<td class="text-nowrap"><?= if_empty($componentPrice['container_type'], '-') ?></td>
				<td class="text-nowrap table-danger"><?= if_empty($componentPrice['expired_date'], '-') ?></td>
				<?php foreach ($component['sub_components'] as $subComponent) : ?>
					<td class="text-nowrap">Rp. <?= numerical($componentPrice[$subComponent['sub_component']]) ?></td>
				<?php endforeach ?>
				<?php foreach ($component['packages'] as $package) : ?>
					<td class="text-nowrap table-success px-lg-2 font-weight-bold">Rp. <?= numerical($componentPrice[$package['package']]) ?></td>
				<?php endforeach ?>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
<?php endforeach ?>
