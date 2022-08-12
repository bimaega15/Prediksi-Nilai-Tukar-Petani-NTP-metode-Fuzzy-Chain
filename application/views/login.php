<?php
$konfigurasi = check_konfigurasi();
?>

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <img src="<?= base_url('public/image/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>" alt="<?= $konfigurasi->nama_aplikasi; ?>" height="100px;" class="rounded mb-2">
                        <h1 class="h4 text-gray-900 mb-4"><?= $konfigurasi->nama_aplikasi; ?></h1>
                    </div>
                    <form class="user" method="post" action="<?= base_url('Login/process') ?>">
                        <div class="form-group">
                            <input type="text" name="username" class="form-control form-control-user <?= form_error('username') != null ? 'border border-danger' : '' ?>" placeholder="Username...">
                            <?= form_error('username') ?>

                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control form-control-user ?= form_error('password') != null ? 'border border-danger' : '' ?>" placeholder="Password">
                            <?= form_error('password') ?>

                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input name="remember" type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Remember
                                    Me</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Login
                        </button>

                    </form>
                    <hr>
                    <!-- <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('public/template/') ?>vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var success = "<?= $this->session->flashdata('success'); ?>";
        var error = "<?= $this->session->flashdata('error'); ?>";

        if (success != '') {
            Swal.fire({
                icon: 'success',
                title: 'Successfully',
                text: success,
                showConfirmButton: false,
                timer: 1500
            })

            clearForm();
            $('#modalForm').modal('hide');
            $("#onLoad").load("<?= current_url() ?> #onLoad > *");

        }

        if (error != '') {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: error,
                showConfirmButton: false,
                timer: 1500
            })

            clearForm();
            $('#modalForm').modal('hide');
            $("#onLoad").load("<?= current_url() ?> #onLoad > *");

        }

    })
</script>