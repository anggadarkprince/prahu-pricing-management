<?php
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);
?>
<nav id="main-navbar" class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm fixed-top py-2 py-sm-2" style="background: white">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-brand">
            <img src="<?= base_url('assets/dist/img/layouts/icon.jpg') ?>" alt="Logo" class="mr-2" style="max-width: 35px; border-radius: 3px">
            <?= $this->config->item('app_name') ?>
        </span>
        <ul class="navbar-nav ml-auto d-block d-lg-none">
            <li class="nav-item dropdown">
                <a class="nav-link p-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="d-flex flex-row align-items-center">
                        <span class="d-none d-sm-inline-block mr-2"><?= AuthModel::loginData('name') ?></span>
                        <div class="rounded-circle" style="height: 37px; width: 37px; background: url('<?= base_url(if_empty(AuthModel::loginData('avatar'), 'assets/dist/img/no-avatar.png', 'uploads/')) ?>') center center / cover"></div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= site_url('account') ?>">My Account</a>
                    <a class="dropdown-item" href="<?= site_url('inbound/notification') ?>">Notification</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url('auth/logout') ?>">Sign Out</a>
                </div>
            </li>
        </ul>
        <div class="collapse navbar-collapse" id="main-nav">
            <ul class="navbar-nav ml-3 mr-auto">
                <li class="nav-item<?= $segment1 == 'dashboard' ? ' active' : '' ?>">
                    <a class="nav-link" href="<?= site_url('dashboard') ?>">
                        <i class="mdi mdi-speedometer-slow mr-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown<?= $segment1 == 'master' ? ' active' : '' ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="nav-master" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-cube-outline mr-1"></i>Master
                    </a>
                    <div class="dropdown-menu" aria-labelledby="nav-master">
                        <a class="dropdown-item<?= $segment2 == 'role' ? ' active' : '' ?>" href="<?= site_url('master/role') ?>">
                            <i class="mdi mdi-lock-outline mr-2"></i>Roles
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'user' ? ' active' : '' ?>" href="<?= site_url('master/user') ?>">
                            <i class="mdi mdi-account-outline mr-2"></i>Users
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item<?= $segment2 == 'component' ? ' active' : '' ?>" href="<?= site_url('master/component') ?>">
                            <i class="mdi mdi-layers-triple-outline mr-2"></i>Component
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'sub-component' ? ' active' : '' ?>" href="<?= site_url('master/sub-component') ?>">
                            <i class="mdi mdi-layers-search mr-2"></i>Sub-component
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'package' ? ' active' : '' ?>" href="<?= site_url('master/package') ?>">
                            <i class="mdi mdi-archive-arrow-down-outline mr-2"></i>Packages
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'service' ? ' active' : '' ?>" href="<?= site_url('master/service') ?>">
                            <i class="mdi mdi-inbox-full-outline mr-2"></i>Services
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item<?= $segment2 == 'port' ? ' active' : '' ?>" href="<?= site_url('master/port') ?>">
                            <i class="mdi mdi-anchor mr-2"></i>Ports
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'location' ? ' active' : '' ?>" href="<?= site_url('master/location') ?>">
                            <i class="mdi mdi-map-marker-outline mr-2"></i>Location
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'vendor' ? ' active' : '' ?>" href="<?= site_url('master/vendor') ?>">
                            <i class="mdi mdi-factory mr-2"></i>Vendor
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'container-size' ? ' active' : '' ?>" href="<?= site_url('master/container-size') ?>">
                            <i class="mdi mdi-move-resize-variant mr-2"></i>Cargo Sizes
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'container-type' ? ' active' : '' ?>" href="<?= site_url('master/container-type') ?>">
                            <i class="mdi mdi-truck-outline mr-2"></i>Cargo Types
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'marketing' ? ' active' : '' ?>" href="<?= site_url('master/marketing') ?>">
                            <i class="mdi mdi-account-supervisor-outline mr-2"></i>Marketing
                        </a>
                        <div class="dropdown-divider"></div>
						<a class="dropdown-item<?= $segment2 == 'payment-type' ? ' active' : '' ?>" href="<?= site_url('master/payment-type') ?>">
							<i class="mdi mdi-calendar-text-outline mr-2"></i>Payment Type
						</a>
                        <a class="dropdown-item<?= $segment2 == 'service-payment' ? ' active' : '' ?>" href="<?= site_url('master/service-payment') ?>">
                            <i class="mdi mdi-script-text-outline mr-2"></i>Service Payment
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'price' ? ' active' : '' ?>" href="<?= site_url('master/component-price') ?>">
                            <i class="mdi mdi-currency-usd mr-2"></i>Component Price
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown<?= $segment1 == 'pricing' ? ' active' : '' ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="nav-inbound" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-cart-outline mr-1"></i>Pricing
                    </a>
                    <div class="dropdown-menu" aria-labelledby="nav-inbound">
                        <a class="dropdown-item<?= $segment2 == 'calculator' ? ' active' : '' ?>" href="<?= site_url('pricing/calculator') ?>">
                            <i class="mdi mdi-ballot-outline mr-2"></i>Calculators
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'price-history' ? ' active' : '' ?>" href="<?= site_url('pricing/price-history') ?>">
                            <i class="mdi mdi-file-document-box-check-outline mr-2"></i>Quotation
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown<?= $segment1 == 'report' ? ' active' : '' ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="nav-inbound" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-file-outline mr-1"></i>Report
                    </a>
                    <div class="dropdown-menu" aria-labelledby="nav-inbound">
                        <a class="dropdown-item<?= $segment2 == 'service-combination' ? ' active' : '' ?>" href="<?= site_url('report/service-combination') ?>">
                            <i class="mdi mdi-inbox-full-outline mr-2"></i>Service Combination
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'package-combination' ? ' active' : '' ?>" href="<?= site_url('report/package-combination') ?>">
                            <i class="mdi mdi-archive-arrow-down-outline mr-2"></i>Package Combination
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'component-pricing' ? ' active' : '' ?>" href="<?= site_url('report/component-pricing') ?>">
                            <i class="mdi mdi-shopping-outline mr-2"></i>Component Pricing
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'consumable-pricing' ? ' active' : '' ?>" href="<?= site_url('report/consumable-pricing') ?>">
                            <i class="mdi mdi-cart-plus mr-2"></i>Consumable Pricing
                        </a>
                    </div>
                </li>
                <li class="nav-item<?= $segment1 == 'setting' ? ' active' : '' ?>">
                    <a class="nav-link" href="<?= site_url('setting') ?>">
                        <i class="mdi mdi-tune mr-1"></i>Setting
                    </a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav ml-auto d-none d-lg-block">
            <li class="nav-item dropdown">
                <a class="nav-link p-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="d-flex flex-row align-items-center">
                        <span class="mr-2"><?= AuthModel::loginData('name') ?></span>
                        <div class="rounded-circle" style="height: 37px; width: 37px; background: url('<?= base_url(if_empty(AuthModel::loginData('avatar'), 'assets/dist/img/layouts/no-avatar.png', 'uploads/')) ?>') center center / cover"></div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= site_url('account') ?>">
                        <i class="mdi mdi-account-outline mr-2"></i>My Account
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= site_url('auth/logout') ?>">
                        <i class="mdi mdi-logout-variant mr-2"></i>Sign Out
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
