<?php
$konfigurasi = check_konfigurasi();
?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Penerapan Metode Fuzzy Chain">
    <meta name="author" content="Arnilika Wahyudi">

    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('public/template/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('public/template/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url('public/image/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('public/library/sweetalert2/dist/sweetalert2.min.css') ?>">


</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-8">

                <?= $content; ?>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('public/template/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('public/template/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('public/template/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('public/template/') ?>js/sb-admin-2.min.js"></script>
    <script src="<?= base_url('public/library/sweetalert2/dist/sweetalert2.min.js') ?>"></script>

</body>

</html>