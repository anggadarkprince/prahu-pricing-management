<?php $this->load->view('partials/_breadcrumb', [
    'breadcrumbs' => [
        'payment' => 'master/payment-type',
        'margin' => 'report/payment-margin'
    ]
]) ?>

<h4 class="text-primary"><?= $title ?></h4>
<p class="form-section-title">Payment margin schema</p>

<table class="table table-sm mt-3 table-hover responsive">
    <thead>
        <tr class="bg-success text-white">
            <td rowspan="2" class="text-center" style="width: 60px"><strong>No</strong></th>
            <td rowspan="2"><strong>Service</strong></th>
            <td colspan="<?= count($paymentTypes) ?>" class="text-center"><strong>Margin / Payment</strong></th>
        </tr>
        <tr class="bg-primary text-white">
            <th class="d-sm-none">No</th>
            <th class="d-sm-none">Service</th>
            <?php foreach ($paymentTypes as $paymentType) : ?>
                <th class="text-md-center"><?= $paymentType['payment_type'] ?></th>
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
                <?php foreach ($paymentTypes as $paymentType) : ?>
                    <td class="text-md-center">
                        <?php foreach ($service['payment_types'] as $servicePaymentType) : ?>
                            <?php if ($servicePaymentType['id_payment_type'] == $paymentType['id']) : ?>
                                <?= numerical($servicePaymentType['margin_percent']) ?>%<br>
                                <small class="text-muted">
                                    (Payment <?= numerical($servicePaymentType['payment_percent']) ?>%)
                                </small>
                            <?php endif ?>
                        <?php endforeach ?>
                    </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
        <?php if (empty($services)) : ?>
            <tr>
                <td colspan="<?= 2 + count($paymentTypes) ?>">
                    No service payment data available
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>