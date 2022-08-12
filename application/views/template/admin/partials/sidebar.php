<?php
$uri = $this->uri->segment(1);
$sub_uri = $this->uri->segment(2);
$sub_sub_uri = $this->uri->segment(3);

?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('Admin/Home') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-calculator"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Fuzzy Chen-PSO</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $uri == 'Admin' && $sub_uri == 'Home' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Admin/Home') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item <?= $uri == 'Admin' && $sub_uri == 'Profile' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Admin/Profile') ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>My Profile</span></a>
    </li>
    <li class="nav-item <?= $uri == 'Admin' && $sub_uri == 'Users' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Admin/Users') ?>">
            <i class="fas fa-fw fa-user-lock"></i>
            <span>Users</span></a>
    </li>

    <li class="nav-item <?= $uri == 'Admin' && $sub_uri == 'DataPenerapan' || $uri == 'Admin' && $sub_uri == 'DataPenerapan' && $sub_sub_uri == 'Grafik' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Penerapan</span>
        </a>
        <div id="collapseUtilities" class="collapse <?= $uri == 'Admin' && $sub_uri == 'DataPenerapan' || $uri == 'Admin' && $sub_uri == 'DataPenerapan' && $sub_sub_uri == 'Grafik' ? 'show' : '' ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= $uri == 'Admin' && $sub_uri == 'DataPenerapan' && $sub_sub_uri == '' ? 'active' : '' ?>" href="<?= base_url('Admin/DataPenerapan') ?>">Data</a>
                <a class="collapse-item <?= $uri == 'Admin' && $sub_uri == 'DataPenerapan' && $sub_sub_uri == 'Grafik' ? 'active' : '' ?>" href="<?= base_url('Admin/DataPenerapan/Grafik') ?>">Grafik</a>
            </div>
        </div>
    </li>

    <li class="nav-item <?= $uri == 'Admin' && $sub_uri == 'Metode' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Admin/Metode') ?>">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Penerapan Metode</span></a>
    </li>
    <li class="nav-item <?= $uri == 'Admin' && $sub_uri == 'Konfigurasi' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Admin/Konfigurasi') ?>">
            <i class="fas fa-fw fa-cog"></i>
            <span>Konfigurasi</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Logout') ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

</ul>