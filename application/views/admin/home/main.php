<?php
$konfigurasi = check_konfigurasi();
?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <?= $breadcrumb; ?>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Data Penerapan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $penerapan; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-table fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $users ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-lock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <div class="col-xl-12 col-lg-7">
            <div class="card">
                <div class="card-header text-primary">
                    Tentang Aplikasi
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table">
                                <tr>
                                    <td>Nama Aplikasi</td>
                                    <td>:</td>
                                    <td class="text-right"><?= $konfigurasi->nama_aplikasi; ?></td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td>:</td>
                                    <td class="text-right"><?= $konfigurasi->keterangan; ?></td>
                                </tr>
                                <tr>
                                    <td>Logo</td>
                                    <td>:</td>
                                    <td class="text-right">
                                        <img src="<?= base_url('public/image/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>" height="80px;" alt="">
                                    </td>
                                </tr>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>