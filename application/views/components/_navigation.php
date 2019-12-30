<?php
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);
?>
<nav id="main-navbar" class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top py-2 py-sm-3" style="background: white">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-brand"><?= $this->config->item('app_name') ?></span>
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
                        <a class="dropdown-item<?= $segment2 == 'container-size' ? ' active' : '' ?>" href="<?= site_url('master/container-size') ?>">
                            <i class="mdi mdi-move-resize-variant mr-2"></i>Cargo Sizes
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'position' ? ' active' : '' ?>" href="<?= site_url('master/container-type') ?>">
                            <i class="mdi mdi-truck-delivery-outline mr-2"></i>Cargo Types
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'ports' ? ' active' : '' ?>" href="<?= site_url('master/port') ?>">
                            <i class="mdi mdi-anchor mr-2"></i>Ports
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'vendor' ? ' active' : '' ?>" href="<?= site_url('master/vendor') ?>">
                            <i class="mdi mdi-factory mr-2"></i>Vendor
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'component' ? ' active' : '' ?>" href="<?= site_url('master/component') ?>">
                            <i class="mdi mdi-layers-triple-outline mr-2"></i>Component
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'sub' ? ' active' : '' ?>" href="<?= site_url('master/sub-component') ?>">
                            <i class="mdi mdi-layers-search mr-2"></i>Sub-component
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown<?= $segment1 == 'inbound' ? ' active' : '' ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="nav-inbound" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-cart-outline mr-1"></i>Pricing
                    </a>
                    <div class="dropdown-menu" aria-labelledby="nav-inbound">
                        <a class="dropdown-item<?= $segment2 == 'calculator' ? ' active' : '' ?>" href="<?= site_url('pricing/calculator') ?>">
                            <i class="mdi mdi-ballot-outline mr-2"></i>Calculators
                        </a>
                        <a class="dropdown-item<?= $segment2 == 'price-history' ? ' active' : '' ?>" href="<?= site_url('pricing/price-history') ?>">
                            <i class="mdi mdi-update mr-2"></i>Price Histories
                        </a>
                    </div>
                </li>
                <li class="nav-item<?= $segment1 == 'setting' ? ' active' : '' ?>">
                    <a class="nav-link" href="<?= site_url('setting') ?>">
						<i class="mdi mdi-settings-outline mr-1"></i>Setting
                    </a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav ml-auto d-none d-lg-block">
            <li class="nav-item dropdown">
                <a class="nav-link p-0" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="d-flex flex-row align-items-center">
                        <span class="mr-2"><?= AuthModel::loginData('name') ?></span>
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
    </div>
</nav>
